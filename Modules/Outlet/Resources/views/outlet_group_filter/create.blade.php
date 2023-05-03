<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    	.select2-container .select2-search__field {
		    width: 100% !important;
		}
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>

    <script>
        function changeFilterType(value) {
            $('#select-outlet').val('').trigger('change');
            if(value == 'Outlets'){
                document.getElementById('div-listoutlet').style.display = 'block';
                document.getElementById('div-conditions').style.display = 'none';
                $("#select-outlet").prop('required', true);
            }else if(value == 'Conditions'){
                document.getElementById('div-listoutlet').style.display = 'none';
                document.getElementById('div-conditions').style.display = 'block';
                $("#select-outlet").prop('required', false);
            }
        }

        $(document).ready(function() {
	        $("#select-outlet").select2({
	        	"closeOnSelect": false,
	        	width: '100%'
	        }).on('change', function(evt) {
	        	var $container = $(this).data("select2").$container.find(".select2-selection__rendered");
	        	var $results = $(".select2-dropdown--below");
	        	$results.position({
	        		my: "top",
	        		at: "bottom",
	        		of: $container
	        	});
	        })
	        .on('select2:selecting select2:unselecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
	        .on('select2:select select2:unselect', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
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
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('outlet-group-filter/store')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Outlet Group Filter Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama untuk group filter" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="outlet_group_name" value="{{ old('outlet_group_name') }}" placeholder="Outlet Group Filter Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Filter Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah outlet group mau menggunakan filter berdasarkan list outlet yang ada atau kondisi tertentu" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="outlet_group_type" class="md-radiobtn filterType" value="Outlets" onclick="changeFilterType(this.value)" required>
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> List Outlet</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="outlet_group_type" class="md-radiobtn filterType" value="Conditions" onclick="changeFilterType(this.value)" required>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Conditions</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div-listoutlet" style="display: none">
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-4 control-label">
                                    List Outlet
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih Outlet sesuai kebutuhan" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <select  class="form-control select2 select2-multiple-product"  multiple data-placeholder="Outlets"  id="select-outlet" name="outlets[]">
                                    <option value="all">All Outlet</option>
                                    @foreach($outlets as $outlet)
                                        <option value="{{$outlet['id_outlet']}}">{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="div-conditions" style="display: none">
                        <br>
                        <div style="text-align: center"><h3>List Filter</h3></div>
                        <hr style="border-top: 2px dashed;">
                        <div>
                            @include('outlet::outlet_group_filter.filter-detail')
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection