<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    date_default_timezone_set('Asia/Jakarta');
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main-closed')
@include('promocampaign::report')
@include('promocampaign::coupon')
@include('promocampaign::template.promo-extend-period', ['promo_source' => 'promo_campaign'])
@include('promocampaign::template.promo-description', ['promo_source' => 'promo_campaign'])
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script>
	
	$('.sample_1, .sample_5, .sample_6, .sample_7').dataTable({
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
                buttons: [],
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
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

    $('#sample_2').dataTable({
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
                buttons: [],
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

    $('#sample_3').dataTable({
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
                buttons: [],
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

        $('#sample_4').dataTable({
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
                buttons: [],
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
        
	$('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success submit', btnCancelClass: 'btn btn-sm btn-danger'});

	$(document).on('click', '.submit', function() {
		if ($('#pinUser').val() == ''){
			$('#pinUser').focus();
		}else{
			$('#formSuspend').submit();
		}
	})

	$(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });
	</script>
    @yield('more_script')
    @yield('more_script2')
    @yield('extend-period-script')
    @yield('promo-description-script')
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
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
</div>
@include('layouts.notifications')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row" style="margin-top:20px">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="3">
                                	@if ( !empty($result['total_coupon']) )
                                		{{ number_format(($result['total_coupon']??0)-($result['used_code']??0)) }}
                                	@elseif( $result['total_coupon'] === 0 || $result['total_coupon'] === '0' )
                                		{{'unlimited'}}
                                	@endif
                                </span>
                            </div>
                            <div class="desc"> Available </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="20">{{ number_format($result['used_code']??0) }}</span>
                            </div>
                            <div class="desc"> Total Used </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$result['total_coupon']??''}}">
                                	@if ( !empty($result['total_coupon']) )
                                		{{ number_format($result['total_coupon']??0) }}
                                	@elseif( isset($result['total_coupon']) )
                                		{{'unlimited'}}
                                	@endif
                                </span>
                            </div>
                            <div class="desc"> Total {{ isset($result['total_coupon']) ? 'Coupon' : '' }} </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="tabbable-line tabbable-full-width">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#promocampaign" data-toggle="tab"> Promo Campaign </a>
                    </li>
                    <li class="">
                        <a href="#detail-information" data-toggle="tab"> Detail Information </a>
                    </li>
                    <li class="">
                        <a href="#promo-description" data-toggle="tab"> Promo Description </a>
                    </li>
            		@yield('extend-period-form')
                </ul>
            </div>

            <div class="tab-content" style="margin-top:20px">
                <div class="tab-pane active" id="promocampaign">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title"> 
                                <span class="caption font-blue sbold uppercase">{{$result['campaign_name']}}</span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="sale-info"> Status 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                @if( empty($result['step_complete']) )
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span>
                                                @elseif(strtotime($result['date_end']) < strtotime($datenow))
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
                                                @elseif(strtotime($result['date_start']) <= strtotime($datenow))
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                                                @elseif(strtotime($result['date_start']) > strtotime($datenow))
                                                    <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                                                @endif
                                            </li>
                                            <li>
                                                <span class="sale-info"> Creator 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="font-black sale-num sbold">
                                                    {{$result['user']['name']}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Level
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$result['user']['level']}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Promo Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$result['promo_type']}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Code Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$result['code_type']??''}}
                                                </span>
                                            </li>
                                            @if($result['code_type'] == "Single")
                                            <li>
                                                <span class="sale-info"> Promo Code
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    <b>{{ $result['promo_campaign_promo_codes'][0]['promo_code']??'' }}</b>
                                                </span>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                	<div class="row static-info">
                                        <div class="col-md-4 name">Brand</div>
			                            <div class="col-md-8 value">: 
			                            	@if (!empty($result['id_brand']))
			                            		{{ $result['brand']['name_brand'] }}
			                            	@else
				                            	@php
				                            		foreach ($result['brands'] as $key => $value) {
					                            		if ($key == 0) {
					                            			$comma = '';
					                            		}else{
					                            			$comma = ', ';
					                            		}
					                            		echo $comma.$value['name_brand'];
				                            		}
				                            	@endphp
			                            	@endif
				                        </div>
                                    </div>
                                    <div class="row static-info">
	                                    <div class="col-md-4 name">Brand Rule</div>
	                                    <div class="col-md-8 value">: 
	                                        {{ $result['brand_rule'] && $result['brand_rule'] == 'and' ? 'All selected brands' : 'One of the selected brands' }}
	                                    </div>
	                                </div>
	                                <div class="row static-info">
					                    <div class="col-md-4 name">Charged Central</div>
					                    <div class="col-md-8 value">: {{$result['charged_central']}} %</div>
					                </div>
					                <div class="row static-info">
					                    <div class="col-md-4 name">Charged Outlet</div>
					                    <div class="col-md-8 value">: {{$result['charged_outlet']}} %</div>
					                </div>
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Tag</div>
                                        @if (count($result['promo_campaign_have_tags']) > 1)
                                            @php
                                                $tagID = [];
                                                for ($i = 0; $i < count($result['promo_campaign_have_tags']); $i++) {
                                                    $tagID[] = $result['promo_campaign_have_tags'][$i]['promo_campaign_tag']['tag_name'];
                                                }
                                            @endphp
                                            <div class="col-md-8 value">: {{implode(', ',$tagID)}}</div>
                                        @else
                                            <div class="col-md-8 value">: No Tags</div>
                                        @endif
                                    </div>
                                    @if(isset($result['date_start']))
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Start Date</div>
                                        <div class="col-md-8 value">: {{date("d F Y", strtotime($result['date_start']))}}&nbsp;{{date("H:i", strtotime($result['date_start']))}}</div>
                                    </div>
                                    @endif
                                    @if(isset($result['date_end']))
                                    <div class="row static-info">
                                        <div class="col-md-4 name">End Date</div>
                                        <div class="col-md-8 value">: {{date("d F Y", strtotime($result['date_end']))}}&nbsp;{{date("H:i", strtotime($result['date_end']))}}</div>
                                    </div>
                                    @endif
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Created</div>
                                        <div class="col-md-8 value">: {{date("d F Y", strtotime($result['created_at']))}}&nbsp;{{date("H:i", strtotime($result['created_at']))}}</div>
                                    </div>
                                    @if( ($result['code_type'])=='Multiple' )
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Prefix Code</div>
                                        <div class="col-md-8 value">: {{ $result['prefix_code']??'' }}</div>
                                    </div>
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Number Last Code</div>
                                        <div class="col-md-8 value">: {{ $result['number_last_code']??'' }}</div>
                                    </div>
                                    @endif
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Total Coupon</div>
                                        <div class="col-md-8 value">: {{ !empty($result['total_coupon']) ? number_format($result['total_coupon']).' Coupons' : (isset($result['total_coupon']) ? 'unlimited' : '') }}</div>
                                    </div>
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Used Coupon</div>
                                        <div class="col-md-8 value">: {{ number_format($result['used_code']??0).' Coupons' }}</div>
                                    </div>
                                    @if ( $result['code_type'] == 'Single' )
	                                    <div class="row static-info">
	                                        <div class="col-md-4 name">Limit Usage</div>
	                                        <div class="col-md-8 value">: {{ ($result['limitation_usage'] ?? false) ? number_format($result['limitation_usage']).' Times usage' : 'Unlimited' }}</div>
	                                    </div>
	                                @else
	                                	<div class="row static-info">
	                                        <div class="col-md-4 name">User Limit</div>
	                                        <div class="col-md-8 value">: {{ $result['user_limit']??false ? number_format($result['user_limit']).' Different code' : 'Unlimited' }}</div>
	                                    </div>
	                                    <div class="row static-info">
	                                        <div class="col-md-4 name">Code Limit</div>
	                                        <div class="col-md-8 value">: {{ $result['code_limit']??false ? number_format($result['code_limit']).' Times usage' : 'Unlimited' }}</div>
	                                    </div>
                                    @endif
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Image</div>
                                        <div class="col-md-8 value">
                                            <span style="float: left;margin-right: 5px">:</span>
                                            <div><img src="{{ $result['url_promo_image'] ?? null }}" style="width: 100px"></div>
                                        </div>
                                    </div>
                                    <div class="row static-info">
                                        <div class="col-md-4 name">Image Detail</div>
                                        <div class="col-md-8 value">
                                            <span style="float: left;margin-right: 5px">:</span>
                                            <div><img src="{{ $result['url_promo_image_detail'] ?? null }}" style="width: 225px"></div>
                                        </div>
                                    </div>

                                {{-- if promo campaign already used --}}
                                @if( (empty($result['promo_campaign_reports']) || empty($result['step_complete']) || session('level') == 'Super Admin' ) && MyHelper::hasAccess([203], $grantedFeature))
                                <div class="row static-info">
                                    <div class="col-md-11 value">
                                        <a class="btn blue" href="{{ url('/')}}/promo-campaign/step1/{{$result['id_promo_campaign']}}">Edit Detail</a>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 profile-info">
                            <div class="profile-info portlet light bordered">
                                <div class="portlet-title"> 
                                <span class="caption font-blue sbold uppercase">{{ $result['promo_type']??'' }} Rules </span>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-4 name">User Target</div>
                                    <div class="col-md-8 value">: {{ $result['user_type']??'No User Target' }} </div>
                                </div>
                                @if($result['user_type'] == 'Specific user')
                                <div class="row static-info">
                                    <div class="col-md-4 name">Specific user</div>
                                    <div class="col-md-8 value">: {{ $result['specific_user']??'No Specific Target' }} </div>
                                </div>
                                @endif
                                <div class="row static-info">
                                	@php
				                		$outlet_type = null;
				                		if ( !empty($result['is_all_outlet']) ) {
				                			$outlet_type ='All outlet';
				                		} elseif ( !empty($result['outlets']) ){
				                			$outlet_type = 'Selected outlet';
				                		} elseif ( !empty($result['outlet_groups']) ){
				                			$outlet_type = 'Outlet group filter';
				                		}

				                	@endphp
				                    <div class="col-md-4 name">Outlet Target</div>
				                    <div class="col-md-8 value">: <a href="{{ url('#outlet') }}" target="_blank"> {{ $outlet_type }} </a></div>
                                </div>
                                @if ( !empty($result['product_rule'])
	                                	&& ( (isset($result['promo_campaign_product_discount_rules']['is_all_product']) 
	                                			&& $result['promo_campaign_product_discount_rules']['is_all_product'] == 0)
		                                	|| !empty($result['promo_campaign_tier_discount_rules'])
		                                	|| !empty($result['promo_campaign_buyxgety_rules'])
		                                	|| (isset($result['promo_campaign_discount_bill_rules']['is_all_product']) 
	                                			&& $result['promo_campaign_discount_bill_rules']['is_all_product'] == 0)
	                                	)
                                	)
                                @php
                                	$promo_product = $result['promo_campaign_product_discount'] ?: $result['promo_campaign_tier_discount_product'] ?: $result['promo_campaign_buyxgety_product_requirement'] ?: $result['promo_campaign_discount_bill_products'] ?: [];
                                	$promo_product_simple = [];
                                	foreach ($promo_product as $value) {
                                		$variant = [];
										foreach ($value['product_variant_pivot'] as $val) {
											$variant[] = $val['product_variant']['product_variant_name'];
										}
										$variant = implode(', ',$variant);
                                		$promo_product_simple[] = [
                                			'brand' => $value['brand']['name_brand']??$result['brand']['name_brand']??'',
                                			'product_code' => $value['product']['product_code'],
                                			'product_name' => $value['product']['product_name'],
                                			// 'product_name' => '<a href="'.url('product/detail/'.$value['product']['product_code']??'').'" target="_blank">'.($value['product']['product_name']??'').'</a>',
                                			'variant' => $variant
                                		];
                                	}
                                @endphp
                                <div class="row static-info">
                                    <div class="col-md-4 name">Product Rule</div>
                                    <div class="col-md-8 value">: 
                                        {{ $result['product_rule'] && $result['product_rule'] == 'and' ? 'All items must be present' : 'One of the items must exist' }}
                                    </div>
                                </div>
                                @endif
                                @include('promocampaign::template.promo-global-requirement-detail', ['promo_source' => 'promo_campaign'])
                                @if ( !empty($result['step_complete']) )
                                	{{-- Product Discount --}}
                                    @if (isset($result['promo_campaign_product_discount_rules']) && $result['promo_campaign_product_discount_rules'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Product Requirement</div>
                                            <div class="col-md-8 value">: 
                                                @if ($result['promo_campaign_product_discount_rules'] != null)
                                                    @if ($result['promo_campaign_product_discount_rules']['is_all_product'] == '1')
                                                        All Product
                                                    @elseif ($result['promo_campaign_product_discount_rules']['is_all_product'] == '0')
                                                        Selected Product
                                                    @else
                                                        No Product Requirement
                                                    @endif
                                                @elseif ($result['promo_campaign_tier_discount_rules'] != null)
                                                    {{$result['promo_campaign_tier_discount_product']['product']['product_name']}}
                                                @elseif ($result['promo_campaign_buyxgety_rules'] != null)
                                                    {{$result['promo_campaign_buyxgety_product_requirement']['product']['product_name']??''}}
                                                @endif
                                            </div>
                                        </div>
                                        @if ($result['promo_campaign_product_discount_rules'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Discount</div>
                                            <div class="col-md-8 value">: 
                                                @if ($result['promo_campaign_product_discount_rules']['discount_type'] == 'Percent')
                                                    {{$result['promo_campaign_product_discount_rules']['discount_value']}}% (max : {{ !empty($result['promo_campaign_product_discount_rules']['max_percent_discount']) ? 'IDR '.number_format($result['promo_campaign_product_discount_rules']['max_percent_discount']) : '-' }} )
                                                @elseif ($result['promo_campaign_product_discount_rules']['discount_type'] == 'Nominal')
                                                    {{ 'IDR '.number_format($result['promo_campaign_product_discount_rules']['discount_value']) }}
                                                @else
                                                    No discount
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Min Basket Size</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($result['min_basket_size']) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Max Product</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['promo_campaign_product_discount_rules']['max_product'] == 0) ? 'no limit' : number_format($result['promo_campaign_product_discount_rules']['max_product']).' item' }}
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mt-comments">
                                            @if ($result['promo_campaign_product_discount_rules'] != null)
                                                @if(isset($result['promo_campaign_product_discount_rules']['is_all_product']) && $result['promo_campaign_product_discount_rules']['is_all_product'] == '0')
                                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                                        <thead>
                                                            <tr>
                                                                <th>Brand</th>
                                                                <th>Code</th>
                                                                <th>Name</th>
                                                                <th>Variant</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($promo_product_simple as $res)
                                                                <tr>
                                                                    <td>{{ $res['brand'] }}</td>
                                                                    <td>{{ $res['product_code'] }}</td>
                                                                    <td><a href="{{ url('product/detail/'.$res['product_code']??'') }}" target="_blank">{{ $res['product_name']??'' }}</a></td>
                                                                    <td>{{ $res['variant'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endif
                                        </div>
                                    {{-- Tier Discount --}}
                                    @elseif (isset($result['promo_campaign_tier_discount_rules']) && $result['promo_campaign_tier_discount_rules'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Min Basket Size</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($result['min_basket_size']) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Product Requirement</div>
                                            <div class="col-md-8 value">: 
                                                @if ( ($result['promo_campaign_tier_discount_rules'][0]['is_all_product'] ?? false) == '1' )
                                                    All Product
                                                @elseif ( ($result['promo_campaign_tier_discount_rules'][0]['is_all_product'] ?? false) == '0' )
                                                    Selected Product
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-comments">
                                            @if(!empty($result['promo_campaign_tier_discount_product']))
                                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                                    <thead>
                                                        <tr>
                                                            <th  class="col-md-3">Brand</th>
                                                            <th  class="col-md-3">Code</th>
                                                            <th  class="col-md-6">Name</th>
                                                            <th  class="col-md-6">Variant</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($promo_product_simple as $res)
                                                            <tr>
                                                                <td>{{ $res['brand'] }}</td>
                                                                <td>{{ $res['product_code'] }}</td>
                                                                <td><a href="{{ url('product/detail/'.$res['product_code']??'') }}" target="_blank">{{ $res['product_name']??'' }}</a></td>
                                                                <td>{{ $res['variant'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Promo Rule</div>
                                            <div class="col-md-8 value">: 
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_6">
                                            <thead>
                                                <tr>
                                                    <th>Min Qty</th>
                                                    <th>Max Qty</th>
                                                    <th>{{ ($result['promo_campaign_tier_discount_rules'][0]['discount_type']??'').' Discount' }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($result['promo_campaign_tier_discount_rules'] as $res)
                                                    <tr>
                                                        <td>{{ number_format($res['min_qty']) }}</td>
                                                        <td>{{ number_format($res['max_qty']) }}</td>
                                                        <td>
                                                        	@if ($res['discount_type'] == 'Percent')
	                                                        	{{ ( $res['discount_value'].'%' ) }} (max : {{ !empty($res['max_percent_discount']) ? 'IDR '.number_format($res['max_percent_discount']) : '-' }})
	                                                        @else
	                                                        	{{ 'IDR '.number_format($res['discount_value']) }}
	                                                        @endif
	                                                    </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    {{-- Buy x Get Y Discount --}}
                                    @elseif (isset($result['promo_campaign_buyxgety_rules']) && $result['promo_campaign_buyxgety_rules'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Min Basket Size</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($result['min_basket_size']) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Product Requirement</div>
                                            <div class="col-md-8 value">: 
                                                @if ( ($result['promo_campaign_buyxgety_rules'][0]['is_all_product'] ?? false) == '1' )
                                                    All Product
                                                @elseif ( ($result['promo_campaign_buyxgety_rules'][0]['is_all_product'] ?? false) == '0' )
                                                    Selected Product
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-comments">
                                            @if(!empty($result['promo_campaign_buyxgety_product_requirement']))
                                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-md-3">Brand</th>
                                                            <th class="col-md-3">Code</th>
                                                            <th class="col-md-6">Name</th>
                                                            <th class="col-md-6">Variant</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	@foreach($promo_product_simple as $res)
                                                            <tr>
                                                                <td>{{ $res['brand'] }}</td>
                                                                <td>{{ $res['product_code'] }}</td>
                                                                <td><a href="{{ url('product/detail/'.$res['product_code']??'') }}" target="_blank">{{ $res['product_name']??'' }}</a></td>
                                                                <td>{{ $res['variant'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Promo Rule</div>
                                            <div class="col-md-8 value">: 
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_7">
                                            <thead>
                                                <tr>
                                                    <th>Min Qty</th>
                                                    <th>Max Qty</th>
                                                    <th>Product Benefit</th>
                                                    <th>Product Benefit Variant</th>
                                                    <th>Benefit Qty</th>
                                                    <th>Benefit Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($result['promo_campaign_buyxgety_rules'] as $res)
                                                @php
                                                	$variant = [];
													foreach ($res['product_variant_pivot'] as $val) {
														$variant[] = $val['product_variant']['product_variant_name'];
													}
													foreach ($res['promo_campaign_buyxgety_product_modifiers'] as $mod) {
														$variant[] = $mod['modifier']['text_detail_trx'];
													}
													$variant = implode(', ',$variant);
                                                @endphp
                                                    <tr>
                                                        <td>{{ $res['min_qty_requirement'] }}</td>
                                                        <td>{{ $res['max_qty_requirement'] }}</td>
                                                        <td><a href="{{ url('product/detail/'.$res['product']['product_code']??'') }}" target="_blank">{{ $res['brand']['name_brand'].' - '.$res['product']['product_code'].' - '.$res['product']['product_name'] }}</a></td>
                                                        <td>{{ $variant }}</td>
                                                        <td>{{ $res['benefit_qty'] }}</td>
                                                        <td>
                                                        @if( ($res['discount_type']??false) == 'nominal' )
                                                        	{{'IDR '.number_format($res['discount_value'])}}
                                                        @elseif( ($res['discount_type']??false) == 'percent' )
                                                        	@if( ($res['discount_value']??false) == 100 )
                                                        		Free
                                                        	@else
                                                        		{{ ($res['discount_value']??false).'%' }} (max : {{ !empty($res['max_percent_discount']) ? 'IDR '.number_format($res['max_percent_discount']) : '-' }})
                                                        	@endif
                                                        @endif
                                                        </td>
                                                        <td>
                                                        {{ ( ($res['discount_percent']??'') == 100) ? 'Free' : ( ($res['discount_percent']??false) ? $res['discount_percent'].' %' : (($res['discount_nominal']??false) ? 'IDR '.number_format($res['discount_nominal']) : '' ) ) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    {{-- Bill Discount --}}
                                    @elseif (!empty($result['promo_campaign_discount_bill_rules'])) 
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Discount</div>
                                            <div class="col-md-8 value">: 
                                                @if ($result['promo_campaign_discount_bill_rules']['discount_type'] == 'Percent')
                                                    {{ $result['promo_campaign_discount_bill_rules']['discount_value'] }}% (max : {{ !empty($result['promo_campaign_discount_bill_rules']['max_percent_discount']) ? 'IDR '.number_format($result['promo_campaign_discount_bill_rules']['max_percent_discount']) : '-' }})
                                                @elseif ($result['promo_campaign_discount_bill_rules']['discount_type'] == 'Nominal')
                                                    {{ 'IDR '.number_format($result['promo_campaign_discount_bill_rules']['discount_value']) }}
                                                @else
                                                    No discount
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Min Basket Size</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($result['min_basket_size']) }}
                                            </div>
                                        </div>
                                        <div class="row static-info">
					                        <div class="col-md-4 name">Product Requirement</div>
					                        <div class="col-md-8 value">: 
					                        	@if ( ($result['promo_campaign_discount_bill_rules']['is_all_product'] ?? false) == '1' )
					                                All Product
					                            @elseif ( isset($result['promo_campaign_discount_bill_rules']['is_all_product']) && $result['promo_campaign_discount_bill_rules']['is_all_product'] == '0' )
					                                Selected Product
					                            @endif
					                        </div>
					                    </div>
                                        <div class="mt-comments">
                                            @if ($result['promo_campaign_discount_bill_rules'] != null)
                                                @if(isset($result['promo_campaign_discount_bill_rules']['is_all_product']) && $result['promo_campaign_discount_bill_rules']['is_all_product'] == '0')
                                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                                        <thead>
                                                            <tr>
                                                                <th>Brand</th>
                                                                <th>Code</th>
                                                                <th>Name</th>
                                                                <th>Variant</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($promo_product_simple as $res)
                                                                <tr>
                                                                	<td>{{ $res['brand'] }}</td>
	                                                                <td>{{ $res['product_code'] }}</td>
	                                                                <td><a href="{{ url('product/detail/'.$res['product_code']??'') }}" target="_blank">{{ $res['product_name']??'' }}</a></td>
	                                                                <td>{{ $res['variant'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endif
                                        </div>
                                    {{-- Delivery Discount --}}
                                    @elseif (!empty($result['promo_campaign_discount_delivery_rules'])) 
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Discount</div>
                                            <div class="col-md-8 value">: 
                                                @if ($result['promo_campaign_discount_delivery_rules']['discount_type'] == 'Percent')
                                                    {{ $result['promo_campaign_discount_delivery_rules']['discount_value'] }}% (max : {{ !empty($result['promo_campaign_discount_delivery_rules']['max_percent_discount']) ? 'IDR '.number_format($result['promo_campaign_discount_delivery_rules']['max_percent_discount']) : '-' }})
                                                @elseif ($result['promo_campaign_discount_delivery_rules']['discount_type'] == 'Nominal')
                                                    {{ 'IDR '.number_format($result['promo_campaign_discount_delivery_rules']['discount_value']) }}
                                                @else
                                                    No discount
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Min Basket Size</div>
                                            <div class="col-md-8 value">: 
                                                    {{ ($result['min_basket_size'] == 0) ? 'no min basket size' : 'IDR '.number_format($result['min_basket_size']) }}
                                            </div>
                                        </div>
                                    @endif
                                    {{-- if promo campaign already used --}}
                                    @if( (empty($result['promo_campaign_reports']) || empty($result['step_complete']) || session('level') == 'Super Admin') && MyHelper::hasAccess([203], $grantedFeature))
                                    <div class="row static-info">
                                        <div class="col-md-11 value">
                                            <a class="btn blue" href="{{ url('/')}}/promo-campaign/step2/{{$result['id_promo_campaign']}}">Edit Rule</a>
                                        </div>
                                    </div>
                                    @endif
                                @else
                                <span class="sale-num font-red sbold">
                                    No Promo Campaign Rules
                                </span>
                                @if(MyHelper::hasAccess([203], $grantedFeature))
                                <div class="row static-info">
                                    <div class="col-md-11 value">
                                        <a class="btn blue" href="{{ url('/')}}/promo-campaign/step2/{{$result['id_promo_campaign']}}">Create Rule</a>
                                    </div>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="tab-pane" id="detail-information">
                    <div class="col-md-12">
                        <div class="tabbable-line tabbable-full-width">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#report" data-toggle="tab"> Report </a>
                                </li>
                                @if ($result['code_type'] == 'Multiple')
                                <li>
                                    <a href="#coupon" data-toggle="tab"> Coupon </a>
                                </li>
                                @endif
                                @if (isset($result['is_all_outlet']) && $result['is_all_outlet'] == '0')
                                <li>
                                    <a href="#outlet" data-toggle="tab"> Outlet </a>
                                </li>
                                @endif
                                @if ( ($result['product_discount_rule']??false) != null)
                                    @if (isset($result['product_discount_rule']['is_all_product']) && $result['product_discount_rule']['is_all_product'] == '0')
                                    <li>
                                        <a href="#product" data-toggle="tab"> Product </a>
                                    </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                        <div class="tab-content" style="margin-top:20px">
                            <div class="tab-pane" id="coupon">
                                <!-- BEGIN: Comments -->
                                @if ($result['code_type'] == 'Multiple')
                                <div class="mt-comments">
                                    @yield('coupon')
                                </div>
                                @endif
                                <!-- END: Comments -->
                            </div>
                            <div class="tab-pane" id="outlet">
                                <!-- BEGIN: Comments -->
                                <div class="mt-comments">
                                    @if(isset($result['is_all_outlet']) && $result['is_all_outlet'] == '0')
                                    	@if ($result['outlet_groups'])
	                                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
	                                            <thead>
	                                                <tr>
									                    <th > Outlet Group Filter Name</th>
									                    <th> Filter Type </th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                            	@foreach($result['outlet_groups'] as $key => $res)
								                        <tr style="background-color: #fbfbfb;">
								                            <td > 
								                            	@if(MyHelper::hasAccess([295,297], $grantedFeature))
									                                <a class="" target="_blank" href="{{url('outlet-group-filter/detail', $res['id_outlet_group'])}}">{{ $res['outlet_group_name'] }}</a>
									                            @else
									                            	{{ $res['outlet_group_name'] }} 
									                            @endif
									                        </td>
								                            <td > {{ $res['outlet_group_type'] }} </td>
								                        </tr>
								                    @endforeach
	                                            </tbody>
	                                        </table>
	                                    @else
	                                    	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
	                                            <thead>
	                                                <tr>
	                                                    <th>Code</th>
	                                                    <th>Name</th>
	                                                    <th>Address</th>
	                                                    <th>Phone</th>
	                                                    <th>Email</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                @foreach($result['outlets'] as $res)
	                                                    <tr>
	                                                        <td>{{ $res['outlet_code'] }}</td>
	                                                        <td>{{ $res['outlet_name'] }}</td>
	                                                        <td>{{ $res['outlet_address'] }}</td>
	                                                        <td>{{ $res['outlet_phone'] }}</td>
	                                                        <td>{{ $res['outlet_email'] }}</td>
	                                                    </tr>
	                                                @endforeach
	                                            </tbody>
	                                        </table>
                                    	@endif
                                    @else
                                        This promo for all outlet
                                    @endif
                                </div>
                                <!-- END: Comments -->
                            </div>
                            <div class="tab-pane" id="product">
                                <!-- BEGIN: Comments -->
                                <div class="mt-comments">
                                    @if ($result['product_discount_rule']??'' != null)
                                        @if(isset($result['product_discount_rule']['is_all_product']) && $result['product_discount_rule']['is_all_product'] == '0')
                                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Code</th>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($result['product_discount'] as $res)
                                                        <tr>
                                                            <td>{{ $res['product']['product_category']['product_category_name'] }}</td>
                                                            <td>{{ $res['product']['product_code'] }}</td>
                                                            <td>{{ $res['product']['product_name'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            This promo for all product
                                        @endif
                                    @endif
                                </div>
                                <!-- END: Comments -->
                            </div>
                            <div class="tab-pane active" id="report">
                                @yield('report')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="promo-description">
                    @yield('promo-description')
                </div>
            </div>

        </div>


    </div>

    <div class="col-md-12">
    </div>

    
</div>

@endsection