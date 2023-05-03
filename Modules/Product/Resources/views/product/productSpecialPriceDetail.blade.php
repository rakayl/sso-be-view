<?php
$id_product = $product[0]['id_product'];
?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="formWithPrice2">
  <div class="form-body">

  	<div class="form-group" style="padding-left:20px">
		<label class="bold" style="width:30%">Outlet</label>
		<label class="bold" style="width:25%">Price</label>
	</div>
		@foreach($outletSpecialPrice as $key => $ou)
		  <div class="form-group" style="padding-left:20px">
			  <label class=""  style="width:30%">{{$ou['outlet_name']}}</label>
			  <?php
			  $price_special = 0;
			  $id_product_special_price = 0;
			  if(isset($ou['product_special_price'])){
				  $checkExist = array_search($ou['id_outlet'], array_column($ou['product_special_price'], 'id_outlet'));
				  if($checkExist !== false){
					  $price_special = (int)$ou['product_special_price'][$checkExist]['product_special_price'];
					  $id_product_special_price = $ou['product_special_price'][$checkExist]['id_product_special_price'];
				  }
			  }
			  ?>
			  @if($id_product_special_price != 0)
				  <div style="width:25%; display:inline-block">
					  <input type="text" class="form-control nominal price product-price" name="product_price[]" value="{{$price_special}}" data-id="{{$ou['id_outlet']}}">
					  <input type="hidden" name="id_product_special_price[]" value="{{ $id_product_special_price }}">
					  <input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
				  </div>
			  @else
				  <div style="width:25%; display:inline-block">
					  <input type="text" class="form-control nominal price product-price" name="product_price[]" value="0" data-id="{{$ou['id_outlet']}}">
					  <input type="hidden" name="id_outlet[]" value="{{ $ou['id_outlet'] }}">
					  <input type="hidden" name="id_product_special_price[]" value="0">
				  </div>
			  @endif
			  <div style="width:25%; display:inline-block; vertical-align: text-top;">
				  <label class="mt-checkbox mt-checkbox-outline"> Same for all
					  <input type="checkbox" name="sameall[]" class="same checkbox-price" data-check="ampas"/>
					  <span></span>
				  </label>
			  </div>
		  </div>
		@endforeach
	</div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_product" value="{{ $id_product }}">
            <button type="submit" class="btn green" id="submit">Submit</button>
          </div>
      </div>
  </div>
    <input type="hidden" name="page" value="{{$page}}">
	<input type="hidden" name="type" value="product_special_price">
</form>
@if ($outletSpecialPricePaginator)
	{{ $outletSpecialPricePaginator->fragment('outletpricesetting')->links() }}
@endif