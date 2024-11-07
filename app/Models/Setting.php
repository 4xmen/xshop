<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['value'];

    public static $settingTypes = ['TEXT', 'NUMBER', 'LONGTEXT', 'CODE', 'EDITOR',
        'CATEGORY', 'GROUP', 'CHECKBOX', 'FILE', 'COLOR', 'SELECT', 'MENU', 'LOCATION',
        'ICON','DATE','DATETIME','TIME'];

    public function getData()
    {
        return json_decode($this->data, true);
    }
}
