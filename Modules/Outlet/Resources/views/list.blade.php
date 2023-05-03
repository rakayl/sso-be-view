<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                stateSave: true,
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
                order: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 20,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('outlet/delete') }}",
                data : "_token="+token+"&id_outlet="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Outlet has been deleted.");
                    }
                    else if(result == "fail"){
                        toastr.warning("Failed to delete outlet. Outlet has been used.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete outlet.");
                    }
                }
            });
        });

         $('#sample_1').on('draw.dt', function() {
            $('input[name="outlet_status"]').bootstrapSwitch();
        });

        $('#sample_1').on('switchChange.bootstrapSwitch', 'input[name="outlet_status"]', function(event, state) {
            var id     = $(this).data('id');
            var token  = "{{ csrf_token() }}";
            if(state == true){
                state = 'Active'
            }else{
                state = 'Inactive'
            }
            $.ajax({
                type : "POST",
                url : "{{ url('outlet/update/status') }}",
                data : "_token="+token+"&id_outlet="+id+"&outlet_status="+state,
                success : function(result) {
                    if (result.status == "success") {
                        document.getElementById('atr-'+id).innerHTML = state;
                        $('#sample_1').DataTable().rows().invalidate()
                            .draw();
                        toastr.info("Outlet status has been updated.");
                    }
                    else {
                        toastr.warning(result.messages);
                    }
                }
            });
        });

        var SweetAlert = function() {
        	return {
	        	init: function() {
			    	$(".sweetalert-delete").each(function() {
			    		var token  	= "{{ csrf_token() }}";
			    		let column 	= $(this).parents('tr');
			            let id     	= $(this).data('id');
			            let code 	= $(this).data('code');
			            let name    = $(this).data('name');
			            $(this).click(function() {
			                swal({
								title: code+" - "+name+"\n\nAre you sure want to delete this outlet?",
								text: "Your will not be able to recover this data!",
								type: "warning",
								showCancelButton: true,
								confirmButtonClass: "btn-danger",
								confirmButtonText: "Yes, delete it!",
								closeOnConfirm: false
							},
							function(){
								$.ajax({
					                type : "POST",
					                url : "{{ url('outlet/delete') }}",
					                data : "_token="+token+"&id_outlet="+id,
					                success : function(result) {
					                    if (result == "success") {
					                        $('#sample_1').DataTable().row(column).remove().draw();
											swal("Deleted!", "Outlet has been deleted.", "success")
											SweetAlert.init()
					                    }
					                    else if(result == "fail"){
											swal("Error!", "Failed to delete outlet. Outlet has been used.", "error")
					                    }
					                    else {
											swal("Error!", "Something went wrong. Failed to delete outlet.", "error")
					                    }
					                }
					            });
							});
			            })
			        })
		    	}
		    }
		}();

        jQuery(document).ready(function() {
		    SweetAlert.init()
		});
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
                <span class="caption-subject font-blue sbold uppercase">Outlet List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Code </th>
                        <th> Name </th>
                        @if(MyHelper::hasAccess([95], $configs))
                        <th> Brand </th>
                        @endif
                        <th> City </th>
                        <th> Status </th>
                        @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                            <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($outlet))
                        @foreach($outlet as $value)
                            <tr>
                                <td>{{ $value['outlet_code'] }}</td>
                                <td>{{ $value['outlet_name'] }}</td>
                                @if(MyHelper::hasAccess([95], $configs))
                                <td>
                                    @foreach ($value['brands'] as $item)
                                        {{$item['name_brand']}}
                                    @endforeach
                                </td>
                                @endif
                                @if (empty($value['city']))
                                    <td> - </td>
                                @else
                                    <td>{{ $value['city']['city_name'] }}</td>
                                @endif
                                <td>
                                    <input type="checkbox" name="outlet_status" @if($value['outlet_status'] == 'Active') checked @endif data-id="{{ $value['id_outlet'] }}" class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
                                    <p style="display: none" id="atr-{{$value['id_outlet']}}">{{$value['outlet_status']}}</p>
                                </td>
                                @if(MyHelper::hasAccess([25,27,28], $grantedFeature))
                                    <td style="width: 90px;">
                                        @if(MyHelper::hasAccess([28], $grantedFeature))
                                        	<a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $value['id_outlet'] }}" data-name="{{ $value['outlet_name'] }}" data-code="{{ $value['outlet_code'] }}"><i class="fa fa-trash-o"></i></a>
                                            {{-- commented because delete button replaced with sweetalert
                                            	<a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_outlet'] }}"><i class="fa fa-trash-o"></i></a> 
                                            --}}
                                        @endif
                                        @if(MyHelper::hasAccess([25,27], $grantedFeature))
                                            <a href="{{ url('outlet/detail') }}/{{ $value['outlet_code'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection