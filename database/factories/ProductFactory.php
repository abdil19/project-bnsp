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
        // Daftar makanan khas Indonesia
    $makanan = ['Nasi Goreng Spesial', 'Sate Ayam Madura (10 tusuk)', 'Rendang Daging Sapi', 'Soto Ayam Lamongan', 'Gado-Gado Siram', 'Bakso Urat Komplit', 'Ikan Bakar Jimbaran', 'Ayam Geprek Sambal Bawang'];

    // Daftar minuman khas Indonesia
    $minuman = ['Es Teh Manis Jumbo', 'Es Jeruk Peras Segar', 'Jus Alpukat Mentega', 'Kopi Tubruk Gayo', 'Wedang Jahe Merah', 'Es Cendol Elizabeth', 'Teh Tarik Panas'];

    // Tentukan secara acak apakah produk ini makanan atau minuman
    $kategori = $this->faker->randomElement(['makanan', 'minuman']);

    // Jika yang terpilih adalah makanan
    if ($kategori === 'makanan') {
        return [
            'name' => $this->faker->randomElement($makanan),
            'description' => 'Hidangan lezat yang dibuat dengan resep otentik nusantara, menggunakan bahan-bahan segar pilihan dan bumbu rempah yang kaya rasa.',
            'price' => $this->faker->numberBetween(18, 75) * 1000, // Harga makanan 18rb - 75rb
            'stock' => $this->faker->numberBetween(15, 50),
            'image' => null,
        ];
    }

    // Jika yang terpilih adalah minuman
    else {
        return [
            'name' => $this->faker->randomElement($minuman),
            'description' => 'Minuman segar yang cocok untuk melepas dahaga dan menjadi teman sempurna untuk setiap hidangan.',
            'price' => $this->faker->numberBetween(5, 25) * 1000, // Harga minuman 5rb - 25rb
            'stock' => $this->faker->numberBetween(30, 100),
            'image' => null,
        ];
    }
    }
}

