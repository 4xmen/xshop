<?php

namespace App\Helpers;

use App\Models\Visitor;

/**
 * @package Helpers
 * @author A1Gard <a1gard@4xmen.ir>
 * @date : 3-April-2013 (14-1-1392)
 * @time : 20:32
 * @subpackage   TVisitor
 * @version 1.0
 * @todo : TVisitor class for get visitor info
 */
class TVisitor {

    function __construct() {

    }

    /**
     * @todo Detect visitor OS
     * @return int os number
     */
    public static function DetectOSI() {
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return 0;

        $os_list = array_values(Visitor::$osList);

        foreach ($os_list as $index => $match) {
            if (preg_match("/$match/i", $_SERVER['HTTP_USER_AGENT'])) {
                return $index + 1;
            }
        }

        return null;
    }

    /**
     * @todo Detect visitor OS
     * @return string OS name
     */
    public static function DetectOS() {
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return null;

        $os_list = Visitor::$osList;

        foreach ($os_list as $os => $pattern) {
            if (preg_match("/$pattern/i", $_SERVER['HTTP_USER_AGENT'])) {
                return $os;
            }
        }

        return null;
    }

    /**
     * @todo Detect if visitor is using a mobile device
     * @return bool
     */
    public static function IsMobile() {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }

        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        // List of mobile devices and operating systems
        $mobile_agents = [
            'mobile', 'android', 'iphone', 'ipod', 'ipad', 'windows phone', 'blackberry', 'kindle', 'silk',
            'opera mini', 'opera mobi', 'webos', 'symbian', 'nokia', 'samsung', 'lg', 'htc', 'mot', 'tablet',
            'rim tablet', 'meego', 'netfront', 'bolt', 'fennec', 'series60', 'maemo', 'midp', 'cldc', 'up.browser',
            'up.link', 'mmp', 'symbian', 'smartphone', 'wap',
        ];

        // Check if user agent contains any mobile keywords
        foreach ($mobile_agents as $agent) {
            if (strpos($user_agent, $agent) !== false) {
                return true;
            }
        }

        // Check for mobile-specific headers
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false) {
                return true;
            }
        }

        if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
            return true;
        }

        // Check for Opera Mini
        if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
            return true;
        }

        // Use PHP's built-in mobile detection (if available)
        if (function_exists('http_negotiate_language')) {
            $accept = http_negotiate_language(['wap', 'html']);
            if ($accept === 'wap') {
                return true;
            }
        }

        return false;
    }



    /**
     * @todo Get browser name only
     * @return string browser name
     */
    public static function DetectBrowser() {
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return null;

        $browser_list = Visitor::$browserList;

        foreach ($browser_list as $browser => $pattern) {
            if (preg_match("/$pattern/i", $_SERVER['HTTP_USER_AGENT'])) {
                return $browser;
            }
        }

        return null;
    }

    /**
     * @todo Get browser name only
     * @return int browser num
     */
    public static function DetectBrowserI() {
        if (!isset($_SERVER['HTTP_USER_AGENT']))
            return 0;

        $browser_list = array_values(Visitor::$browserList);

        foreach ($browser_list as $index => $pattern) {
            if (preg_match("/$pattern/i", $_SERVER['HTTP_USER_AGENT'])) {
                return $index + 1;
            }
        }

        return 0;
    }

    /**
     * @todo Find browser version
     * @return string version
     */
    public static function BrowserVersion() {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return '0';
        }

        $ua = $_SERVER['HTTP_USER_AGENT'];
        $browser = self::DetectBrowser();

        $version = null;

        switch ($browser) {
            case 'Edge':
                if (preg_match('/(Edge|Edg)\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[2];
                }
                break;
            case 'Chrome':
                if (preg_match('/Chrome\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Firefox':
                if (preg_match('/Firefox\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Safari':
                if (preg_match('/Version\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1];
                }
                break;
            case 'Opera':
                if (preg_match('/(OPR|Opera)\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[2];
                }
                break;
            case 'Internet Explorer':
                if (preg_match('/MSIE (\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1];
                } elseif (preg_match('/rv:(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1]; // For IE 11
                }
                break;
            default:
                // Generic version detection for other browsers
                if (preg_match('/' . preg_quote($browser, '/') . '\/(\d+(\.\d+)*)/', $ua, $matches)) {
                    $version = $matches[1];
                }
                break;
        }

        return $version;
    }

    /**
     * Get searched keywords from referrer URL
     * @param string $referer
     * @return array|null
     */
    public static function GetKeyword($referer = null) {
        if ($referer === null) {
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        }

        if (empty($referer)) {
            return null;
        }

        $engines = Visitor::$engines;

        $parsed_url = parse_url($referer);
        $host = isset($parsed_url['host']) ? strtolower($parsed_url['host']) : '';
        $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';

        parse_str($query, $query_params);

        foreach ($engines as $engine => $params) {
            if (strpos($host, $engine) !== false) {
                foreach ($params as $param) {
                    if (isset($query_params[$param]) && !empty($query_params[$param])) {
                        return [
                            'engine' => $engine,
                            'keyword' => urldecode($query_params[$param])
                        ];
                    }
                }
            }
        }

        return null;
    }

//    /**
//     * @param string $class alternative class
//     * return vistor os icon
//     * @uses awesome font
//     */
//    static public function GetOSIcon($class = '') {
//        // get os
//        $os_int = self::DetectOSI();
//
//        $win = range(1, 16);
//        $linux = range(17, 19);
//        $osx = array(20, 21);
//        $android = array(25);
//        $searchbot = array(27);
//        $other = array(0, 22, 23, 24, 26);
//
//        switch (true) {
//            case in_array($os_int, $win):
//                $icon = 'windows';
//                break;
//            case in_array($os_int, $linux):
//                $icon = 'linux';
//                break;
//            case in_array($os_int, $osx):
//                $icon = 'apple';
//                break;
//
//            case in_array($os_int, $android):
//                $icon = 'android';
//                break;
//
//            case in_array($os_int, $searchbot):
//                $icon = 'google';
//                break;
//            default:
//                $icon = 'question';
//                break;
//        }
//
//        $result = '<span class="fa fa-' . $icon . ' ' . $class . '" title="'
//            . self::DetectOS() . '" ></span>';
//
//        return $result;
//    }
//    /**
//     * @param string $class alternative class
//     * return vistor browser icon
//     * @uses awesome font
//     */
//    static public function GetBrowerIcon($class = '') {
//        // get os
//        $bowser = self::DetectBrowser();
//
//
//
//        $result = '<span class="fa fa-' . strtolower($bowser) . ' ' . $class . '" title="'
//            . self::DetectBrowser() . '" ></span>';
//        return $result;
//    }

    public static function getRefererDomain() {
        if(isset($_SERVER['HTTP_REFERER'])) {
            $referer = parse_url($_SERVER['HTTP_REFERER']);
            $domain = isset($referer['host']) ? $referer['host'] : null;
            return $domain;
        } else {
            return null;
        }
    }

}
