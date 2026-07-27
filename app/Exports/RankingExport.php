<?php

namespace App\Exports;

use App\Models\Period;
use App\Models\Ranking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RankingExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, ShouldAutoSize
{
    protected Period $period;

    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    /**
     * Return the collection of rankings for the period.
     */
    public function collection()
    {
        return Ranking::with('stock')
            ->where('period_id', $this->period->id)
            ->orderBy('rank')
            ->get();
    }

    /**
     * Define the headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'Ranking',
            'Kode Saham',
            'Nama Saham',
            'Emiten',
            'Vektor S',
            'Vektor V',
        ];
    }

    /**
     * Map each ranking row to the export columns.
     */
    public function map($ranking): array
    {
        return [
            $ranking->rank,
            $ranking->stock->code,
            $ranking->stock->name,
            $ranking->stock->issuer,
            number_format($ranking->vector_s, 4),
            number_format($ranking->vector_v, 4),
        ];
    }

    /**
     * Set the sheet title.
     */
    public function title(): string
    {
        return 'Ranking ' . $this->period->name;
    }

    /**
     * Style the worksheet header row.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFD9D9D9',
                    ],
                ],
            ],
        ];
    }
}
