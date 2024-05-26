<?php

use App\Helpers;


/**
 * @param $lang code like fa
 * @return string
 */
function getEmojiLanguagebyCode($lang)
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
 * @return bool
 */

function hasRoute($name)
{
    // create route
    $cRuote = str_replace('index', $name, request()->route()->getName());
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
 * @return string|null
 */
function getRoute($name,$args = [])
{
    // create route
    $cRuote = str_replace('index', $name, request()->route()->getName());
    if (\Illuminate\Support\Facades\Route::has($cRuote)) {
        return \route($cRuote,$args);
    } else {
        return null;
    }
}


/**
 * make sort link suffix
 * @param $col string
 * @return string
 */
function sortSuffix($col){
    if (request()->sort == $col){
        if (request('sortType','asc') == 'desc'){
            return '&sortType=asc';
        }else{
            return '&sortType=desc';
        }
    }else{
        return '';
    }
}
