<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $denominations = [
            ['value' => 500, 'count' => 10],
            ['value' => 200, 'count' => 20],
            ['value' => 100, 'count' => 30],
            ['value' => 50, 'count' => 40],
            ['value' => 20, 'count' => 50],
            ['value' => 10, 'count' => 60],
            ['value' => 5, 'count' => 70],
            ['value' => 2, 'count' => 80],
            ['value' => 1, 'count' => 100],
        ];

        foreach ($denominations as $denomination) {
            Denomination::updateOrCreate(
                ['value' => $denomination['value']],
                $denomination
            );
        }
    }
}
