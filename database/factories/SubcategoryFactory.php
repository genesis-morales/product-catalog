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
        $subcategories = [
            'Laptops',
            'Desktops',
            'Tablets',
            'Mini PCs',
            'Teclados',
            'Ratones',
            'Webcams',
            'Micrófonos',
            'Auriculares',
            'Monitores',
            'Discos Duros (HDD)',
            'Discos Sólidos (SSD)',
            'USB/Pendrives',
            'Tarjetas de Memoria',
            'Procesadores (CPUs)',
            'Tarjetas Gráficas (GPUs)',
            'Memorias RAM',
            'Placas Madre',
            'Fuentes de Poder',
            'Routers',
            'Switches',
            'Adaptadores WiFi',
            'Cables Ethernet',
        ];

        return [
            'name' => $this->faker->randomElement($subcategories),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
