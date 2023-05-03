<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportRulePromoPaymentGatewayBladeExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('disburse::promo_payment_gateway.export_list_transaction', [
            'detail' => $this->data['detail'],
            'data' => $this->data['list_trx'],
            'summary' => $this->data['summary']
        ]);
    }
}
