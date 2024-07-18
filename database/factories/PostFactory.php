<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    public $icons = [
        'ri-home-4-line',
        'ri-building-line',
        'ri-mail-open-line',
        'ri-award-line',
        'ri-line-chart-line',
        'ri-verified-badge-line',
        'ri-pie-chart-2-line',
        'ri-printer-line',
        'ri-service-line',
        'ri-chat-1-line',
        'ri-compasses-2-line',
        'ri-code-s-slash-line',
        'ri-phone-line',
        'ri-rss-line',
        'ri-fingerprint-line',
        'ri-trophy-line',
        'ri-shopping-cart-line',
        'ri-hand-heart-line',
        'ri-funds-line',
        'ri-heart-2-line',
        'ri-map-pin-line',
        'ri-notification-2-line',
        'ri-alarm-line',
        'ri-user-6-line',
        'ri-cloudy-2-line',
        'ri-key-2-line',
        'ri-customer-service-2-line',
        'ri-bar-chart-grouped-line',
        'ri-survey-line',
        'ri-image-circle-line',
        'ri-mic-2-line',
        'ri-speed-up-line',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->realText(75);
        return [
            //
            'title' => $title,
            'slug' => sluger($title),
            'subtitle' => $this->faker->realText(),
            'body' => $this->faker->realText(500),
            'group_id' => Group::inRandomOrder()->first()->id,
            'hash' => str_pad(dechex(crc32($title)), 8, '0', STR_PAD_LEFT),
            'status' => rand(0,1),
            'view' => rand(0,999),
            'user_id' => User::where('id','<',6)->inRandomOrder()->first()->id,
            'icon' => $this->icons[rand(0,count($this->icons)-1)],
        ];
    }
}
