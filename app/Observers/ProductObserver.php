<?php

namespace App\Observers;

use App\Models\Price;
use App\Models\Product;

class ProductObserver
{
    //
    public function updated(Product $product){
        \Log::info('product update');
        if ($product->wasChanged('price') && $p->price != null){
        \Log::info('product price update');
            $p = new Price();
            $p->product_id = $product->id;
            $p->price = $product->price;
            $p->save();
        }
    }
}
