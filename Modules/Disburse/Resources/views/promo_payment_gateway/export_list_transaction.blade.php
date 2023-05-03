<!DOCTYPE html>
<html>
<body>

<table>
    <tr>
        <td width="25">ID</td>
        <td>: {{$detail['promo_payment_gateway_code']}}</td>
    </tr>
    <tr>
        <td width="25">Name</td>
        <td>: {{$detail['name']}}</td>
    </tr>
    <tr>
        <td>Payment Gateway</td>
        <td>: {{$detail['payment_gateway']}}</td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
    </tr>
    <tr>
        <td>Maximum Total Cashback</td>
        <td>: {{number_format($detail['maximum_total_cashback'])}}</td>
    </tr>
    <tr>
        <td>Total Limit</td>
        <td>: {{$detail['limit_promo_total']}}</td>
    </tr>
    <tr>
        <td>Limit user per day</td>
        <td>: {{$detail['limit_per_user_per_day']}}</td>
    </tr>
    <tr>
        <td>Additional Limit Day</td>
        <td>: {{$detail['limit_promo_additional_day']}}</td>
    </tr>
    <tr>
        <td>Additional Limit Week</td>
        <td>: {{$detail['limit_promo_additional_week']}}</td>
    </tr>
    <tr>
        <td>Additional Limit Month</td>
        <td>: {{$detail['limit_promo_additional_month']}}</td>
    </tr>
    <tr>
        <td>Additional Limit Account</td>
        <td>: {{$detail['limit_promo_additional_account']}} @if(!empty($detail['limit_promo_additional_account'])) (User : {{$detail['limit_promo_additional_account_type']}}) @endif</td>
    </tr>
    <tr>
        <td>Cashback</td>
        <td>: @if($detail['cashback_type'] == 'Nominal') IDR {{number_format((int)$detail['cashback'])}} @else {{$detail['cashback']}} % @endif</td>
    </tr>
    <tr>
        <td>Maximum Cashback</td>
        <td>: @if($detail['cashback_type'] == 'Nominal') - @else IDR {{number_format($detail['maximum_cashback'])}} @endif</td>
    </tr>
    <tr>
        <td>Minimum Transaction</td>
        <td>: IDR {{number_format($detail['minimum_transaction'])}}</td>
    </tr>
    <tr>
        <td>Charged Payment Gateway</td>
        <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_payment_gateway'])}} @else {{$detail['charged_payment_gateway']}} % @endif</td>
    </tr>
    <tr>
        <td>Charged Jiwa Group</td>
        <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_jiwa_group'])}} @else {{$detail['charged_jiwa_group']}} % @endif</td>
    </tr>
    <tr>
        <td>Charged Central</td>
        <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_outlet'])}} @else {{$detail['charged_outlet']}} % @endif</td>
    </tr>
    <tr>
        <td>Charged Outlet</td>
        <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_outlet'])}} @else {{$detail['charged_outlet']}} % @endif</td>
    </tr>
    <tr>
        <td>MDR Setting</td>
        <td>: {{$detail['mdr_setting']}} </td>
    </tr>
    <tr>
        <td>Total Transaction</td>
        <td>: {{ number_format($summary['total_transaction']??0) }} </td>
    </tr>
    <tr>
        <td>Total Amount/td>
        <td>: {{ number_format($summary['total_amount']??0) }} </td>
    </tr>
    <tr>
        <td>Total Cashback</td>
        <td>: {{ number_format($summary['total_cashback']??0) }} </td>
    </tr>
</table>
<br>

<table style="border: 1px solid black">
    <thead>
        <tr>
            <th style="background-color: #dcdcdc;" width="25"> Transaction date</th>
            <th style="background-color: #dcdcdc;" width="25"> Customer name</th>
            <th style="background-color: #dcdcdc;" width="25"> Customer phone</th>
            <th style="background-color: #dcdcdc;" width="25"> Customer account PG</th>
            <th style="background-color: #dcdcdc;" width="25"> Receipt number </th>
            <th style="background-color: #dcdcdc;" width="25"> Amount </th>
            <th style="background-color: #dcdcdc;" width="25"> Chasback Received </th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $key => $res)
            <tr style="background-color: #fbfbfb;">
                <td> {{date('d M Y H:i', strtotime($res['transaction_date']))}} </td>
                <td> {{ $res['customer_name'] }} </td>
                <td> {{ $res['customer_phone'] }} </td>
                <td> {{ $res['payment_gateway_user'] }} </td>
                <td> {{ $res['transaction_receipt_number'] }} </td>
                <td> {{ number_format($res['amount'],2,",",".") }} </td>
                <td> {{ number_format($res['total_received_cashback'],2,",",".") }} </td>
            </tr>
        @endforeach
    @else
        <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
    @endif
    </tbody>
</table>

</body>
</html>

