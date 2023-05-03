@include('promocampaign::template.promo-product', ['promo_source' => ($result['deals_type'] ?? $deals_type), 'promo_type' => 'bxgy'])

@section('buyXgetYForm')

@yield('promo-product')
{{-- <div class="row">
		<div class="col-md-6">
	<div id="selectProduct2" class="form-group" style="width: 100%!important">
			<label for="multipleProduct2" class="control-label">Product Utama<span class="required" aria-required="true"> * </span>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih produk X yang akan menjadi syarat untuk mendapatkan promo </br></br>X : Produk utama </br>Y : Produk benefit" data-container="body" data-html="true"></i></label>
			<select id="multipleProduct3" name="product[]" class="form-control select2 select2-hidden-accessible" multiple tabindex="-1" aria-hidden="true" data-value="{{
				( $result['deals_buyxgety_product_requirement'] ?? $result['deals_promotion_buyxgety_product_requirement'] ?? false )
			 	? 
			 	json_encode(
		 		([
	 				$result['deals_buyxgety_product_requirement'] ?? 
	 				$result['deals_promotion_buyxgety_product_requirement'] ??
	 				$result['deals_buyxgety_product_requirement'] ??
	 				$result['deals_promotion_buyxgety_product_requirement'] ?? ''
		 		])
		 		) 
			 	:''
				 }}" style="width: 100%!important">
			</select>
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
					&& (!empty($result['deals_buyxgety_rules']) || !empty($result['deals_promotion_buyxgety_rules']))
					) checked 
				@endif/>
			<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>semua</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
			<span></span>
		</label>
		<label class="mt-radio mt-radio-outline"> One of the items must exist
			<input type="radio" value="or" name="product_rule" 
				@if(isset($result['product_rule']) 
					&& $result['product_rule'] === 'or' 
					&& (!empty($result['deals_buyxgety_rules']) || !empty($result['deals_promotion_buyxgety_rules']))
					) checked 
				@endif/>
			<i class="fa fa-question-circle tooltips" data-original-title="Promo akan berlaku ketika <b>salah satu</b> syarat product ada dalam transaksi" data-container="body" data-html="true"></i>
			<span></span>
		</label>
	</div>
</div> --}}

<div class="form-group">
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
<div id="ruleSection2">
	<label class="control-label">Price Rule
	<span class="required" aria-required="true"> * </span>
	<i class="fa fa-question-circle tooltips" data-original-title="Masukan rentang jumlah produk dan benefit yang didapatkan dalam promo ini" data-container="body"></i></label>
	<div class="row">
		<div class="col-md-3">
			<div class="col-md-6 text-center">
				<label>Min. Qty <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah minimal produk X agar diskon dapat berlaku pada produk Y" data-container="body"></i></label>
			</div>
			<div class="col-md-6 text-center">
				<label>Max. Qty <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal produk X agar diskon dapat berlaku pada produk Y" data-container="body"></i></label>
			</div>
		</div>
		<div class="col-md-9">
			<div class="col-md-5 text-center">
				<label>Product Benefit <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Produk Y yang akan diberikan diskon setelah pembelian produk X" data-container="body"></i></label>
			</div>
			<div class="col-md-6 text-center">
				<label>Benefit <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk Y yang akan dikenakan diskon setelah pembelian produk X </br></br> Free : jumlah product Y yang diberikan </br></br> Discount : Besar diskon yang diberikan pada produk Y. Diskon akan dihitung dari harga produk tanpa harga topping" data-html="true" data-container="body"></i></label>
			</div>
			<div class="col-md-1 text-center">
			</div>
		</div>
	</div>
	<div id="ruleSectionBody2">
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-primary new">Add New</button>
	</div>
</div>@endSection

