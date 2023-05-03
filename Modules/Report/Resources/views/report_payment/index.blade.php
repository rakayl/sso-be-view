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

    if(Session::has('filter-list-payment-'.$type)){
        $search_param = Session::get('filter-list-payment-'.$type);
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
        @include('report::report_payment.filter_list')
    </form>

    <div class="m-heading-1 border-green m-bordered">
        <p>Default data yang ditampilkan adalah data dengan status <b>"Completed"</b>. Untuk mencari data dengan status selain <b>"Completed"</b>, Anda bisa menggunakan filter diatas dengan memilih subject "Status". Export akan menghasilkan data sesuai dengan list data yang tampil saat ini.</p>
        <p>Tombol export akan muncul jika list dibawah tersedia.</p>
    </div>

    <br>
    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-5" style="text-align: center;">
            <div style="border: solid 1px black;">
                <h4><b>Total Amount : {{number_format($sum)}}</b></h4>
            </div>
        </div>
    </div>
    <br>

    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover" id="tableReport">
            <thead>
            <tr>
                <th scope="col" width="10%"> Date </th>
                <th scope="col" width="10%"> Reject Type </th>
                <th scope="col" width="10%">Status</th>
                <th scope="col" width="10%"> Type </th>
                <th scope="col" width="10%"> Payment Type </th>
                <th scope="col" width="10%"> Grand Total </th>
                <th scope="col" width="10%"> Payment Amount </th>
                <th scope="col" width="10%"> User Name </th>
                <th scope="col" width="10%"> User Phone </th>
                <th scope="col" width="10%"> Receipt Number </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                    <tr>
                        <td>{{date('d M Y H:i', strtotime($val['created_at']))}}</td>
                        <td>
                            @if($val['reject_type'] == 'Not Reject')
                                <span class="badge bg-green-jungle">{{$val['reject_type']}}</span>
                            @elseif($val['reject_type'] == 'Reject To Point')
                                <span class="badge bg-red">{{$val['reject_type']}}</span>
                            @endif
                        </td>
                        <td>{{$val['payment_status']}}</td>
                        <td>{{$val['type']}}</td>
                        <td>{{$val['payment_type']}}</td>
                        <td>{{number_format($val['grand_total'])}}</td>
                        <td>
                            @if(isset($val['gross_amount']))
                                {{number_format((int)$val['gross_amount'])}}
                            @elseif(isset($val['amount']))
                                {{number_format((int)$val['amount'])}}
                            @endif
                        </td>
                        <td>{{$val['name']}}</td>
                        <td><a target="_blank" href="{{ url('user/detail', $val['phone']) }}">{{$val['phone']}} </a></td>
                        <td><a target="_blank" href="{{ url('transaction/detail') }}/{{ $val['id_report'] }}/{{ $val['trx_type'] }}">{{$val['receipt_number']}} </a></td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
        Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
    @endif
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection