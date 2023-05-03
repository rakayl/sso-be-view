<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-7" style="text-align: right">
        <form class="form-horizontal" role="form" action="{{url('outlet/detail', $outlet_code)}}/list-payment" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Search
                        <i class="fa fa-question-circle tooltips" data-original-title="Search by transaction receipt number or payment" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="search_list_payment" required placeholder="Receipt number or payment" value="{{Session::get('search_list_payment')}}">
                </div>
                <div class="col-md-2" style="margin-left: -1%">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-1" style="margin-left: -2%">
        <a class="btn btn-sm btn-default" href="{{url('outlet/detail', $outlet_code)}}/list-payment?reset=1" type="submit">Reset</a>
    </div>
</div>

<br>
<br>
<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th> Status </th>
        <th> Transaction Date </th>
        <th> Receipt Number </th>
        <th> Payment </th>
        <th> Nomimal </th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($data_list_payment))
        @foreach($data_list_payment as $val)
            <tr>
                <td>{{$val['transaction_payment_status']}}</td>
                <td>{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                <td>
                    @if($val['trasaction_type'] == 'Consultation')
                        <a target="_blank" href="{{url('consultation/be', $val['id_transaction'])}}/detail">{{$val['transaction_receipt_number']}}</a>
                    @else
                        <a target="_blank" href="{{url('transaction/detail', $val['id_transaction'])}}">{{$val['transaction_receipt_number']}}</a>
                    @endif
                </td>
                <td>{{$val['payment_type']}}</td>
                <td>{{number_format($val['amount'],0,",",".")}}</td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
    @endif
    </tbody>
</table>
@if ($data_list_payment_paginator)
    {{ $data_list_payment_paginator->links() }}
@endif