<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Xmen\StarterKit\Models\Post;
use Xmen\StarterKit\StarterKitFacade;

class PostSeeder extends Seeder
{

    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items = [
            [
                'title' => 'معرفی مجموعه',
                'category_id' => 1,
            ],
            [
                'title' => 'شعب',
                'category_id' => 1,
            ],
            [
                'title' => 'چگونه ثبت نام کنیم',
                'category_id' => 4,
            ],
            [
                'title' => 'چگونه خرید کنیم',
                'category_id' => 4,
            ],
            [
                'title' => 'قوانین فروشگاه',
                'category_id' => 4,
            ],
            [
                'title' => 'نحوه ارسال محصولات',
                'category_id' => 4,
            ],
        ];

        foreach ($items as $item){
            $p = new Post();
            $p->title = $item['title'];
            $p->slug = StarterKitFacade::slug($item['title']);
            $p->subtitle = $this->faker->realText(100);
            $p->body = $this->faker->realText(500);
            $p->category_id = $item['category_id'];
            $p->user_id = User::first()->id;
            $p->status = 1;
                $p->hash = date('Ym') . str_pad(dechex(crc32($p->slug)), 8, '0', STR_PAD_LEFT);
            $p->save();
            $p->categories()->sync([$item['category_id']]);
            $num = rand(1, 6);
            $p->addMedia(__DIR__ . "/img/$num/$num.jpg")->preservingOriginal()->toMediaCollection();
            $p->save();
        }
    }
}
