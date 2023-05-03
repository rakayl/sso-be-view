<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Lib\MyHelper;

class ProductVariantPriceArrayExport implements FromArray, WithTitle, ShouldAutoSize, WithEvents
{
    protected $datas;
    protected $code_brand;
    protected $name_brand;
    protected $title;
    protected $alphabet;
    protected $length;

    public function __construct(array $datas, $brand = null, $title = '')
    {
        $this->datas = $datas;
        $this->code_brand = $brand['code_brand'] ?? '';
        $this->name_brand = $brand['name_brand'] ?? '';
        $this->title = $title;
        $this->alphabet = array( 'a', 'b', 'c', 'd', 'e',
            'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z'
        );
        $this->length = 0;
        $this->until = '';
    }

    public function array(): array
    {
        $array = [
            ['Brand Code',$this->code_brand],
            ['Brand Name',$this->name_brand],
            array_keys($this->datas[0] ?? [])
        ];
        return array_merge($array, $this->datas);
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
        $arr = [];
        $name = $this->datas[0]['product'];
        $this->length = count($this->datas[0]);
        $num = $this->length;

        //get alphabet
        $letter = '';
        while ($num > 0) {
            $code = ($num % 26 == 0) ? 26 : $num % 26;
            $letter .= chr($code + 64);
            $num = ($num - $code) / 26;
        }
        $this->until = $letter;
        $count = 1;
        $i = 4;
        foreach ($this->datas as $key => $value) {
            if ($value['product'] !== $name) {
                $count = $count + 1;
                if ($count % 2 != 0) {
                    array_push($arr, 'A' . $i . ':' . strtoupper($this->until) . $i);
                }
            } elseif ($count == 1) {
                array_push($arr, 'A' . $i . ':' . strtoupper($this->until) . $i);
            } elseif ($count % 2 != 0) {
                array_push($arr, 'A' . $i . ':' . strtoupper($this->until) . $i);
            }

            $name = $value['product'];
            $i++;
        }

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($arr) {
                $last = count($this->datas);
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

                $event->sheet->getStyle('A3:' . strtoupper($this->until) . ($last + 3))->applyFromArray($styleArray);
                $headRange = 'A3:' . strtoupper($this->until) . '3';
                $event->sheet->getStyle($headRange)->applyFromArray($styleHead);

                foreach ($arr as $dt) {
                    $cellRange = $dt;
                    $event->sheet->getColumnDimensionByColumn('1')->setAutoSize(false)->setWidth(20);
                    $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffe2e2e2');
                }
            },
        ];
    }
}
