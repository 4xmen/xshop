<?php

namespace App\Observers;

use App\Models\Setting;

class settingObserver
{
    public $afterCommit = true;

    /**
     * Handle the setting "created" event.
     *
     * @param  \App\Setting  $setting
     * @return void
     */
//    public function created(Setting $setting)
//    {
//        //
//    }

    /**
     * Handle the setting "updated" event.
     *
     * @param  \App\Setting  $setting
     * @return void
     */
//    public function updated(Setting $setting)
//    {
//        //
//        if ($setting->key == 'price'){
//            $p = (float) str_replace(',','',$setting->value);
//            if ($setting->value != $p){
//                $setting->value = $p;
//                $setting->save();
//                return ;
//            }
//            $pros = Product::where('active',1)->get();
//            foreach ($pros as $pro){
//                if ($pro->getMeta('weight') != null){
//                    $np = (($p * (float) $pro->getMeta('weight')) /(100+7+9+15) )* 100;
//                    $pro->price = $np;
//                    $pro->save();
//                }
//            }
//        }
//    }

    /**
     * Handle the setting "deleted" event.
     *
     * @param  \App\Setting  $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "restored" event.
     *
     * @param  \App\Setting  $setting
     * @return void
     */
    public function restored(Setting $setting)
    {
        //
    }

    /**
     * Handle the setting "force deleted" event.
     *
     * @param  \App\Setting  $setting
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
        //
    }


}
