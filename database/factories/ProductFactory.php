<?php

namespace Database\Factories;

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
    public function definition(): array
    {
    //daftar makanan khas indonesia
        $makanan = ['Nasi Goreng', 'Sate Ayam', 'Rendang Daging', 'Soto Lamongan', 'Gado-Gado', 'Gudeg', 'Ikan Bakar', 'Coto Makassar'];
    $adj_makanan = ['Spesial', 'Komplit', 'biasa', 'Pedas'];

    // Daftar minuman khas Indonesia
    $minuman = ['Es Teh', 'Es Jeruk', 'Wedang Uwuh', "Susu Sapi", 'Wedang Jahe', 'Es Cendol', 'Teh Tarik'];
    $adj_minuman = ['Jumbo', 'Spesial'];

    // Tentukan secara acak apakah produk ini makanan atau minuman
    $kategori = $this->faker->randomElement(['makanan', 'minuman']);

    // Jika yang terpilih adalah makanan
    if ($kategori === 'makanan') {
        return [
            'name' => $this->faker->unique()->randomElement($makanan) .' '. $this->faker->randomElement($adj_makanan),
            'description' => 'Hidangan lezat yang dibuat dengan resep otentik nusantara, menggunakan bahan-bahan segar pilihan dan bumbu rempah yang kaya rasa.',
            'price' => $this->faker->numberBetween(18, 75) * 1000, // Harga makanan 18rb - 75rb
            'stock' => $this->faker->numberBetween(15, 50),
            'image' => null,
        ];
    }

    // Jika yang terpilih adalah minuman
    else {
        return [
            'name' => $this->faker->unique()->randomElement($minuman) . ' '. $this->faker->randomElement($adj_minuman),
            'description' => 'Minuman segar yang cocok untuk melepas dahaga dan menjadi teman sempurna untuk setiap hidangan.',
            'price' => $this->faker->numberBetween(5, 25) * 1000, // Harga minuman 5rb - 25rb
            'stock' => $this->faker->numberBetween(30, 100),
            'image' => null,
        ];
    }
    }
    }

