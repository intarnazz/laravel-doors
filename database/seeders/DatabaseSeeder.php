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

        $img_id = 1;
        for ($i = 1; $i < 11; $i++) {
            \App\Models\Image::create([
                'path' => 'img_' . $img_id++ . '.png',
                'title' => 'title',
                'alt' => 'alt',
                'style' => '',
            ]);
            \App\Models\Image::create([
                'path' => 'img_' . $img_id++ . '.png',
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
                'image_front_id' => $img_id - 1,
                'image_back_id' => $img_id - 2,
                'brand_id' => $i,
                'material_id' => $i,
                'name' => $faker->word,
                'is_favorite' => true,
                'price' => $faker->randomFloat(0, 2000, 20000),
            ]);
        }
    }
}
