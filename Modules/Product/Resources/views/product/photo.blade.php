<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
@if(MyHelper::hasAccess([54], $grantedFeature))
	<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" id="formimage" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-4 control-label">Photo <br> <span class="required" aria-required="true"> (300*300) </span> </label>
				<div class="col-md-8">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
						<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
						<div>
							<span class="btn default btn-file">
							<span class="fileinput-new"> Select image </span>
							<span class="fileinput-exists"> Change </span>
							<input type="file" class="file" id="fieldphoto" accept="image/*" name="photo">
							{{ csrf_field() }}
							<input type="hidden" name="id_product" value="{{ $product[0]['id_product'] }}">
							</span>

							<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endif

<div class="alert alert-warning deteksi-trigger">
    <p> The menu below is used to set the order of photos displayed in android apps and ios. </p>
    <p> To arrange the order of photos, drag and drop on the image in the order of the desired image. </p>
</div>
<div class="portlet-body form">
@if (!empty($product))
	@php
		$show = 0;
	@endphp
   	<form action="{{ url()->current() }}" method="POST">
 	<div class="col-md-12" id="sortable">
 	 @foreach($product as $value)
 	 	@if (!empty($value['photos']))
 	 		@php
 	 			$show = 1;
 	 		@endphp

 	 		@foreach ($value['photos'] as $key=> $you)
 			<div class="portlet portlet-sortable light bordered col-md-4">
 				<div class="portlet-title">
					<div class="row">
						<div class="col-md-5">
 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
						</div>
						@if(MyHelper::hasAccess([55], $grantedFeature))
							<div class="col-md-7">
								<a class="btn red-mint btn-circle hapus-gambar" data-id="{{ $you['id_product_photo'] }}" data-toggle="confirmation" data-popout="true">Delete <i class="fa fa-trash-o"></i> </a>
							</div>
						@endif
					</div>
 				</div>
 			 	<div class="portlet-body">
 			   		<input type="hidden" name="id_product_photo[]" value="{{ $you['id_product_photo'] }}">
 			   		<center><img src="{{ $you['url_product_photo'] }}" alt="Category Image" width="150"></center>
 			 	</div>
 			</div>
 			@endforeach
 	   	@endif
 	 @endforeach
 	</div>

 	@if ($show == 1)
 	<div class="row deteksi" data-dis="1">
 	  	<div class="col-md-5"></div>
 	  	<div class="col-md-7">
 		<button type="submit" class="btn green">Update Sorting</button>
 		{{ csrf_field() }}
 	  	</div>
 	</div>
 	@endif
   	</form>
@endif
</div>
