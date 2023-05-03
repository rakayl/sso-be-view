@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 120
          });
        });

		function viewUpdate(id){
			var keyword = document.getElementById('keyword_'+id).value;
			var reference = document.getElementById('reference_'+id).value;
			var type = document.getElementById('type_'+id).value;
			var default_value = document.getElementById('default_value_'+id).value;
			var custom_rule = document.getElementById('custom_rule_'+id).value;
			var status = document.getElementById('status_'+id).value;

			document.getElementById('keyword').value = keyword;
			document.getElementById('reference').value = reference;
			document.getElementById('type').value = type;
			document.getElementById('default_value').value = default_value;
			document.getElementById('custom_rule').value = custom_rule;
			// document.getElementById('status').value = status;
			document.getElementById('id_text_replace').value = id;
			// $("#status").select2().select2(status,status);
			setTimeout(function(){
				$('status').val(status); // Select the option with a value of 'Copter'
				$('status').trigger('change'); // Notify any JS components that the value changed
			},1000)

		}
    </script>

@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="/">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>{{ $title }}</span>
			@if (!empty($sub_title))
				<i class="fa fa-circle"></i>
			@endif
		</li>
		@if (!empty($sub_title))
		<li>
			<span>{{ $sub_title }}</span>
		</li>
		@endif
	</ul>
</div><br>

@include('layouts.notifications')

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-blue sbold uppercase">List Text Replace</span>
		</div>
	</div>
	<div class="portlet-body form" style="overflow-x:scroll">
		<table class="table table-bordered table-hover" width="100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Keyword</th>
					<th>Reference</th>
					<th>Type</th>
					<th>Default&nbsp;Value</th>
					<th>Custom&nbsp;Rule</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if (!empty($textreplaces))
					@foreach($textreplaces as $key => $value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value['keyword'] }}</td>
							<td>{{ $value['reference'] }}</td>
							<td>{{ $value['type'] }}</td>
							<td>{{ $value['default_value'] }}</td>
							<td>{{ $value['custom_rule'] }}</td>
							<td>{{ $value['status'] }}</td>
							<td><a href="#update" data-toggle="modal" class="btn btn-sm blue" onClick="viewUpdate('{{ $value['id_text_replace'] }}')"><i class="fa fa-edit"></i></a>
							</td>

							<input type="hidden" id="keyword_{{ $value['id_text_replace'] }}" value="{{$value['keyword']}}">
							<input type="hidden" id="reference_{{ $value['id_text_replace'] }}" value="{{$value['reference']}}">
							<input type="hidden" id="type_{{ $value['id_text_replace'] }}" value="{{$value['type']}}">
							<input type="hidden" id="default_value_{{ $value['id_text_replace'] }}" value="{{$value['default_value']}}">
							<input type="hidden" id="custom_rule_{{ $value['id_text_replace'] }}" value="{{$value['custom_rule']}}">
							<input type="hidden" id="status_{{ $value['id_text_replace'] }}" value="{{$value['status']}}">
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade bs-modal-lg" id="update" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Update Text Replace</h4>
			</div>
			<div class="modal-body form">
				<form class="form-horizontal" role="form" action="{{ url('textreplace') }}" method="post" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Keyword</label>
							<div class="col-md-9">
								<input type="text" placeholder="Keyword" class="form-control" id="keyword" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Reference</label>
							<div class="col-md-9">
								<input type="text" placeholder="Reference" class="form-control" id="reference" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Type</label>
							<div class="col-md-9">
								<input type="text" placeholder="Type" class="form-control" id="type" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Default Value</label>
							<div class="col-md-9">
								<input type="text" placeholder="Default Value" class="form-control" name="default_value" id="default_value">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Custom Rule</label>
							<div class="col-md-9">
								<input type="text" placeholder="Custom Rule" class="form-control" name="custom_rule" id="custom_rule">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-9">
								<select  autocomplete="off" name="status" class="form-control select2-multiple select2-hidden-accessible" id="status" tabindex="-1" aria-hidden="true" data-placeholder="Select User Status">
									<option value="Activated">Activated</option>
									<option value="Not Activated">Not Activated</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<input type="hidden" id="id_text_replace" name="id_text_replace">
						<div class="row">
							<div class="col-md-offset-4 col-md-8">
								<button type="submit" class="btn green">Update</button>
								<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection