<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>

@section('step1')
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Title
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Judul subscription" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-5">
            <div class="input-icon right">
                <input type="text" class="form-control" name="subscription_title" value="{{ old('subscription_title')??$subscription['subscription_title']??'' }}" placeholder="Title" required autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Sub Title
            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul subscription jika ada" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-5">
            <div class="input-icon right">
                <input type="text" class="form-control" name="subscription_sub_title" value="{{ old('subscription_sub_title')??$subscription['subscription_sub_title']??'' }}" placeholder="Sub Title" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Image
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Gambar subscription" data-container="body"></i>
            <br>
            <span class="required" aria-required="true"> (600*250) </span>
            </label>
        </div>
        <div class="col-md-9">
            <div class="input-icon right">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 300px; height: 125px;">
                      <img src="{{$subscription['url_subscription_image']??'https://www.placehold.it/600x250/EFEFEF/AAAAAA&amp;text=no+image'}}" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 125px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" accept="image/*" name="subscription_image" {{ isset($subscription['url_subscription_image']) ? '' : 'required' }} id="file">

                        </span>

                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"> subscription Periode <span class="required" aria-required="true"> * </span> </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control date-top-right" name="subscription_start" value="{{ old('subscription_start') ? old('subscription_start') : ( ($subscription['subscription_start']??false) ? date('d-M-Y H:i', strtotime( $subscription['subscription_start'])) : '' ) }}" required autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Subscription dapat mulai diklaim user. Tidak bisa sebelum dari tanggal Publish Periode" data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control date-top-right" name="subscription_end" value="{{ old('subscription_end') ? old('subscription_end') : ( ($subscription['subscription_end']??false) ? date('d-M-Y H:i', strtotime( $subscription['subscription_end'])) : '' ) }}" required autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Batas tanggal Subscription dapat diklaim user." data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if ($subscription_type == 'subscription')
    <div class="form-group">
        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="subscription_publish_start" value="{{ old('subscription_publish_start') ? old('subscription_publish_start') : ( ($subscription['subscription_publish_start']??false) ? date('d-M-Y H:i', strtotime( $subscription['subscription_publish_start'])) : '' ) }}" required autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Subscription akan mulai dipublish / ditayangkan pada aplikasi." data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="subscription_publish_end" value="{{ old('subscription_publish_end') ? old('subscription_publish_end') : ( ($subscription['subscription_publish_end']??false) ? date('d-M-Y H:i', strtotime( $subscription['subscription_publish_end'])) : '' ) }}" autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Batas tanggal Subscription dipublish / ditayangkan pada aplikasi." data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif
    	
    <div class="form-group" id="brand-rule">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Product Type
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe produk yang akan dikenakan promo jika promo yang dipilih menggunakan syarat produk" data-container="body" data-html="true"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-5">
                    <select class="form-control" name="product_type" required>
                        <option value="" disabled 
                            @if ( old('product_type')) 
                                @if ( old('product_type') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['product_type']) ) 
                                selected
                            @endif>Select Product Type</option>
                        <option value="single" 
                            @if ( old('product_type')) 
                                @if ( old('product_type') == "single" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['product_type']) && $subscription['product_type'] === 'single')
                                selected
                            @endif>Product only<i class="fa fa-question-circle tooltips" data-original-title="Syarat produk yang dapat dipilih hanya produk saja tanpa variant" data-container="body"></i>
                        </option>
                        <option value="variant" 
                            @if ( old('product_type')) 
                                @if ( old('product_type') == "variant" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['product_type']) && $subscription['product_type'] === 'variant')
                                selected
                            @endif>Product variant<i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dengan variant" data-container="body"></i>
                        </option>
                        <option value="single + variant" 
                            @if ( old('product_type')) 
                                @if ( old('product_type') == "single + variant" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['product_type']) && $subscription['product_type'] === 'single + variant')
                                selected
                            @endif>Product + Product variant<i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dan product dengan variant" data-container="body"></i>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"> Charged Central
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Percent fee yang akan dibebankan ke pihak pusat" data-container="body"></i>
        </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input required type="text" class="form-control" name="charged_central" placeholder="Charged Central" @if(isset($subscription['charged_central']) && $subscription['charged_central'] != "") value="{{$subscription['charged_central']}}" @elseif(old('charged_central') != "") value="{{old('charged_central')}}" @endif>
                    <span class="input-group-addon">%</span>
                </div>
                <p style="color: red;display: none" id="label_central">Invalid value, charged central and outlet must be 100</p>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"> Charged Outlet
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Percent fee yang akan dibebankan ke pihak outlet" data-container="body"></i>
        </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input required type="text" class="form-control" name="charged_outlet" placeholder="Charged Outlet" @if(isset($subscription['charged_outlet']) && $subscription['charged_outlet'] != "") value="{{$subscription['charged_outlet']}}" @elseif(old('charged_outlet') != "") value="{{old('charged_outlet')}}" @endif>
                    <span class="input-group-addon">%</span>
                </div>
                <p style="color: red;display: none" id="label_outlet">Invalid value, charged central and outlet must be 100</p>
            </div>
        </div>
    </div>
@endsection