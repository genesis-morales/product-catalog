<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Subcategory::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->words(2, true)), // Ej: "Comida rápida"
            'category_id' => Category::factory(), // por si se crea sola
        ];
    }
}
