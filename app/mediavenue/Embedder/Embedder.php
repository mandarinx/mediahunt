<?php

/**
 * @author Abhi
 */
namespace Mediavenue\Embedder;

use GuzzleHttp;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use OAuth\Common\Exception\Exception;

class Embedder {

    protected $id;
    protected $source;
    protected $provider;
    protected $response;
    protected $title;

    protected $services = [
        'youtube'    => [
            'name'       => 'youtube',
            'id'         => '#(?:youtu\.be/|youtube.com/(?:v/|embed/|watch\?v=))(?<id>[a-z0-9_-]+)#i',
            'url'        => 'http://www.youtube.com/embed/%s',
            'type'       => 'direct',
            'oembed_url' => 'http://www.youtube.com/oembed?url=%s&format=json',
            'html'       => '<div class="embed-responsive embed-responsive-16by9"><iframe src="%s" class="embed-responsive-item"  seamless="seamless" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>',
            'title'      => [
                'type'       => 'oembed',
                'oembed_key' => 'title',
            ],
            'thumbnail'  => [
                'type' => 'direct',
                'url'  => 'http://i1.ytimg.com/vi/%s/hqdefault.jpg',
            ],
            'map'        => [
                'theme'          => 'light',
                'autoplay'       => 1,
                'showinfo'       => 0,
                'modestbranding' => 1,
                'iv_load_policy' => 3,
                'autohide'       => 1,
            ]
        ],
        'vimeo'      => [
            'name'       => 'vimeo',
            'id'         => '#vimeo\.com/(?:video/)?(?<id>[0-9]+)#i',
            'url'        => 'http://player.vimeo.com/video/%s',
            'type'       => 'direct',
            'oembed_url' => 'http://vimeo.com/api/oembed.json?url=%s',
            'html'       => '<div class="embed-responsive embed-responsive-16by9"><iframe src="%s" class="embed-responsive-item"  frameborder="0" class="video-player" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>',
            'title'      => [
                'type'       => 'oembed',
                'oembed_key' => 'title',
            ],
            'thumbnail'  => [
                'type'       => 'oembed',
                'oembed_key' => 'thumbnail_url'
            ],
            'map'        => [
                'badge'    => 0,
                'byline'   => 0,
                'title'    => 0,
                'portrait' => 0,
                'color'    => 'e74c3c'
            ]
        ],
        'vine'       => [
            'name'      => 'vine',
            'id'        => '#(?:vine.co)\/v\/(?<id>[A-Za-z0-9]+)#i',
            'type'      => 'direct',
            'url'       => 'https://vine.co/v/%s',
            'html'      => '<div class="embed-responsive embed-responsive-4by3"><iframe class="vine-embed embed-responsive-item" src="%s/embed/simple" width="600" height="600" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script></div>',
            'title'     => [
                'type' => 'og:title'
            ],
            'thumbnail' => [
                'type' => 'og:image',
            ],
            'map'       => []
        ],
        'soundcloud' => [
            'name'       => 'soundcloud',
            'id'         => '#(?:soundcloud.com)\/(?<id>.+)#',
            'type'       => 'oembed',
            'oembed_url' => 'http://soundcloud.com/oembed?format=json&url=%s',
            'html'       => 'html',
            'title'      => [
                'type'       => 'oembed',
                'oembed_key' => 'title',
            ],
            'thumbnail'  => [
                'type'       => 'oembed',
                'oembed_key' => 'thumbnail_url'
            ],
            'map'        => []
        ]
    ];

    public function __construct(array $services = [])
    {

        $this->services = array_merge($this->services, $services);
    }

    public function initialize($source)
    {
        $this->source = $this->formatUrl($source);
        $this->provider = $this->initialCheck($source);

        return $this;
    }

    protected function formatUrl($url)
    {
        $url = preg_replace('#http(s)?://#', '', $url);
        $url = 'http://' . $url;

        if ( ! (strpos($url, "http://") === 0) && ! (strpos($url, "https://") === 0))
        {

            $url = "http://$url";

        }

        return $url;

    }

    protected function initialCheck($source)
    {
        foreach ($this->services as $service => $config)
        {
            if (preg_match($config['id'], $source, $matches))
            {
                $this->id = $matches['id'];
                $this->provider = $config;

                return true;
                break;
            }
        }

        return false;
    }

