<?php
	use App\Lib\MyHelper;
    $configs    		= session('configs');
 ?>
@if (empty($deals['deals_type']) || $deals['deals_type'] != "Point")

    <div class="form-body">

		{{-- Deals Type --}}
    	@if(MyHelper::hasAccess([97], $configs) && MyHelper::hasAccess([98], $configs))
    	<div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Deals Type
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe untuk deal ini" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
            	<div class="mt-checkbox-inline">
                    <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                        <input class="online_offline" type="checkbox" id="is_online" name="is_online" value="1" 
                        @if ( old('is_online') == "1" )
                            checked 
                        @elseif ( !empty($deals['is_online']) ) 
                            checked 
                        @endif 

                        @if (old('is_online') == 1 || old('is_offline') == 1)
                        @elseif(empty($deals['is_online']) && empty($deals['is_offline']))
                        	required
                        @else
                        @endif> Online
                        <span></span>
                    </label>
                    <label class="mt-checkbox mt-checkbox-outline" style="margin-bottom: 0px">
                        <input class="online_offline" type="checkbox" id="is_offline" name="is_offline" value="1" 
                        @if ( old('is_offline') == "1" )
                            checked 
                        @elseif ( !empty($deals['is_offline']) ) 
                            checked 
                        @endif 

                        @if (old('is_online') == 1 || old('is_offline') == 1)
                        @elseif(empty($deals['is_online']) && empty($deals['is_offline']))
                        	required
                        @else
                        @endif> Offline
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        @elseif(MyHelper::hasAccess([97], $configs))
        <input type="hidden" name="is_offline" value="1">
        @elseif(MyHelper::hasAccess([98], $configs))
        <input type="hidden" name="is_online" value="1">
        @endif
        
        {{-- Brand --}}
        @if(MyHelper::hasAccess([95], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Brand
                <span class="required" aria-required="true"> * </span>  
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-icon right">
                    @php
						$selected_brand = [];
						if (old('id_brand')) {
							$selected_brand = old('id_brand');
						}
						elseif (!empty($deals['deals_brands']) || !empty($deals['deals_promotion_brands'])) {
							$selected_brand = array_column($deals['deals_brands']??$deals['deals_promotion_brands'], 'id_brand');
						}
					@endphp
                    <select class="form-control select2-multiple disable-input" data-placeholder="Select Brand" name="id_brand[]" multiple required>
                        <option></option>
                    @if (!empty($brands))
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id_brand'] }}" 
                            	@if ($selected_brand) 
                            		@if(in_array($brand['id_brand'], $selected_brand)) selected 
                            		@endif 
                            	@endif
                            >{{ $brand['name_brand'] }}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
            </div>
        </div>

        {{-- Brand Rule --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Brand Rule
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang akan digunakan untuk memilih outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9" style="margin-left: -15px;">
            	<div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="brand_rule" id="brand_rule_radio_and" value="and" class="md-radiobtn" required 
	                    		@if ( (old('brand_rule')??$deals['brand_rule']??false) == "and" ) checked 
	                    		@endif>
	                        <label for="brand_rule_radio_and">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> All selected brands </label>
	                        	<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki semua brand yang dipilih" data-container="body"></i>
	                    </div>
	                </div>
            	</div>
	            <div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="brand_rule" id="brand_rule_radio_or" value="or" class="md-radiobtn" required 
	                        	@if ( (old('brand_rule')??$deals['brand_rule']??false) == "or" ) checked 
	                    		@endif>
	                        <label for="brand_rule_radio_or">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> One of the selected brands </label>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki setidaknya salah satu brand yang dipilih" data-container="body"></i>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
        @endif

        {{-- Product Type --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Product Type
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe produk yang akan dikenakan promo jika promo yang dipilih menggunakan syarat produk" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9" style="margin-left: -15px;">
            	<div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="product_type" id="product_type_radio_single" value="single" class="md-radiobtn" required 
	                    		@if ( (old('product_type')??$deals['product_type']??false) == "single" ) checked 
	                    		@endif>
	                        <label for="product_type_radio_single">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> Product only </label>
	                        	<i class="fa fa-question-circle tooltips" data-original-title="Syarat produk yang dapat dipilih hanya produk saja tanpa variant" data-container="body"></i>
	                    </div>
	                </div>
            	</div>
	            <div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="product_type" id="product_type_radio_variant" value="variant" class="md-radiobtn" required 
	                        	@if ( (old('product_type')??$deals['product_type']??false) == "variant" ) checked 
	                    		@endif>
	                        <label for="product_type_radio_variant">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> Product variant only </label>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dengan variant" data-container="body"></i>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="product_type" id="product_type_radio_product_and_variant" value="single + variant" class="md-radiobtn" required 
	                        	@if ( (old('product_type')??$deals['product_type']??false) == "single + variant" ) checked 
	                    		@endif>
	                        <label for="product_type_radio_product_and_variant">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> Product + Product variant </label>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Syarat product yang dapat dipilih adalah product dan product dengan variant" data-container="body"></i>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>

        {{-- Title --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Title
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deals_title" value="{{ old('deals_title')??$deals['deals_title']??'' }}" placeholder="Title" required maxlength="45" autocomplete="off">
            </div>
        </div>

        {{-- Second Title --}}
        @if(MyHelper::hasAccess([105], $configs))
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Second Title
                <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="deals_second_title" value="{{ old('deals_second_title')??$deals['deals_second_title']??'' }}" placeholder="Second Title" maxlength="20" autocomplete="off">    
            </div>
        </div>
        @endif


        {{-- Deals Periode --}}
        @if ( $deals_type == "Deals" || $deals_type == "WelcomeVoucher" )
        <div class="form-group">
            <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control" name="deals_start" value="{{ !empty($deals['deals_start']) || old('deals_start') ? date('d-M-Y H:i', strtotime(old('deals_start')??$deals['deals_start'])) : ''}}" required autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                            <button class="btn default" type="button">
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Deals dapat mulai diklaim user. Tidak bisa sebelum dari tanggal Publish Periode" data-container="body"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control" name="deals_end" value="{{ !empty($deals['deals_end']) || old('deals_end') ? date('d-M-Y H:i', strtotime(old('deals_end')??$deals['deals_end'])) : ''}}" required autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                            <button class="btn default" type="button">
                                <i class="fa fa-question-circle tooltips" data-original-title="Batas tanggal Deals dapat diklaim user." data-container="body"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Deals Publish Periode --}}
        @if ($deals_type == "Deals")
        <div class="form-group">
            <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ !empty($deals['deals_publish_start']) || old('deals_publish_start') ? date('d-M-Y H:i', strtotime(old('deals_publish_start')??$deals['deals_publish_start'])) : '' }}" required autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                            <button class="btn default" type="button">
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal Deals akan mulai dipublish / ditayangkan pada aplikasi." data-container="body"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ !empty($deals['deals_publish_end']) || old('deals_publish_end') ? date('d-M-Y H:i', strtotime(old('deals_publish_end')??$deals['deals_publish_end'])) : '' }}" required autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                            <button class="btn default" type="button">
                                <i class="fa fa-question-circle tooltips" data-original-title="Batas tanggal Deals dipublish / ditayangkan pada aplikasi." data-container="body"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Image --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Image
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                <br>
                <span class="required" aria-required="true"> (500*500) </span>
                </label>
            </div>
            <div class="col-md-9">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                      <img src="{{ $deals['url_deals_image']??'https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image' }}" alt="Image Deals">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                    <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" accept="image/*"  {{ empty($deals['url_deals_image']) ? 'required' : '' }} name="deals_image" id="file">

                        </span>

                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Outlet --}}
        @php
        	if (!empty($deals['deals_list_outlet'])) { // promotion deals
        		$outletselected = explode(',',$deals['deals_list_outlet']);
        		if (in_array('all', $outletselected)) {
        			$deals['is_all_outlet'] = 1;
        		}
        	}elseif (!empty($deals['outlets'])) { // normal deals
                $outletselected = array_pluck($deals['outlets'],'id_outlet');
            }
            else {
                $outletselected = [];
            }

            $selected_outlet_groups = [];
            $selected_outlet_groups = array_pluck(($deals['outlet_groups'] ?? []), 'id_outlet_group');

        @endphp

        {{-- Filter Outlet --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Filter Outlet
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang dapat menggunakan deals" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9" style="margin-left: -15px;">
            	<div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="filter_outlet" id="filter_outlet_radio_single" value="all_outlet" class="md-radiobtn" required 
	                    		@if ( (old('filter_outlet') ?? false) == "all_outlet" ) checked 
	                    		@elseif (isset($deals['is_all_outlet']) && $deals['is_all_outlet'] == "1") checked 
	                    		@endif>
	                        <label for="filter_outlet_radio_single">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> All Outlet </label>
	                        	<i class="fa fa-question-circle tooltips" data-original-title="Deals berlaku di semua outlet" data-container="body"></i>
	                    </div>
	                </div>
            	</div>
	            <div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="filter_outlet" id="filter_outlet_radio_variant" value="selected_outlet" class="md-radiobtn" required 
	                        	@if ( (old('filter_outlet') ?? false) == "selected_outlet" ) checked 
	                        	@elseif (empty($deals['is_all_outlet']) && !empty($deals['outlets'])) checked
	                    		@endif>
	                        <label for="filter_outlet_radio_variant">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> Selected Outlet </label>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Deals hanya berlaku untuk outlet tertentu" data-container="body"></i>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-12">
	                <div class="md-radio-inline">
	                    <div class="md-radio">
	                        <input type="radio" name="filter_outlet" id="filter_outlet_radio_product_and_variant" value="outlet_group" class="md-radiobtn" required 
	                        	@if ( (old('filter_outlet') ?? false) == "outlet_group" ) checked 
	                        	@elseif (empty($deals['is_all_outlet']) && !empty($deals['outlet_groups'])) checked
	                    		@endif>
	                        <label for="filter_outlet_radio_product_and_variant">
	                            <span></span>
	                            <span class="check"></span>
	                            <span class="box"></span> Outlet Group Filter </label>
	                            <i class="fa fa-question-circle tooltips" data-original-title="Deals hanya berlaku untuk outlet yang terdapat dalam outlet group filter" data-container="body"></i>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>

        <div class="form-group" id="select-outlet" @if( ($deals['is_all_outlet'] ?? false) == 1  || empty($deals['outlets']) ) style="display: none;" @endif >
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Outlet Available
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet')??$outletselected??[])}}" data-all-outlet="{{json_encode($outlets??[])}}" data-all="{{ $deals['is_all_outlet']??0 }}" 
                	@if ( (old('filter_outlet') ?? false) == "selected_outlet" ) required 
                	@elseif (empty($deals['is_all_outlet']) && !empty($deals['outlets'])) required
            		@endif >

                	@if(!empty($outlets))
                        @foreach($outlets as $row)
                            <option value="{{$row['id_outlet']}}">{{$row['outlet_code']}} - {{$row['outlet_name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group" id="select-outlet-group" @if( ($deals['is_all_outlet'] ?? false) == 1  || empty($deals['outlet_groups']) ) style="display: none;" @endif>
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Outlet Group Filter
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet group filter" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <select class="form-control select2-multiple" id="input-select-outlet-group" data-placeholder="Select Outlet Group Filter" name="id_outlet_group[]" multiple data-value="{{ json_encode(old('id_outlet_group') ?? $selected_outlet_groups ?? []) }}" data-all-outlet="{{ json_encode($outlet_groups ?? []) }}" data-all="{{ $deals['is_all_outlet'] ?? 0 }}"
                	@if ( (old('filter_outlet') ?? false) == "outlet_group" ) required 
	            	@elseif (empty($deals['is_all_outlet']) && !empty($deals['outlet_groups'])) required
	        		@endif >

                	@if(!empty($outlet_groups))
                        @foreach($outlet_groups as $row)
                            <option value="{{$row['id_outlet_group']}}">{{$row['outlet_group_name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        {{-- Custom Outlet Text --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Custom Outlet Available Text
                <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan untuk mengganti daftar outlet untuk penukaran. Kosongkan bila ingin menampilkan daftar outlet saja." data-container="body"></i>
                </label>
            </div>
            <div class="col-md-9">
                <div class="input-icon right">
                    <textarea name="custom_outlet_text" id="field_tos" class="form-control summernote" placeholder="Custom Outlet Available Text">{{ old('custom_outlet_text')??$deals['custom_outlet_text']??null }}</textarea>
                </div>
            </div>
        </div>

        {{-- Charged --}}
        <div class="form-group">
            <label class="col-md-3 control-label"> Charged Central
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Percent fee yang akan dibebankan ke pihak pusat" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input required type="text" class="form-control" name="charged_central" placeholder="Charged Central" @if(isset($deals['charged_central']) && $deals['charged_central'] != "") value="{{$deals['charged_central']}}" @elseif(old('charged_central') != "") value="{{old('charged_central')}}" @endif>
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
                        <input required type="text" class="form-control" name="charged_outlet" placeholder="Charged Outlet" @if(isset($deals['charged_outlet']) && $deals['charged_outlet'] != "") value="{{$deals['charged_outlet']}}" @elseif(old('charged_outlet') != "") value="{{old('charged_outlet')}}" @endif>
                        <span class="input-group-addon">%</span>
                    </div>
                    <p style="color: red;display: none" id="label_outlet">Invalid value, charged central and outlet must be 100</p>
                </div>
            </div>
        </div>

        {{-- Voucher Price --}}
        @if ( $deals_type == "Deals" )
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Voucher Price
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio6" value="free" class="prices md-radiobtn" required 
                        	@if (old('prices_by')) 
                            	@if (old('prices_by') == "free") checked 
                            	@endif
                        	@elseif (isset($deals['id_deals']) && empty($deals['deals_voucher_price_point']) && empty($deals['deals_voucher_price_cash'])) checked 
                        	@endif>
                        <label for="radio6">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Free </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio7" value="point" class="prices md-radiobtn" required 
                        	@if (old('prices_by'))
                        		@if (old('prices_by') == "point") checked
                        		@endif
                        	@elseif (!empty($deals['deals_voucher_price_point'])) checked 
                        	@endif>
                        <label for="radio7">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Point </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio8" value="money" class="prices md-radiobtn" required 
                        	@if (old('prices_by'))
                            	@if (old('prices_by') == "money") checked
                            	@endif
                        	@elseif (!empty($deals['deals_voucher_price_cash'])) checked 
                        	@endif>
                        <label for="radio8">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Money </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" id="prices"
        	@if (old('prices_by'))
        		@if (old('prices_by') == "free")
        	 		style="display: none;" 
        		@endif 
        	@elseif ( empty($deals['deals_voucher_price_point']) && empty($deals['deals_voucher_price_cash']) ) 
        		style="display: none;" 
        	@endif>
            <label class="col-md-3 control-label"></label>
            <div class="col-md-9">
                <div class="col-md-3">
                    <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
                </div>
                <div class="col-md-9 payment" id="point" 
                	@if ( old('prices_by')) 
                        @if ( old('prices_by') != "point" ) 
                            style="display: none;"
                        @endif
                    @elseif ( empty($deals['deals_voucher_price_point']) )
                		style="display: none;" 
                	@endif>
                    <input type="text" class="form-control point moneyOpp freeOpp digit-mask" name="deals_voucher_price_point" value="{{ $deals['deals_voucher_price_point']??'' }}" placeholder="Input point values" autocomplete="off">
                </div>
                <div class="col-md-9 payment" id="money" 
                	@if ( old('prices_by')) 
                        @if ( old('prices_by') != "money" ) 
                            style="display: none;"
                        @endif
                    @elseif ( empty($deals['deals_voucher_price_cash']) )
                		style="display: none;" 
                	@endif>
                    <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ $deals['deals_voucher_price_cash']??'' }}" placeholder="Input money values" autocomplete="off">
                </div>
            </div>
        </div>
        @endif

        {{-- Voucher Type --}}
        @if($deals_type != 'Promotion')
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                    Voucher Type
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembuatan voucher, di list secara manual, auto generate atau unlimited" data-container="body"></i>
                    </label>
                </div>
                <div class="">
                    <div class="input-icon right">
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType" 
                                    	@if ( old('deals_voucher_type') ) 
                                    		@if ( old('deals_voucher_type') == 'Auto generated' ) checked 
                                    		@endif
                                    	@elseif ( 	
                                    			($deals['deals_voucher_type']??false) == "Auto generated" || 
                                    			($deals['deals_voucher_type']??false) == "Unlimited"
                                    		) checked 
                                    	@endif>
                                    <label for="radio1">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Auto Generated </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType" 
                                    @if ( old('deals_voucher_type') ) 
                                    	@if ( old('deals_voucher_type') == 'List Vouchers' ) checked 
                                    	@endif
                                    @elseif ( ($deals['deals_voucher_type']??false) == "List Vouchers") checked 
                                    @endif required>
                                    <label for="radio2">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> List Voucher </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" id="total-voucher-form" 
            @if( old('deals_voucher_type') == 'Auto generated' || old('deals_voucher_type') == 'Unlimited' || ($deals['deals_voucher_type']??false) == 'Unlimited' || ($deals['deals_voucher_type']??false) == 'Auto generated' )
            @elseif( old('deals_voucher_type') != 'Auto generated' || empty($deals['deals_voucher_type']) || ($deals['deals_voucher_type'] != 'Auto generated') )
            	style="display: none;" 
            @endif>
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                    Total Voucher Type
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Total voucher yang dibuat, limited atau unlimited" data-container="body"></i>
                    </label>
                </div>
                <div class="">
                    <div class="input-icon right">
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="total_voucher_type" id="radio-total-limited" value="Auto generated" class="voucherType" @if ( old('total_voucher_type') == 'Auto generated' || ($deals['deals_voucher_type']??false) == "Auto generated") checked @endif>
                                    <label for="radio-total-limited">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Limited </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="total_voucher_type" id="radio-total-unlimited" value="Unlimited" class="voucherType" @if ( old('total_voucher_type') == 'Unlimited' || ($deals['deals_voucher_type']??false) == "Unlimited") checked @endif>
                                    <label for="radio-total-unlimited">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Unlimited </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		{{-- 
            @if ($deals['deals_voucher_type'] == "Auto generated" || $deals['deals_voucher_type'] == "List Vouchers")
            <div class="form-group">
                <label class="col-md-3 control-label">Voucher Total <span class="required" aria-required="true"> * </span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="deals_total_voucher" value="{{ $deals['deals_total_voucher'] }}" placeholder="Total Voucher" required="">

                </div>
            </div>
            @endif
			--}}
			<div class="form-group" id="listVoucher" 
				@if (old('voucher_code')||old('deals_voucher_type',($deals['deals_voucher_type']??false)) == "List Vouchers") style="display: block;" 
				@else 
					style="display: none;" 
				@endif>
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                	@php 
                		$voucher_code = old('voucher_code')??"";

                		if(!empty($voucher))
                		{
                			$voucher_code = "";
                			foreach($voucher??[] as $row)
							{
								$voucher_code .= $row['voucher_code']."\n";
							}
                		}
                	@endphp
                    <textarea name="voucher_code" class="form-control listVoucher" rows="10">@php 
                    	if(old('voucher_code'))
                    	{
                    		echo old('voucher_code');
                    	}
                    	else
                    	{
							echo $voucher_code;
                    	}@endphp</textarea>
                </div>
            </div>

            <div class="form-group" id="generateVoucher" @if (!(old('voucher_code')||old('deals_voucher_type',($deals['deals_voucher_type']??false)) == "List Vouchers")&&old('deals_total_voucher',($deals['deals_total_voucher']??false))) style="display: block;" @else style="display: none;" @endif>
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <div class="col-md-3">
                        <label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control generateVoucher digit-mask" name="deals_total_voucher" value="{{ old('deals_total_voucher',($deals['deals_total_voucher']??false)) }}" min="0" placeholder="Total Voucher" autocomplete="off">
                    </div>
                </div>
            </div>

        {{-- Voucher Start Date --}}
        <br>
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Voucher Start Date
                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan, kosongkan bila voucher tidak memiliki minimal tanggal penggunaan" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control" name="deals_voucher_start" value="{{ ($start_date=old('deals_voucher_start',($deals['deals_voucher_start']??false)))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                            <button class="btn default" type="button">
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal voucher mulai dapat digunakan" data-container="body"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Voucher Expiry --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                Voucher Expiry
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required 
                        	@if ( old('duration') )  
                        		@if ( old('duration') == "dates" ) checked 
                        		@endif
                        	@elseif (!empty($deals['deals_voucher_expired'])) checked 
                        	@endif>
                        <label for="radio9">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> By Date </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required 
                        	@if ( old('duration') ) 
                        		@if ( old('duration') == "duration" ) checked 
                        		@endif
                        	@elseif ( !empty($deals['deals_voucher_duration']) ) checked 
                        	@endif>
                        <label for="radio10">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Duration </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" id="times" 
        	@if (old('duration') || (!empty($deals['deals_voucher_expired']) || !empty($deals['deals_voucher_duration'])) ) style="display: block;" 
        	@else 
        		style="display: none;" 
        	@endif>
            <label class="col-md-3 control-label"></label>
            <div class="col-md-9">
                <div class="col-md-3">
                    <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
                </div>
                <div class="col-md-9 voucherTime" id="dates"  
                	@if (old('duration') == "dates") style="display: block;" 
                	@elseif (empty($deals['deals_voucher_expired'])) style="display: none;" 
                	@endif>
                    <div class="input-group">
                        <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" @if (old('deals_voucher_expired') || !empty($deals['deals_voucher_expired'])) value="{{ date('d-M-Y H:i', strtotime(old('deals_voucher_expired')??$deals['deals_voucher_expired'])) }}" @endif autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-9 voucherTime" id="duration" 
                	@if (old('duration') == "duration") style="display: block;" 
                	@elseif (empty($deals['deals_voucher_duration'])) style="display: none;" 
                	@endif>
                    <div class="input-group">
                        <input type="text" min="1" class="form-control duration datesOpp digit-mask" name="deals_voucher_duration" value="{{ old('deals_voucher_duration')??$deals['deals_voucher_duration']??'' }}" autocomplete="off">
                        <span class="input-group-addon">
                            day after claimed
                        </span>
                    </div>

                </div>
            </div>
        </div>
        @endif

        {{-- User Limit --}}
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                User Limit
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Batasan user untuk claim voucher, input 0 untuk unlimited" data-container="body"></i>
                </label>
            </div>

            <div class="col-md-4">
                <div class="input-icon right">
                    <input type="text" class="form-control digit-mask" min="0" name="user_limit" value="{{ old('user_limit')??$deals['user_limit']??'' }}" placeholder="User limit" maxlength="30" autocomplete="off">
                </div>
            </div>
        </div>

    </div>
@else
    @include('deals::deals.info-point')
@endif
            