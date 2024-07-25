<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 1; $i < 11; $i++) {
            \App\Models\Image::create([
                'path' => 'image.jpg',
                'title' => 'title',
                'alt' => 'alt',
                'style' => '',
            ]);

            \App\Models\Brand::create([
                'name' => $faker->company,
            ]);
            \App\Models\Material::create([
                'name' => $faker->word,
            ]);
            \App\Models\Door::create([
                'image_front_id' => $i,
                'image_back_id' => $i,
                'brand_id' => $i,
                'material_id' => $i,
                'name' => $faker->word,
                'price' => $faker->randomFloat(0, 2000, 20000),
            ]);
        }
    }
}
