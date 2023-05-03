@php
	switch ($promo_source) {
		case 'promo_campaign':
			$data = $result;
			break;
		
		case 'Promotion':
			$data = $result;
			$promo_source = 'deals_promotion';
			break;

		default:
			$data = $result;
			$promo_source = 'deals';
			break;
	}
@endphp

@section('promo-shipment-method')
@php
	$shipment_method = array_column($data[$promo_source.'_shipment_method'], 'shipment_method');
	// $delivery_list = ['GO-SEND'];
	// $is_delivery = count(array_intersect($shipment_method, $delivery_list)) > 0;
@endphp
@if($result['promo_use_in'] != 'Consultation')
<div class="row">
	<div class="col-md-12">
		<label class="control-label">Shipment method</label>
		<i class="fa fa-question-circle tooltips" data-original-title="Pilih metode shipment" data-container="body" data-html="true"></i>
		<div class="mt-radio-inline">
			<label class="mt-radio mt-radio-outline"> All Shipment
				<input type="radio" value="all_shipment" name="filter_shipment" @if(isset($data['is_all_shipment']) && $data['is_all_shipment'] === 1) checked @endif required/>
				<span></span>
			</label>
			<label class="mt-radio mt-radio-outline"> Selected Shipment
				<input type="radio" value="selected_shipment" name="filter_shipment" id="checkbox-selected-shipment" @if(empty($data['is_all_shipment']) && $data['is_all_shipment'] === 0)) checked @endif required/>
				<span></span>
			</label>
		</div>
        <div id="selected-shipment" 
	        @if ( $data['is_all_shipment'] !== 0  ) 
	        	style="display: none;" 
	        @endif>
		        <label class="control-label">Select Shipment</label>
	        <div class="mt-checkbox-inline">
	            @foreach ($delivery_list as $delivery)
					@foreach($delivery['service'] as $s)
						<label class="mt-checkbox mt-checkbox-outline">
							<input class="input-selected-shipment" type="checkbox" value="{{ $s['code'] }}" name="shipment_method[]" @if (in_array($s['code'], $shipment_method)) checked @endif> {{ $delivery['delivery_name']  }} - {{ $s['service_name']  }}
							<span></span>
						</label>
					@endforeach
	            @endforeach
	            {{-- <label class="mt-checkbox mt-checkbox-outline">
	                <input class="input-selected-shipment" type="checkbox" value="Delivery"	 id="checkbox-shipment-delivery" @if ($is_delivery) checked @endif> Delivery
	                <span></span>
	            </label> --}}
	        </div>
        </div>
        {{-- <div id="shipment-delivery"
        	@if ( !$is_delivery && !in_array('GO-SEND', $shipment_method) )
        		style="display: none;" 
        	@endif
        	>
	        <label class="control-label">Select Shipment delivery</label>
			<i class="fa fa-question-circle tooltips" data-original-title="Pilih shipment delivery" data-container="body" data-html="true"></i>
	        <div class="mt-checkbox-inline">
	            <label class="mt-checkbox mt-checkbox-outline">
	                <input class="input-shipment-delivery" type="checkbox" value="GO-SEND" name="shipment_method[]" @if (in_array('GO-SEND', $shipment_method)) checked @endif> GO-SEND
	                <span></span>
	            </label>
	            <label class="mt-checkbox mt-checkbox-outline">
	                <input class="input-shipment-delivery" type="checkbox" value="GRAB" name="shipment_method[]" @if (in_array('GRAB', $shipment_method)) checked @endif> GRAB
	                <span></span>
	            </label>
	        </div>
        </div> --}}
	</div>
</div>
@endif
@endsection

@section('promo-shipment-method-script')
<script type="text/javascript">

	$('.input-selected-shipment').on('change', function(){
    	let check_delivery = $(this).is(":checked");
    	if (check_delivery) {
    		$('.input-selected-shipment').prop('required', false);
    	}

    	if ($('#checkbox-selected-shipment').is(":checked") && $('#selected-shipment input:checked').length == 0) {
    		$('.input-selected-shipment').prop('required', true);
    	}
    });

	$('.input-shipment-delivery').on('change', function(){
    	let check_delivery = $(this).is(":checked");
    	if (check_delivery) {
    		$('.input-shipment-delivery').prop('required', false);
    	}

    	if ($('#checkbox-shipment-delivery').is(":checked") && $('#shipment-delivery input:checked').length == 0) {
    		$('.input-shipment-delivery').prop('required', true);
    	}
    });

	$('#checkbox-shipment-delivery').on('change', function(){
		if(this.checked){
			document.getElementById('shipment-delivery').style.display = 'block';
			$('.input-shipment-delivery').prop('required',true);
		} 
		else {
			document.getElementById('shipment-delivery').style.display = 'none';
			$('.input-shipment-delivery').prop('required',false);
		}
		$('#shipment-delivery').find('input').prop('checked',false);
	});

	$('#checkbox-selected-shipment').on('change', function(){
		if(this.checked){
			document.getElementById('selected-shipment').style.display = 'block';
			$('.input-selected-shipment').prop('required',true);
		} 
		else {
			document.getElementById('selected-shipment').style.display = 'none';
			$('.input-selected-shipment').prop('required',false);
		}
		$('#selected-shipment').find('input').prop('checked',false);
	});

	$('input[name=filter_shipment]').on('click', function(){
		let shipment = $(this).val();
		if(shipment == 'selected_shipment') {
			$('#selected-shipment').show();
		}
		else {
			$('#selected-shipment').hide().find('input').prop('required', false);
		}
		$('#selected-shipment').find('input').prop('checked',false);
		$('#shipment-delivery').hide().prop('required', false);
	});

</script>
@endsection