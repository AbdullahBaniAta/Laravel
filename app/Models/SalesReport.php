<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $collection_data;
    protected $headings_data;

    public function __construct($collection, $headings_data)
    {
        $this->collection_data = $collection;
        $this->headings_data = $headings_data;
    }

    public function collection()
    {
        return $this->collection_data;
    }

    public function headings(): array
    {
        return $this->headings_data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 22,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 35,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
