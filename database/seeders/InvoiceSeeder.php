<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Invoice::factory(70)->create();
        foreach (Invoice::all() as $it){
            $total = 0;
            for ($i = 0; $i <= rand(1,4); $i++) {
                $order = new Order();
                $order->product_id = Product::inRandomOrder()->first()->id;
                $order->count = 1;
                $order->price_total = rand(100,2000).'000';
                $total = $order->price_total ;
                $order->invoice_id = $it->id;
                $order->created_at = $it->created_at;
                $order->updated_at = $it->updated_at;
                $order->save();
            }
            $it->total_price = $total;
            $it->count = $it->orders()->count();

            $it->save();
        }
    }
}
