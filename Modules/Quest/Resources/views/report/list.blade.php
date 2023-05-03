@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	table th{
    		text-align: center;
    	}
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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

    <?php
    $date_start = '';
    $date_end = '';
    if(Session::has('filter-report-quest')){
        $search_param = Session::get('filter-report-quest');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('quest::report.filter')
    </form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ $title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
        	<div style="overflow-x: scroll;">
	            <table class="table table-striped table-bordered table-hover" id="tableReport">
	                <thead>
	                <tr>
	                    <th nowrap>Quest Name</th>
	                    <th nowrap>Quest Description</th>
	                    <th nowrap>Date Start</th>
	                    <th nowrap>Date End</th>
	                    <th nowrap>Status</th>
	                    <th nowrap>Benefit Type</th>
	                    <th nowrap>Total User</th>
	                    <th nowrap>Action</th>
	                </tr>
	                </thead>
	                <tbody>
	                @if(!empty($data))
	                    @foreach($data as $val)
	                        <tr>
	                            <td>{{$val['name']}}</td>
	                            <td><?php echo $val['short_description']?></td>
	                            <td nowrap>@if(!is_null($val['date_start'])){{date('d M Y H:i', strtotime($val['date_start']))}}@else Not Set @endif</td>
	                            <td nowrap>@if(!is_null($val['date_end'])){{date('d M Y H:i', strtotime($val['date_end']))}}@else Not Set @endif</td>
	                            <td nowrap class="text-center">
                                    @if ($val['status'] == 'Stopped')
                                        <span class="sale-num sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Stopped</span>
	                            	@elseif ($val['status'] == 'Started')
	                            		<span class="sale-num sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
	                            	@elseif ($val['status'] == 'Ended')
	                            		<span class="sale-num sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Ended</span>
	                            	@else
	                            		<span class="sale-num sbold badge badge-pill secondary" style="font-size: 14px!important;height: 25px!important;padding: 5px 12px;color: #fff;">Not Started</span>
	                            	@endif
	                            </td>
	                            <td nowrap>{{$val['benefit_type']}}</td>
	                            <td nowrap>{{number_format($val['total_user'])}}</td>
	                            <td nowrap>
	                                <a class="btn btn-xs blue dropdown-toggle" target="_blank" href="{{url('quest/report/detail/'.$val['id_quest'])}}"> Detail </a>
	                            </td>
	                        </tr>
	                    @endforeach
	                @else
	                    <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
	                @endif
	                </tbody>
	            </table>
	        </div>
            <br>
            @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
                Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
            @endif
            @if ($dataPaginator)
                {{ $dataPaginator->links() }}
            @endif
        </div>
    </div>



@endsection
