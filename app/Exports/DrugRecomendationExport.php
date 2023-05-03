<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Lib\MyHelper;

class DrugRecomendationExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize, WithEvents
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
                $last = count($this->outlets['items']);
                $lastOutlet = count($this->outlets['outlet']);
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
                //for outlet array
                $x_coor = MyHelper::getNameFromNumber(count($this->outlets['outlet'][0] ?? []));
                $event->sheet->getStyle('A1:' . $x_coor . ($lastOutlet - 1))->applyFromArray($styleArray);

                //for recomendation array
                $x_coor = MyHelper::getNameFromNumber(count($this->outlets['items'][0] ?? []));
                $event->sheet->getStyle('A6:' . $x_coor . ($last + 6))->applyFromArray($styleArray);
                $headRange = 'A6:' . $x_coor . '6';
                $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
            },
        ];
    }
}
