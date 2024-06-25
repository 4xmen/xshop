<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Clip;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        switch (rand(0, 3)) {
            case 0:
            case 1:
                $c = Post::class;
                $m = $c::inRandomOrder()->first()->id;
                break;
            case 2:
            case 3:
                $c = Product::class;
                $m = $c::inRandomOrder()->first()->id;
                break;
//            case 4:
//                $c = Gallery::class;
//                $m = $c::inRandomOrder()->first()->id;
//                break;
//            case 5:
//                $c = Clip::class;
//                $m = $c::inRandomOrder()->first()->id;
//                break;
//            case 6:
//                $c = Attachment::class;
//                $m = $c::inRandomOrder()->first()->id;
//                break;
        }
        $comment  = [
            //
            'body' => $this->faker->realText(),
            'commentable_id' => $m,
            'commentable_type' => $c,
            'ip'=> $this->faker->ipv4(),
            'status' => rand(-1,1)

        ];
        switch (rand(0,2)){
            case 0:
                $comment['email'] = $this->faker->email;
                $comment['name'] = $this->faker->name;
                break;
            case 1:
                $comment['commentator_type'] = Customer::class;
                $comment['commentator_id'] = Customer::inRandomOrder()->first()->id;
                break;
            case 2:
                $comment['commentator_type'] = User::class;
                $comment['commentator_id'] = User::inRandomOrder()->first()->id;
                break;
        }
        if (rand(0,3) == 1 && Comment::count() > 0){
            $comment['parent_id'] = Comment::inRandomOrder()->first()->id;
        }
        return $comment;
    }
}
