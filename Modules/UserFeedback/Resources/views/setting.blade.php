<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .item{
        padding: 10px;
        border-bottom: 4px solid #eeeeee;
        background: #fff;
        margin: 15px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        position: relative;
    }
    .value-bg{
        text-align: center;
        border: 3px solid;
        width: 100px;
        height: 100px;
        border-radius: 50% 50% !important;
        font-size: 60px;
        position: absolute;
        right: 10px;
        bottom: 10px;
        opacity: .7;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('#select-total').on('change',function(){
            if($(this).val()==="2"){
                $('#rating-item-netral').addClass('hidden');
                $('#rating-item-netral input').attr('disabled','disabled');
            }else{
                $('#rating-item-netral').removeClass('hidden');
                $('#rating-item-netral input').removeAttr('disabled');
            }
        });
        $(".file").change(function(e) {
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;
            var domLock = $(this);
            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (domLock.val().split('.').pop().toLowerCase() != 'png') {
                        domLock.val().split('.').pop().toLowerCase()
                        domLock.parents('.fileinput').find('.removeImage').click();
                    }
                    if (this.width != 100 || this.height != 100) {
                        console.log('width: '+this.width+' height:'+this.height);
                        toastr.warning("Please check dimension of your photo.");
                        domLock.parents('.fileinput').find('.removeImage').click();
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
        });
        $('#select-total').change();
    });
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
            <span class="caption-subject font-dark sbold uppercase font-blue">User Feedback Setting</span>
        </div>
    </div>
    <div class="portlet-body form form-horizontal" id="detailRating">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_setting" data-toggle="tab"> Setting </a>
            </li>
            <li>
                <a href="#tab_rating_items" data-toggle="tab"> Rating Items </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab_setting">
                <form action="#" method="POST">
                    @csrf
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Popup Interval Time <i class="fa fa-question-circle tooltips" data-original-title="Rentang waktu minimal ditampilkannya popup rating" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" name="popup_min_interval" class="form-control" required value="{{old('popup_min_interval',$setting['popup_min_interval']['value']??'')}}" /><br/>
                                    <span class="input-group-addon">
                                        Seconds
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Maximum Refuse Popup <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penolakan maksimal untuk memberikan rating. Setelah jumlah terlampaui, popup tidak akan ditampilkan lagi sampai ada transaksi baru lagi" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" name="popup_max_refuse" required value="{{old('popup_max_refuse',$setting['popup_max_refuse']['value']??'')}}" /><br/>
                                    <span class="input-group-addon">
                                        Times
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Transaction Date <i class="fa fa-question-circle tooltips" data-original-title="Rentang hari maksimal dari transaksi yang memungkinkan untuk ditampilkan di popup rating mobile apps" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control" name="popup_max_days" required value="{{old('popup_max_days',$setting['popup_max_days']['value']??3)}}" /><br/>
                                    <span class="input-group-addon">
                                        days before
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(MyHelper::hasAccess([213], $grantedFeature))
                    <div class="row">
                        <div class="col-md-offset-3 col-md-5">
                            <div class="form-group">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            <div class="tab-pane fade" id="tab_rating_items">
                <form action="{{url('user-feedback/item')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <label class="col-md-offset-3 col-md-3 control-label text-right">Total Rating Item <i class="fa fa-question-circle tooltips" data-original-title="Jumlah rating item yang akan tampil di mobile apps" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="select2 form-control" id="select-total">
                                    <option value="2">2 Item</option>
                                    <option value="3" @if(count($items)==3) selected @endif>3 Item</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="rating-container" class="col-md-8">
                            <div class="item border-blue" id="rating-item-good">
                                <div class="value-bg font-blue border-blue">1</div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">Text
                                        <span class="required" aria-required="true"> *
                                        </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di popup" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{old('item.1.text',$items['1']['text']??'')}}" name="item[1][text]" required maxlength="10" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">
                                        Image
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['1']['image']??false)
                                                <img id="preview_image" src="{{$items['1']['image']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[1][image]"  @if(!($items['1']['image']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px">
                                    <label class="col-md-4 control-label text-right">
                                        Image Selected
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks saat terpilih" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['1']['image_selected']??false)
                                                <img id="preview_image" src="{{$items['1']['image_selected']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[1][image_selected]" @if(!($items['1']['image_selected']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item border-dark" id="rating-item-netral">
                                <div class="value-bg font-dark border-dark">0</div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">Text
                                        <span class="required" aria-required="true"> *
                                        </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di popup" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{old('item.0.text',$items['0']['text']??'')}}" name="item[0][text]" required maxlength="10" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">
                                        Image
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['0']['image']??false)
                                                <img id="preview_image" src="{{$items['0']['image']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[0][image]"  @if(!($items['0']['image']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px">
                                    <label class="col-md-4 control-label text-right">
                                        Image Selected
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks saat terpilih" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['0']['image_selected']??false)
                                                <img id="preview_image" src="{{$items['0']['image_selected']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[0][image_selected]" @if(!($items['0']['image_selected']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item border-red" id="rating-item-bad">
                                <div class="value-bg font-red border-red">-1</div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">Text
                                        <span class="required" aria-required="true"> *
                                        </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di popup" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{old('item.-1.text',$items['-1']['text']??'')}}" name="item[-1][text]" required maxlength="10" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4 control-label text-right">
                                        Image
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['-1']['image']??false)
                                                <img id="preview_image" src="{{$items['-1']['image']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[-1][image]" @if(!($items['-1']['image']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px">
                                    <label class="col-md-4 control-label text-right">
                                        Image Selected
                                        <span class="required" aria-required="true"> * </span>
                                        <br>
                                        <span class="required" aria-required="true"> (100 * 100) </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar yang akan ditampilkan diatas teks saat terpilih" data-container="body"></i>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                @if($items['1']['image_selected']??false)
                                                <img id="preview_image" src="{{$items['-1']['image_selected']}}"/>
                                                @else
                                                <img id="preview_image" src="https://www.placehold.it/100x100/EFEFEF/AAAAAA"/>
                                                @endif
                                            </div>

                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" accept="image/png" class="file" name="item[-1][image_selected]" @if(!($items['-1']['image_selected']??false)) required @endif> 
                                                </span>
                                                <a href="javascript:;" class="btn red default fileinput-exists removeImage" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(MyHelper::hasAccess([213], $grantedFeature))
                            <div class="text-center" style="margin-top: 10px">
                                <button class="btn blue" id="saveItemBtn"><i class="fa fa-check"></i> Save</button>
                            </div>
                            @endif
                        </div>
                        <div class="preview col-md-4 pull-right" style="right: 0;top: 70px; position: sticky">
                            <img src="{{env('STORAGE_URL_VIEW')}}img/setting/rating_preview.png" class="img-responsive">
                        </div>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalInfo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{env('STORAGE_URL_VIEW')}}img/setting/rating2_preview.png" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection