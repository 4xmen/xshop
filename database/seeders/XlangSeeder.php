<?php

namespace Database\Seeders;

use App\Models\Xlang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class XlangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $lang = new Xlang();
        $lang->tag = config('app.xlang_main');
        $lang->rtl =  true;
        $lang->is_default = true;
        $lang->name = __("Default");
        $lang->save();
    }
}
