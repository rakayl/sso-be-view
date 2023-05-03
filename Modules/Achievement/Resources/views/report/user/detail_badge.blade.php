@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        td {
            height: 30px;
        }
    </style>
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

    @include('layouts.notifications')

    <div class="row">
        @if(isset($data[0]['achivement_name']))
            <div class="col-md-6">
                <div class="portlet profile-info portlet light bordered">
                    <div class="portlet-title" style="display: flex;">
                            <span class="caption font-blue sbold uppercase">
                                &nbsp;&nbsp;{{$data[0]['achivement_name']}}
                            </span>
                    </div>
                    <div class="portlet sale-summary">
                        <div class="portlet-body">
                            <table>
                                <tr>
                                    <td width="60%">Status</td>
                                    <td>
                                        @if ($data[0]['date_start'] < date('Y-m-d H:i:s'))
                                            <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                                        @elseif (!is_null($data[0]['date_end']) && strtotime($data[0]['date_end']) < strtotime(date('Y-m-d H:i:s')))
                                            <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
                                        @else
                                            <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="60%">User Name</td>
                                    <td>{{$data[0]['user_name']}}</td>
                                </tr>
                                <tr>
                                    <td width="60%">User Phone</td>
                                    <td>{{$data[0]['phone']}}</td>
                                </tr>
                                <tr>
                                    <td width="60%">User Email</td>
                                    <td>{{$data[0]['email']}}</td>
                                </tr>
                                <tr>
                                    <td width="60%">Category Achievement</td>
                                    <td>{{$data[0]['category_name']}}</td>
                                </tr>
                                <tr>
                                    <td width="60%">Pulished at</td>
                                    <td>{{date('d F Y H:i', strtotime($data[0]['publish_start']))}}</td>
                                </tr>
                                <tr>
                                    <td width="60%">Created at</td>
                                    <td>{{date('d F Y H:i', strtotime($data[0]['achivement_created_at']))}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            @foreach ($data as $item)
                <div class="col-md-12 profile-info">
                    <div class="profile-info portlet light bordered">
                        <div class="portlet-title">
                            <div class="col-md-6" style="display: flex;">
                                <img src="{{$item['logo_badge']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                <span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
                                    &nbsp;&nbsp;{{$item['name']}}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row" style="padding: 5px;position: relative;">
                                <div class="col-md-12">
                                    <div class="row static-info">
                                        <div class="col-md-5 value">Badge Date</div>
                                        <div class="col-md-7 value">: {{date('d F Y H:i:s', strtotime($item['date']))}}</div>
                                    </div>
                                    @if (!is_null($item['id_product']) || !is_null($item['product_total']))
                                        <div class="row static-info">
                                            <div class="col-md-5 value">Product Rule</div>
                                        </div>
                                        <div class="row static-info">
                                            @if (!is_null($item['id_product']))
                                                <div class="col-md-5 name">Product</div>
                                                <div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
                                            @endif
                                            @if (!is_null($item['product_total']))
                                                <div class="col-md-5 name">Product Total</div>
                                                <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                            @endif
                                        </div>
                                    @endif
                                    @if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
                                        <div class="row static-info">
                                            <div class="col-md-5 value">Outlet Rule</div>
                                        </div>
                                        <div class="row static-info">
                                            @if (!is_null($item['id_outlet']))
                                                <div class="col-md-5 name">Outlet</div>
                                                <div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
                                            @endif
                                            @if (!is_null($item['different_outlet']))
                                                <div class="col-md-5 name">Outlet Different ?</div>
                                                <div class="col-md-7 value">: {{$item['different_outlet']}} Outlet</div>
                                            @endif
                                        </div>
                                    @endif
                                    @if (!is_null($item['id_province']) || !is_null($item['different_province']))
                                        <div class="row static-info">
                                            <div class="col-md-5 value">Province Rule</div>
                                        </div>
                                        <div class="row static-info">
                                            @if (!is_null($item['id_province']))
                                                <div class="col-md-5 name">Province</div>
                                                <div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
                                            @endif
                                            @if (!is_null($item['different_province']))
                                                <div class="col-md-5 name">Province Different ?</div>
                                                <div class="col-md-7 value">: {{$item['different_province']}} Provice</div>
                                            @endif
                                        </div>
                                    @endif
                                    @if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
                                        <div class="row static-info">
                                            <div class="col-md-5 value">Transaction Rule</div>
                                        </div>
                                        <div class="row static-info">
                                            @if (!is_null($item['trx_nominal']))
                                                <div class="col-md-5 name">Transaction Nominal</div>
                                                <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                            @endif
                                        </div>
                                        <div class="row static-info">
                                        @if (!is_null($item['trx_total']))
                                            <div class="col-md-5 name">Transaction Total</div>
                                            <div class="col-md-7 value">: Minimum {{number_format($item['trx_total'])}}</div>
                                        @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
