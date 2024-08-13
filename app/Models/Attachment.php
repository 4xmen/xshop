<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Attachment extends Model
{
    use HasFactory,HasTranslations;

    public static $mrohps = [Product::class,Post::class,Group::class,
        Category::class,Clip::class,Gallery::class];

    public $translatable = ['title','subtitle','body'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function url()
    {
        if ($this->file == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \Storage::url('attachments/' . $this->file);
    }

    public function tempUrl() // WIP
    {

        if ($this->file == null) {
            return asset('/assets/upload/logo.svg');
        }

        return \URL::temporarySignedRoute(
            'client.attach-dl', now()->addMinutes(60), [$this->slug]
        );
        return \Storage::url('attachments/' . $this->file);
    }


    public function ownerModel(){
        switch ($this->attachable_type){
            case Product::class:
                return Product::whereId($this->attachable_id)->first();
            case Post::class:
                return Post::whereId($this->attachable_id)->first();
            case Group::class:
                return Group::whereId($this->attachable_id)->first();
            case Category::class:
                return Category::whereId($this->attachable_id)->first();
            case Clip::class:
                return Clip::whereId($this->attachable_id)->first();
            case Gallery::class:
                return Gallery::whereId($this->attachable_id)->first();
            default:
                return null;
        }
    }


    public function webUrl()
    {
        return fixUrlLang(route('client.attachment',$this->slug));
    }

}
