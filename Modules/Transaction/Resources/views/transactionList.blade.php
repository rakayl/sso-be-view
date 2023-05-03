@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $codeColor = [
            1 => 'badge-danger',
            2 => 'badge-warning',
            3 => 'badge-secondary',
            4 => 'badge-warning',
            5 => 'badge-warning',
            6 => 'badge-success',
        ];
@endphp

@extends('layouts.main')

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

    @include('layouts.notifications')
    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-transaction-list')){
        $search_param = Session::get('filter-transaction-list');
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
        @include('transaction::transactionFilter')
    </form>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Transaction</span>
            </div>
        </div>
        <div class="portlet-body">
            <div style="display: block;overflow-x: auto;white-space: nowrap;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Transaction Status</th>
                        <th>Date</th>
                        <th>Grandtotal</th>
                        <th>Receipt Number Group</th>
                        <th>Receipt Number</th>
                        <th>Customer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($data))
                        @foreach($data as $res)
                            <tr>
                                <td>
                                    @if(MyHelper::hasAccess([39], $grantedFeature))
                                        <a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail', $res['id_transaction']) }}"><i class="icon-pencil"></i> Detail </a>
                                    @endif
                                </td>
                                <td><span class="badge badge-sm {{$codeColor[$res['transaction_status_code']]??'badge-default'}}" @if($res['transaction_status_code'] == 6) style="background-color: #28a745;" @endif>{{ $res['transaction_status_text'] }}</span></td>
                                <td>{{ date('d F Y H:i', strtotime($res['transaction_date'])) }}</td>
                                <td>Rp {{number_format($res['transaction_grandtotal'],0,",",".")}}</td>
                                <td>{{ $res['transaction_group_receipt_number'] }}</td>
                                <td>{{ $res['transaction_receipt_number'] }}</td>
                                <td>
                                    {{$res['user_name']}} </br>
                                    {{$res['user_phone']}} </br>
                                    {{$res['user_email']}} </br>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <br>
            @if ($dataPaginator)
                {{ $dataPaginator->links() }}
            @endif
        </div>
    </div>
@endsection
