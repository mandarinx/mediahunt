<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 * @param $string
 * @return string
 */

function t($string)
{
    return trans('text.' . $string);
}

/**
 * @return int|number
 */
function perPage()
{
    if ( ! siteSettings('perPage'))
    {
        return 20;
    }

    return abs((int) siteSettings('perPage'));
}

/**
 * @param $request
 * @return mixed
 */
function siteSettings($request)
{
    $request = DB::table('sitesettings')->where('option', '=', $request)->remember(999, $request)->first();

    return $request->value;
}

/**
 * @return mixed
 */
function siteCategories()
{
    return Category::remember(999, 'categories')->where('id', '<>', 1)->orderBy('lft', 'asc')->get();
}

/**
 * @return mixed
 */
function getCategoryName($slug = null)
{
    $category = Category::select('name')->whereSlug($slug)->first();
    if ($category)
        return $category->name;

    return $slug;
}

/**
 * @return bool
 */
function autoApprove()
{
    if ((int) siteSettings('autoApprove') == 1)
    {
        return true;
    }

    return false;
}

/**
 * @return int
 */
function limitPerDay()
{
    return (int) siteSettings('limitPerDay');
}

/**
 * @param $url
 * @return mixed
 */
function parseUrl($url)
{
    return str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
}


/**
 * @param        $email
 * @param int    $s
 * @param string $d
 * @param string $r
 * @param bool   $img
 * @param array  $atts
 * @return string
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
{
    $url = '//www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img)
    {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }

    return $url;
}


/**
 * @param null $votes
 * @return bool
 */
function checkVoted($votes = null)
{
    if (Auth::check() == false || ! $votes)
        return false;

    $a = array();
    foreach ($votes as $v)
        $a[] = $v->user->id;

    return in_array(Auth::user()->id, $a);
}

/**
 * @param $url
 * @return string
 */
function addhttp($url)
{
    if ( ! preg_match("~^(?:f|ht)tps?://~i", $url))
    {
        $url = "http://" . $url;
    }

    return $url;
}

/**
 * @param     $user
 * @param int $size
 * @return string
 */
function getAvatar($user, $size = 80)
{
    if ($user->avatar == null)
    {
        return get_gravatar($user->email, $size);
    }

    return asset(zoomCrop('avatars/' . $user->avatar, $size, $size));
}

/**
 * @param     $post
 * @param int $width
 * @param int $height
 * @return mixed
 */
function thumbnail($post, $width = 374, $height = 374)
{
    $thumbnail = 'uploads/' . $post->thumbnail;

    if ( ! file_exists($thumbnail))
    {
        $thumbnail = 'uploads/fallback.jpeg';
    }

    if ($post->provider == 'youtube')
    {
        $thumbnail = JitImage::source($thumbnail)->cropAndResize(350, 197, 5);
        preg_match('/storage\/(.*)(.+)(?=\.jpg)/', $thumbnail, $temp);
        $temp = str_replace('storage/', '', $temp);

        return JitImage::source('../app/storage/jit/' . $temp[0])->cropAndResize($width, $height, 5);
    }

    return JitImage::source($thumbnail)->cropAndResize($width, $height, 5);
}

/**
 * @param     $image
 * @param int $width
 * @param int $height
 * @return mixed
 */
function zoomCrop($image, $width = 200, $height = 150)
{
    if ( ! file_exists($image))
    {
        $image = 'avatars/user.jpg';
    }

    return JitImage::source($image)->toJpeg()->cropAndResize($width, $height, 5);
}


/**
 * @param $url
 * @return string
 */
function formatUrl($url)
{
    $url = preg_replace('#http(s)?://#', '', $url);
    $url = 'http://' . $url;

    if ( ! (strpos($url, "http://") === 0) && ! (strpos($url, "https://") === 0))
    {

        $url = "http://$url";

    }

    return $url;

}

/**
 * @param $lang
 * @return string
 */
