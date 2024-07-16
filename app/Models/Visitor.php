<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public static $engines = [
        'google' => ['q', 'query'],
        'bing' => ['q'],
        'yahoo' => ['p'],
        'yandex' => ['text'],
        'baidu' => ['wd', 'word'],
        'duckduckgo' => ['q'],
        'ask' => ['q'],
        'aol' => ['q'],
        'naver' => ['query'],
        'ecosia' => ['q'],
    ];

    public static $browserList = ['Firefox' => '(Firefox)',
        'FirFox' => '(FireFox)',
        'Chrome' => '(Chrome)(?!.*Edge)',
        'Edge' => '(Edg|Edge)',
        'Opera' => '(OPR|Opera)',
        'Brave' => '(Brave)',
        'Safari' => '(Safari)(?!.*Chrome)',
        'Internet Explorer' => '(MSIE|Trident)',
        'DeepNet Explorer' => '(Deepnet)',
        'Flock' => '(Flock)',
        'Maxthon' => '(Maxthon)',
        'Avant Browser' => '(Avant)',
        'AOL' => '(AOL)',
        'Vivaldi' => '(Vivaldi)',
        'UC Browser' => '(UCBrowser)',
        'Yandex Browser' => '(YaBrowser)',
        'Samsung Internet' => '(SamsungBrowser)',
    ];

    public static $osList = [
        'Linux' => '(Linux)',
        'Windows 11' => '(Windows NT 11.0)', // Added Windows 11
        'Windows 10' => '(Windows NT 10.0)',
        'Mac OS X' => '(Mac OS X)',
        'Android' => '(Android)',
        'iOS' => '(iPhone)|(iPad)',
        'Windows 8.1' => '(Windows NT 6.3)',
        'Windows 8' => '(Windows NT 6.2)',
        'Windows 7' => '(Windows NT 6.1)',
        'Windows Vista' => '(Windows NT 6.0)',
        'Windows Server 2003/XP x64' => '(Windows NT 5.2)',
        'Windows XP' => '(Windows NT 5.1)',
        'Windows 2000' => '(Windows NT 5.0)',
        'Windows ME' => '(Win 9x 4.90)',
        'Windows 98' => '(Windows 98)',
        'Windows 95' => '(Windows 95)',
        'Windows CE' => '(Windows CE)',
        'Windows (iPhone/iPad)' => 'Windows (iPhone|iPad)',
        'Mac OS' => '(MacPPC)|(Mac_PowerPC)|(Macintosh)',
        'Ubuntu' => '(Ubuntu)',
        'Linux Mint' => '(Linux Mint)',
        'Debian' => '(Debian)',
        'Fedora' => '(Fedora)',
        'Red Hat' => '(Red Hat)',
        'SuSE' => '(SuSE)',
        'webOS' => '(webOS)|(hpwOS)',
        'BlackBerry' => '(BlackBerry)',
        'Symbian' => '(Symbian)',
        'FreeBSD' => '(FreeBSD)',
        'OpenBSD' => '(OpenBSD)',
        'NetBSD' => '(NetBSD)',
        'SunOS' => '(SunOS)',
        'OpenSolaris' => '(OpenSolaris)',
        'Chrome OS' => '(Chrome OS)|(CrOS)',
        'bot' => '(bot)'
    ];

}
