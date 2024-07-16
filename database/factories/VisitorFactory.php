<?php

namespace Database\Factories;

use App\Helpers\TVisitor;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $displays = ['1920x1080', '1366x768', '1920x1080', '1366x768', '1280x1024', null, null];
        $displays_mobile = ['360x780', '430x932', '390x844', '375x667', '412x915', '428x926', null];
        if (rand(0, 2) == 1) {
            $date = $this->faker->dateTimeBetween('-30 days', 'now');
        } else {
            $date = $this->faker->dateTimeBetween('-120 days', 'now');
        }
        if (rand(1, 10) == 7) {
            $keyword = $this->faker->word();
            $engine = array_keys(Visitor::$engines)[rand(0, count(Visitor::$engines) - 1)];
        }
        $os = array_keys(Visitor::$osList)[rand(0, 6)];

        return [
            //
            'ip' => $this->faker->ipv4(),
            'visit' => rand(1, rand(2, 12)),
            'browser' => array_keys(Visitor::$browserList)[rand(0, 6)],
            'os' => $os,
            'version' => rand(100, 132),
            'display' => $os === 'iOS' || $os === 'Android' ? $displays_mobile[rand(0, count($displays_mobile) - 1)] : $displays[rand(0, count($displays) - 1)],
            'updated_at' => $date,
            'created_at' => $date,
            'keywords' => $keyword ?? null,
            'engine' => $engine ?? rand(0, 5) == 0 ? 'google' : null,
            'is_mobile' => $os === 'iOS' || $os === 'Android',
        ];
    }
}
