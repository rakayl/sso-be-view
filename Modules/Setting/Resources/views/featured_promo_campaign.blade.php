@section('featured-promo-campaign')
	<div class="tab-pane" id="featured_promo_campaign">
	    <div style="margin:20px 0">
	        <a class="btn blue btn-outline sbold" data-toggle="modal" href="#modalFeaturedPromoCampaign"> New Featured Promo Campaign
	        	<i class="fa fa-question-circle tooltips" data-original-title="Membuat featured promo campaign di halaman home aplikasi mobile" data-container="body"></i>
	        </a>
	    </div>

		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">List Featured Promo Campaign</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="alert alert-warning">
						    <p> To arrange the order of promo campaign, drag and drop on the promo campaign in the order of the desired image.</p>
						</div>
						@if(!empty($featured_promo_campaigns))
						<form action="{{ url('setting/featured_promo_campaign/reorder') }}" method="POST">
							<div class="clearfix" id="sortable-ft-promo">
								@foreach ($featured_promo_campaigns as $key => $featured_promo)
					 			<div class="portlet portlet-sortable light bordered col-md-3">
					 				<div class="portlet-title">
										<div class="row">
											<div class="col-md-2">
					 				  			<span class="caption-subject bold" style="font-size: 12px !important;">{{ $key + 1 }}</span>
											</div>
											<div class="col-md-10 text-right">
													<a class="btn blue btn-circle btn-edit" href="#modalFeaturedPromoCampaignUpdate" data-toggle="modal" data-start-date="{{ date('d M Y H:i',strtotime($featured_promo['date_start'])) }}" data-end-date="{{ date('d M Y H:i',strtotime($featured_promo['date_end'])) }}" data-id-promo-campaign="{{ $featured_promo['id_promo_campaign'] }}" data-promo-title="{{ $featured_promo['promo_campaign']['promo_title'] }}" data-id="{{ $featured_promo['id_featured_promo_campaign'] }}"><i class="fa fa-pencil"></i> </a>
													<a class="btn red-mint btn-circle btn-delete" data-id="{{ $featured_promo['id_featured_promo_campaign'] }}"><i class="fa fa-trash-o"></i> </a>
											</div>
										</div>
					 				</div>
					 			 	<div class="portlet-body">
					 			   		<input type="hidden" name="id_featured_promo_campaign[]" value="{{ $featured_promo['id_featured_promo_campaign'] }}">
					 			   		<center><img src="{{ $featured_promo['promo_campaign']['url_promo_image'] ?? null }}" alt="FeaturedPromoCampaign Image" width="150"></center>
					 			 	</div>
					 			 	<div class="click-to text-center">
					 			 		<div style="white-space: nowrap">@if(strlen($featured_promo['promo_campaign']['promo_title']) > 18) {{ substr($featured_promo['promo_campaign']['promo_title'], 0, 18) }} ... @else {{ $featured_promo['promo_campaign']['promo_title'] }} @endif</div>
					 			 		<div>{!! date('d M Y H:i:s',strtotime($featured_promo['date_start']))."<br> - <br>".date('d M Y H:i:s',strtotime($featured_promo['date_end'])) !!}</div>
					 			 	</div>
									<div style="text-align: right;">
										<br>
										@if(!empty($featured_promo['date_end']) && (strtotime(date('Y-m-d H:i:s')) > strtotime($featured_promo['date_end']) || strtotime(date('Y-m-d H:i:s')) > strtotime($featured_promo['promo_campaign']['date_end'])))
											<span class="badge badge-dark badge-sm">Expired</span>
										@else
											<span class="badge badge-primary badge-sm">Active</span>
										@endif
									</div>
					 			</div>
					 			@endforeach
							</div>
							<div class="text-center">
								{{ csrf_field() }}
								<input type="submit" value="Update Sorting" class="btn blue">
							</div>
						</form>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalFeaturedPromoCampaignUpdate" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Edit Featured Promo Campaign</h4>
				</div>
				<div class="modal-body form">
					<br>
					<form role="form" id="form_featured_promo_edit" action="{{url('setting/featured_promo_campaign/update')}}" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id_featured_promo_campaign" id="id_featured_promo_campaign">
						<div class="row">
							<div class="col-md-3 text-right">
								<label>Promo Campaign</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<select class="select2 form-control" name="id_promo_campaign" id="id_promo_campaign" style="width: 100%" required>
										<option></option>
										@foreach($promo_campaigns as $val)
										<option value="{{$val['id_promo_campaign']}}">{{$val['promo_title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-right">
								<label>Start Date</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="text" class="datetime form-control" name="date_start" id="date_start" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-right">
								<label>End Date</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="text" class="datetime form-control" name="date_end" id="date_end" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="form-actions" style="text-align:center">
							{{ csrf_field() }}
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn blue" id="checkBtn">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalFeaturedPromoCampaign" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Create Featured Promo Campaign</h4>
				</div>
				<div class="modal-body form">
					<br>
					<form role="form" id="form_featured_promo_create" action="{{url('setting/featured_promo_campaign/create')}}" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-3 text-right">
								<label>Promo Campaign</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<select class="select2 form-control" name="id_promo_campaign" style="width: 100%" required>
										<option></option>
										@foreach($promo_campaigns as $val)
										<option value="{{$val['id_promo_campaign']}}">{{$val['promo_title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-right">
								<label>Start Date</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="text" id="create_date_start" class="datetime form-control" name="date_start" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 text-right">
								<label>End Date</label>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<input type="text" id="create_date_end" class="datetime form-control" name="date_end" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="form-actions" style="text-align:center">
							{{ csrf_field() }}
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							<button type="submit" class="btn blue" id="checkBtn">Create</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('featured-promo-campaign-script')
	<script>
		$(document).ready(function(){
			$('#form_featured_promo_create').on('submit', function(e) {
				var date_start = new Date($('#create_date_start').val()).getTime();
				var date_end = new Date($('#create_date_end').val()).getTime();

				if(date_end < date_start) {
					$('#validation').remove();
					$('#create_date_end').parent().append('<p id="validation" style="color: red;margin-top: -0.1%">End date must be greater than start date</p>');
					e.preventDefault();
					$('#create_date_end').focus();
					focusSet = true;
				}
			});

			$('#form_featured_promo_edit').on('submit', function(e) {
				var date_start = new Date($('#date_start').val()).getTime();
				var date_end = new Date($('#date_end').val()).getTime();

				if(date_end < date_start) {
					$('#validation').remove();
					$('#date_end').parent().append('<p id="validation" style="color: red;margin-top: -0.1%">End date must be greater than start date</p>');
					e.preventDefault();
					$('#date_end').focus();
					focusSet = true;
				}
			});
		});

		$('#create_date_start').on('change', function() {
			removeValidation();
		});

		$('#create_date_end').on('change', function() {
			removeValidation();
		});

		$('#date_start').on('change', function() {
			removeValidation();
		});

		$('#date_end').on('change', function() {
			removeValidation();
		});

		function removeValidation(){
			$('#validation').remove();
		}

	    $( "#sortable-ft-promo" ).sortable();
	    $( "#sortable-ft-promo" ).disableSelection();

	    $('#featured_promo_campaign .btn-edit').click(function() {
			var id         = $(this).data('id');
			var date_end   = $(this).data('end-date');
			var date_start = $(this).data('start-date');
			var id_promo_campaign   = $(this).data('id-promo-campaign');
			var promo_title   = $(this).data('promo-title');

			// assign value to form
			$('#id_featured_promo_campaign').val(id);
			$('#date_end').val(date_end).datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:1
		    });
			$('#date_start').val(date_start).datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:1
		    });
			$('#id_promo_campaign').find('option').first().attr('value',id_promo_campaign).text(promo_title);
			$('#id_promo_campaign').select2().trigger('change');
	    });

	    $('#featured_promo_campaign .btn-delete').click(function() {
			var id 		= $(this).data('id');
			var link 	= "{{ url('setting/featured_promo_campaign/delete') }}/" + id;
			swal({
			  title: "Are you sure want to delete this featured promo campaign ? ",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, delete it",
			  closeOnConfirm: false
			},
			function(){
				window.location = link;
			});
	    });
	</script>
@endsection