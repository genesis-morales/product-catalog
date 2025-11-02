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
       $products = [
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'Laptop profesional con chip M3 Pro, 16GB RAM, 512GB SSD',
                'price' => 1999.99,
            ],
            [
                'name' => 'ThinkPad X1 Carbon',
                'description' => 'Laptop ultraligera con procesador Intel Core i7, 16GB RAM',
                'price' => 1599.99,
            ],
            [
                'name' => 'Logitech MX Keys',
                'description' => 'Teclado inalámbrico retroiluminado con teclas de perfil bajo',
                'price' => 99.99,
            ],
            [
                'name' => 'Logitech MX Master 3S',
                'description' => 'Ratón ergonómico inalámbrico con 8000 DPI',
                'price' => 89.99,
            ],
            [
                'name' => 'Samsung 980 PRO 1TB',
                'description' => 'SSD NVMe M.2 con velocidades de hasta 7000 MB/s',
                'price' => 129.99,
            ],
            [
                'name' => 'WD Black SN850X 2TB',
                'description' => 'SSD rápido para gaming y edición de video',
                'price' => 189.99,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone con chip A17 Pro, 256GB, cámara de 48MP',
                'price' => 1199.99,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Smartphone 5G con pantalla AMOLED 120Hz',
                'price' => 999.99,
            ],
            [
                'name' => 'Corsair RM850e',
                'description' => 'Fuente de poder 850W 80+ Gold modular',
                'price' => 129.99,
            ],
            [
                'name' => 'ROG Zephyrus G14',
                'description' => 'Laptop gaming ASUS con RTX 4090, pantalla 120Hz',
                'price' => 2299.99,
            ],
        ];

        $product = $this->faker->randomElement($products);

        return [
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'stock' => $this->faker->numberBetween(5, 100),
            'available' => $this->faker->boolean(90), // 90% de probabilidad de estar disponible
            'img' => 'https://example.com/' . $this->faker->slug() . '.jpg',
            'subcategory_id' => Subcategory::inRandomOrder()->first()->id,
        ];
    }
}
