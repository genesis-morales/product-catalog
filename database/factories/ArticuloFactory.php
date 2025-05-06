<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Articulo;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articulo>
 */
class ArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Articulo::class;


    public function definition(): array
    {
        return [
            'nombre'=> $this->faker->title(),
            'nota'=> $this->faker->sentence(),
            'tipo'=> $this->faker->randomElement(['abarrote', 'fruta', 'verdura', 'otro']),
            'precio'=> $this->faker->randomFloat(2, 10, 500),
            'fecha_vencimiento'=> $this->faker->date(),
        ];
    }
}
