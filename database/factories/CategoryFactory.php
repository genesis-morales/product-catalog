<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Computadoras',
            'Periféricos',
            'Almacenamiento',
            'Componentes',
            'Redes y Conectividad',
            'Audio y Video',
            'Móviles y Accesorios',
            'Gaming'
        ];

        return [
            'name' => $this->faker->randomElement($categories),
        ];
    }
}