function langDecode($lang)
{
    switch ($lang)
    {
        case "af":
            return "kaans";
        case "ak":
            return "Akan";
        case "sq":
            return "Albanian";
        case "am":
            return "Amharic";
        case "ar":
            return "Arabic";
        case "hy":
            return "Armenian";
        case "az":
            return "Azerbaijani";
        case "eu":
            return "Basque";
        case "be":
            return "Belarusian";
        case "bem":
            return "Bemba";
        case "bn":
            return "Bengali";
        case "bh":
            return "Bihari";
        case "xx-bork":
            return "Bork, bork, bork!";
        case "bs":
            return "Bosnian";
        case "br":
            return "Breton";
        case "bg":
            return "Bulgarian";
        case "km":
            return "Cambodian";
        case "ca":
            return "Catalan";
        case "chr":
            return "Cherokee";
        case "ny":
            return "Chichewa";
        case "zh-CN":
            return "Chinese (Simplified)";
        case "zh-TW":
            return "Chinese (Traditional)";
        case "co":
            return "Corsican";
        case "hr":
            return "Croatian";
        case "cs":
            return "Czech";
        case "da":
            return "Danish";
        case "nl":
            return "Dutch";
        case "xx-elmer":
            return "Elmer Fudd";
        case "en":
            return "English";
        case "eo":
            return "Esperanto";
        case "et":
            return "Estonian";
        case "ee":
            return "Ewe";
        case "fo":
            return "Faroese";
        case "tl":
            return "Filipino";
        case "fi":
            return "Finnish";
        case "fr":
            return "French";
        case "fy":
            return "Frisian";
        case "gaa":
            return "Ga";
        case "gl":
            return "Galician";
        case "ka":
            return "Georgian";
        case "de":
            return "German";
        case "el":
            return "Greek";
        case "gn":
            return "Guarani";
        case "gu":
            return "Gujarati";
        case "xx-hacker":
            return "Hacker";
        case "ht":
            return "Haitian Creole";
        case "ha":
            return "Hausa";
        case "haw":
            return "Hawaiian";
        case "iw":
            return "Hebrew";
        case "hi":
            return "Hindi";
        case "hu":
            return "Hungarian";
        case "is":
            return "Icelandic";
        case "ig":
            return "Igbo";
        case "id":
            return "Indonesian";
        case "ia":
            return "Interlingua";
        case "ga":
            return "Irish";
        case "it":
            return "Italian";
        case "ja":
            return "Japanese";
        case "jw":
            return "Javanese";
        case "kn":
            return "Kannada";
        case "kk":
            return "Kazakh";
        case "rw":
            return "Kinyarwanda";
        case "rn":
            return "Kirundi";
        case "xx-klingon":
            return "Klingon";
        case "kg":
            return "Kongo";
        case "ko":
            return "Korean";
        case "kri":
            return "Krio (Sierra Leone)";
        case "ku":
            return "Kurdish";
        case "ckb":
            return "Kurdish (Soranî)";
        case "ky":
            return "Kyrgyz";
        case "lo":
            return "Laothian";
        case "la":
            return "Latin";
        case "lv":
            return "Latvian";
        case "ln":
            return "Lingala";
        case "lt":
            return "Lithuanian";
        case "loz":
            return "Lozi";
        case "lg":
            return "Luganda";
        case "ach":
            return "Luo";
        case "mk":
            return "Macedonian";
        case "mg":
            return "Malagasy";
        case "ms":
            return "Malay";
        case "ml":
            return "Malayalam";
        case "mt":
            return "Maltese";
        case "mi":
            return "Maori";
        case "mr":
            return "Marathi";
        case "mfe":
            return "Mauritian Creole";
        case "mo":
            return "Moldavian";
        case "mn":
            return "Mongolian";
        case "sr-ME":
            return "Montenegrin";
        case "ne":
            return "Nepali";
        case "pcm":
            return "Nigerian Pidgin";
        case "nso":
            return "Northern Sotho";
        case "no":
            return "Norwegian";
        case "nn":
            return "Norwegian (Nynorsk)";
        case "oc":
            return "Occitan";
        case "or":
            return "Oriya";
        case "om":
            return "Oromo";
        case "ps":
            return "Pashto";
        case "fa":
            return "Persian";
        case "xx-pirate":
            return "Pirate";
        case "pl":
            return "Polish";
        case "pt-BR":
            return "Portuguese (Brazil)";
        case "pt-PT":
            return "Portuguese (Portugal)";
        case "pa":
            return "Punjabi";
        case "qu":
            return "Quechua";
        case "ro":
            return "Romanian";
        case "rm":
            return "Romansh";
        case "nyn":
            return "Runyakitara";
        case "ru":
            return "Russian";
        case "gd":
            return "Scots Gaelic";
        case "sr":
            return "Serbian";
        case "sh":
            return "Serbo-Croatian";
        case "st":
            return "Sesotho";
        case "tn":
            return "Setswana";
        case "crs":
            return "Seychellois Creole";
        case "sn":
            return "Shona";
        case "sd":
            return "Sindhi";
        case "si":
            return "Sinhalese";
        case "sk":
            return "Slovak";
        case "sl":
            return "Slovenian";
        case "so":
            return "Somali";
        case "es":
            return "Spanish";
        case "es-419":
            return "Spanish (Latin American)";
        case "su":
            return "Sundanese";
        case "sw":
            return "Swahili";
        case "sv":
            return "Swedish";
        case "tg":
            return "Tajik";
        case "ta":
            return "Tamil";
        case "tt":
            return "Tatar";
        case "te":
            return "Telugu";
        case "th":
            return "Thai";
        case "ti":
            return "Tigrinya";
        case "to":
            return "Tonga";
        case "lua":
            return "Tshiluba";
        case "tum":
            return "Tumbuka";
        case "tr":
            return "Turkish";
        case "tk":
            return "Turkmen";
        case "tw":
            return "Twi";
        case "ug":
            return "Uighur";
        case "uk":
            return "Ukrainian";
        case "ur":
            return "Urdu";
        case "uz":
            return "Uzbek";
        case "vi":
            return "Vietnamese";
        case "cy":
            return "Welsh";
        case "wo":
            return "Wolof";
        case "xh":
            return "Xhosa";
        case "yi":
            return "Yiddish";
        case "yo":
            return "Yoruba";
        case "zu":
            return "Zulu";
        default:
            return "English";
    }
}

