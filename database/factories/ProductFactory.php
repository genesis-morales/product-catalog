<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

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

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->words(2, true)), 
            'description'=> $this->faker->sentence(),
            'price'=> $this->faker->randomFloat(2, 10, 500),
            'subcategory_id' => Subcategory::factory(), // igual, por si se crea fuera del seeder    
        ];
    }
}
