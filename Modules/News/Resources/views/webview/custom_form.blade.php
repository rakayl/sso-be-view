<?php
    use App\Lib\MyHelper;
    $title = "News Custom Form";
?>
@extends('webview.main')

@section('page-style-plugin')
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" /><link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
@stop

@section('css')
    <style type="text/css">
        .form-group.form-md-line-input .form-control.edited:not([readonly]) ~ label:after,
        .form-group.form-md-line-input .form-control.edited:not([readonly]) ~ .form-control-focus:after,
        .form-group.form-md-line-input .form-control:focus:not([readonly]) ~ label:after,
        .form-group.form-md-line-input .form-control:focus:not([readonly]) ~ .form-control-focus:after {
            background: #6C5648;
        }

        .md-checkbox label > .check{
            border-color: #6C5648;
        }
        .datepicker table td, .datepicker table th, .datetimepicker table td, .datetimepicker table th{
            font-family: "Seravek", sans-serif !important;
        }
        .datepicker .active,
        .datetimepicker .active,
        .md-radio label > .check {
            background-color: #6C5648 !important;
        }
        .datepicker .active:hover,
        .datetimepicker .active:hover{
            background-color: #907462 !important;
        }

        .form-actions .btn{
            width: 75%;
            max-width: 400px;
            font-size: 16px;
        }
        .btn-round{
            border-radius: 25px !important;
        }
        .btn-outline.brown{
            border-color: #6C5648;
            color: #6C5648;
            background-color: #fff;
        }
        .btn-outline.brown:focus{
            background-color: #6C5648;
            color: #fff;
        }
        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            [class*="col-"] {
                width: 100%;
            }

        }
    </style>
@stop

