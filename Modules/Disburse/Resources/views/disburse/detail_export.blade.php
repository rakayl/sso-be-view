<!DOCTYPE html>
<html>
<body>

<table>
    <tr>
        <td width="30">Date</td>
        <td>: {{ date('d M Y H:i', strtotime($disburse['created_at'])) }}</td>
    </tr>
    <tr>
        <td width="30">Outlet</td>
        <td>: {{$disburse['outlet_code']}} - {{$disburse['outlet_name']}}</td>
    </tr>
    <tr>
        <td width="30">Status</td>
        @if($disburse['disburse_status'] == 'Fail')
            <td>: <b  style="color: red">{{ $disburse['disburse_status'] }}</b></td>
        @else
            <td>: <b style="color: green">{{ $disburse['disburse_status'] }}</b></td>
        @endif
    </tr>
    <tr>
        <td width="30">Bank Name</td>
        <td>: {{$disburse['bank_name']}}</td>
    </tr>
    <tr>
        <td width="30">Account Number</td>
        <td>: {{$disburse['beneficiary_account_number']}}</td>
    </tr>
    <tr>
        <td width="30">Recipient Name</td>
        <td>: {{$disburse['beneficiary_name']}}</td>
    </tr>
    <tr>
        <td width="30" style="font-size: 22px"><b>Nominal</b></td>
        <td style="font-size: 22px"><b>: {{number_format((float)$disburse['disburse_nominal'], 2)}}</b></td>
    </tr>
</table>
<br>

<table style="border: 1px solid black">
    <thead>
    @if(!empty($config) && $config['is_active'] == 1)
        <tr><td style="background-color: #ff9933;" colspan="4">Sub Total = Gross Sales + delivery - discount delivery - discount</td></tr>
        <tr><td style="background-color: #ff9933;" colspan="4">Net Sale (Income Outlet) = Sub Total - Fee Item - Fee Discount Delivery - Fee Payment - Fee Promo - Fee Subscription</td></tr>
        <tr></tr>
    @endif
    <tr>
        <th style="background-color: #dcdcdc;"> Recipient Number </th>
        <th style="background-color: #dcdcdc;" width="20"> Transaction Date </th>
        <th style="background-color: #dcdcdc;" width="20"> Gross Sales </th>
        <th style="background-color: #dcdcdc;" width="20"> Discount </th>
        <th style="background-color: #dcdcdc;" width="20"> Delivery </th>
        <th style="background-color: #dcdcdc;" width="20"> Sub Total </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Item </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Payment </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Promo </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Subcription </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Point Use </th>
        <th style="background-color: #dcdcdc;" width="20"> Net Sale (Income Outlet) </th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($list_trx))
        @foreach($list_trx as $val)
            <tr>
                <td style="text-align: left">
                    {{ $val['transaction_receipt_number']??'' }}
                </td>
                <td style="text-align: left">{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                <td style="text-align: left">{{$val['transaction_grandtotal']}}</td>
                <td style="text-align: left">{{abs($val['transaction_discount'])}}</td>
                <td style="text-align: left">{{$val['transaction_shipment_go_send']}}</td>
                <td style="text-align: left">{{$val['transaction_subtotal']}}</td>
                <td style="text-align: left">{{$val['fee_item']}}</td>
                <td style="text-align: left">{{$val['payment_charge']}}</td>
                <td style="text-align: left">{{$val['discount']}}</td>
                <td style="text-align: left">{{$val['subscription']}}</td>
                <td style="text-align: left">{{$val['point_use_expense']}}</td>
                <td style="text-align: left">{{$val['income_outlet']}}</td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
    @endif
    </tbody>
</table>

</body>
</html>

