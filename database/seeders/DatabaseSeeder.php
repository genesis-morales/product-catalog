<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

use App\Models\SubcategoryCategory;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos 10 categorías
        Category::factory(10)->create()->each(function ($category) {
            
            // Por cada categoría creada, generamos entre 2 y 5 subcategorías
            Subcategory::factory(rand(2, 5))->create([
                // Asignamos la subcategoría a la categoría actual
                'category_id' => $category->id
            ])->each(function ($subcategory) {

                // Por cada subcategoría creada, generamos entre 3 y 10 productos
                Product::factory(rand(3, 10))->create([
                    // Asignamos el producto a la subcategoría actual
                    'subcategory_id' => $subcategory->id
                ]);
            });
        });
    }
}
