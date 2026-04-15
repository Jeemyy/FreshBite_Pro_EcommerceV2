<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::updateOrCreate(
            ['id' => 1],
            [
                'sale' => [
                    'month'     => "December",
                    'discount'  => '50'
                ],
            ]
        );
    }
}
