@section('discount-bill')
@if($result['promo_use_in'] != 'Consultation')
<div class="form-group">
	<div class="row">
		<div class="col-md-3">
			<label class="control-label">Filter Product</label>
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon </br></br>All Product : Promo code berlaku untuk semua product </br></br>Selected Product : Promo code hanya berlaku untuk product tertentu" data-container="body" data-html="true"></i>
			<select class="form-control" name="filter_product_bill">
				<option value="All Product"  @if(isset($result['promo_campaign_discount_bill_rules']['is_all_product']) && $result['promo_campaign_discount_bill_rules']['is_all_product'] == "1") selected @endif required> All Product </option>
				<option value="Selected" @if(isset($result['promo_campaign_discount_bill_rules']['is_all_product']) && $result['promo_campaign_discount_bill_rules']['is_all_product'] == "0") selected @endif> Selected Product </option>
            </select>
		</div>
	</div>
</div>
@endif
<div id="select-product-bill">
	<div class="form-group row" style="width: 100%!important">
		<div class="">
			<div class="col-md-6">
				<label for="multiple-product-bill" class="control-label">Select Product</label>
				<select id="multiple-product-bill" name="multiple_product[]" class="form-control select2 select2-hidden-accessible col-md-6" multiple="" tabindex="-1" aria-hidden="true" style="width: 100%!important" @if(isset($result['promo_campaign_product_bill_rules']['is_all_product']) && $result['promo_campaign_product_bill_rules']['is_all_product'] == "0") required @endif>
				</select>
			</div>
		</div>
	</div>

	<div>
		<label class="control-label">Product Rule</label>
		<i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang berlaku ketika transaksi menggunakan syarat product" data-container="body" data-html="true"></i>
		<div class="mt-radio-list">
			<label class="mt-radio mt-radio-outline"> All items must be present
				<input type="radio" value="and" name="product_rule" @if(isset($result['product_rule']) && $result['product_rule'] === 'and' && !empty($result['promo_campaign_discount_bill_rules'])) checked @endif/>
				<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>semua</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
				<span></span>
			</label>
			<label class="mt-radio mt-radio-outline"> One of the items must exist
				<input type="radio" value="or" name="product_rule" @if(isset($result['product_rule']) && $result['product_rule'] === 'or' && !empty($result['promo_campaign_discount_bill_rules'])) checked @endif/>
				<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>salah satu</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
				<span></span>
			</label>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="control-label">Min basket size</label>
	<i class="fa fa-question-circle tooltips" data-original-title="syarat minimum basket size atau total harga product (subtotal) sebelum dikenakan promo dan biaya pengiriman. Subtotal diambil dari subtotal dari brand yang dipilih. Kosongkan jika tidak ada syarat jumlah minimum basket size" data-container="body" data-html="true"></i>
	<div class="row">
		<div class="col-md-3">
			<div class="input-group" >
				<div class="input-group-addon">IDR</div>
				<input type="text" class="form-control text-center digit_mask" name="min_basket_size" placeholder="" value="{{ old('min_basket_size')??$result['min_basket_size']??null }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
			</div>
		</div>
	</div>
