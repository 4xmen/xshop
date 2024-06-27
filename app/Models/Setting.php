<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['value'];

    public static $settingTypes = ['TEXT', 'LONGTEXT', 'CODE', 'EDITOR',
        'CATEGORY', 'GROUP', 'CHECKBOX', 'FILE'];
}
