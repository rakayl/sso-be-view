<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-7" style="text-align: right">
        <form class="form-horizontal" role="form" action="{{url('outlet/detail', $outlet_code)}}/log-balance" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Search
                        <i class="fa fa-question-circle tooltips" data-original-title="Search by transaction receipt number/beneficiary name/beneficiary number/source" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="search_log_balance" required placeholder="Search ..." value="{{Session::get('search_log_balance')}}">
                </div>
                <div class="col-md-2" style="margin-left: -1%">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-success" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-1" style="margin-left: -2%">
        <a class="btn btn-sm btn-default" href="{{url('outlet/detail', $outlet_code)}}/log-balance?reset=1" type="submit">Reset</a>
    </div>
</div>

<br>
<br>
<table class="table table-striped table-bordered table-hover" id="tableReport">
    <thead>
    <tr>
        <th scope="col"> Source </th>
        <th scope="col"> Nominal </th>
        <th scope="col"> Date </th>
        <th scope="col"> Description </th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($data_log_balance))
        @foreach($data_log_balance as $val)
            <tr>
                <td>{{$val['source']}}</td>
                <td>
                    @if($val['nominal'] < 0)
                        <p style="color: red">{{number_format($val['nominal'],0,",",".")}}</p>
                    @else
                        <p style="color: green">{{number_format($val['nominal'],0,",",".")}}</p>
                    @endif
                </td>
                <td>{{ date('d M Y H:i', strtotime($val['date'])) }}</td>
                <td>
                    @if(!empty($val['data_transaction']))
                        Receipt Number : {{$val['data_transaction']['transaction_receipt_number']}}
                    @endif

                    @if(!empty($val['data_bank_account']))
                        Bank Name : {{$val['data_bank_account']['bank_name']}}<br>
                        Beneficiary Name : {{$val['data_bank_account']['beneficiary_name']}}<br>
                        Beneficiary Number : {{$val['data_bank_account']['beneficiary_account']}}
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
    @endif
    </tbody>
</table>
@if ($data_log_balance_paginator)
    {{ $data_log_balance_paginator->links() }}
@endif