@section('content')
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="col-md-offset-3 col-md-6" style="padding-left: 0; padding-right: 0;">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light">
                    <div class="portlet-body form">
                        @include('layouts.notifications')
{{-- form --}}
<form role="form" action="{{ url($form_action) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-body">
        <?php
            $old = session()->getOldInput();
            $checkbox_id = 1;
            $radio_id = 1;
        ?>

        @foreach ($news['news_form_structures'] as $key => $item)
            <div class="form-group form-md-line-input">
                <input type="hidden" name="news_form[{{$key}}][input_type]" value="{{ $item['form_input_types'] }}">
                <input type="hidden" name="news_form[{{$key}}][input_label]" value="{{ $item['form_input_label'] }}">
                <input type="hidden" name="news_form[{{$key}}][is_unique]" value="{{$item['is_unique']}}">

                <?php
                    $field_name = "news_form[" .$key. "][input_value]";
                    $old_value = "";
                    if (!empty($old) && isset($old['news_form'][$key]['input_value'])) {
                        $old_value = $old['news_form'][$key]['input_value'];
                    }
                ?>

                @if($item['form_input_types'] == 'Short Text')
                    <input type="text" class="form-control" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Long Text')
                    <textarea class="form-control" rows="3" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}</textarea>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Number Input')
                    <input type="text" class="form-control" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }} value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=0) }}">
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Date')
                    <div class="input-icon right">
                        <input type="text" class="form-control datepicker" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=1) }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                        <i class="fa fa-calendar"></i>
                    </div>
                @elseif($item['form_input_types'] == 'Date & Time')
                    <div class="input-icon right">
                        <input type="text" class="form-control date form_datetime form_datetime bs-datetime" placeholder="Enter {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }} value="{{ MyHelper::oldValue($old_value, $item['form_input_autofill'], $user, $is_autofill=0) }}">
                        <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                        <i class="fa fa-calendar"></i>
                    </div>
                @elseif($item['form_input_types'] == 'Dropdown Choice' && $item['form_input_options'] != "")
                    @php
                        $listOption = explode(',', $item['form_input_options']);
                    @endphp
                    <select class="form-control" placeholder="Select {{$item['form_input_label']}}" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        @foreach ($listOption as $opt)
                            <option value="{{$opt}}" {{ ($old_value==$opt ? "selected" : "") }}>{{ucwords($opt)}}</option>
                        @endforeach
                    </select>
                    <label>{{ucwords($item['form_input_label'])}}  {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                @elseif($item['form_input_types'] == 'Radio Button Choice' && $item['form_input_options'] != "")
                    @php $listOption = explode(',', $item['form_input_options']) @endphp
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="md-radio-list">
                        @foreach ($listOption as $i => $opt)
                        <div class="md-radio">
                            @if($item['is_required']==1 && $i==0)
                                <input type="radio" id="radio{{$radio_id}}" name="{{ $field_name }}" value="{{$opt}}" class="md-radiobtn" required {{ ($old_value==$opt ? "checked" : "") }}>
                            @else
                                <input type="radio" id="radio{{$radio_id}}" name="{{ $field_name }}" value="{{$opt}}" class="md-radiobtn" {{ ($old_value==$opt ? "checked" : "") }}>
                            @endif
                            <label for="radio{{$radio_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ucwords($opt)}} </label>
                        </div>
                        <?php $radio_id++; ?>
                        @endforeach
                    </div>
                @elseif($item['form_input_types'] == 'Multiple Choice' && $item['form_input_options'] != "")
                    @php
                        $listOption = explode(',', $item['form_input_options']);
                        if ($old_value != "") {
                            $old_value = implode(' ', $old_value);
                        }
                    @endphp
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="md-checkbox-list {{ ($item['is_required']==1 ? 'checkbox-required' : '') }}">
                        @foreach ($listOption as $i => $opt)
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox{{$checkbox_id}}"  name="{{ $field_name }}[]" value="{{$opt}}" class="md-check" {{ (strpos($old_value, $opt)!==false ? "checked" : "") }}>
                                <label for="checkbox{{$checkbox_id}}">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ucwords($opt)}} </label>
                            </div>
                            <?php $checkbox_id++; ?>
                        @endforeach
                    </div>
                @elseif($item['form_input_types'] == 'File Upload')
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="display:block;">
                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput" style="width:100% !important">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> </span>
                            <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput" style="float:right"> </a>
                        </div>
                        <span class="input-group-addon btn default btn-file" style="display:none">
                            <span class="fileinput-new"></span>
                            <input type="file" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                        </span>
                        <span class="fileinput-exists"></span>
                    </div>
                @elseif($item['form_input_types'] == 'Image Upload')
                    <label style="color: #888;">{{ucwords($item['form_input_label'])}} {!! MyHelper::isRequiredMark($item['is_required']) !!}</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="display:block;">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                        <div>
                            <span class="btn default btn-file">
                                <span class="fileinput-new"> Select image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="{{ $field_name }}" {{ ($item['is_required']==1 ? 'required' : '') }}>
                            </span>
                            <a href="javascript:;" class="btn red fileinput-exists" style="margin-left:5px" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach


        @if($form_action != "")
            <input type="hidden" name="bearer" value="{{ $bearer }}">
            <input type="hidden" name="flag" value="{{ $flag }}">
            <input type="hidden" name="id_news" value="{{ $news['id_news'] }}">
        @endif

        <div class="form-actions noborder text-center">
            @if($form_action != "")
                <input type="submit" value="Submit" class="btn btn-round btn-outline brown">
            @else
                {{-- only preview for admin --}}
                <button type="button" class="btn btn-round btn-outline brown" style="cursor: not-allowed;">Submit</button>
            @endif
        </div>
    </div>
</form>
{{-- end form --}}
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
@stop

@section('page-script')
    <!--[if lt IE 9] -->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true,
            'orientation': 'auto right'
        });

        $(document).ready(function() {
            // check required checkbox
            $("form").on('submit', function(e) {
                $('.md-checkbox-list.checkbox-required').each(function(i) {
                    if($(this).find('input[type="checkbox"]:checked').length == 0){
                        e.preventDefault();
                        alert('Please check the checkbox at least 1');
                        return false;
                    };
                });
            });
        });
    </script>
@stop