</div>
<div class="form-group" style="height: 90px;">
	<label class="control-label">Discount Type</label>
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon. </br></br>Nominal : Diskon berupa potongan nominal, jika total diskon melebihi harga subtotal akan dikembalikan ke harga subtotal </br></br>Percent : Diskon berupa potongan persen dari subtotal </br></br> Subtotal yang dikenakan diskon diambil dari subtotal dari brand yang dipilih" data-container="body" data-html="true"></i>
	<div class="mt-radio-list">
		<label class="mt-radio mt-radio-outline"> Nominal
			<input type="radio" value="Nominal" name="discount_type" @if( (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Nominal") checked @endif required/>
			<span></span>
		</label>
		<label class="mt-radio mt-radio-outline"> Percent
			<input type="radio" value="Percent" name="discount_type" @if( (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Percent") checked @endif required/>
			<span></span>
		</label>
	</div>
</div>
<div class="form-group" id="discount-bill-div" @if( !(old('discount_value')??$result['promo_campaign_discount_bill_rules']??false) ) style="display: none;" @endif >
	<div class="row">
		<div class="col-md-3">
			<label class="control-label" id="discount-bill-value">Discount Value</label>
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon yang diberikan. Besar diskon akan dihitung dari subtotal produk yang berasal dari brand yang dipilih" data-container="body"></i>
			<div class="input-group @if( (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Percent") col-md-5 @else col-md-12 @endif" id="discount-bill-group">
				<div class="input-group-addon" id="bill-addon-rp" @if( (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Percent") style="display: none;" @endif>IDR</div>
				<input required type="text" class="form-control text-center" name="discount_value" placeholder="" value="{{ old('discount_value')??$result['promo_campaign_discount_bill_rules']['discount_value']??null }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
				<div class="input-group-addon" id="discount-bill-addon" @if( (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Nominal") style="display: none;" @endif>%</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group" id="discount-bill-percent-max-div" style="{{ (old('discount_type')??$result['promo_campaign_discount_bill_rules']['discount_type']??false) == "Percent" ? '' : "display: none" }}">
	<div class="row">
		<div class="col-md-3">
			<label class="control-label" id="discount-bill-value">Max Percent Discount</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Jumlah diskon maksimal yang bisa didapatkan ketika menggunakan promo. Kosongkan jika maksimal persen mengikuti harga subtotal " data-container="body"></i>
			<div class="input-group col-md-12">

				<div class="input-group-addon">IDR</div>

				<input type="text" class="form-control text-center digit_mask" name="max_percent_discount" placeholder="" value="{{ old('max_percent_discount')??$result['promo_campaign_discount_bill_rules']['max_percent_discount']??null }}" min="0" oninput="validity.valid||(value='');" autocomplete="off">
			</div>
		</div>
	</div>
</div>
@endSection

@section('discount-bill-script')
@php
	$is_all_product_bill = $result['promo_campaign_discount_bill_rules']['is_all_product']??1;
@endphp
<script type="text/javascript">
	$(document).ready(function() {
		let is_all_product_bill = {{ $is_all_product_bill }};
		if (is_all_product_bill != 0) {
			$('#select-product-bill').hide();
		}

		$('input[name=discount_type]').change(function() {
			discount_value = $('input[name=discount_type]:checked').val();
			$('#discount-bill-div').show();
			if (discount_value == 'Nominal') {
				$('input[name=discount_value]').removeAttr('max').val('').attr('placeholder', '100.000').inputmask({removeMaskOnSubmit: "true", placeholder: "", alias: "currency", digits: 0, rightAlign: false});
				$('#discount-bill-value').text('Discount Nominal');
				$('#discount-bill-addon, #discount-bill-percent-max-div').hide();
				$('#bill-addon-rp').show();
				$('#discount-bill-group').addClass('col-md-12');
				$('#discount-bill-group').removeClass('col-md-5');
				$('input[name=max_percent_discount]').val('');
			} else {
				$('input[name=discount_value]').attr('max', 100).val('').attr('placeholder', '50').inputmask({
					removeMaskOnSubmit: true,
					placeholder: "",
					alias: 'integer',
					min: '0',
					max: '100',
					allowMinus : false,
					allowPlus : false
				});
				$('#discount-bill-value').text('Discount Percent Value');
				$('#bill-addon-rp').hide();
				$('#discount-bill-addon, #discount-bill-percent-max-div').show();
				$('#discount-bill-group').addClass('col-md-5');
				$('#discount-bill-group').removeClass('col-md-12');
			}
			$('input[name=discount_value]').removeAttr("style");
		});

		$('select[name=filter_product_bill]').change(function() {
			product = $('select[name=filter_product_bill] option:selected').val()
			$('#multiple-product-bill').prop('required', false)
			$('#multiple-product-bill').prop('disabled', true)
			if (product == 'Selected') {
				$('#select-product-bill').show()
				if (productLoad == 0) {
					$.ajax({
						type: "GET",
						url: "getData",
						data : {
							"get" : 'Product',
							"brand" : brand,
							"product_type" : product_type
						},
						dataType: "json",
						success: function(data){
							productLoad = 1;
							listProduct=data;
							$.each(data, function( key, value ) {
								$('#multipleProduct,#multipleProduct2,#multipleProduct3','multiple-product-bill').append("<option value='"+value.id_brand+'-'+value.id_product+'-'+value.id_product_variant_group+"'>"+value.product+"</option>");
							});
							$('#multiple-product-bill').prop('required', true)
							$('#multiple-product-bill').prop('disabled', false)
						}
					});
				} else {
					$('#multiple-product-bill').prop('required', true)
					$('#multiple-product-bill').prop('disabled', false)
				}
			} else {
				$('#select-product-bill').hide()
			}
		});
	});
</script>
@endSection