<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'テスト',
            'price' => fake()->numberBetween(100, 1000),
            'description' => 'テスト',
            'image_path' => UploadedFile::fake()->image('test.jpg')
        ];
    }
}
