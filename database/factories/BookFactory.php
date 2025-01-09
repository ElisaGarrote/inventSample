<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'book_number' => $this->faker->unique()->isbn13,
            'study_title' => $this->faker->sentence,
            'authors' => $this->faker->name,
            'categories' => $this->faker->word,
            'restriction_codes' => $this->faker->optional()->word,
        ];
    }
}