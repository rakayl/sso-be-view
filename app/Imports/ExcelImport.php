<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return $collection;
        $column = array();
        $newCollection = array();
        foreach ($collection[0] as $key => $value) {
            if ($key < 1) {
                $column = $value;
            } else {
                $childColection = array();
                foreach ($column as $key2 => $val2) {
                    $colval = $value[$key2];
                    $childColection[$val2] = $colval ?? '';
                }
                $newCollection[] = (object) $childColection;
            }
        }
        return $newCollection;
    }
}
