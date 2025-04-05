<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->name = ['en' => 'Category1', 'ar' => '1فئة'];
        $category->save();

        $category = new Category();
        $category->name = ['en' => 'Category2', 'ar' => '2فئة'];
        $category->save();

        $category = new Category();
        $category->name = ['en' => 'Category3', 'ar' => '3فئة'];
        $category->save();
    }
}
