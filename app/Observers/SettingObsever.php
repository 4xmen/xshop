<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObsever
{
    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        //
        $setting->raw = $setting->value;
        $setting->save();
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     */
    public function restored(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     */
    public function forceDeleted(Setting $setting): void
    {
        //
    }
}