@section('child-script2')
<script type="text/javascript">
	var lastError2='';
	var listVariant=[];
	var template2='<div class="row" data-id="::n::">\
		<div class="col-md-3">\
			<div class="col-md-6">\
				<div class="form-group">\
					<input type="text" class="form-control ::classMinQty:: text-center qty_mask" min="1" name="promo_rule[::n::][min_qty_requirement]" value="::min_qty::" required autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error1::</p>\
			</div>\
			<div class="col-md-6">\
				<div class="form-group">\
					<input type="text" class="form-control ::classMaxQty:: text-center qty_mask" min="1" name="promo_rule[::n::][max_qty_requirement]" value="::max_qty::" required autocomplete="off">\
				</div>\
				<p class="text-danger help-block" style="padding-bottom:10px;margin-top:-10px">::error2::</p>\
			</div>\
		</div>\
		<div class="col-md-9">\
			<div class="col-md-5">\
				<div class="form-group bxgy-product-benefit">\
					<select name="promo_rule[::n::][benefit_id_product]" class="form-control product-selector select2" placeholder="Select product" style="width: 100%!important" required>::productList::</select>\
				</div>\
			</div>\
			<div class="col-md-6">\
				<select class="form-control benefit" name="promo_rule[::n::][benefit_type]">\
					<option value="free" ::selected_free::> Free Product</option>\
					<option value="nominal" ::selected_nominal::> Nominal Discount </option>\
					<option value="percent" ::selected_percent::> Percent Discount </option>\
		        </select>\
			</div>\
			<div class="col-md-1">\
				<button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash-o"></i></button>\
			</div>\
		</div>\
		<div class="col-md-3">\
		</div>\
		<div class="col-md-9">\
			<div class="col-md-5 text-left">\
				<div class="form-group ::hide_select_variant::">\
					<div class="col-md-4 p-l-0 text-right">\
						<label>Variant<span class="required" aria-required="true"> * </span></label>\
					</div>\
					<div class="col-md-8 p-l-r-0" style="margin-bottom:15px;">\
						<select name="promo_rule[::n::][id_product_variant_group]" class="form-control variant-selector select2" placeholder="Select Variant" style="width: 100%!important; " ::variant_required::>::variantList::</select>\
					</div>\
				</div>\
			</div>\
			<div class="col-md-6">\
				<div class="col-md-6 p-l-0 text-right">\
					<label>Discount<span class="required" aria-required="true"> * </span></label>\
				</div>\
				<div class="col-md-6 p-l-r-0">\
					<div class="form-group ::hide_qty::">\
						<div class="input-group">\
							<input type="text" class="form-control benefit_qty text-center digit_mask" min="0" name="promo_rule[::n::][benefit_qty]" value="::benefit_qty::" ::required_qty:: placeholder="Benefit Qty" autocomplete="off" required>\
							<div class="input-group-addon">qty</div>\
						</div>\
					</div>\
					<div class="form-group ::hide_nominal::">\
						<div class="input-group">\
							<div class="input-group-addon">IDR</div>\
							<input type="text" class="form-control digit_mask text-center" min="0" name="promo_rule[::n::][discount_nominal]" value="::discount_nominal::" ::required_nominal:: placeholder="100000" autocomplete="off">\
						</div>\
					</div>\
					<div class="form-group ::hide_percent::">\
						<div class="input-group">\
							<input type="number" class="form-control discount_value max100 benefit_percent text-center" min="0" max="100" name="promo_rule[::n::][discount_percent]" value="::discount_percent::" ::discount_prop:: ::required_percent:: style="padding-left: 7px;padding-right: 7px;text-align: center;" placeholder="50" autocomplete="off">\
							<div class="input-group-addon">%</div>\
						</div>\
					</div>\
				</div>\
			</div>\
			<div class="::hide_percent_max::">\
				<div class="col-md-5 text-right">\
				</div>\
				<div class="col-md-6">\
					<div class="col-md-6 p-l-0 text-right">\
						<label>Max Discount <br> (untuk 1 qty)</label>\
					</div>\
					<div class="col-md-6 p-l-r-0">\
						<div class="form-group">\
							<div class="input-group">\
								<div class="input-group-addon">IDR</div>\
								<input type="text" class="form-control digit_mask text-center" min="0" name="promo_rule[::n::][max_percent_discount]" value="::max_percent_discount::"  placeholder="100000" autocomplete="off">\
							</div>\
						</div>\
					</div>\
				</div>\
			</div>\
		</div>\
	</div>';
	@if( isset($result['deals_buyxgety_rules']) || isset($result['deals_promotion_buyxgety_rules']) )
		database2={!!json_encode($result['deals_buyxgety_rules']??$result['deals_promotion_buyxgety_rules'])!!};
	@else
		database2=[];
	@endif
	function add2(id){
		if(!isNaN(id)){
			database2.splice(id+1,0,{});
		}else{
			database2.splice(0,0,{});
		}
		reOrder();
	}
	function update2(col,val){
		var ncol=col.replace('promo_rule','database2').replace(/\[/g,'["').replace(/\]/g,'"]');
		eval(ncol+'=val');
	}
	function reOrder2(drawIfTrue=true){
		var html='';
		var last=0;
		var status=true;
		var lastErrorReal='';
		if(database2.length<1||database2[0]==undefined){
			database2=[];
			add2();
		}
		database2.forEach(function(it,id){
			var edited=template2;
			var errorNow='';
			var discount_value=it['discount_value'];
			var discount_nominal_value=it['discount_nominal'];
			var discount_percent_value=it['discount_percent'];
			var qty = it['benefit_qty'];
			var hide_qty = '';
			var hide_nominal = '';
			var hide_percent = '';
			var selected_free = '';
			var selected_nominal = '';
			var hide_percent_max = '';
			var selected_percent = '';
			var required_qty = '';
			var required_nominal = '';
			var required_percent = '';
			var max_percent_discount = it['max_percent_discount'];
			var it_min_qty = it['min_qty_requirement']+'';
			var it_max_qty = it['max_qty_requirement']+'';
			it_min_qty = it_min_qty.replace(/,/g , '');
			it_max_qty = it_max_qty.replace(/,/g , '');
			it_min_qty = parseInt(it_min_qty);
			it_max_qty = parseInt(it_max_qty);

			if(it['benefit_type'] == "free"){
				hide_nominal = 'd-none';
				hide_percent = 'd-none';
				hide_percent_max = 'd-none';
				selected_free = 'selected';
				required_qty = 'required';
				discount_value = 100;
				discount_nominal_value = ''
				max_percent_discount = ''

			}else if(it['benefit_type'] == "percent") {

				hide_qty = 'd-none';
				hide_nominal = 'd-none';
				hide_percent_max = '';
				selected_percent = 'selected';
				required_percent = 'required';
				discount_nominal_value = ''

			}else if(it['benefit_type'] == "nominal") {

				hide_qty = 'd-none';
				hide_percent = 'd-none';
				hide_percent_max = 'd-none';
				selected_nominal = 'selected';
				required_nominal = 'required';
				discount_value = '';
				max_percent_discount = ''

			}else {

				if (it['discount_type'] == 'nominal') {

					discount_nominal_value = it['discount_nominal'] ? it['discount_nominal'] : it['discount_value'];
					hide_qty = 'd-none';
					hide_percent = 'd-none';
					hide_percent_max = 'd-none';
					hide_nominal = '';
					selected_nominal = 'selected';
					required_qty = '';
					required_nominal = 'required';
					discount_value = '';
					max_percent_discount = ''
					
				}else if (it['discount_type'] =='percent' && it['discount_value'] != 100) {

					discount_percent_value = it['discount_percent'] ? it['discount_percent'] : it['discount_value'];
					hide_qty = 'd-none';
					hide_nominal = 'd-none';
					hide_percent = '';
					hide_percent_max = '';
					selected_percent = 'selected';
					required_percent = 'required';
					discount_nominal_value = ''

				}else {
					hide_nominal = 'd-none';
					hide_percent = 'd-none';
					hide_percent_max = 'd-none';
					selected_free = 'selected';
					discount_value = 100;
					discount_nominal_value = ''
					discount_percent_value = '';
					max_percent_discount = '';
				}

			}

			let id_product = '' + it['benefit_id_product'];

			if (id_product.indexOf('-') > -1) {
				id_product = id_product.split('-');
				id_product = id_product[1];
			}else{
				it['benefit_id_product'] = it['id_brand']+'-'+it['benefit_id_product'];
			}

			$('button[type="submit"]').prop('disabled', false);
			if( (it['discount_value']-100)>0 && it['discount_type'] == "percent"){
				discount_value=100;
			}
			edited=edited.replace(/::n::/g,id)
			.replace('::min_qty::',it['min_qty_requirement'])
			.replace('::max_qty::',it['max_qty_requirement'])
			.replace('::discount_value::',discount_value)
			.replace('::benefit_qty::',it['benefit_qty'])
			.replace('::hide_qty::', hide_qty)
			.replace('::hide_nominal::', hide_nominal)
			.replace('::hide_percent::', hide_percent)
			.replace('::selected_free::', selected_free)
			.replace('::selected_nominal::', selected_nominal)
			.replace('::selected_percent::', selected_percent)
			.replace('::discount_nominal::',discount_nominal_value?discount_nominal_value:'')
			.replace('::discount_percent::',discount_percent_value?discount_percent_value:'')
			.replace('::required_qty::',required_qty)
			.replace('::required_nominal::',required_nominal)
			.replace('::required_percent::',required_percent)
			.replace('::hide_percent_max::', hide_percent_max)
			.replace('::max_percent_discount::', max_percent_discount);

			if(it_min_qty-last<=0){
				if(!lastErrorReal){
					edited=edited.replace('::error1::','Min. Quantity should be greater than '+last).replace('::classMinQty::','red');
					errorNow='min_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else if(it_min_qty-it_max_qty>0){
				if(!lastErrorReal){
					edited=edited.replace('::error2::','Max. Quantity should be greater than or equal '+it['min_qty_requirement']).replace('::classMaxQty::','red');
					errorNow='max_qty'+id;
					$('button[type="submit"]').prop('disabled', true);
				}
				status=false;
			}else{
				edited=edited.replace('::error::','');
			}
			edited=edited.replace('::classMinQty::','').replace('::classMaxQty::','').replace('::error1::','').replace('::error2::','');
			if(!lastErrorReal){
				lastErrorReal=errorNow;
			}
			if(listProduct){
				if (it['benefit_id_product'] == 'undefined' || it['benefit_id_product'] == 'undefined-undefined') {
					var htmlProduct = '<option value="">Select Product</option>';
				}else{
					var htmlProduct = '';
				}
				listProduct.forEach(function(i){
					var addthis='';
					if(it['benefit_id_product'] && it['benefit_id_product'] == i['id_brand']+'-'+i['id_product']){
						addthis='selected';
					}
					htmlProduct+='<option value="'+i['id_brand']+'-'+i['id_product']+'" '+addthis+'>'+i['product']+'</option>';
				})
				edited=edited.replace('::productList::',htmlProduct);
			}else{
				edited=edited.replace('::productList::','');
			}

			if (it['benefit_id_product']) {
				loadProductVariant(id_product);

				if(listVariant[id_product] && listVariant[id_product].length){
					var htmlProduct='';
					listVariant[id_product].forEach(function(i){
						var addthis='';
						var id_product_variant_group = '';
						if(it['id_product_variant_group'] && it['id_product_variant_group']){
							id_product_variant_group = it['id_product_variant_group'].toString();
						}

						if (it['deals_buyxgety_product_modifiers'] && id_product_variant_group.indexOf('-') === -1) {
							let extra_mod = [];
							if (true) {}
							// extra_mod = it['deals_buyxgety_product_modifiers'].map(function(val){ return val['id_product_modifier']});
							it['deals_buyxgety_product_modifiers'].forEach(function(val){
								extra_mod.push(val['id_product_modifier']);
							});

							if (extra_mod.length != 0) {
								extra_mod = extra_mod.join('-');
								id_product_variant_group = id_product_variant_group+'-'+extra_mod;
							}
						}

						// if(it['id_product_variant_group'] && it['id_product_variant_group'] == i['id_product_variant_group']){
						if(id_product_variant_group == i['id_product_variant_group']){
							addthis = 'selected';
						}
						htmlProduct+='<option value="'+i['id_product_variant_group']+'" '+addthis+'>'+i['product_variant_group_name']+'</option>';
					})
					edited=edited.replace('::variantList::',htmlProduct).replace('::hide_select_variant::', '').replace('::variant_required::','required');
				}else{
					edited=edited.replace('::variantList::','').replace('::hide_select_variant::', 'd-none').replace('::variant_required::','');
				}
			}

			last=it['max_qty_requirement'];
			html+=edited;
		})
		if(lastErrorReal!=lastError2||(status&&drawIfTrue)){
			lastError2=lastErrorReal;
			$('.product-selector, .variant-selector').select2('destroy');
			$('#ruleSectionBody2').html(html);
			$('.product-selector').select2({ width: '100%' ,placeholder:'Select product'});
			$('.variant-selector').select2({ width: '100%' ,placeholder:'Select variant'});
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

	function loadProductVariant(id_product){
		if (!(id_product in listVariant)) {
		    listVariant[id_product] = [];
			$.ajax({
				type: "GET",
				url: "{{url('promo-campaign/step2/getData')}}",
				data : {
					"get" : 'Product Variant',
					"id_product" : id_product
				},
				dataType: "json",
				success: function(data){
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					listVariant[id_product] = data;
					productVariantLoad = 1;
					reOrder2();
				}
			});
		}else{
			return true;
		}
	}

	$(document).ready(function(){
		$('#buyXgetYProduct').on('click','.new',function(){
			if(!reOrder2()){
				return false;
			}
			database2.push({});
			reOrder2();
		});
		$('#buyXgetYProduct').on('keyup','.max100',function(){
			if($(this).val()>100){
				$(this).val(100);
			}
		});
		$('#buyXgetYProduct').on('click','.remove',function(){
			var id=$($(this).parents('.row')[0]).data('id');
			delete database2[id];
			database2=database2.filter(function(x){return x!==undefined;});
			reOrder2();
		});
		$('#buyXgetYProduct').on('change','input',function(){
			var col=$(this).prop('name');
			var val=$(this).val();
			update2(col,val);
			reOrder2();
		});
		$('#ruleSectionBody2').on('change','input,select',function(){
			var col=$(this).prop('name');
			var val=$(this).val();
			update2(col,val);
			reOrder2();
		});
		$('#buyXgetYProduct').on('change','input[name="discount_type"]',function(){
			if($('input[name="discount_type"]:checked').val()=='Percent'){
				$('.discount_value').prop('max','100');
			}else{
				$('.discount_value').removeProp('max');
			}
		});
		$('button[type="submit"]').on('click',function(){
			if($('input[name=promo_type]:checked').val()=='Buy X Get Y'){
				return reOrder2();
			}
		});
	});

</script>
@yield('promo-product-script')
@endSection