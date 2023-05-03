@extends('layouts.main')
@include('subscription::transaction-report-filter')
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.middle-center, .header-table th, .content-middle-center td {
            vertical-align: middle!important;
            text-align: center;
        }
        .content-middle-center td {
            white-space: nowrap;
        }
        .middle-left {
            vertical-align: middle!important;
            text-align: left;
        }
        .paginator-right {
            display: flex;
            justify-content: flex-end;
        }
    </style>
    @yield('filter-style')
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    </script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },
                emptyTable: "No data available in table",
                // info: "Showing _START_ to _END_ of _TOTAL_ entries",
                info: "Showing "+{{ $subsFrom }}+" to "+ {{ $subsUpTo }} +" of "+{{ $subsTotal }}+" entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ entries",
                search: "Search:",
                zeroRecords: "No matching records found"
            },
            buttons: [],
            order: [2, "asc"],
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            pageLength: 10,
            "searching": false,
            "paging": false,
            "ordering": false,
            dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('news/delete') }}",
                data : "_token="+token+"&id_news="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("News has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete news.");
                    }
                }
            });
        });

    </script>

    @yield('filter-script')

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

    @yield('filter')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Result</span>
            </div>
            <div class="actions">
                @if(isset($subs) && !empty($subs))
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1" target="_blank"><i class="fa fa-download"></i> Export</a>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
        	<div class="content-middle-center">
	            <table class="table table-striped table-bordered table-hover" id="sample_1">
	                <thead class="header-table">
	                    <tr>
	                        <th> Subscription Name </th>
	                        <th> Voucher Code </th>
	                        <th> User </th>
	                        <th> Subscription Price </th>
	                        <th> Bought at </th>
	                        <th> Expired at </th>
	                        @if ($report_type == 'transaction')
	                        	<th> Used at </th>
		                        <th> Receipt Number </th>
		                        <th> Transaction Grandtotal </th>
		                        <th> Outlet </th>
		                        <th> Subscription Nominal </th>
		                        {{-- <th> Charged Central </th>
		                        <th> Charged Outlet </th> --}}
	                        @endif
	                    </tr>
	                </thead>
	                <tbody>
	                    @if (!empty($subs))
	                        @foreach($subs as $val)
	                        	@php
	                        		$subs_price = 'Free';
	                        		if( !empty($val['subscription_price_point']) ){
	                        			$subs_price = number_format($val['subscription_price_point']).' Point';
	                        		}elseif( !empty($val['subscription_price_cash']) ){
	                        			$subs_price = 'IDR '.number_format($val['subscription_price_cash']);
	                        		}
	                        	@endphp
	                            <tr>
	                                <td>
	                                	<a href="{{ $val['redirect_subs'] }}" target=”_blank”>{{ $val['subscription_title'] }}</a>
	                                </td>
	                                <td>{{ $val['voucher_code'] }}</td>
	                                <td>
	                                	<a href="{{ $val['redirect_user'] }}" target=”_blank”>{{ $val['user'] }}</a>
	                                </td>
	                                <td>{{ $subs_price }}</td>
	                                <td>{{ !empty($val['bought_at']) ? date('d-M-y', strtotime($val['bought_at'])) : '-' }}</td>
	                                <td>{{ !empty($val['subscription_expired_at']) ? date('d-M-y', strtotime($val['subscription_expired_at'])) : '-' }}</td>
	                                @if ($report_type == 'transaction')
		                                <td>{{ !empty($val['used_at']) ? date('d-M-y', strtotime($val['used_at'])) : '-' }}</td>
		                                <td>
		                                	<a href="{{ $val['redirect_trx'] }}" target=”_blank”>{{ $val['transaction_receipt_number'] }}</a>
		                                </td>
		                                <td>{{ !empty($val['transaction_grandtotal']) ? 'IDR '.number_format($val['transaction_grandtotal']) : '' }}</td>
		                                <td>{{ $val['outlet'] }}</td>
		                                <td>{{ !empty($val['subscription_nominal']) ? 'IDR '.number_format($val['subscription_nominal']) : '' }}</td>
		                                {{-- <td>{{ !empty($val['charged_central']) ? 'IDR '.number_format($val['charged_central']) : '' }}</td>
		                                <td>{{ !empty($val['charged_outlet']) ? 'IDR '.number_format($val['charged_outlet']) : '' }}</td> --}}
	                                @endif
	                            </tr>
	                        @endforeach
	                    @endif
	                </tbody>
	            </table>
        	</div>
        	<div class="paginator-right">
	            @if ($subsPaginator)
	                {{ $subsPaginator->links() }}
	            @endif
            </div>
        </div>
    </div>
@endsection