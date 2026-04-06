<?php

namespace Database\Seeders;

use App\Models\Criterion;
use Illuminate\Database\Seeder;

class CriterionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            [
                'code' => 'C1',
                'name' => 'ROE',
                'attribute' => 'benefit',
                'weight' => 0.3621,
                'description' => 'Return on Equity',
            ],
            [
                'code' => 'C2',
                'name' => 'PER',
                'attribute' => 'cost',
                'weight' => 0.2780,
                'description' => 'Price to Earnings Ratio',
            ],
            [
                'code' => 'C3',
                'name' => 'PBV',
                'attribute' => 'cost',
                'weight' => 0.2241,
                'description' => 'Price to Book Value',
            ],
            [
                'code' => 'C4',
                'name' => 'Dividend Yield',
                'attribute' => 'benefit',
                'weight' => 0.0776,
                'description' => 'Dividend Yield',
            ],
            [
                'code' => 'C5',
                'name' => 'DER',
                'attribute' => 'cost',
                'weight' => 0.0582,
                'description' => 'Debt to Equity Ratio',
            ],
        ];

        foreach ($criteria as $criterion) {
            Criterion::updateOrCreate(
                ['code' => $criterion['code']],
                $criterion
            );
        }
    }
}