/**
 * @return array
 */
function languageArray()
{
    return array('af', 'ak', 'sq', 'am', 'ar', 'hy', 'az', 'eu', 'be', 'bem', 'bn', 'bh', 'xx-bork', 'bs', 'br', 'bg', 'km', 'ca', 'chr', 'ny', 'zh-CN', 'zh-TW', 'co', 'hr', 'cs', 'da', 'nl', 'xx-elmer', 'en', 'eo', 'et', 'ee', 'fo', 'tl', 'fi', 'fr', 'fy', 'gaa', 'gl', 'ka', 'de', 'el', 'gn', 'gu', 'xx-hacker', 'ht', 'ha', 'haw', 'iw', 'hi', 'hu', 'is', 'ig', 'id', 'ia', 'ga', 'it', 'ja', 'jw', 'kn', 'kk', 'rw', 'rn', 'xx-klingon', 'kg', 'ko', 'kri', 'ku', 'ckb', 'ky', 'lo', 'la', 'lv', 'ln', 'lt', 'loz', 'lg', 'ach', 'mk', 'mg', 'ms', 'ml', 'mt', 'mi', 'mr', 'mfe', 'mo', 'mn', 'sr-ME', 'ne', 'pcm', 'nso', 'no', 'nn', 'oc', 'or', 'om', 'ps', 'fa', 'xx-pirate', 'pl', 'pt-BR', 'pt-PT', 'pa', 'qu', 'ro', 'rm', 'nyn', 'ru', 'gd', 'sr', 'sh', 'st', 'tn', 'crs', 'sn', 'sd', 'si', 'sk', 'sl', 'so', 'es', 'es-419', 'su', 'sw', 'sv', 'tg', 'ta', 'tt', 'te', 'th', 'ti', 'to', 'lua', 'tum', 'tr', 'tk', 'tw', 'ug', 'uk', 'ur', 'uz', 'vi', 'cy', 'wo', 'xh', 'yi', 'yo', 'zu');
}