<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Auth;
use Carbon\Carbon;
use Category;
use DB;
use Embedder;
use Favorite;
use File;
use Mediavenue\Repository\PostsRepositoryInterface;
use Post;
use Purifier;
use Str;

class PostsRepository extends AbstractRepository implements PostsRepositoryInterface {

    /**
     * @var \Post
     */
    protected $model;

    /**
     * @param Post     $posts
     * @param Category $category
     */
    public function __construct(Post $posts, Category $category)
    {
        $this->model = $posts;
        $this->category = $category;
    }

    /**
     * @param      $id
     * @return mixed
     */
    public function getById($id)
    {
        $post = $this->model->approved()->whereId($id)->first();

        return $post;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAnyById($id)
    {
        $post = $this->model->approved()->whereId($id)->first();

        return $post;
    }

    /**
     * @param null $provider
     * @param null $category
     * @return mixed
     */
    public function getTrending($provider = null, $category = null)
    {
        $posts = $this->posts($provider, $category)->with('comments', 'votes', 'category', 'user', 'votes.user')
            ->leftJoin('votes', 'posts.id', '=', 'votes.post_id')
            ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
            ->select('posts.*', DB::raw('count(comments.post_id)*7 + count(votes.post_id)*5 + posts.views as popular'))
            ->groupBy('posts.id')->with('user')->orderBy('popular', 'desc')
            ->paginate(perPage());

        return $posts;
    }

    /**
     * @param null $provider
     * @param null $category
     * @return Post
     */
    private function posts($provider = null, $category = null)
    {
        $type = ['media', 'image'];
        if ($provider == 'blog' || $provider == 'link' || $provider == 'image')
        {
            $type = [$provider];
        }

        $posts = $this->model->approved();
        if ($category)
        {
            $category = $this->category->whereSlug($category)->first();
            if ($category)
            {
                $posts = $posts->whereCategoryId($category->id);
            }
        }
        if ($provider)
        {
            $posts = $posts->whereProvider($provider);
        }
        if ($type)
        {
            $posts = $posts->whereIn('type', $type);
        }

        return $posts;
    }

    /**
     * @param null   $provider
     * @param null   $category
     * @param string $order
     * @return mixed
     */
    public function getLatest($provider = null, $category = null, $order = 'desc')
    {
        $posts = $this->posts($provider, $category)->with('comments', 'votes', 'category', 'user', 'votes.user')->orderBy('approved_at', $order)->paginate(perPage());

        return $posts;
    }

    /**
     * @param null        $provider
     * @param null        $category
     * @param null|string $type
     * @return mixed
     */
    public function getFeatured($provider = null, $category = null, $type = 'media')
    {
        $posts = $this->posts($provider, $category, $type)->whereNotNull('featured_at')->with('comments', 'votes', 'category', 'user', 'votes.user')->orderBy('featured_at', 'desc')->paginate(perPage());

        return $posts;
    }


    /**
     * @param $news
     * @return mixed
     */
    public function incrementViews($news)
    {
        $news->views = $news->views + 1;
        $news->save();

        return $news;
    }

    /**
     * @param      $term
     * @param null $type
     * @param null $category
     * @return mixed
     */
    public function search($term, $type = null, $category = null)
    {
        $posts = $this->posts($type, $category)->where(function ($query) use ($term)
        {
            $query->where('title', 'LIKE', '%' . $term . '%')
                ->orWhere('summary', 'LIKE', '%' . $term . '%')
                ->orWhere('source', 'LIKE', '%' . $term . '%');
        })->with('comments', 'votes', 'category', 'user', 'votes.user')->orderBy('title', 'asc')->paginate(perPage());

        return $posts;
    }

    /**
     * @param array $input
     * @param null  $thumbnail
     * @param null  $type
     * @return mixed
     */
    public function create(array $input, $thumbnail = null, $type = null)
    {
        $post = $this->getNew();
        $post->title = $input['title'];
        $post->summary = Purifier::clean($input['summary']);
        $post->user_id = Auth::user()->id;
        $post->category_id = $input['category'];
        $slug = @Str::slug($input['title']);
        if ( ! $slug)
        {
            $slug = Str::random(9);
        }
        if ((bool) autoApprove() == false)
        {
            $post->approved_at = null;
        }
        else
        {
            $post->approved_at = Carbon::now();
        }
        switch ($type)
        {
            case 'image':
                $post->source = 'image';
                $post->thumbnail = $thumbnail;
                $post->provider = 'image';
                $post->type = 'image';
                break;
            case 'blog':
                $post->source = 'blog';
                $post->thumbnail = null;
                $post->provider = 'blog';
                $post->type = 'blog';
                break;
            case 'link':
                $post->source = filter_var(formatUrl($input['url']), FILTER_SANITIZE_URL);
                $post->thumbnail = null;
                $post->provider = 'link';
                $post->type = 'link';
                break;
            default:
                $post->source = filter_var(formatUrl($input['url']), FILTER_SANITIZE_URL);
                $post->thumbnail = $thumbnail->thumbnail() . '.jpeg';
                $post->provider = $thumbnail->providerName();
                $post->type = 'media';
                break;
        }
        $post->slug = $slug;
        $post->save();

        return $post;
    }

    /**
     * @param Post  $posts
     * @param array $input
     * @return Post
     */
    public function edit(Post $posts, array $input)
    {
        $post = $posts;
        if (isset($input['delete']))
        {
            $post->flags()->delete();
            $comments = $post->comments()->get();
            foreach ($comments as $comment)
            {
                $comment->reply()->delete();
                $comment->delete();
            }
            $post->reply()->delete();
            $post->votes()->delete();
            File::delete('uploads/' . $post->thumbnail . '.jpeg');
            $post->delete();

            return $posts;
        }
        $slug = @Str::slug($input['title']);
        if ( ! $slug)
        {
            $slug = Str::random(9);
        }
        $post->title = $input['title'];
        $post->slug = $slug;
        $post->summary = Purifier::clean($input['summary']);
        $post->category_id = $input['category'];
        if ((bool) autoApprove() == false)
        {
            $post->approved_at = null;
        }
        $post->update();

        return $post;
    }

    /**
     * @param $list
     * @return mixed
     */
    public function getFeedsForUser($list)
    {
        return $this->posts()->whereIn('user_id', $list)->paginate(perPage());
    }

    //@todo add filter for admin panel
    /**
     * @return mixed
     */
    public function getApprovalRequired()
    {
        $posts = $this->model->whereNull('approved_at')->with('comments', 'votes', 'category', 'user', 'votes.user')->orderBy('featured_at', 'desc')->paginate(perPage());

        return $posts;
    }

    /**
     * Admin helper, gives output irr-respective of post approved or not
     *
     * @param $id
     * @return mixed
     */
    public function getByIdForAdmin($id)
    {
        $posts = $this->model->whereId($id)->first();

        return $posts;
    }

    /**
     * Admin helper, to edit post irr-respective of post approved or not
     *
     * @param Post  $posts
     * @param array $input
     * @return Post
     */
    public function adminEdit(Post $posts, array $input)
    {
        $post = $posts;
        if (isset($input['delete']))
        {
            $post->flags()->delete();
            $post->comments()->delete();
            $post->reply()->delete();
            $post->votes()->delete();
            $post->delete();

            return $posts;
        }
        if (isset($input['url']) && $post->provider != 'blog' && $post->provider != 'image')
        {
            $post->source = filter_var(formatUrl($input['url']), FILTER_SANITIZE_URL);;
        }
        $slug = @Str::slug($input['title']);
        if ( ! $slug)
        {
            $slug = Str::random(9);
        }
        $post->title = $input['title'];
        $post->slug = $slug;
        $post->summary = Purifier::clean($input['summary']);
        $post->category_id = $input['category'];
        if (isset($input['approve']))
        {
            $post->approved_at = Carbon::now();
        }
        if (isset($input['featured']) && $post->featured_at == null)
        {
            $post->featured_at = Carbon::now();
        }
        elseif ( ! isset($input['featured']))
        {
            $post->featured_at = null;
        }
        $post->update();

        return $post;
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function findNextPost(Post $post)
    {
        $next = $this->posts()->where('approved_at', '>=', $post->approved_at)
            ->whereNotIn('id', [$post->id])
            ->orderBy('approved_at', 'asc')
            ->first(['id', 'slug', 'title']);

        return $next;
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function findPreviousPost(Post $post)
    {
        $prev = $this->posts()->where('approved_at', '<=', $post->approved_at)
            ->whereNotIn('id', [$post->id])
            ->orderBy('approved_at', 'desc')
            ->first(['id', 'slug', 'title']);


        return $prev;
    }

    /**
     * @param Post $post
     * @return mixed
     */
    public function findRelatedPosts(Post $post)
    {

        $related = $this->posts()
            ->whereNotIn('id', [$post->id])->with('comments', 'votes', 'category', 'user', 'votes.user')
            ->orWhere(function ($query) use ($post)
            {
                $query->where('title', '%' . $post->title . '%')
                    ->whereNotIn('title', [$post->title]);

            })->orderBy(DB::raw('RAND()'))
            ->take(8)->remember(10)->paginate(8);

        return $related;
    }
}