    public function validate()
    {
        if ( ! $this->initialCheck($this->source))
            return false;

        if (isset($this->provider['oembed_url']))
        {
            if ( ! $this->requestCheck(sprintf($this->provider['oembed_url'], $this->source)))
                return false;
        }
        else
        {
            if ( ! $this->requestCheck($this->source))
                return false;
        }

        if ( ! $this->title())
            return false;

        return true;
    }

    protected function requestCheck($source)
    {
        $this->request($source);
        if ( ! $this->response) return false;

        if ($this->response->getStatusCode() == 200 && $this->response != null)
        {
            return true;
        }

        return false;
    }

    public function request($source)
    {

        $client = new GuzzleHttp\Client();
        try
        {
            $this->response = $client->get($source);

            return $this;

        } catch (ClientException $e)
        {
            return false;
        } catch (FatalErrorException $e)
        {
            return false;
        } catch (GuzzleHttp\Exception\RequestException $e)
        {
            return false;
        }
    }

    public function title()
    {
        if ($this->title)
            return $this->title;

        if ($this->provider['title']['type'] == 'oembed')
        {
            $this->request(sprintf($this->provider['oembed_url'], $this->source));
            if ($this->json())
            {
                $this->title = $this->json()[$this->provider['title']['oembed_key']];

                return $this->title;
            }

            return false;
        }

        if ($this->provider['title']['type'] == 'og:title')
        {
            return $this->getOGTitle($this->response->getBody());
        }

        return false;
    }

    protected function json()
    {
        if ( ! $this->response)
            return false;

        try
        {
            $response = $this->response->json();

            return $response;
        } catch (FatalErrorException $e)
        {
            return false;
        } catch (GuzzleHttp\Exception\ParseException $e)
        {
            return false;
        }
    }

    protected function getOGTitle($body)
    {
        preg_match('/"og:title".*content="(.*)"/', $body, $title);

        return $title[1];
    }

    public function  thumbnail()
    {
        if ($this->provider['thumbnail']['type'] == 'og:image')
        {
            $res = $this->request(sprintf($this->provider['url'], $this->id));
            $res = $this->request($this->getOGImage($this->response->getBody()));
        }
        if (isset($this->provider['thumbnail']['url']))
        {
            $res = $this->request(sprintf($this->provider['thumbnail']['url'], $this->id));
        }
        elseif (isset($this->provider['thumbnail']['oembed_key']))
        {
            $res = $this->request(sprintf($this->provider['oembed_url'], $this->source));
            $res = $this->request($res->json()[$this->provider['thumbnail']['oembed_key']]);
        }

        try
        {
            return $this->saveFile($this->response->getBody());
        } catch (Exception $e)
        {
            return null;
        }
    }

    protected function getOGImage($body)
    {
        preg_match('/"og:image".*content="(.*)"/', $body, $image);

        return $image[1];
    }

    protected function saveFile($resource)
    {
        $imageId = $this->dirName();
        $file = fopen(public_path() . '/uploads/' . $imageId . '.jpeg', 'w');
        fwrite($file, $resource);
        fclose($file);

        return $imageId;
    }

    protected function dirName()
    {
        $str = str_random(9);
        if (file_exists(public_path() . '/uploads/' . $str))
        {
            $str = $this->dirName();
        }

        return $str;
    }

    public function providerName()
    {
        return $this->provider['name'];
    }

    public function html($post)
    {
        if (Cache::has('post_embed_html_' . $post->id))
        {
            return Cache::get('post_embed_html_' . $post->id);
        }

        $this->initialCheck($post->source);

        if ($this->id && $this->provider['type'] === 'oembed')
        {
            $resource = $this->request(sprintf($this->provider['oembed_url'], $post->source));
            $resource = $resource->json();

            $source = $resource['html'];
        }

        if ($this->id && $this->provider['type'] === 'direct')
        {
            $params = $this->mapped($this->provider['map']);
            $url = sprintf($this->provider['url'], $this->id);
            if ($params)
            {
                $url .= '?' . $params;
            }

            $source = sprintf($this->provider['html'], $url);
        }

        Cache::forever('post_embed_html_' . $post->id, $source);

        return $source;
    }

    protected function mapped(array $map)
    {
        $query = null;
        $i = 0;
        foreach ($map as $generic => $specific)
        {
            if ($i == 0)
                $query .= $generic . '=' . $specific;
            else
                $query .= '&' . $generic . '=' . $specific;

            $i++;
        }

        return $query;
    }
}