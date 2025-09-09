<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Employee;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Employee::first(); // link products to first employee

        // Product::create([
        //     'name' => 'Red Roses',
        //     'description' => 'A bouquet of fresh red roses',
        //     'stock' => 12,
        //     'image' => 'roses.jpg',
        //     'employee_id' => $employee->id,
        // ]);

        // Product::create([
        //     'name' => 'White Lilies',
        //     'description' => 'Elegant white lilies, perfect for events',
        //     'stock' => 8,
        //     'image' => 'lilies.jpg',
        //     'employee_id' => $employee->id,
        // ]);

         $products = [
            [
                'name' => '🌹 Red Roses',
                'description' => 'A bouquet of fresh red roses',
                'stock' => 12,
                'price' => 32,
                'image' => 'roses.jpg',
            ],
            [
                'name' => '🌷 Tulips',
                'description' => 'Bright spring tulips in various colors',
                'stock' => 15,
                'price' => 20,
                'image' => 'tulips.jpg',
            ],
            [
                'name' => '🌻 Sunflowers',
                'description' => 'Large golden sunflowers full of sunshine',
                'stock' => 10,
                'price' => 28,
                'image' => 'sunflowers.jpg',
            ],
            [
                'name' => '🌸 Orchids',
                'description' => 'Exotic orchids in vibrant colors',
                'stock' => 6,
                'price' => 38,
                'image' => 'orchids.jpg',
            ],
            [
                'name' => '🌼 Daisies',
                'description' => 'Simple and cheerful daisies',
                'stock' => 20,
                'price' => 16,
                'image' => 'daisies.jpg',
            ],
            [
                'name' => '🌺 Hibiscus',
                'description' => 'Tropical hibiscus flowers in bright red',
                'stock' => 8,
                'price' => 25,
                'image' => 'hibiscus.jpg',
            ],
            [
                'name' => '💐 Peonies',
                'description' => 'Soft pink and white peonies, very elegant',
                'stock' => 9,
                'price' => 28,
                'image' => 'peonies.jpg',
            ],
            [
                'name' => '🌸 Cherry Blossoms',
                'description' => 'Delicate cherry blossoms, symbol of spring',
                'stock' => 14,
                'price' => 40,
                'image' => 'cherry_blossoms.jpg',
            ],
            [
                'name' => '🌼 Marigolds',
                'description' => 'Golden-orange marigolds, vibrant and fresh',
                'stock' => 18,
                'price' => 14,
                'image' => 'marigolds.jpg',
            ],
            [
                'name' => '🌷 Yellow Tulips',
                'description' => 'Cheerful yellow tulips in a bouquet',
                'stock' => 11,
                'price' => 17,
                'image' => 'yellow_tulips.jpg',
            ],
            [
                'name' => '🌹 White Roses',
                'description' => 'Pure white roses, symbol of elegance',
                'stock' => 13,
                'price' => 27,
                'image' => 'white_roses.jpg',
            ],
            [
                'name' => '🌼 Chrysanthemums',
                'description' => 'Beautiful chrysanthemums in mixed colors',
                'stock' => 16,
                'price' => 19,
                'image' => 'chrysanthemums.jpg',
            ],
            [
                'name' => '🌺 Camellias',
                'description' => 'Pink camellias full of beauty',
                'stock' => 7,
                'price' => 24,
                'image' => 'camellias.jpg',
            ],
            [
                'name' => '🌻 Golden Sunflowers',
                'description' => 'Tall sunflowers shining bright',
                'stock' => 10,
                'price' => 29,
                'image' => 'golden_sunflowers.jpg',
            ],
            [
                'name' => '🌸 Exotic Orchids',
                'description' => 'Rare and exotic orchid bouquet',
                'stock' => 5,
                'price' => 45,
                'image' => 'exotic_orchids.jpg',
            ],
            [
                'name' => '🌺 Azaleas',
                'description' => 'Colorful azalea flowers for gardens',
                'stock' => 8,
                'price' => 23,
                'image' => 'azaleas.jpg',
            ],
            [
                'name' => '🌻 Mini Sunflowers',
                'description' => 'Cute and bright mini sunflowers',
                'stock' => 12,
                'price' => 20,
                'image' => 'mini_sunflowers.jpg',
            ],
            [
                'name' => '🌹 Pink Roses',
                'description' => 'Romantic pink roses bouquet',
                'stock' => 15,
                'price' => 33,
                'image' => 'pink_roses.jpg',
            ],
            [
                'name' => '🌸 Orchid Mix',
                'description' => 'Mix of colorful orchids',
                'stock' => 6,
                'price' => 36,
                'image' => 'orchid_mix.jpg',
            ],
            [
                'name' => '🌼 Wildflowers',
                'description' => 'A bouquet of fresh wildflowers',
                'stock' => 18,
                'price' => 13,
                'image' => 'wildflowers.jpg',
            ],
            [
                'name' => '🌺 Gardenias',
                'description' => 'Sweet-scented gardenias',
                'stock' => 9,
                'price' => 21,
                'image' => 'gardenias.jpg',
            ],
            [
                'name' => '🌷 White Tulips',
                'description' => 'Fresh white tulip bouquet',
                'stock' => 14,
                'price' => 16,
                'image' => 'white_tulips.jpg',
            ],
            [
                'name' => '🌻 Bright Sunflowers',
                'description' => 'Bright and tall sunflower bouquet',
                'stock' => 10,
                'price' => 31,
                'image' => 'bright_sunflowers.jpg',
            ],
            [
                'name' => '🌹 Rose Bouquet',
                'description' => 'Mixed rose bouquet for any occasion',
                'stock' => 20,
                'price' => 45,
                'image' => 'rose_bouquet.jpg',
            ],
            [
                'name' => '🌸 Rare Orchid',
                'description' => 'Rare orchid variety, very unique',
                'stock' => 4,
                'price' => 50,
                'image' => 'rare_orchid.jpg',
            ],
            [
                'name' => '🌼 Seasonal Daisies',
                'description' => 'Seasonal daisy collection',
                'stock' => 12,
                'price' => 19,
                'image' => 'seasonal_daisies.jpg',
            ],
            [
                'name' => '🌺 Desert Rose',
                'description' => 'Exotic desert rose flower',
                'stock' => 5,
                'price' => 37,
                'image' => 'desert_rose.jpg',
            ],
            [
                'name' => '🌷 Spring Tulips',
                'description' => 'Beautiful spring tulip bouquet',
                'stock' => 16,
                'price' => 22,
                'image' => 'spring_tulips.jpg',
            ],
            [
                'name' => '🌻 Tall Sunflowers',
                'description' => 'Tall bright yellow sunflowers',
                'stock' => 9,
                'price' => 30,
                'image' => 'tall_sunflowers.jpg',
            ],
            [
                'name' => '🌹 Golden Roses',
                'description' => 'Golden shade roses for luxury',
                'stock' => 6,
                'price' => 42,
                'image' => 'golden_roses.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name'        => $product['name'],
                'description' => $product['description'],
                'stock'       => $product['stock'],
                'image'       => $product['image'],
                'employee_id' => $employee->id,
            ]);
        }

    }
}
