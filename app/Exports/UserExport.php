<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $query, $total;

    public function __construct($query, $total)
    {
        $this->query = $query;
        $this->total = $total;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(15);
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1:C1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A1:C1')->getFont()->setBold(true);
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ]
                    ]
                ];
                $heading_cell = ["A1", "B1", "C1"];
                foreach ($heading_cell as $cell) {
                    $event->sheet->getDelegate()->getStyle($cell)->applyFromArray($styleArray);
                }

                foreach (array("A", "B", "C") as $cell) {
                    for ($i = 0; $i < $this->total + 9; $i++) {
                        $event->sheet->getDelegate()->getStyle($cell . $i)->applyFromArray($styleArray);
                        $event->sheet->getDelegate()->getStyle($cell . $i)->getFont()->setSize(14);
                    }
                }
            }
        ];
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.user', [
            "data" => $this->query,
            "total" => $this->total
        ]);
    }
}
