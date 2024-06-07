<?php

use App\Helpers;


/**
 * @param $lang code like fa
 * @return string
 */
function getEmojiLanguagebyCode($lang) : string
{
    $languages = [
        "af" => "🇿🇦", // Afrikaans
        "sq" => "🇦🇱", // Albanian
        "am" => "🇪🇹", // Amharic
        "ar" => "🇸🇦", // Arabic
        "hy" => "🇦🇲", // Armenian
        "az" => "🇦🇿", // Azerbaijani
        "eu" => "🇪🇸", // Basque
        "be" => "🇧🇾", // Belarusian
        "bn" => "🇧🇩", // Bengali
        "bs" => "🇧🇦", // Bosnian
        "bg" => "🇧🇬", // Bulgarian
        "ca" => "🇪🇸", // Catalan
        "zh" => "🇨🇳", // Chinese
        "hr" => "🇭🇷", // Croatian
        "cs" => "🇨🇿", // Czech
        "da" => "🇩🇰", // Danish
        "nl" => "🇳🇱", // Dutch
        "en" => "🇺🇸", // English
        "et" => "🇪🇪", // Estonian
        "fi" => "🇫🇮", // Finnish
        "fr" => "🇫🇷", // French
        "gl" => "🇪🇸", // Galician
        "ka" => "🇬🇪", // Georgian
        "de" => "🇩🇪", // German
        "el" => "🇬🇷", // Greek
        "gu" => "🇮🇳", // Gujarati
        "ht" => "🇭🇹", // Haitian
        "he" => "🇮🇱", // Hebrew
        "hi" => "🇮🇳", // Hindi
        "hu" => "🇭🇺", // Hungarian
        "is" => "🇮🇸", // Icelandic
        "id" => "🇮🇩", // Indonesian
        "ga" => "🇮🇪", // Irish
        "it" => "🇮🇹", // Italian
        "ja" => "🇯🇵", // Japanese
        "kk" => "🇰🇿", // Kazakh
        "ko" => "🇰🇷", // Korean
        "lv" => "🇱🇻", // Latvian
        "lt" => "🇱🇹", // Lithuanian
        "mk" => "🇲🇰", // Macedonian
        "ms" => "🇲🇾", // Malay
        "ml" => "🇮🇳", // Malayalam
        "mt" => "🇲🇹", // Maltese
        "mn" => "🇲🇳", // Mongolian
        "no" => "🇳🇴", // Norwegian
        "ps" => "🇦🇫", // Pashto
        "fa" => "🇮🇷", // Persian
        "pl" => "🇵🇱", // Polish
        "pt" => "🇵🇹", // Portuguese
        "ro" => "🇷🇴", // Romanian
        "ru" => "🇷🇺", // Russian
        "sr" => "🇷🇸", // Serbian
        "sk" => "🇸🇰", // Slovak
        "sl" => "🇸🇮", // Slovenian
        "es" => "🇪🇸", // Spanish
        "sw" => "🇰🇪", // Swahili
        "sv" => "🇸🇪", // Swedish
        "ta" => "🇮🇳", // Tamil
        "te" => "🇮🇳", // Telugu
        "th" => "🇹🇭", // Thai
        "tr" => "🇹🇷", // Turkish
        "uk" => "🇺🇦", // Ukrainian
        "ur" => "🇵🇰", // Urdu
        "uz" => "🇺🇿", // Uzbek
        "vi" => "🇻🇳", // Vietnamese
        "cy" => "🇬🇧"  // Welsh
    ];
    $lang = strtolower($lang);
    if (array_key_exists($lang, $languages)) {
        return $languages[$lang];
    } else {
        return "❓";
    }
}

/**
 * has route as named we want this model?
 * @param $name string
 * @param $endRoute string 'index' or alt list
 * @return bool
 */

function hasRoute($name,$endRoute = 'index') : bool
{
    // create route
    $cRuote = str_replace($endRoute, $name, request()->route()->getName());
    if (\Illuminate\Support\Facades\Route::has($cRuote)) {
        return true;
    } else {
        return false;
    }
}

/**
 * get named route url
 * @param $name string
 * @param $args array
 * @param $endRoute string 'index' or alt list
 * @return string|null
 */
function getRoute($name, $args = [],$endRoute = 'index') : string | null
{
    // create route
    $cRuote = str_replace($endRoute, $name, request()->route()->getName());
    if (\Illuminate\Support\Facades\Route::has($cRuote)) {
        return \route($cRuote, $args);
    } else {
        return null;
    }
}


/**
 * make sort link suffix
 * @param $col string
 * @return string
 */
function sortSuffix($col) : string
{
    if (request()->sort == $col) {
        if (request('sortType', 'asc') == 'desc') {
            return '&sortType=asc';
        } else {
            return '&sortType=desc';
        }
    } else {
        return '';
    }
}


/**
 * make array compatible | help us to translate
 * @param $array
 * @param $translate
 * @return false|string
 */
function arrayNormolizeVueCompatible($array, $translate = false): false | string
{
    $result = [];
    foreach ($array as $index => $item) {
        $result[] = ['id' => $index, 'name' => ($translate ? __($item) : $item)];
    }
    return json_encode($result);
}


/**
 * check string is json or not
 * @param $string
 * @return bool
 */
function isJson($string) : bool {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}


/**
 * save admin batch log
 * @param $method
 * @param $cls class
 * @param $ids
 * @return void
 */
function logAdminBatch($method, $cls, $ids): void
{
    $act = explode('\\', $method);
    foreach ($ids as $id) {
        auth()->user()->logs()->create([
            'action' => $act[count($act) - 1],
            'loggable_type' => $cls,
            'loggable_id' => $id,
        ]);
    }
}

/**
 * save admin log
 * @param $method
 * @param $cls class
 * @param $id
 * @return void
 */
function logAdmin($method, $cls, $id) :void
{
    $act = explode('\\', $method);
    auth()->user()->logs()->create([
        'action' => $act[count($act) - 1],
        'loggable_type' => $cls,
        'loggable_id' => $id,
    ]);
}
