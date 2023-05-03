<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

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

    if(Session::has('filter-list-disburse-trx')){
        $search_param = Session::get('filter-list-disburse-trx');
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
        @include('disburse::disburse.filter_list_trx')
    </form>
    <br>

    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover" id="tableReport">
            <thead>
            <tr>
                <th scope="col" width="25%"> Status Disburse</th>
                <th scope="col" width="10%"> Recipient Number </th>
                <th scope="col" width="30%"> Outlet </th>
                <th scope="col" width="30%"> Transaction Date </th>
                <th scope="col" width="10%"> Grand total Transaction</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($trx))
                @foreach($trx as $val)
                    <tr>
                        <td>
                            @if(!is_null($val['disburse_status']))

                                <?php
                                     $color = 'grey';
                                     if($val['disburse_status'] == 'Success'){
                                         $color = '#26C281';
                                     }elseif ($val['disburse_status'] == 'Fail'){
                                         $color = '#f54842';
                                     }
                                ?>
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{$color}};padding: 5px 12px;color: #fff;">{{$val['disburse_status']}}</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: grey;padding: 5px 12px;color: #fff;">Unprocessed</span>
                            @endif
                        </td>
                        <td>{{$val['transaction_receipt_number']}}</td>
                        <td>{{$val['outlet_code']}} - {{$val['outlet_name']}}</td>
                        <td>{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                        <td>{{number_format($val['transaction_grandtotal'], 2)}}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($trxPaginator)
        {{ $trxPaginator->links() }}
    @endif
@endsection