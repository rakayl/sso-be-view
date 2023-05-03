<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@if(MyHelper::hasAccess([30], $grantedFeature))
	<form class="form-horizontal" role="form" action="{{ url()->current() }}" id="formimage" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-4 control-label">Photo <br> <span class="required" aria-required="true"> (600*300) </span> </label>
				<div class="col-md-8">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
						<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
						</div>
						<div class="fileinput-preview fileinput-exists thumbnail" id="imageoutlet" style="max-width: 200px; max-height: 200px;"></div>
						<div>
							<span class="btn default btn-file">
							<span class="fileinput-new"> Select image </span>
							<span class="fileinput-exists"> Change </span>
							<input type="file" class="file" accept="image/*" name="photo">
							{{ csrf_field() }}
							<input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
							</span>

							<a href="javascript:;" class="btn red fileinput-exists" id='removeimage' data-dismiss="fileinput"> Remove </a>
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
@if (!empty($outlet))
	@php
		$show = 0;
	@endphp
   	<form action="{{ url()->current() }}" method="POST">
 	<div class="col-md-12" id="sortable">
 	 @foreach($outlet as $value)
 	 	@if (!empty($value['outlet_photos']))
 	 		@php
 	 			$show = 1;
 	 		@endphp

 	 		@foreach ($value['outlet_photos'] as $key=> $you)
 			<div class="portlet portlet-sortable light bordered col-md-4">
 				<div class="portlet-title">
					<div class="row">
						<div class="col-md-5">
 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
						</div>
						<div class="col-md-7">
							@if(MyHelper::hasAccess([31], $grantedFeature))
								<a class="btn red-mint btn-circle hapus-gambar" data-id="{{ $you['id_outlet_photo'] }}" data-toggle="confirmation" data-popout="true">Delete <i class="fa fa-trash-o"></i> </a>
							@endif
						</div>
					</div>
 				</div>
 			 	<div class="portlet-body">
 			   		<input type="hidden" name="id_outlet_photo[]" value="{{ $you['id_outlet_photo'] }}">
 			   		<center><img src="{{ env('STORAGE_URL_API').$you['outlet_photo'] }}" alt="Photo" width="150"></center>
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