<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')


@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .datepicker{
            padding: 6px 12px;
           }
    </style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
        <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
        <script>
        $('.price').each(function() {
        var input = $(this).val();
        var input = input.replace(/[\D\s\._\-]+/g, "");
        input = input ? parseInt( input, 10 ) : 0;

        $(this).val( function() {
            return ( input === 0 ) ? "" : input.toLocaleString( "id" );
        });
    });

        $( ".price" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        }

        $( ".price" ).on( "blur", checkFormat);
        function checkFormat(event){
            var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
            if(!$.isNumeric(data)){
                $( this ).val("");
            }
        }

        </script>
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('/')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            {{$title}}
        </li>
    </ul>
</div>
<br>


@include('layouts.notifications')
<br>
<div class="portlet card_ light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">Jenis Kepemilikan Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-body">
                <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_Android">
                        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                            <div class="portlet light">
                                <div id="addAndroid">
                                    <div class="mt-repeater" id="Android0">
                                        <div class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="col-md-12">
                                                    <div class="col-md-1">
                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('Android0')">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="name[][value]" required placeholder="Jenis Kepemilikan">
                                                            <span class="input-group-addon">
                                                                <i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Jenis Kepemilikan" data-container="body"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="btn btn-success mt-repeater-add" onclick="addVersion('Android')">
                                <i class="fa fa-plus"></i> Add New Jenis Kepemilikan</a>
                            </div>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-8">
                                        <button type="submit" class="btn green">Save</button>
                                        <button type="button" class="btn default">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                var noAndroid = 1;
                var noIOS = 1;
                var noOutletApp = 1;
                var noDoctorAndroid = 1;
                var noDoctorIOS = 1;

                window.onload = function(event) {
                    var android = JSON.parse('{!! json_encode($version) !!}');
                    if (android.length != 0) {
                        android.forEach(function(entry) {
                            $('#Android0').remove()
                            appendData('Android', 'Android', noAndroid, 'value', entry, entry.rules);
                            noAndroid++;
                        });
                    } 
                };

                function appendData(id, device, number, name, version, rules) {
                    var allow = ''
                    var not_allow = ''
                    if (rules == 1) {
                        var allow = 'selected'
                    } else if (rules == 0) {
                        var not_allow = 'selected'
                    }
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="name[][value]" value="'+version+'" required placeholder="Jenis Kepemilikan">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Jenis Kepemilikan" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }


                function dataAppend(item) {
                    if (item.app_type == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'value')
                        noAndroid++;
                    }
                }

                function addVersion(id){
                    if (id == "Android") {
                        appendDiv('Android', 'Android', noAndroid, 'value')
                        noAndroid++;
                    } 
                }

                function appendDiv(id, device, number, name) {
                    $("#add"+id).append(
                        '<div class="mt-repeater" id="'+id+number+'">'+
                            '<div class="mt-repeater-item mt-overflow">'+
                                '<div class="mt-repeater-cell">'+
                                    '<div class="col-md-12">'+
                                        '<div class="col-md-1">'+
                                            '<a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+id+number+'`)">'+
                                                '<i class="fa fa-close"></i>'+
                                            '</a>'+
                                        '</div>'+
                                        '<div class="col-md-5">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control" name="name[][value]" value="" required placeholder="Jenis Kepemilikan">'+
                                                '<span class="input-group-addon">'+
                                                    '<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Jenis Kepemilikan" data-container="body"></i>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    $('.tooltips').tooltip()
                }
                function deleteCondition(response) {
                    $('#'+response).remove()
                }
            </script>
            </div>
        </div>
    </div>
@endsection

