<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> 1,
            'title' => $this-> faker->sentence,
            'body' =>  $this-> faker->text(400),
        ];

        User::create([
            'name' => 'Edwin Gallardo',
            'email' => 'i@admin.com',
            'password' => bcrypt('12345')
        ]);

        Post::factory()->count(10)->create();
    }
}
