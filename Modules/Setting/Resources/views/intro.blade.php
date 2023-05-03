<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
 @extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

    <style type="text/css">
        .sort-icon{
         position: absolute;
         top: 7px;
         left: 0px;
         z-index: 10;
         color: #777;
         cursor: move;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();

            $('#day').multiDatesPicker();

            $(".file").change(function(e) {
                var type      = $(this).data('jenis');
                var widthImg  = 1080;
                var heightImg = 1720;

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                    image = new Image();

                    image.onload = function() {
                        if (this.width == widthImg && this.height == heightImg) {
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");

                            if (type == "square" || type == "icon") {
                                $('#field_image_square').val("");
                                $('#image_square').children('img').attr('src', 'https://www.placehold.it/1080x1720/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                        }
                    };
                    image.src = _URL.createObjectURL(file);
                }
            });

            $('.mt-repeater-add').on('click', function(event) {
                if ($(this).parents(".mt-repeater").find("div[data-repeater-item]").length <= $(this).parents(".mt-repeater").attr("data-limit")) {
                    $('.previewImage').last().attr('src', 'https://www.placehold.it/1080x1720/EFEFEF/AAAAAA&amp;text=no+image');
                    $('.btnImage').last().show();
                    $('.featureImageForm').last().prop('type', 'file');
                    $('.featureImageForm').last().val('');
                    $('.featureImageForm').last().prop('required',true);
                } else {
                    alert("List tutorial maksimal hanya " + $(this).parents(".mt-repeater").attr("data-limit") + ' gambar');
                    $('.mt-repeater-item').last().remove();
                }
            });
        });
        
        function checkImage(){
            var type      = $(this).data('jenis');
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;
            var this2 = this;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (type == "landscape") {
                        if (this.width != 1080 || this.height != 1720) {
                            toastr.warning("Please check dimension of your photo.");
                            $(this2).parent().parent().find('.removeLogo').trigger( "click" );
                        }
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
        };
    </script>
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
                @if (!empty($subTitle))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($subTitle))
            <li>
                <span>{{ $subTitle }}</span>
            </li>
            @endif
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase">{{$sub_title}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal form-bordered" action="{{ url('setting/intro/save') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Status Active
                            <i class="fa fa-question-circle tooltips" data-original-title="Status tutorial aplikasi, jika Active maka gambar tutorial akan tampil di apps dan jika Inactive maka gambar tutorial tidak akan tampil di apps" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <input type="checkbox" name="active" @if(isset($value['active']) && $value['active'] == '1') checked @endif class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Status Skippable
                            <i class="fa fa-question-circle tooltips" data-original-title="Status dilewati tutorial, jika Active maka gambar tutorial dapat dilewati oleh pengguna" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <input type="checkbox" name="skippable" @if(isset($value['skippable']) && $value['skippable'] == '1') checked @endif class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Text Button
                            <i class="fa fa-question-circle tooltips" data-original-title="Teks untuk button yang akan ditampilkan pada halaman tutorial" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <div class="col-md-6">
                                <div class="form-group" style="border: none;">
                                    <img class="img-responsive" src="{{env('STORAGE_URL_VIEW').'img/setting/next.png'}}" alt="">
                                    <div class="input-group" style="border: none;border: none;width: 60%;margin: auto;">
                                        <input maxlength="11" type="text" name="text_next" @if(isset($value['text_next'])) value="{{$value['text_next']}}" @endif class="form-control">
                                        <span class="input-group-addon">
                                            <i style="color:#333;" class="fa fa-question-circle tooltips" data-original-title="Input ini akan menggantikan text Selanjutnya (Default), di tampilkan di bagian bawah kanan" data-container="body"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="border: none;">
                                    <img class="img-responsive" src="{{env('STORAGE_URL_VIEW').'img/setting/previous.png'}}" alt="">
                                    <div class="input-group" style="border: none;border: none;width: 60%;margin: auto;">
                                        <input maxlength="11" type="text" name="text_previous" @if(isset($value['text_previous'])) value="{{$value['text_previous']}}" @endif class="form-control">
                                        <span class="input-group-addon">
                                            <i style="color:#333;" class="fa fa-question-circle tooltips" data-original-title="Input ini akan menggantikan text Lewati (Default), di tampilkan di bagian bawah kiri" data-container="body"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="border: none;">
                                    <img class="img-responsive" src="{{env('STORAGE_URL_VIEW').'img/setting/skip.png'}}" alt="">
                                    <div class="input-group" style="border: none;border: none;width: 60%;margin: auto;">
                                        <input maxlength="11" type="text" name="text_skip" @if(isset($value['text_skip'])) value="{{$value['text_skip']}}" @endif class="form-control">
                                        <span class="input-group-addon">
                                            <i style="color:#333;" class="fa fa-question-circle tooltips" data-original-title="Input ini akan menggantikan text Lewati (Default), di tampilkan di bagian bawah kiri" data-container="body"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                <div class="form-group" style="border: none;">
                                    <img class="img-responsive" src="{{env('STORAGE_URL_VIEW').'img/setting/last_button.png'}}" alt="">
                                    <div class="input-group" style="border: none;border: none;width: 60%;margin: auto;">
                                        <input maxlength="11" type="text" name="text_last" @if(isset($value['text_last'])) value="{{$value['text_last']}}" @endif class="form-control">
                                        <span class="input-group-addon">
                                            <i style="color:#333;" class="fa fa-question-circle tooltips" data-original-title="Input ini akan menggantikan text Mulai (Default), di tampilkan di bagian bawah kanan, menggantikan text Next (Default) jika sudah di gambar terakhir" data-container="body"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">
                                Intro List
                            <i class="fa fa-question-circle tooltips" data-original-title="List gambar sesuai urutan" data-container="body"></i>
                        </label>
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <div class="mt-repeater" data-limit="8" id="parent-list">
                                    <div data-repeater-list="value_text" id="sortable">
                                        @if (isset($value_text) && $value_text != null)
                                        @foreach ($value_text as $item)
                                        <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                            <div class="mt-repeater-cell" style="position: relative;">
                                                <div class="sort-icon">
                                                    <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                </div>
                                                <div class="col-md-12">
                                                    @if(MyHelper::hasAccess([171], $grantedFeature))
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    <div class="input-icon right">
                                                        <label class="col-md-4 control-label">
                                                        Image Tutorial
                                                        <span class="required" aria-required="true"> * </span>
                                                        <br>
                                                        <span class="required" aria-required="true"> (1080*1720) </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran portrait ditampilkan pada halaman awal aplikasi mobile" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 17Z0px;">
                                                            <img class='previewImage' src="{{env('STORAGE_URL_API') . $item}}" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 17Z0px; max-height: 100px;"></div>
                                                            <div class='btnImage' hidden>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="text" accept="image/*" value="{{'value='.$item}}" class="file form-control demo featureImageForm" name="value_text" data-jenis="landscape" onchange="checkImage.bind(this)()">
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists removeLogo" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
                                            <div class="mt-repeater-cell" style="position: relative;">
                                                <div class="sort-icon">
                                                    <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                                                </div>
                                                <div class="col-md-12">
                                                    @if(MyHelper::hasAccess([171], $grantedFeature))
                                                    <div class="col-md-2">
                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                            <i class="fa fa-close"></i>
                                                        </a>
                                                    </div>
                                                    @endif
                                                    <div class="input-icon right">
                                                        <label class="col-md-4 control-label">
                                                        Image Tutorial
                                                        <span class="required" aria-required="true"> * </span>
                                                        <br>
                                                        <span class="required" aria-required="true"> (1080*1720) </span>
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran portrait ditampilkan pada halaman awal aplikasi mobile" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 17Z0px;">
                                                                <img class='previewImage' src="https://www.placehold.it/1080x1720/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 17Z0px; max-height: 100px;"></div>
                                                            <div class='btnImage'>
                                                                <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Select image </span>
                                                                <span class="fileinput-exists"> Change </span>
                                                                <input type="file" accept="image/*" class="file form-control demo featureImageForm" name="value_text" data-jenis="landscape" onchange="checkImage.bind(this)()">
                                                                </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists removeLogo" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @if (!isset($detail))
                                    <div class="form-action col-md-12">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            @if(MyHelper::hasAccess([169], $grantedFeature))
                                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                                            <i class="fa fa-plus"></i> Add New Input</a>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    @if(MyHelper::hasAccess([170], $grantedFeature))
                                    <input hidden type="text" name="key" value="{{$key}}">
                                    <button type="submit" class="btn green">
                                        <i class="fa fa-check"></i> Submit</button>
                                    @endif
                                    <button type="button" class="btn default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection