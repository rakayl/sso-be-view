<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DisburseDetailBladeExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('disburse::disburse.detail_export', [
            'disburse' => $this->data['data_disburse'],
            'list_trx' => $this->data['list_trx'],
            'config' => $this->data['config']
        ]);
    }
}
