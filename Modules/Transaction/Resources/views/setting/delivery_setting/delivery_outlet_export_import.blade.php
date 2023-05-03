<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Order</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Delivery Settings</span>
                <i class="fa fa-circle"></i>
            </li>
            @if (!empty($sub_title))
                <li>
                    <span>{{ $sub_title }}</span>
                </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

    @if(MyHelper::hasAccess([32], $grantedFeature))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-green sbold uppercase">Import/Export Outlet Availability (Only in excel format)</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="m-heading-1 border-green m-bordered">
                    <p>Anda bisa mengubah data delivery outlet dengan contoh format excel dibawah ini. Data yang dibutuhkan untuk import delivery adalah delivery code dan outlet code.</p><br>
                    Contoh data : <br><br>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="30%">
                        <thead>
                        <tr>
                            <th> outlet_code </th>
                            <th> delivery_1 (Show/Hide)</th>
                            <th> delivery_1 (Enable/Disable)</th>
                            <th> delivery_2 (Show/Hide)</th>
                            <th> delivery_2 (Enable/Disable)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> a01 </td>
                            <td> Show </td>
                            <td> Enable </td>
                            <td> Hide </td>
                            <td> Disable </td>
                        </tr>
                        <tr>
                            <td> a02 </td>
                            <td> Hide </td>
                            <td> Disable </td>
                            <td> Show </td>
                            <td> Disable </td>
                        </tr>
                        <tr>
                            <td> a03 </td>
                            <td> Hide </td>
                            <td> Disable </td>
                            <td> Show </td>
                            <td> Disable </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @if(MyHelper::hasAccess([2], $configs))
                    @if(MyHelper::hasAccess([32], $grantedFeature))
                        <form class="form-horizontal" role="form" action="{{url('transaction/setting/delivery-outlet/import-save')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Export Delivery</label>
                                    <div class="col-md-8">
                                        <a href= "{{url('transaction/setting/export/delivery-outlet')}}"> <i class="fa fa-file-excel-o"></i> Delivery </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">File Delivery Outlet <span class="required" aria-required="true"> * </span></label>
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                    <span class="fileinput-filename"> </span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required> </span>
                                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Import</button>
                                        <!-- <button type="button" class="btn default">Cancel</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    @endif
@endsection