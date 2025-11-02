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
        // Crear 4 categorías
        Category::factory(4)->create();

        // Crear 8 subcategorías
        Subcategory::factory(8)->create();

        // Crear 5 productos
        Product::factory(5)->create();
    }
}
