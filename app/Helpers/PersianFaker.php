<?php

namespace App\Helpers;

class PersianFaker
{

    private static $mobile_prefix = ['0912', '0919', '0935', '0936', '0937', '0933', '0938', '0915'];
    private static $card_prefix = ['6037', '6104', '6391', '6280', '6273', '6287', '6280', '5022'];

    private static $colors = [
        'red' => ['name' => 'قرمز', 'code' => '#ff0000'],
        'blue' => ['name' => 'آبی', 'code' => '#0000ff'],
        'green' => ['name' => 'سبز', 'code' => '#008000'],
        'yellow' => ['name' => 'زرد', 'code' => '#ffff00'],
        'purple' => ['name' => 'بنفش', 'code' => '#800080'],
        'orange' => ['name' => 'نارنجی', 'code' => '#ffa500'],
        'pink' => ['name' => 'صورتی', 'code' => '#ffc0cb'],
        'white' => ['name' => 'سفید', 'code' => '#ffffff'],
        'black' => ['name' => 'سیاه', 'code' => '#000000'],
        'grey' => ['name' => 'خاکستری', 'code' => '#808080'],
        'brown' => ['name' => 'قهوه‌ای', 'code' => '#a52a2a'],
        'silver' => ['name' => 'نقره‌ای', 'code' => '#c0c0c0'],
        'gold' => ['name' => 'طلایی', 'code' => '#ffd700'],
        'turquoise' => ['name' => 'فیروزه ای', 'code' => '#40e0d0'],
        'magenta' => ['name' => 'بنفش روشن', 'code' => '#ff00ff'],
        'cyan' => ['name' => 'فیروزی', 'code' => '#00ffff'],
        'maroon' => ['name' => 'آبی کمرنگ', 'code' => '#800000'],
        'navy' => ['name' => 'نیرویی', 'code' => '#000080'],
        'teal' => ['name' => 'نیلی', 'code' => '#008080'],
        'olive' => ['name' => 'زیتونی', 'code' => '#808000'],
    ];

    static public function mobile()
    {
        return self::$mobile_prefix[rand(0, count(self::$mobile_prefix) - 1)] . rand(1000000, 9999999);
    }


    static public function shetabCard()
    {
        return self::$card_prefix[rand(0, count(self::$card_prefix) - 1)] . '-'
            . rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
    }


    static function validCodeMeli()
    {
        do {
            $randomNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            $code = '0000' . $randomNumber;
            $code = substr($code, strlen($code) - 10, 10);

            if (intval(substr($code, 3, 6)) == 0) {
                continue;
            }

            $checksum = intval(substr($code, 9, 1));
            $s = 0;
            for ($i = 0; $i < 9; $i++) {
                $s += intval(substr($code, $i, 1)) * (10 - $i);
            }

            $s = $s % 11;

            if (($s < 2 && $checksum == $s) || ($s >= 2 && $checksum == (11 - $s))) {
                return $code;
            }
        } while (true);
    }


    static public function color(){
        $colors = self::$colors;
        shuffle($colors);
        return $colors[0];
    }
}
