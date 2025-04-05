<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->name = ['en' => 'Product' . $i, 'ar' => $i . 'منتج'];
            $product->description = ['en' => 'Description' . $i, 'ar' => $i . 'وصف'];
            $product->sale_price = 100;
            $product->purchase_price = 100;
            $product->category_id = rand(1, 3); // Assuming you have 3 categories
            $product->stock = 10;
            $product->save();
        }
    }
}
