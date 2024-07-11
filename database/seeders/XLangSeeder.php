<?php

namespace Database\Seeders;

use App\Models\XLang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class XLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //


        $langz = [
            'en' => 'English',
            'ar' => 'عربي',
            'es' => 'Spanish',
            'fr' => 'French',
            'pt' => 'Portuguese',
            'fa' => 'پارسی',
            'ru' => 'Русский',
            'de' => 'Deutsch',
            'ro' => 'Romanian',
            'it' => 'Italian',
            'zh'=> '简化字',
        ];
        if (config('app.xlang.active')) {
            $lang = new XLang();
            $lang->tag = config('app.xlang.main');
            $lang->emoji = getEmojiLanguagebyCode(config('app.xlang.main'));
            $lang->name = $langz[config('app.xlang.main')]??config('app.xlang.main');
            $lang->rtl = langIsRTL(config('app.xlang.main'));
            $lang->is_default = true;
            $lang->save();
        }
    }
}
