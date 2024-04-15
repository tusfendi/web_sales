<?php

namespace App\Exports;

use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{

    private $requestor, $start_date, $end_date;

    public function __construct($requestor, $start_date, $end_date)
    {
        $this->requestor = $requestor;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function headings() :array
    {
        Carbon::setLocale('id');
        $startDate = Carbon::parse($this->start_date)->isoFormat('D MMMM Y');
        $endDate = Carbon::parse($this->end_date)->isoFormat('D MMMM Y');
        return [
            ['Requestor', $this->requestor],
            [],
            ['Parameter'],
            ['Start Date', $startDate],
            ['End Date', $endDate],
            [],
            [
                'User',
                'Jumlah Hari Kerja',
                'Jumlah Transaksi Barang',
                'Jumlah Transaksi Jasa',
                'Nominal Transaksi Barang',
                'Nominal Transaksi Jasa'
            ]
        ];
    }

    public function array(): array
    {
        $data = [];
        $report = Sales::getReport($this->start_date, $this->end_date);
        foreach ($report as $item) {
            $data[] = [
                $item->name,
                $item->total_hari,
                $item->total_transaksi_barang,
                $item->total_transaksi - $item->total_transaksi_barang,
                $item->total_nominal_barang,
                $item->total_nominal - $item->total_nominal_barang,
            ];
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:A7'    => ['font' => ['bold' => true]],
            'B7:F7'    => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        $coll = [
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
        ];

        return $coll;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
