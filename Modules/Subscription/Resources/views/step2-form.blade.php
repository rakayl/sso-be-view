<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
@section('step2')
	<div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Discount Type
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Tipe subscription yang akan digunakan. Sebagai metode pembayaran atau sebagai diskon" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="subscription_discount_type" required>
                        <option value="" disabled 
                            @if ( old('subscription_discount_type')) 
                                @if ( old('subscription_discount_type') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['subscription_discount_type']) ) 
                                selected
                            @endif>Select Type</option>
                        <option value="payment_method" 
                            @if ( old('subscription_discount_type')) 
                                @if ( old('subscription_discount_type') == "payment_method" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['subscription_discount_type']??'') == 'payment_method') ) 
                                selected
                            @endif>Payment Method</option>
                        <option value="discount" 
                            @if ( old('subscription_discount_type')) 
                                @if ( old('subscription_discount_type') == "discount" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['subscription_discount_type']??'') == 'discount') ) 
                                selected
                            @endif>Discount</option>
                        <option value="discount_delivery" 
                            @if ( old('subscription_discount_type')) 
                                @if ( old('subscription_discount_type') == "discount_delivery" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['subscription_discount_type']??'') == 'discount_delivery') ) 
                                selected
                            @endif>Discount Delivery</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
	@if ($subscription_type == 'subscription')
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Subscription Price
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran subscription (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="prices_by" required>
                        <option value="" disabled 
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by')== "" ) 
                                        selected 
                                    @endif
                                @elseif ( empty($subscription['is_free']) && empty($subscription['subscription_price_point']) && empty($subscription['subscription_price_cash']) ) ) 
                                    selected 
                                @endif>Select Price</option>
                        <option value="free" 
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by')== "free" ) 
                                        selected 
                                    @endif
                                @elseif ( !empty($subscription['is_free']) ) 
                                    selected 
                                @endif>Free</option>
                        @if(MyHelper::hasAccess([19], $configs))
                        <option value="point" 
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by')== "point" ) 
                                        selected 
                                    @endif
                                @elseif ( !empty($subscription['subscription_price_point']) ) 
                                    selected 
                                @endif>Point</option>
                        @endif
                        <option value="money" 
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by')== "money" ) 
                                        selected 
                                    @endif
                                @elseif ( !empty($subscription['subscription_price_cash']) ) 
                                    selected 
                                @endif>Money</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="" id="prices" 
                    @if ( old('prices_by')) 
                        @if ( old('prices_by') == "") 
                            style="display: none;" 
                        @endif
                    @elseif ( !empty($subscription['is_free']) ) 
                        style="display: none;" 
                    @endif>
                        <div class="">
                            <div class=" payment" id="point"
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by') != "point") 
                                        style="display: none;" 
                                    @endif
                                @elseif ( empty($subscription['subscription_price_point']) ) 
                                    style="display: none;" 
                                @endif>
                                <div class="input-group">
                                    <input type="text" class="form-control point moneyOpp freeOpp digit_mask" name="subscription_price_point" value="{{ old('subscription_price_point')??$subscription['subscription_price_point']??'' }}" placeholder="Input point nominal" autocomplete="off">
                                    <div class="input-group-addon">Point</div>
                                </div>
                            </div>
                            <div class="payment" id="money" 
                                @if ( old('prices_by')) 
                                    @if ( old('prices_by') != "money") 
                                        style="display: none;" 
                                    @endif
                                @elseif ( empty($subscription['subscription_price_cash']) ) 
                                    style="display: none;" 
                                @endif>
                                <div class="input-group">
                                    <div class="input-group-addon">IDR</div>
                                    <input type="text" class="form-control money pointOpp freeOpp price" name="subscription_price_cash" value="{{ old('subscription_price_cash')??$subscription['subscription_price_cash']??'' }}" placeholder="Input money nominal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Brand
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk subscription ini" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <div class="input-icon right">
                <select class="form-control select2-multiple disable-input" data-placeholder="Select Brand" name="id_brand[]" multiple required>
                    <option></option>
                @php
					$selected_brand = [];
					if (old('id_brand')) {
						$selected_brand = old('id_brand');
					}
					elseif (!empty($subscription['subscription_brands'])) {
						$selected_brand = array_column($subscription['subscription_brands'], 'id_brand');
					}
				@endphp
                @if (!empty($brands))
                	@if ($subscription['id_brand']) 
	                    @foreach($brands as $brand)
	                        <option value="{{ $brand['id_brand'] }}" 
	                    	@if ($subscription['id_brand']) 
	                    		@if($brand['id_brand'] == $subscription['id_brand']) selected @endif 
	                    	@endif>{{ $brand['name_brand'] }}</option>
	                    @endforeach
	                @else
	                    @foreach($brands as $brand)
	                        <option value="{{ $brand['id_brand'] }}" 
	                        	@if ($selected_brand) 
	                        		@if(in_array($brand['id_brand'], $selected_brand)) selected 
	                        		@endif 
	                        	@endif
	                        >{{ $brand['name_brand'] }}</option>
	                    @endforeach
                	@endif
                @endif
                </select>
            </div>
        </div>
    </div>

    @php
        if (!empty($subscription['outlets'])) {
            $outletselected = array_pluck($subscription['outlets'],'id_outlet');
        }
        else {
            $outletselected = old('id_outlet[]',[]);
        }

        $selected_outlet_groups = [];
        $selected_outlet_groups = old('id_outlet_group[]', array_pluck(($subscription['outlet_groups'] ?? []), 'id_outlet_group'));
    @endphp

    <div class="form-group" id="brand-rule">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Brand Rule
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="<div style='text-align: left'>Pilih rule yang akan digunakan untuk memilih outlet
            </br>
			</br> All selected brands : Promo berlaku untuk semua product atau product tertentu tanpa jumlah minimum
			</br>
			</br> One of the selected brands : Promo hanya berlaku untuk suatu product setelah melakukan pembelian dalam jumlah yang telah ditentukan</div>" data-container="body" data-html="true"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-5">
                    <select class="form-control" name="brand_rule" required>
                        <option value="" disabled 
                            @if ( old('brand_rule')) 
                                @if ( old('brand_rule') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['brand_rule']) ) 
                                selected
                            @endif>Select Product Rule</option>
                        <option value="and" 
                            @if ( old('brand_rule')) 
                                @if ( old('brand_rule') == "and" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['brand_rule']) && $subscription['brand_rule'] === 'and')
                                selected
                            @endif>All selected brands<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki semua brand yang dipilih" data-container="body"></i>
                        </option>
                        <option value="or" 
                            @if ( old('brand_rule')) 
                                @if ( old('brand_rule') == "or" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['brand_rule']) && $subscription['brand_rule'] === 'or')
                                selected
                            @endif>One of the selected brands<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku untuk outlet yang memiliki setidaknya salah satu brand yang dipilih" data-container="body"></i>
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Filter Outlet
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang dapat menggunakan subscription" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-4">
                    <select class="form-control" name="filter_outlet" required>
                        <option value="" disabled 
                            @if ( old('filter_outlet')) 
                                @if ( old('filter_outlet') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['is_all_outlet']) && !empty($subscription['outlets']) && !empty($subscription['outlet_groups']) ) 
                                selected
                            @endif>Select Type</option>
                        <option value="all_outlet" 
                            @if ( old('filter_outlet')) 
                                @if ( old('filter_outlet') == "all_outlet" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['is_all_outlet']) ) 
                                selected
                            @endif> All Outlet </option>
                        <option value="selected_outlet" 
                            @if ( old('filter_outlet')) 
                                @if ( old('filter_outlet') == "selected_outlet" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['is_all_outlet']) && !empty($subscription['outlets']))
                                selected
                            @endif> Selected Outlet </option>
                        <option value="outlet_group" 
                            @if ( old('filter_outlet')) 
                                @if ( old('filter_outlet') == "outlet_group" )
                                    selected
                                @endif
                            @elseif ( empty($subscription['is_all_outlet']) && !empty($subscription['outlet_groups']))
                                selected
                            @endif> Outlet Group Filter </option>
                    </select>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" id="select-outlet" @if( ($subscription['is_all_outlet'] ?? false) == 1  || empty($subscription['outlets']) ) style="display: none;" @endif >
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Outlet Available
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan subscription tersebut" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple data-value="{{json_encode($outletselected)}}" data-all="{{ $subscription['is_all_outlet']??0 }}" data-brand-rule="{{ $subscription['brand_rule']??'and' }}" @if (empty($subscription['is_all_outlet']) && !empty($subscription['outlets'])) required @endif>
            </select>
        </div>
    </div>

    <div class="form-group" id="select-outlet-group" @if( ($subscription['is_all_outlet'] ?? false) == 1  || empty($subscription['outlet_groups']) ) style="display: none;" @endif>
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Outlet Group Filter
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet group filter" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <select class="form-control select2-multiple" id="input-select-outlet-group" data-placeholder="Select Outlet Group Filter" name="id_outlet_group[]" multiple data-value="{{json_encode($selected_outlet_groups)}}" data-all="{{ $subscription['is_all_outlet']??0 }}" data-brand-rule="{{ $subscription['brand_rule']??'and' }}" @if (empty($subscription['is_all_outlet']) && !empty($subscription['outlet_groups'])) required @endif>
            </select>
        </div>
    </div>

    @php
    	$productselected = [];
        if (!empty($subscription['subscription_products'])) {
        	foreach ($subscription['subscription_products'] as $key => $value) {
    			$productselected[] = $value['id_brand'].'-'.$value['id_product'].'-'.$value['id_product_variant_group'];
        	}
        }
        else {
            $productselected = old('id_product[]',[]);
        }
    @endphp

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Product
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih product yang akan menjadi syarat untuk menggunakan subscription" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <select class="form-control select2-multiple" data-placeholder="Select Product" name="id_product[]" multiple data-value="{{json_encode($productselected)}}" data-all="{{ $subscription['is_all_product']??0 }}" required>
            </select>
        </div>
    </div>

    <div class="form-group" id="product-rule">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Product Rule
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang berlaku ketika transaksi menggunakan syarat product" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-5">
                    <select class="form-control" name="product_rule" required>
                        <option value="" disabled 
                            @if ( old('product_rule')) 
                                @if ( old('product_rule') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['product_rule']) ) 
                                selected
                            @endif>Select Product Rule</option>
                        <option value="and" 
                            @if ( old('product_rule')) 
                                @if ( old('product_rule') == "and" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['product_rule']) && $subscription['product_rule'] === 'and')
                                selected
                            @endif>All items must be present</option>
                        <option value="or" 
                            @if ( old('product_rule')) 
                                @if ( old('product_rule') == "or" ) 
                                    selected
                                @endif
                            @elseif(isset($subscription['product_rule']) && $subscription['product_rule'] === 'or')
                                selected
                            @endif>One of the items must exist</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Shipment Method
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode shipment yang akan menjadi syarat berlakunya promo" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
			@php
				$shipment_list = [
					[
						'code' => 'Pickup Order',
						'delivery_name' => 'Pickup Order'
					]
				];
				$shipment_list = array_merge($shipment_list, $delivery_list);
				$selected_shipment = [];
				if (old('shipment_method')) {
					$selected_shipment = old('shipment_method');
				}
				elseif (!empty($subscription['subscription_shipment_method'])) {
					$selected_shipment = array_column($subscription['subscription_shipment_method'], 'shipment_method');
				}
			@endphp
            <select name="shipment_method[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" data-placeholder="Select Shipment">

            	<option value="all" 
            		@if (old('shipment_method'))
            			@if (in_array('all', old('shipment_method')))
	            			selected 
            			@endif
	            	@elseif($subscription['is_all_shipment'] == 1)
	            		selected 
	            	@endif>All Shipment</option>

                @if (!empty($shipment_list))
                    @foreach($shipment_list as $shipment)
                        <option value="{{ $shipment['code'] }}" @if( in_array($shipment['code'], $selected_shipment) ) selected @endif >
                        	{{ $shipment['delivery_name'] }}
                        </option>
                    @endforeach
                @endif
			</select>
        </div>
    </div>

    @php
        if (!empty($subscription['subscription_payment_method'])) {
            $payment_selected = array_pluck($subscription['subscription_payment_method'],'payment_method');
        }
        else {
            $payment_selected = old('payment_method',[]);
        }
    @endphp

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Payment Method
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih metode pembayaran yang akan menjadi syarat berlakunya promo" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <select name="payment_method[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" data-placeholder="Select Payment">
				@php
					$selected_payment = [];
					if (old('payment_method')) {
						$selected_payment = old('payment_method');
					}
					elseif (!empty($subscription['subscription_payment_method'])) {
						$selected_payment = array_column($subscription['subscription_payment_method'], 'payment_method');
					}
				@endphp

            	<option value="all" 
            		@if (old('payment_method'))
            			@if (in_array('all', old('payment_method')))
	            			selected 
            			@endif
	            	@elseif($subscription['is_all_payment'] == 1)
	            		selected 
	            	@endif>All Payment</option>

                @if (!empty($payment_list))
                    @foreach($payment_list as $payment)
                        <option value="{{ $payment['payment_method'] }}" 
                        	@if ( $selected_payment??false ) 
                        		@if( in_array($payment['payment_method'], $selected_payment) ) selected 
                        		@endif 
                        	@endif
                        >{{ $payment['text'] }}</option>
                    @endforeach
                @endif
			</select>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Subscription Total
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal pengguna yang dapat membeli subscription" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="subscription_total_type" required>
                        <option value="" disabled 
                            @if ( old('subscription_total_type')) 
                                @if ( old('subscription_total_type')== "" ) 
                                    selected 
                                @endif
                            @elseif ( empty($subscription['subscription_total']) ) 
                                selected 
                            @endif>Select Total</option>
                        <option value="limited" 
                            @if ( old('subscription_total_type')) 
                                @if ( old('subscription_total_type')== "limited" ) 
                                    selected 
                                @endif
                            @elseif ( !empty($subscription['subscription_total']) ) 
                                selected 
                            @endif>Limited</option>
                        <option value="unlimited" 
                            @if ( old('subscription_total_type')) 
                                @if ( old('subscription_total_type')== "unlimited" ) 
                                    selected 
                                @endif
                            @elseif ( isset($subscription['subscription_total']) && $subscription['subscription_total'] == 0 ) 
                                selected 
                            @endif>Unlimited</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="" id="subscription-total-form"                                         
                        @if ( old('subscription_total_type')) 
                            @if ( old('subscription_total_type') != "limited") 
                                style="display: none;" 
                            @endif
                        @elseif ( empty($subscription['subscription_total']) )
                            style="display: none;" 
                        @endif>
                        <div class="" id="subscription-total-value">
                            <div class="input-group">
                                <input type="text" class="form-control digit_mask" name="subscription_total" value="{{ old('subscription_total')??$subscription['subscription_total']??'' }}" placeholder="Input subscription total" autocomplete="off">
                                <div class="input-group-addon">Subscription</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($subscription_type == 'subscription')
        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                User Limit
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Batasan berapa kali pengguna dapat membeli lagi subscription yang sama, input 0 untuk unlimited" data-container="body"></i>
                </label>
            </div>

            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <input type="text" class="digit_mask form-control" name="user_limit" value="{{ old('user_limit')??$subscription['user_limit']??'' }}" placeholder="User limit" min="0" autocomplete="off">
                        <div class="input-group-addon">User</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                    <input type="text" class="form_datetime form-control" name="subscription_voucher_start" value="{{ ($start_date=old('subscription_voucher_start',$subscription['subscription_voucher_start']??0))?date('d-M-Y H:i',strtotime($start_date)):'' }}" autocomplete="off">
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

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Voucher Expiry
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi subscription atau tanggal expirednya" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="duration" required>
                        <option value="" disabled 
                            @if ( old('duration')) 
                                @if ( old('duration')== "" ) 
                                    selected 
                                @endif
                            @elseif ( empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration']) ) 
                                selected 
                            @endif>Select Expiry</option>
                        <option value="dates" 
                            @if ( old('duration')) 
                                @if ( old('duration')== "dates" ) 
                                    selected 
                                @endif
                            @elseif ( !empty($subscription['subscription_voucher_expired']) ) 
                                selected 
                            @endif>By Date</option>
                        <option value="duration" 
                            @if ( old('duration')) 
                                @if ( old('duration')== "duration" ) 
                                    selected 
                                @endif
                            @elseif ( !empty($subscription['subscription_voucher_duration']) ) 
                                selected 
                            @endif>Duration</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="" id="times" 
                        @if ( old('duration')) 
                            @if ( old('duration') == "" ) 
                                style="display: none;"
                            @endif
                        @elseif ( empty($subscription['subscription_voucher_expired']) && empty($subscription['subscription_voucher_duration']) ) 
                            style="display: none;"
                        @endif>
                        <div class="">
                            <div class="voucherTime" id="dates"
                                @if ( old('duration')) 
                                    @if ( old('duration') != "dates" ) 
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($subscription['subscription_voucher_expired']) ) 
                                    style="display: none;"
                                @endif>
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control dates durationOpp" name="subscription_voucher_expired" value="{{ old('subscription_voucher_expired') ? old('subscription_voucher_expired') : ((!empty($subscription['subscription_voucher_expired'])??false) ? date('d-M-Y H:i', strtotime($subscription['subscription_voucher_expired'])) : '') }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="voucherTime" id="duration" 
                                @if ( old('duration')) 
                                    @if ( old('duration') != "duration" ) 
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($subscription['subscription_voucher_duration']) ) 
                                    style="display: none;"
                                @endif>
                                <div class="input-group">
                                    <input type="text" class="form-control duration datesOpp digit_mask_min_1" name="subscription_voucher_duration" value="{{ old('subscription_voucher_duration')??$subscription['subscription_voucher_duration']??'' }}" autocomplete="off">
                                    <span class="input-group-addon">
                                        day after claimed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Voucher Total
            <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal voucher yang dapat digunakan setelah membeli subscription. Minimal 1 voucher" data-container="body"></i>
            </label>
        </div>

        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form-control digit_mask_min_1" name="subscription_voucher_total" value="{{ old('subscription_voucher_total')??$subscription['subscription_voucher_total']??'' }}" placeholder="Subscription Voucher Total" autocomplete="off" required>
                    <div class="input-group-addon">Voucher</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Voucher Discount
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Tipe potongan harga dari voucher subscription (persen atau nominal)" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="voucher_type" required>
                        <option value="" disabled 
                            @if ( old('voucher_type')) 
                                @if ( old('voucher_type') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) ) 
                                selected
                            @endif>Select Type</option>
                        <option value="percent" 
                            @if ( old('voucher_type')) 
                                @if ( old('voucher_type') == "percent" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['subscription_voucher_percent']) ) 
                                selected
                            @endif>Percent</option>
                        <option value="cash" 
                            @if ( old('voucher_type')) 
                                @if ( old('voucher_type') == "cash" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['subscription_voucher_nominal']) ) 
                                selected
                            @endif>Nominal</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="" id="voucher-value" 
                        @if ( old('voucher_type')) 
                            @if ( old('voucher_type') == "" ) 
                                style="display: none;"
                            @endif
                        @elseif ( empty($subscription['subscription_voucher_percent']) && empty($subscription['subscription_voucher_nominal']) ) 
                            style="display: none;"
                        @endif>
                        <div class="">
                            <div class="col-md-4" id="voucher-percent" 
                                @if ( old('voucher_type')) 
                                    @if ( old('voucher_type') != "percent" ) 
                                        style="display: none; padding-left: 0px;"
                                    @endif
                                @elseif ( empty($subscription['subscription_voucher_percent']) ) 
                                    style="display: none; padding-left: 0px;"
                                @endif style="padding-left: 0px;" >
                                <div class="input-group">
                                    <input type="text" class="form-control percent_mask " name="subscription_voucher_percent" value="{{ old('subscription_voucher_percent')??$subscription['subscription_voucher_percent']??'' }}" placeholder="Input Percent value" autocomplete="off">
                                    <div class="input-group-addon">%</div>
                                </div>
                            </div>
                            <div class="" id="voucher-cash" 
                                @if ( old('voucher_type')) 
                                    @if ( old('voucher_type') != "cash" ) 
                                        style="display: none;"
                                    @endif
                                @elseif ( empty($subscription['subscription_voucher_nominal']) ) 
                                    style="display: none;"
                                @endif>
                                <div class="input-group">
                                    <div class="input-group-addon">IDR</div>
                                    <input type="text" class="form-control digit_mask" name="subscription_voucher_nominal" value="{{ old('subscription_voucher_nominal')??$subscription['subscription_voucher_nominal']??'' }}" placeholder="Input Cash nominal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group" id="discount-max" 
        @if ( old('voucher_type')) 
            @if ( old('voucher_type') != "percent" ) 
                style="display: none;"
            @endif
        @elseif ( empty($subscription['subscription_voucher_percent']) ) 
            style="display: none;"
        @endif>
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Discount Max
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah potongan maksimal yang bisa didapatkan. Jika jumlah potongan melebihi jumlah potongan maksimal, maka jumlah potongan yang didapatkan akan mengacu pada jumlah potongan maksimal." data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="percent_max" required>
                        <option value="true" 
                            @if ( old('percent_max')) 
                                @if ( old('percent_max') == "true" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['subscription_voucher_percent_max']) ) 
                                selected
                            @endif>Yes</option>
                        <option value="false" 
                            @if ( old('percent_max')) 
                                @if ( old('percent_max') == "false" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['subscription_voucher_percent_max']) ) 
                                selected
                            @endif>No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="" id="discount-max-form" 
                        @if ( old('percent_max')) 
                            @if ( old('percent_max') != "true" ) 
                                style="display: none;"
                            @endif
                        @elseif ( empty($subscription['subscription_voucher_percent_max']) ) 
                            style="display: none;"
                        @endif>
                        <div class="">
                            <div class="" id="discount-max-value">
                                <div class="input-group">
                                    <div class="input-group-addon">IDR</div>
                                    <input type="text" class="form-control digit_mask" name="subscription_voucher_percent_max" value="{{ old('subscription_voucher_percent_max')??$subscription['subscription_voucher_percent_max']??'' }}" placeholder="Input discount max nominal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Minimum Basket Size
            <i class="fa fa-question-circle tooltips" data-original-title="Syarat minimum basket size atau total harga product (subtotal) sebelum dikenakan promo dan biaya pengiriman. Subtotal diambil dari subtotal dari brand yang dipilih. Kosongkan jika tidak ada syarat jumlah minimum basket size" data-container="body"></i>
            </label>
        </div>

        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <div class="input-group-addon">IDR</div>
                    <input type="text" class="form-control digit_mask" name="subscription_minimal_transaction" value="{{ old('subscription_minimal_transaction')??$subscription['subscription_minimal_transaction']??'' }}" placeholder="minimal transaction" autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Daily Usage Limit
            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penggunaan voucher maksimal dalam satu hari, kosongkan jika tidak ada batas penggunaan" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form-control digit_mask" name="daily_usage_limit" value="{{ old('daily_usage_limit')??$subscription['daily_usage_limit']??'' }}" placeholder="Daily Usage Limit" autocomplete="off">
                    <div class="input-group-addon">Usage</div>
                </div>
            </div>
        </div>
    </div>

    @if ($subscription_type == 'subscription')
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            New Purchase Limit
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Batas kapan pengguna dapat membeli lagi subscription yang sama" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="purchase_limit" required>
                        <option value="" disabled 
                            @if ( old('purchase_limit')) 
                                @if ( old('purchase_limit') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['new_purchase_after']) ) 
                                selected
                            @endif>Select Type</option>
                        <option value="limit" 
                            @if ( old('purchase_limit')) 
                                @if ( old('purchase_limit') == "limit" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] != 'No Limit') ) 
                                selected
                            @endif>Limit</option>
                        <option value="no_limit" 
                            @if ( old('purchase_limit')) 
                                @if ( old('purchase_limit') == "no_limit" ) 
                                    selected
                                @endif
                            @elseif ( !empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] == 'No Limit') ) 
                                selected
                            @endif>No Limit</option>
                    </select>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" id="new-purchase-after" 
        @if ( old('purchase_limit')) 
            @if ( old('purchase_limit') != "limit" ) 
                style="display: none;"
            @endif
        @elseif ( empty($subscription['new_purchase_after']) || (!empty($subscription['new_purchase_after']) && $subscription['new_purchase_after'] == 'No Limit') )
            style="display: none;"
        @endif>
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            New Purchase After
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pembelian baru dapat dilakukan lagi setelah subscription yang dibeli expired atau subscription voucher yang dibeli sudah habis" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9" style="padding-left: 0px">
            <div class="input-icon right">
                <div class="col-md-3">
                    <select class="form-control" name="new_purchase_after" @if( ($subscription['new_purchase_after']??'No Limit') != 'No Limit') required @endif>
                        <option value="" disabled 
                            @if ( old('new_purchase_after')) 
                                @if ( old('new_purchase_after') == "" ) 
                                    selected
                                @endif
                            @elseif ( empty($subscription['new_purchase_after']) ) 
                                selected
                            @endif>Select Type</option>
                        <option value="Empty" 
                            @if ( old('new_purchase_after')) 
                                @if ( old('new_purchase_after') == "Empty" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['new_purchase_after']??'') == 'Empty') ) 
                                selected
                            @endif>Empty</option>
                        <option value="Expired" 
                            @if ( old('new_purchase_after')) 
                                @if ( old('new_purchase_after') == "Expired" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['new_purchase_after']??'') == 'Expired') ) 
                                selected
                            @endif>Expired</option>
                        <option value="Empty Expired" 
                            @if ( old('new_purchase_after')) 
                                @if ( old('new_purchase_after') == "Empty Expired" ) 
                                    selected
                                @endif
                            @elseif ( ($subscription['new_purchase_after']??'') == 'Empty Expired') ) 
                                selected
                            @endif>Empty/Expired</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection