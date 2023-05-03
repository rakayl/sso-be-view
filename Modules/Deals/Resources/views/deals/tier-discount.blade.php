@include('promocampaign::template.promo-product', ['promo_source' => ($result['deals_type'] ?? $deals_type), 'promo_type' => 'tier-discount'])
@section('bulkForm')

@yield('promo-product')

{{-- <div class="">
	<div id="selectProduct2" class="form-group" style="width: 100%!important">
		<div class="row">
			<div class="col-md-6">
				<label for="multipleProduct2" class="control-label">Select Product <span class="required" aria-required="true"> * </span>
				<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk yang akan diberikan diskon" data-container="body"></i></label>
				<select id="multipleProduct2" name="product[]" class="form-control select2 select2-hidden-accessible"  multiple tabindex="-1" aria-hidden="true" data-value="{{
					($result['deals_promotion_tier_discount_product']??$result['deals_tier_discount_product']??null)
					?
					json_encode(
					[
						(
							$result['deals_tier_discount_product']['id_product'] ??
							$result['deals_promotion_tier_discount_product']['id_product'] ??
							$result['deals_tier_discount_product'][0]['id_product'] ??
							$result['deals_promotion_tier_discount_product'][0]['id_product'] ?? ''
						)
					])
					:''
					}}" style="width: 100%!important">
				</select>
			</div>
		</div>
	</div>
</div>

<div>
	<label class="control-label">Product Rule</label>
	<i class="fa fa-question-circle tooltips" data-original-title="Pilih rule yang berlaku ketika transaksi menggunakan syarat product" data-container="body" data-html="true"></i>
	<div class="mt-radio-list">
		<label class="mt-radio mt-radio-outline"> All items must be present
			<input type="radio" value="and" name="product_rule" 
				@if(isset($result['product_rule']) 
					&& $result['product_rule'] === 'and' 
					&& (!empty($result['deals_tier_discount_rules']) || !empty($result['deals_promotion_tier_discount_rules']))
					) checked 
				@endif/>
			<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>semua</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
			<span></span>
		</label>
		<label class="mt-radio mt-radio-outline"> One of the items must exist
			<input type="radio" value="or" name="product_rule" 
				@if(isset($result['product_rule']) 
					&& $result['product_rule'] === 'or' 
					&& (!empty($result['deals_tier_discount_rules']) || !empty($result['deals_promotion_tier_discount_rules']))
					) checked 
				@endif/>
			<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>salah satu</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
			<span></span>
		</label>
	</div>
</div> --}}

<div id="selectProduct2" class="form-group" style="height: 90px;">
	<div class="row">
		<div class=" col-md-6">
			<label for="multipleProduct2" class="control-label">Select Discount Type <span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih jenis diskon untuk produk </br></br>Nominal : Diskon berupa potongan nominal,jika total diskon melebihi harga produk akan dikembalikan ke harga produk </br></br>Percent : Diskon berupa potongan persen" data-container="body" data-html="true"></i></label>
			<div class="mt-radio-list">
				<label class="mt-radio mt-radio-outline">
					 Nominal
					<input type="radio" value="Nominal" name="discount_type" 
						@if(
								isset($result['promo_type']) && $result['promo_type'] == 'Tier discount' && 
								(
									(!empty($result['deals_tier_discount_rules'][0]['discount_type']) && $result['deals_tier_discount_rules'][0]['discount_type'] == 'Nominal') ||
									(!empty($result['deals_promotion_tier_discount_rules'][0]['discount_type']) && $result['deals_promotion_tier_discount_rules'][0]['discount_type'] == 'Nominal') 
								)
							) checked 
						@endif required/>
					<span></span>
				</label>
				<label class="mt-radio mt-radio-outline">
					 Percent
					<input type="radio" value="Percent" name="discount_type" 
						@if(
								isset($result['promo_type']) && $result['promo_type'] == 'Tier discount' && 
								(	
									(!empty($result['deals_tier_discount_rules'][0]['discount_type']) && $result['deals_tier_discount_rules'][0]['discount_type'] == 'Percent') ||
									(!empty($result['deals_promotion_tier_discount_rules'][0]['discount_type']) && $result['deals_promotion_tier_discount_rules'][0]['discount_type'] == 'Percent')
								)
							) checked 
						@endif required/>
					<span></span>
				</label>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label class="control-label">Min basket size</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Syarat minimum basket size atau total harga product (subtotal) sebelum dikenakan promo dan biaya pengiriman. Subtotal diambil dari subtotal dari brand yang dipilih. Kosongkan jika tidak ada syarat jumlah minimum basket size" data-container="body" data-html="true"></i>
			<div class="row">
				<div class="col-md-3">
					<div class="input-group" >
						<div class="input-group-addon">IDR</div>
						<input type="text" class="form-control text-center digit_mask" name="min_basket_size" placeholder="" 
							@if(old('min_basket_size') != "") value="{{old('min_basket_size')}}" 
							@elseif(isset($result['min_basket_size'])) value="{{$result['min_basket_size']}}" 
							@endif min="0" oninput="validity.valid||(value='');" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="ruleSection">
	<div class="row">
		<div class="col-md-12">
			<label for="multipleProduct2" class="control-label">Price Rule
			<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Masukan rentang jumlah produk dan diskon" data-container="body"></i></label>
		</div>
		<hr>
		<div class="col-md-8">
			<div class="col-md-2 text-center">
				<label>Min. Qty <i class="fa fa-question-circle tooltips" data-original-title="Jumlah minimal pembelian produk untuk mendapatkan diskon" data-container="body"></i></label>
			</div>
			<div class="col-md-2 text-center">
				<label>Max. Qty <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal pembelian produk untuk mendapatkan diskon" data-container="body"></i></label>
			</div>
			<div class="{{ (($result['deals_tier_discount_rules'][0]['discount_type']??$result['deals_promotion_tier_discount_rules'][0]['discount_type']??'') == 'Percent') ? 'col-md-3' : 'col-md-5'}}  text-center" id="bulk-label-div">
				<label id="bulk-label" class="control-label"> {{ (($result['deals_tier_discount_rules'][0]['discount_type']??$result['deals_promotion_tier_discount_rules'][0]['discount_type']??'') == 'Percent') ? 'Percent value' : 'Nominal value'}} </label><span class="required" aria-required="true">  </span><i class="fa fa-question-circle tooltips" data-original-title="Besar diskon yang akan diberikan untuk setiap produk. Diskon akan dihitung dari harga produk tanpa harga topping" data-container="body"></i><br>
				<div class="form-group">
				</div>
			</div>
			<div class="col-md-4 text-center" id="max-percent-discount-div" style="{{ (($result['deals_tier_discount_rules'][0]['discount_type']??$result['deals_promotion_tier_discount_rules'][0]['discount_type']??'') == 'Percent') ? '' : 'display: none'}}">
				<label class="control-label"> Max Percent Discount (untuk 1 qty) <span class="required" aria-required="true">  </span><i class="fa fa-question-circle tooltips" data-original-title="Max Discount (untuk 1 qty). Kosongkan jika maksimal persentase diskon mengikuti harga produk" data-container="body"></i></label><br>
				<div class="form-group">
				</div>
			</div>
		</div>
	</div>
	<div id="ruleSectionBody">
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary new">Add New</button>
	</div>
</div>@endSection

@section('child-script')
<script type="text/javascript">
	var lastError='';
	var template='	<div class="row" data-id="::n::">\
		<div class="col-md-8">\
			<div class="col-md-2">\
				<div class="form-group">\
					<input type="text" class="form-control qty_mask ::classMinQty:: text-center" min="1" name="promo_rule[::n::][min_qty]" value="::min_qty::" required autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error1::</p>\
			</div>\
			<div class="col-md-2">\
				<div class="form-group">\
					<input type="text" class="form-control qty_mask ::classMaxQty:: text-center" min="1" name="promo_rule[::n::][max_qty]" value="::max_qty::" required autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error2::</p>\
			</div>\
			<div class="::class_div_input::">\
				<div class="form-group">\
					<div class="input-group">\
						<div class="input-group-addon ::nominal::">IDR</div>\
						<input type="text" class="form-control discount_viewer text-center" id="discount_value::n::" data-target="promo_rule[::n::][discount_value]"  value="::discount_valuex::" required placeholder="::placeholder::" autocomplete="off">\
						<input type="number" class="form-control discount_value" style="display:none" min="0" name="promo_rule[::n::][discount_value]" value="::discount_value::" ::discount_prop:: required>\
						<div class="input-group-addon ::percent::">%</div>\
					</div>\
				</div>\
			</div>\
			<div class="col-md-4 max-percent-input ::class_div_max_percent::">\
				<div class="form-group">\
					<div class="input-group">\
						<div class="input-group-addon">IDR</div>\
						<input type="text" class="form-control text-center digit_mask" id="max_percent_discount::n::" data-target="promo_rule[::n::][max_percent_discount]"  value="::max_percent_discountx::" autocomplete="off" name="promo_rule[::n::][max_percent_discount]">\
					</div>\
				</div>\
			</div>\
			<div class="col-md-1">\
				<button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash-o"></i></button>\
			</div>\
		</div>\
	</div>';
	@if( isset($result['deals_tier_discount_rules']) || isset($result['deals_promotion_tier_discount_rules']) )
		<?php $result['deals_tier_discount_rules'] = array_map(function($x){$x[$x['discount_type']]=$x['discount_value'];return $x;},$result['deals_tier_discount_rules']??$result['deals_promotion_tier_discount_rules']) ?>
		database={!!json_encode($result['deals_tier_discount_rules'])!!};
	@else
		database=[];
	@endif
	function update(col,val){
		ncol=col.replace('promo_rule','database').replace(/\[/g,'["').replace(/\]/g,'"]');
		if(ncol){
			eval(ncol+'=val');
		}
	}
	function reOrder(drawIfTrue=true){
		var html='';
		var last=0;
		var status=true;
		var lastErrorReal='';
		if(database.length<1||database[0]==undefined){
			database=[{}];
		}
		database.forEach(function(it,id){
			var edited=template;
			var errorNow='';
			var discount_value=it['Nominal'];
			var show_nominal = '';
			var class_div_input = 'col-md-5';
			var class_div_percent = 'd-none';
			var show_percent = 'd-none';
			var placeholder = '100.000';
			var it_min_qty = it['min_qty']+'';
			var it_max_qty = it['max_qty']+'';
			var max_percent_discount = it['max_percent_discount']+'';
			max_percent_discount = max_percent_discount.replace(/,/g , '');
			fmpd = parseInt(max_percent_discount);
			it_min_qty = it_min_qty.replace(/,/g , '');
			it_max_qty = it_max_qty.replace(/,/g , '');
			it_min_qty = parseInt(it_min_qty);
			it_max_qty = parseInt(it_max_qty);

			$('button[type="submit"]').prop('disabled', false);
			if($('input[name="discount_type"]:checked').length>0&&$('input[name="discount_type"]:checked')[0].value=='Percent'){
				var discount_value=it['Percent'];
				show_nominal = 'd-none';
				show_percent = '';
				placeholder = '50';
				class_div_input = 'col-md-3';
				class_div_percent = '';
			}
			if(!isNaN(parseInt(discount_value))){
				var fdv=parseInt(discount_value).toLocaleString('id');
			}else{
				var fdv='';
			}
			// if(!isNaN(parseInt(max_percent_discount))){
			// 	var fmpd=parseInt(max_percent_discount).toLocaleString('id');
			// }else{
			// 	var fmpd='';
			// }
			edited=edited.replace(/::n::/g,id).replace('::min_qty::',it['min_qty']).replace('::max_qty::',it['max_qty']).replace("::discount_value::",discount_value).replace("::discount_valuex::",fdv).replace("::nominal::", show_nominal).replace("::percent::", show_percent).replace("::class_div_input::", class_div_input).replace("::class_div_percent::", class_div_percent).replace("::placeholder::", placeholder).replace("::max_percent_discount::", it['max_percent_discount']).replace("::max_percent_discountx::", fmpd).replace("::class_div_max_percent::", show_percent);
			if(it_min_qty-last<=0){
				if(!lastErrorReal){
					edited=edited.replace('::error1::','Min. Quantity should be greater than '+last).replace('::classMinQty::','red');
					errorNow='min_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else if(it_min_qty - it_max_qty >0){
				if(!lastErrorReal){
					edited=edited.replace('::error2::','Max. Quantity should be greater than or equal '+it['min_qty']).replace('::classMaxQty::','red');
					errorNow='max_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}
			edited=edited.replace('::classMinQty::','').replace('::classMaxQty::','').replace('::error1::','').replace('::error2::','');

			if(!lastErrorReal){
				lastErrorReal=errorNow;
			}
			last=it['max_qty'];
			html+=edited;
		});
		if(lastErrorReal!=lastError||(status&&drawIfTrue)){
			lastError=lastErrorReal;
			$('#ruleSectionBody').html(html);
		}

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});
		$('.qty_mask').inputmask({
			removeMaskOnSubmit: true, 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});
		return status;
	}
	$(document).ready(function(){
		$('#bulkProduct').on('click','.new',function(){
			if(!reOrder()){
				return false;
			}
			database.push({});
			reOrder();
		});
		$('#bulkProduct').on('click','.remove',function(){
			var id=$($(this).parents('.row')[0]).data('id');
			delete database[id];
			database=database.filter(function(x){return x!==undefined;});
			reOrder();
		});
		$('#bulkProduct').on('change','input',function(){
			if($(this).prop('name')!='discount_type'){
				if($(this).data('target')){
					var col=$(this).data('target').replace('discount_value',$('input[name="discount_type"]:checked').val()||'discount_value');
					var val=$(this).val().replace('.','');
					update(col,val);
				}else{
					var col=$(this).prop('name');
					var val=$(this).val();
					update(col,val);
				}
			}
			reOrder(false);
		});
		$('#bulkProduct').on('change','input[name="discount_type"]',function(){
			reOrder();
		});
		$('#bulkProduct').on('change','input[name="discount_type"]',function(){
			if($('input[name="discount_type"]:checked').val()=='Percent'){
				$('.discount_value').prop('max','100');
				$('#bulk-label').text('Percent value');
				$('#max-percent-discount-div, .max-percent-input').show();
				$('#bulk-label-div').removeClass('col-md-5').addClass('col-md-3');
			}else{
				$('.discount_value').removeProp('max');
				$('#bulk-label').text('Nominal value');
				$('#max-percent-discount-div, .max-percent-input').hide();
				$('#bulk-label-div').removeClass('col-md-3').addClass('col-md-5');
			}
		});
		$('button[type="submit"]').on('click',function(){
			if($('input[name=promo_type]:checked').val()=='Tier discount'){
				return reOrder();
			}
		});
		$('#bulkProduct').on('keyup','.discount_viewer',function(){
			var type='';
			var value1=$(this).val().replace(/[^0-9]/g,'').replace(/(\.|\,)/g,'');
			if($('input[name="discount_type"]:checked').length>0){
				type=$('input[name="discount_type"]:checked').val();
			}
			if(type=='Percent'&&value1>100){
				value1=100;
			}
			$('input[name="'+$(this).data('target')+'"]').val(value1);
			value=parseInt($('input[name="'+$(this).data('target')+'"]').val()).toLocaleString('id');
			if(isNaN(value1)||!value1){
				value='';
			}
			$(this).val(value);
		});

		$('.digit_mask').inputmask({
			removeMaskOnSubmit: "true", 
			placeholder: "",
			alias: "currency", 
			digits: 0, 
			rightAlign: false,
			min: '0',
			max: '999999999'
		});
		reOrder();
	});
</script>
@yield('promo-product-script')
@endSection