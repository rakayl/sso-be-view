@include('promocampaign::coupon_filter')
@section('coupon')

@yield('coupon-filter')
<a data-toggle="modal" href="#export-code-modal" target="_blank" class="btn green-jungle list-deals" data-deals="{{ $deals['id_deals']??null }}" style="float: right; margin-left: 5px;"><i class="fa fa-download"></i> Export </a>
<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="couponTable">
    <thead>
        <tr>
            <th>Coupon Code</th>
            <th>Status</th>
            <th>Used</th>
            <th>Available</th>
            <th>Max Used</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

{{-- <div id="static2" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" data-attention-animation="false">
    <div class="modal-body">
        <p> Would you like to continue with some arbitrary task? </p>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
        <button type="button" data-dismiss="modal" class="btn green">Continue Task</button>
    </div>
</div> --}}
{{-- <div id="responsive" class="modal fade" tabindex="-1" data-width="760"> --}}
<div class="modal fade" id="export-code-modal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Export Promo Code</h4>
            </div>
            <div class="modal-body row">
                <form action="{{url('promo-campaign/export-code')}}" method="post">
                	{{ csrf_field() }}
                	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="couponTable">
	                	<thead>
					        <tr>
					            <th>Last Generate</th>
					            <th>Status</th>
					            <th>action</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<td nowrap>{{date("d F Y", strtotime($result['export_date']))}}&nbsp;{{date("H:i", strtotime($result['export_date']))}}</td>
					    	<td nowrap>
					    		@if($result['export_status'] == 'Deleted')
		                            <span style="color: red">File has been deleted</span>
		                        @elseif($result['export_status'] == 'Running')
		                        	<span style="color: grey">File not ready</span>
		                        @elseif($result['export_status'] == 'Ready')
		                        	<span style="color: green">File ready</span>
		                        @else
		                        	<span style="color: grey">File not found</span>
		                        @endif
		                    </td>
					    	<td>
					    		<div class="col-md-12">
					    		@if($result['export_status'] == 'Running')
		                            <a class="btn btn-sm grey" href="{{ url()->current().'?modal=1#coupon' }}" onclick="location.reload()" data-toggle="tooltip" data-placement="top" title="Reload page"><i class="fa fa-refresh"></i></a>
		                        @elseif($result['export_status'] == 'Ready')
	                                <a class="btn btn-sm red" href="{{ url('promo-campaign/export-action/deleted', $result['id_promo_campaign']) }}" data-toggle="tooltip" data-placement="top" title="Delete file"><i class="fa fa-trash-o"></i></a>
	                                <a class="btn btn-sm green-jungle" href="{{ url('promo-campaign/export-action/download', $result['id_promo_campaign']) }}" data-toggle="tooltip" data-placement="top" title="Download file"><i class="fa fa-download"></i></a>
		                        @endif

		                        @if(!empty($result['export_url']) && $result['export_status'] != 'Deleted')
		                        	<button type="submit" class="btn blue btn-sm" value="1" name="export_promo_code" data-toggle="tooltip" data-placement="top" title="Update file"><i class="fa fa-file"></i></button>
		                        @else
		                        	<button type="submit" class="btn blue btn-sm" value="1" name="export_promo_code" data-toggle="tooltip" data-placement="top" title="Generate File"><i class="fa fa-file-o"></i></button>
		                        @endif
		                        </div>
					    	</td>
					    </tbody>
					</table>				    
				    <input type="hidden" value="{{ $result['id_promo_campaign']??'' }}"  name="id_promo_campaign" />
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('more_script2')
@if (($launch_modal??false) == 1)
	<script type="text/javascript">
		console.log(1);
	    $(window).on('load',function(){
	        $('#export-code-modal').modal('show');
	    });
	</script>
@endif
<script type="text/javascript">
	$('[data-toggle="tooltip"]').tooltip()
    $('#couponTable').DataTable( {
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered from _MAX_ total entries)",
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
            dom: "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'><'col-md-6 col-sm-12'>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            searching   : true,
            serverSide  : true,
            ajax: {
                url: '{{url('promo-campaign/detail-coupon/'.$result['id_promo_campaign'].'?coupon=true')}}',
                type: 'GET'
            }
        } )
</script>
@yield('child-script2')
@endsection