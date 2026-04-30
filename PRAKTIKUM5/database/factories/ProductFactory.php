<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Sembako', 'Minuman', 'Snack', 'Kebersihan', 'Peralatan Dapur', 'Obat-obatan', 'Sayuran', 'Buah-buahan'];
        $units = ['pcs', 'kg', 'liter', 'pak', 'lusin', 'botol', 'kaleng', 'dus'];

        return [
            'name'        => $this->faker->words(rand(2, 4), true),
            'category'    => $this->faker->randomElement($categories),
            'description' => $this->faker->sentence(rand(8, 15)),
            'price'       => $this->faker->randomElement([500, 1000, 1500, 2000, 2500, 5000, 7500, 10000, 15000, 20000, 25000, 50000]),
            'stock'       => $this->faker->numberBetween(0, 200),
            'unit'        => $this->faker->randomElement($units),
            'sku'         => strtoupper($this->faker->unique()->bothify('PRD-####-??')),
            'status'      => $this->faker->randomElement(['active', 'active', 'active', 'inactive']),
        ];
    }
}
