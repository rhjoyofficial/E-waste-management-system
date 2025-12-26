<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
  public function run(): void
  {
    $categories = [
      ['name' => 'Mobile Phones', 'slug' => 'mobile-phones'],
      ['name' => 'Laptops', 'slug' => 'laptops'],
      ['name' => 'Tablets', 'slug' => 'tablets'],
      ['name' => 'Desktop Computers', 'slug' => 'desktop-computers'],
      ['name' => 'Monitors', 'slug' => 'monitors'],
      ['name' => 'Printers', 'slug' => 'printers'],
      ['name' => 'Batteries', 'slug' => 'batteries'],
      ['name' => 'Televisions', 'slug' => 'televisions'],
      ['name' => 'Audio Equipment', 'slug' => 'audio-equipment'],
      ['name' => 'Other', 'slug' => 'other'],
    ];

    foreach ($categories as $category) {
      Category::firstOrCreate(
        ['slug' => $category['slug']],
        [
          'name' => $category['name'],
          'is_active' => true
        ]
      );
    }
  }
}
