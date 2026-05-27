<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Produk unggulan manual (biar ada data yang "real")
        $products = [
            ['name' => 'Beras Premium 5kg', 'category' => 'Sembako', 'price' => 75000, 'stock' => 50, 'unit' => 'karung', 'sku' => 'PRD-0001-BR', 'status' => 'active', 'description' => 'Beras pulen kualitas premium pilihan pak Cokomi.'],
            ['name' => 'Minyak Goreng 1L', 'category' => 'Sembako', 'price' => 18000, 'stock' => 100, 'unit' => 'botol', 'sku' => 'PRD-0002-MG', 'status' => 'active', 'description' => 'Minyak goreng jernih untuk masakan sehari-hari.'],
            ['name' => 'Indomie Goreng', 'category' => 'Snack', 'price' => 3500, 'stock' => 200, 'unit' => 'pcs', 'sku' => 'PRD-0003-IM', 'status' => 'active', 'description' => 'Mie instan goreng favorit semua kalangan.'],
            ['name' => 'Aqua 600ml', 'category' => 'Minuman', 'price' => 4000, 'stock' => 150, 'unit' => 'botol', 'sku' => 'PRD-0004-AQ', 'status' => 'active', 'description' => 'Air mineral segar untuk kehidupan sehat.'],
            ['name' => 'Sabun Mandi Lifebuoy', 'category' => 'Kebersihan', 'price' => 5000, 'stock' => 80, 'unit' => 'pcs', 'sku' => 'PRD-0005-SB', 'status' => 'active', 'description' => 'Sabun antibakteri perlindungan 10 kuman.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Generate 45 produk random pakai factory
        Product::factory(45)->create();
    }
}