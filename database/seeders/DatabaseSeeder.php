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

        \App\Models\User::create([
            'login' => 'laravel',
            'password' => 'secret',
        ]);

        \App\Models\Component::create([
            'name' => $faker->unique()->word,
            'price' => $faker->randomFloat(0, 2000, 20000),
        ]);
        \App\Models\Component::create([
            'name' => $faker->unique()->word,
            'price' => $faker->randomFloat(0, 2000, 20000),
        ]);

        $img_id = 1;
        $door_id = 1;
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
                'name' => $faker->unique()->company,
            ]);
            \App\Models\Material::create([
                'name' => $faker->unique()->word,
            ]);
            \App\Models\Door::create([
                'image_front_id' => $img_id - 1,
                'image_back_id' => $img_id - 2,
                'brand_id' => $i,
                'material_id' => $i,
                'type' => 'entrance',
                'name' => $faker->word,
                'is_favorite' => true,
                'price' => $faker->randomFloat(0, 2000, 20000),
            ]);
            \App\Models\Component_door::create([
                'door_id' => $door_id,
                'component_id' => 1,
            ]);
            \App\Models\Component_door::create([
                'door_id' => $door_id++,
                'component_id' => 2,
            ]);
        }

        for ($j = 1; $j < 11; $j++) {
            $img_id = 1;
            for ($i = 1; $i < 11; $i++) {
                $img_id++;
                $img_id++;
                \App\Models\Door::create([
                    'image_front_id' => $img_id - 1,
                    'image_back_id' => $img_id - 2,
                    'brand_id' => $i,
                    'material_id' => $i,
                    'name' => $faker->word,
                    'is_favorite' => true,
                    'price' => $faker->randomFloat(0, 2000, 20000),
                ]);
                \App\Models\Component_door::create([
                    'door_id' => $door_id,
                    'component_id' => 1,
                ]);
                \App\Models\Component_door::create([
                    'door_id' => $door_id++,
                    'component_id' => 2,
                ]);
            }
        }
    }
}
