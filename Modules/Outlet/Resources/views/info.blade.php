<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    @foreach ($outlet as $key => $val)
    <div class="form-body">
        <h4>Info</h4>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    PIC Name
                    <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9" style="margin-top: 1%">
                <a target="_blank" href="{{url('merchant/detail', $val['merchant']['id_merchant'])}}">{{$val['merchant']['merchant_pic_name']}}</a>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Code
                <i class="fa fa-question-circle tooltips" data-original-title="Kode outlet bersifat unik" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_code" value="{{ $val['outlet_code'] }}" required placeholder="Outlet Code" @if(Session::get('level') != "Super Admin") readonly @endif>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Name
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_name" value="{{ $val['outlet_name'] }}" required placeholder="Outlet Name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    License Number
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor ijin usaha" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_license_number" value="{{ $val['outlet_license_number'] }}" required placeholder="Outlet License Number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Status
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Status outlet. Outlet tidak akan ditampilkan di aplikasi ketika status Inactive" data-container="body"></i>
            </label>
            <div class="col-md-9">
                    <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" id="radio14" name="outlet_status" class="md-radiobtn" value="Active" required @if($val['outlet_status'] == 'Active') checked @endif>
                        <label for="radio14">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Active </label>
                    </div>
                    <div class="md-radio">
                        <input type="radio" id="radio16" name="outlet_status" class="md-radiobtn" value="Inactive" required @if($val['outlet_status'] == 'Inactive') checked @endif>
                        <label for="radio16">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Inactive </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Province
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                    <optgroup label="Province List">
                        <option value="">Select Province</option>
                        @if (!empty($province))
                            @foreach($province as $suw)
                                <option value="{{ $suw['id_province'] }}" @if ($suw['id_province'] == $val['city']['id_province']) selected @endif >{{ $suw['province_name'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                City
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="city" name="id_city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                    <optgroup label="City List">
                        <option value="{{ $val['city']['id_city'] }}">{{ $val['city']['city_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Disctrict
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih kecamatan outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="district" class="form-control select2-multiple" data-placeholder="Select Disctrict" disabled required>
                    <optgroup label="Disctrict List">
                        <option value="{{ $val['subdistrict']['id_district'] }}">{{ $val['subdistrict']['district']['district_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Subdisctrict
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih kelurahan outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select id="subdistrict" name="id_subdistrict" class="form-control select2-multiple" data-placeholder="Select Subdisctrict" disabled required>
                    <optgroup label="Subdisctrict List">
                        <option value="{{ $val['subdistrict']['id_subdistrict'] }}">{{ $val['subdistrict']['subdistrict_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Address
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <textarea name="outlet_address" class="form-control" placeholder="Outlet Address" required>{{ $val['outlet_address'] }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Postal Code
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Masukkan kode post outlet" maxlength="15" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="outlet_postal_code" name="outlet_postal_code" value="{{ $val['outlet_postal_code'] }}" required placeholder="Postal Code" readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Phone
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_phone" value="{{ $val['outlet_phone'] }}" placeholder="Outlet Phone" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Email
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat email outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="outlet_email" value="{{ $val['outlet_email'] }}" placeholder="Outlet Email" required>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 control-label">
                Image Logo Portrait <span class="required" aria-required="true">* <br>(300*300) </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Logo outlet ukuran 300 x 300" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                        <img src="@if(!empty($val['outlet_image_logo_portrait'])){{$val['url_outlet_image_logo_portrait']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="image" style="max-width: 200px; max-height: 200px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="file" id="fieldphoto" accept="image/*" name="outlet_image_logo_portrait" @if(empty($val['outlet_image_logo_portrait'])) required @endif>
                        </span>

                        <a href="javascript:;" id="remove_fieldphoto" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">
                Image Cover<span class="required" aria-required="true">* <br>(720*375) </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Cover outlet ukuran 730px x 375 px" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 300px; height: 150px;">
                        <img src="@if(!empty($val['outlet_image_cover'])){{$val['url_outlet_image_cover']}}@endif" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="imageCover" style="max-width: 300px; max-height: 150px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" class="filePhotoCover" id="fieldphotocover" accept="image/*" name="outlet_image_cover" @if(empty($val['outlet_image_cover'])) required @endif>
                        </span>

                        <a href="javascript:;" id="remove_fieldphotocover" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>
        {{--
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Time Zone
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Zona waktu outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="form-control" name="time_zone_utc" required>
                    <option value="" disabled @if ( old('time_zone_utc')== "" ) selected @endif>Select Time Zone</option>
                    <option value="7" 
                        @if ( $val['time_zone_utc'] == '7' ) 
                            selected 
                        @endif>WIB - Asia/Jakarta (UTC +07:00)</option>
                    <option value="8" 
                        @if ( $val['time_zone_utc'] == '8' ) 
                            selected 
                        @endif>WITA - Asia/Makassar (UTC +08:00)</option>
                    <option value="9" 
                        @if ( $val['time_zone_utc'] == '9' ) 
                            selected 
                        @endif>WIT - Asia/Jayapura (UTC +09:00)</option>
                </select>
            </div>
        </div>
        --}}
        <!--<div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Gojek
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link gojek" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_gojek" value="{{ $val['deep_link_gojek'] }}" placeholder="Deep link gojek">
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deep Link Grab
                <i class="fa fa-question-circle tooltips" data-original-title="Deep link grab" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deep_link_grab" value="{{ $val['deep_link_grab'] }}" placeholder="Deep link grab">
            </div>
        </div>-->

        @if(MyHelper::hasAccess([96], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Delivery Order
                <i class="fa fa-question-circle tooltips" data-original-title="Jika diaktifkan, maka halaman detail outlet di aplikasi akan menampilkan ketersediaan delivery order untuk outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" name="delivery_order" @if(old('delivery_order',$val['delivery_order']) == '1') checked @endif  class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive" value="1">
            </div>
        </div>
        @endif

        <hr>
        <h4>Maps</h4>

        <div class="form-group">
            <label class="col-md-3 control-label">Latitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_latitude" value="{{ $val['outlet_latitude'] }}" id="lat">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Longitude</label>
            <div class="col-md-9">
                <input type="text" class="form-control latlong" name="outlet_longitude" value="{{ $val['outlet_longitude'] }}" id="lng">
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3"></label>
            <div class="col-md-9">
                <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                <div id="map-canvas" style="width:900;height:380px;"></div>
            </div>
        </div>

    </div>
    <div class="form-actions">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                @if(MyHelper::hasAccess([27], $grantedFeature))
                    <button type="submit" class="btn green">Submit</button>
                @endif
                <input type="hidden" name="id_outlet" value="{{ $val['id_outlet'] }}">
                <!-- <button type="button" class="btn default">Cancel</button> -->
            </div>
        </div>
    </div>
    @endforeach
</form>