<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Lib\MyHelper;

class ArrayExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $outlets;
    protected $title;

    public function __construct(array $outlets, $title = '')
    {
        $this->outlets = $outlets;
        $this->title = $title;
    }

    public function array(): array
    {
        return $this->outlets;
    }

    public function headings(): array
    {
        return array_keys($this->outlets[0] ?? []);
        // return array_map(function($x){return ucwords(str_replace('_', ' ', $x));}, array_keys($this->outlets[0]??[]));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $last = count($this->outlets);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ]
                    ],
                ];
                $styleHead = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ];
                $x_coor = MyHelper::getNameFromNumber(count($this->outlets[0] ?? []));
                $event->sheet->getStyle('A1:' . $x_coor . ($last + 1))->applyFromArray($styleArray);
                $headRange = 'A1:' . $x_coor . '1';
                $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
            },
        ];
    }
}
