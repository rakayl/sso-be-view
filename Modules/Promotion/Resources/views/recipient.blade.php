<div class="portlet box blue-hoki">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-users"></i>Promotion Recipient 
        </div>
    </div>
    <div class="portlet-body row"  style="background-color: white; margin:0" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
        <div class="table-scrollable">
            <table class="table table-bordered table-hover" id="sample_1" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        @if($result['promotion_type'] == 'Campaign Series')
                            @for($x = 1;$x <= $result['promotion_series']; $x++)
                                <th>Campaign {{$x}} Time Sent</th>
                            @endfor
                        @else
                            <th>Promotion Sent Time</th>
                        @endif
                        <th>Voucher</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($users) && count($users) > 0)
                    @php $no = $from; @endphp
                        @foreach($users as $key => $user)
                        @if($result['promotion_type'] == 'Campaign Series')
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['phone']}}</td>
                                @for($x = 1;$x <= $result['promotion_series']; $x++)
                                @if(isset($user['promotion_sents'][$x-1]))
                                <td>{{date('d F Y H:i', strtotime($user['promotion_sents'][$x-1]['send_at']))}}</td>
                                @else
                                <td></td>
                                @endif
                                @endfor
                                <td>given: @if(isset($user['voucher_given'])) {{$user['voucher_given']}} @else 0 @endif
                                    <br>used : @if(isset($user['voucher_used'])) {{$user['voucher_used']}} @else 0 @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['phone']}}</td>
                                <td>{{date('d F Y H:i', strtotime($user['send_at']))}}</td>
                                <td>given: @if(isset($user['voucher_given'])) {{$user['voucher_given']}} @else 0 @endif
                                    <br>used : @if(isset($user['voucher_used'])) {{$user['voucher_used']}} @else 0 @endif
                                </td>
                            </tr>
                        @endif
                        @php $no++; @endphp
                        @endforeach
                    @else
                        @if($result['promotion_type'] == 'Campaign Series') @php $col=$result['promotion_series']+4; @endphp
                        <tr><td colspan="{{$col}}" style="text-align:center">No User Has Received This Promotion</td></tr>
                        @else
                        <tr><td colspan="5" style="text-align:center">No User Has Received This Promotion</td></tr>
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
        <div style="padding-left:5px; @if($users->links() == "") padding-bottom:20px; @endif ">
            Showing {{$from}} to {{$to}} of {{$total}} entries
        </div>
        <div class="pull-right pagination-recipient" style="padding-right:5px">
            {{$users->links()}}
        </div>
    </div>
</div>	
    