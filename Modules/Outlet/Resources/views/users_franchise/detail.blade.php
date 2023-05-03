<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Detail User Mitra</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table>
                <tr>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">Status Franchise</td>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">:
                        @if($user['user_franchise_type'] == 'Franchise')
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Franchise</span>
                        @else
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Not franchise</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">Phone</td>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">: {{$user['phone']}}</td>
                </tr>
                <tr>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">Email</td>
                    <td width="50%" style="padding-top: 10px;padding-bottom: 10px;">: {{$user['email']}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Outlet</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Outlet Name </th>
                        <th> Outlet Code </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($outlets))
                        @foreach($outlets as $value)
                            <tr>
                                <td>{{$value['outlet_code']}}</td>
                                <td>{{$value['outlet_name']}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if (isset($paginator) && !empty($paginator))
                {{ $paginator->links() }}
            @endif
        </div>
    </div>



@endsection