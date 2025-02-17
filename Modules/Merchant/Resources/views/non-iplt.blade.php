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
    <br>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th scope="col"> Action </th>
            <th scope="col"> Vendor </th>
            <th scope="col"> Tempat Pembuangan </th>
            <th scope="col"> Tanggal </th>
            <th scope="col"> Volume </th>
            <th scope="col"> Jumlah Penyedotan </th>
            <th scope="col"> No Plat Armada </th>
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
                                   <div class="modal-header">
                                        <h5 class="modal-title">Detail Pembuangan</h5>
                                    </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Nama Vendor
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['outlet_name']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Tanggal
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['date']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Tempat Pembuangan
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['nama_tempat_pembuangan']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Armada
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['name_accommodation']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    No Plat Armada
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['number_accommodation']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">
                                                    Volume Dumping
                                                </label>
                                                <div class="col-md-8">
                                                    <div style="margin-top: 2%"></div>
                                                    {{$val['volume_dumping']}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col"> No Transaksi </th>
                                                        <th scope="col"> Customer </th>
                                                        <th scope="col"> Waktu </th>
                                                        <th scope="col"> Volume </th>
                                                        <th scope="col"> Alamat </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($val['sedot']))
                                                        @foreach($val['sedot'] as $key=>$vas)
                                                            <tr>
                                                                <td>{{$vas['transaction_receipt_number']}}</td>
                                                                <td>{{$vas['name']}}</td>
                                                                <td>{{$vas['time_confirm']}}</td>
                                                                <td>{{$vas['volume_sedot_wc']}}</td>
                                                                <td>{{$vas['address']}}, {{$vas['subdistrict_name']}}, {{$vas['district_name']}}, {{$vas['city_name']}}, {{$vas['province_name']}}, {{$vas['postal_code']}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr><td colspan="5" style="text-align: center">Data Not Available</td></tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{$val['outlet_name']}}</td>
                    <td>{{$val['nama_tempat_pembuangan']}}</td>
                    <td>{{$val['date']}}</td>
                    <td>{{$val['volume_dumping']}}</td>
                    <td>{{$val['count_sedot']}}</td>
                    <td>{{$val['number_accommodation']}}</td>
                   
                </tr>
            @endforeach
        @else
            <tr><td colspan="7" style="text-align: center">Data Not Available</td></tr>
        @endif
        </tbody>
    </table>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection