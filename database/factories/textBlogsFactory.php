<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\textBlogs;

class textBlogsFactory extends Factory
{
    protected $model = textBlogs::class;

    public function definition()
    {
            return [
                'title' => $this->faker->unique()->name(),
                'details' => Str::random(10),
                'user_id' => 1,
            ];
    }
}
