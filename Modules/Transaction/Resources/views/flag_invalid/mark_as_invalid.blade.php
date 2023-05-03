<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

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

    <?php
    if(Session::has('filter-mark-as-invalid')){
        $search_param = Session::get('filter-mark-as-invalid');

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
            $filterType = $search_param['filter_type'];
        }
    }
    ?>
    <h1 class="page-title">
        {{$title}}
    </h1>
    @include('layouts.notifications')

    <form role="form" action="{{url()->current()}}?filter=1" method="post">
        @include('transaction::flag_invalid.filter_mark')
    </form>

    <br>
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">List Transaction</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive">
                <thead>
                <tr>
                    <th>Detail</th>
                    <th>Transaction Date</th>
                    <th>Receipt Number</th>
                    <th>Order ID</th>
                    <th>Outlet</th>
                    <th>Transaction Type</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $res)
                        <tr>
                            <td>
                                <a class="btn btn-block yellow btn-xs" target="_blank" href="{{ url('transaction/invalid-flag/detail') }}/{{ $res['id_transaction'] }}?from=invalid"><i class="icon-pencil"></i> Detail </a>
                            </td>
                            <td>{{date('d M Y H:i', strtotime($res['transaction_date']))}}</td>
                            <td>{{$res['transaction_receipt_number']}}</td>
                            <td>{{$res['order_id']}}</td>
                            <td>{{$res['outlet_code']}}-{{$res['outlet_name']}}</td>
                            <td>{{$res['trasaction_type']}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
            @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
                Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
            @endif
            @if ($dataPaginator)
                {{ $dataPaginator->links() }}
            @endif
        </div>
    </div>
@endsection
