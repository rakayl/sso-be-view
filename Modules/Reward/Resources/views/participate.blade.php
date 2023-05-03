<div class="portlet-body form">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Participant</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Phone </th>
                        <th> Total Coupon </th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($reward[0]['reward_user']))
                @foreach($reward[0]['reward_user'] as $value)
                    <tr>
                        <td> {{ $value['user']['name'] }} </td>
                        <td> {{ $value['user']['phone'] }}  </td>
                        <td> {{ number_format($value['total_coupon']) }}  </td>
                    </tr>
                @endforeach
                </tbody>
                @endif
            </table>
        </div>
    </div>
</div>