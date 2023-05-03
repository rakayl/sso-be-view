<div class="portlet-body form">
    @if (!empty($voucher))
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase"></span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Trx Id </th>
                        <th> Phone </th>
                        <th> Name </th>
                        <th> RedeemPoint </th>
                        <th> Bought At </th>
                        <th> Expired At</th>
                        <th> Used At</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($voucher as $value)
                    @if (!empty($value['user_redeemption']))
                        @foreach ($value['user_redeemption'] as $key=> $you)
                            <tr>
                                <td> @if (!empty($you['trx_id'])) {{ $you['trx_id'] }} @else - @endif</td>
                                <td> {{ $you['user']['phone'] }} </td>
                                <td> {{ $you['user']['name'] }} </td>
                                <td> {{ $you['redemption_point'] }} </td>
                                <td> {{ date('Y-m-d', strtotime($you['created_at'])) }} </td>
                                <td> {{ date('Y-m-d', strtotime($you['voucher_expired'])) }} </td>
                                <td> @if (!empty($you['voucher_used'])) {{ date('Y-m-d', strtotime($you['voucher_used'])) }} @else - @endif</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>