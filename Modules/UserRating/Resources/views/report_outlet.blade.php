<?php
use App\Lib\MyHelper;
    $grantedFeature = session('granted_features');
$configs = session('configs');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />

	<style type="text/css">
    .show{
        display:block !important;
    }
    </style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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

	if(Session::has('filter-list-user-rating-outlet')){
		$search_param = Session::get('filter-list-user-rating-outlet');

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
		@include('userrating::filter_report_outlet')
	</form>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Outlet</span>
            </div>
        </div>
		<div class="portlet-body form">
			<div style="white-space: nowrap;">
				<table class="table table-striped table-bordered table-hover dt-responsive tablesData" id="tablesDataBusinessDevelopment" width="100%">
					<thead>
					<tr>
						<th> Outlet Code </th>
						<th> Outlet Name </th>
						<th> Rating </th>
						<th> Action </th>
					</tr>
					</thead>
					<tbody>
					@if (!empty($data))
						@foreach($data as $key => $value)
							<tr>
								<td>{{$value['outlet_code']}}</td>
								<td>{{ $value['outlet_name'] }}</td>
								<td>
									<?php
										$html = '';
										$start = '';
										for ($i=1;$i<=$value['outlet_total_rating'];$i++){
											$start .= '<i class="fa fa-star" style="color: #fcba03"></i>';
										}

										if(!empty($start)){
											$html .= '<b>'.$value['outlet_total_rating'].'/5</b> '.$start;
										}else{
											$html = '<b>0/5</b>';
										}
										echo $html;
									?>
								<td><a class="btn green btn-sm" href="{{url('user-rating/report/outlet/detail').'/'. $value['id_outlet']}}">Detail</a></td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div>
		<br>
		@if ($dataPaginator)
			{{ $dataPaginator->fragment('participate')->links() }}
		@endif
    </div>

@endsection