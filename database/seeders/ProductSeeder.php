<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'product_code' => '1001', 'price' => 55000, 'stock' => 10, 'tax' => 18],
            ['name' => 'Phone', 'product_code' => '1002', 'price' => 25000, 'stock' => 20, 'tax' => 40],
            ['name' => 'Mouse', 'product_code' => '1003', 'price' => 500, 'stock' => 50, 'tax' => 5],
            ['name' => 'Keyboard', 'product_code' => '1004', 'price' => 1200, 'stock' => 40, 'tax' => 5],
            ['name' => 'Monitor', 'product_code' => '1005', 'price' => 15000, 'stock' => 15, 'tax' => 18],
            ['name' => 'Printer', 'product_code' => '1006', 'price' => 8000, 'stock' => 8, 'tax' => 40],
            ['name' => 'Scanner', 'product_code' => '1007', 'price' => 6000, 'stock' => 5, 'tax' => 40],
            ['name' => 'Tablet', 'product_code' => '1008', 'price' => 20000, 'stock' => 12, 'tax' => 18],
            ['name' => 'Smartwatch', 'product_code' => '1009', 'price' => 7000, 'stock' => 25, 'tax' => 40],
            ['name' => 'Camera', 'product_code' => '1010', 'price' => 30000, 'stock' => 7, 'tax' => 18],
            ['name' => 'Speaker', 'product_code' => '1011', 'price' => 3500, 'stock' => 30, 'tax' => 40],
            ['name' => 'Headphones', 'product_code' => '1012', 'price' => 2000, 'stock' => 45, 'tax' => 5],
            ['name' => 'Power Bank', 'product_code' => '1013', 'price' => 1500, 'stock' => 60, 'tax' => 5],
            ['name' => 'USB Drive', 'product_code' => '1014', 'price' => 800, 'stock' => 70, 'tax' => 5],
            ['name' => 'External HDD', 'product_code' => '1015', 'price' => 5000, 'stock' => 18, 'tax' => 40],
            ['name' => 'SSD', 'product_code' => '1016', 'price' => 6000, 'stock' => 22, 'tax' => 40],
            ['name' => 'Graphics Card', 'product_code' => '1017', 'price' => 25000, 'stock' => 9, 'tax' => 18],
            ['name' => 'Motherboard', 'product_code' => '1018', 'price' => 12000, 'stock' => 14, 'tax' => 18],
            ['name' => 'RAM', 'product_code' => '1019', 'price' => 4000, 'stock' => 35, 'tax' => 40],
            ['name' => 'CPU', 'product_code' => '1020', 'price' => 20000, 'stock' => 11, 'tax' => 18],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['product_code' => $product['product_code']],
                $product
            );
        }
    }
}
