<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
@endsection

@extends('layouts.main')

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-merchant-withdrawal')){
        $search_param = Session::get('filter-merchant-withdrawal');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('merchant::filter_withdrawal_list')
    </form>

    <br>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col"> Action </th>
            <th scope="col"> Status </th>
            <th scope="col"> Outlet </th>
            <th scope="col"> Nominal </th>
            <th scope="col"> Request Date </th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($data))
            @foreach($data as $key=>$val)
                <tr>
                    <td>
                        <a data-toggle="modal" href="#detail_{{$key}}" class="btn btn-sm blue">Detail</a>
                        <div class="modal fade" id="detail_{{$key}}" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-horizontal" role="form" action="{{url('merchant/withdrawal/completed')}}" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Withdrawal ({{$val['outlet']}})</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Status
                                                </label>
                                                <div class="col-md-8">
                                                    @if($val['status'] == 'Completed')
                                                        <span class="badge badge-sm" style="background-color: mediumseagreen;margin-top: 3%">{{$val['status']}}</span>
                                                    @elseif($val['status'] == 'On Progress')
                                                        <span class="badge badge-warning badge-sm" style="margin-top: 3%">{{$val['status']}}</span>
                                                    @else
                                                        <span class="badge badge-default badge-sm" style="margin-top: 3%">Pending</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Amount Withdrawal
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    Rp {{number_format(abs($val['nominal'])+abs($val['fee']),0,",",".")}}
                                                </div>
                                            </div>
                                            <div class="form-group" style="color: red">
                                                <label class="col-md-4 control-label">
                                                    Fee
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    Rp - {{number_format(abs($val['fee']),0,",",".")}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Amount Receive
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    Rp {{number_format(abs($val['nominal']),0,",",".")}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Outlet phone
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" value="{{$val['data_outlet']['outlet_phone']}}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Outlet email
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" value="{{$val['data_outlet']['outlet_email']}}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Bank Name
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" value="{{$val['data_bank_account']['bank_name']??''}}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Beneficiary Name
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" value="{{$val['data_bank_account']['beneficiary_name']??''}}" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Beneficiary Number
                                                </label>
                                                <div class="col-md-8">
                                                    <input class="form-control" value="{{$val['data_bank_account']['beneficiary_account']??''}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_merchant_log_balance" value="{{$val['id_merchant_log_balance']}}">
                                        @if($val['status'] == 'Pending' || empty($val['status']))
                                        <div class="modal-footer" style="text-align: center">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn green-jungle">Completed</button>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($val['status'] == 'Completed')
                            <span class="badge badge-sm" style="background-color: mediumseagreen">{{$val['status']}}</span>
                        @elseif($val['status'] == 'On Progress')
                            <span class="badge badge-warning badge-sm">{{$val['status']}}</span>
                        @else
                            <span class="badge badge-default badge-sm">Pending</span>
                        @endif
                    </td>
                    <td>{{$val['outlet']}}</td>
                    <td>
                        <b>Rp {{number_format(abs($val['nominal']),0,",",".")}}</b>
                    </td>
                    <td>{{ date('d M Y H:i', strtotime($val['date'])) }}</td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
        @endif
        </tbody>
    </table>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection