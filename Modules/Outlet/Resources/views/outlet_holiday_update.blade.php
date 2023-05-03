<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>

    <script>
         $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        var number = 1;
        // display date holidays
        $(document).ready(function(){
            @foreach($holiday['date_holidays'] as $q => $date_holiday)
                @if($q == 0)
                    $('#new_date').append(
                        '<div class="col-md-12" style="margin-bottom:15px; padding-left:0; padding-right:0" id="date_'+number+'">'+
                            '<input type="text" class="form-control datepicker" name="date_holiday[]" placeholder="Holiday Date" value="{{date("d-M-Y", strtotime($date_holiday["date"]))}}" required>'+
                        '</div>'
                    )
                @else
                    $('#new_date').append(
                        '<div class="input-group" style="margin-bottom:15px" id="date_'+number+'">'+
                            '<input type="text" class="form-control datepicker" name="date_holiday[]" placeholder="Holiday Date" value="{{date("d-M-Y", strtotime($date_holiday["date"]))}}" required>'+
                            '<span class="input-group-btn">'+
                                '<a href="javascript:;" class="btn btn-danger btn_delete_date" data-id="'+number+'">'+
                                    '<i class="fa fa-close"></i>'+
                                '</a>'+
                            '</span>'+
                        '</div>'
                    )
                @endif
                number++;
            @endforeach
            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'todayHighlight' : true,
                'autoclose' : true
            });

            //outlet
            var selected = [];
            @foreach($holiday['outlets'] as $ou)
                selected[selected.length]="{{$ou['id_outlet']}}";
            @endforeach
            $('#outlet').val(selected);
            $('#outlet').trigger('change');
        })

        // add new date holiday
        $('#btn_new_date').click(function(){
            $('#new_date').append(
                '<div class="input-group" style="margin-bottom:15px" id="date_'+number+'">'+
                    '<input type="text" class="form-control datepicker" name="date_holiday[]" placeholder="Holiday Date" required>'+
                        '<span class="input-group-btn">'+
                            '<a href="javascript:;" class="btn btn-danger btn_delete_date" data-id="'+number+'">'+
                                '<i class="fa fa-close"></i>'+
                            '</a>'+
                    '</span>'+
                '</div>'
            )
            number++;
            $('.datepicker').datepicker({
                'format' : 'd-M-yyyy',
                'todayHighlight' : true,
                'autoclose' : true
            });
        })

        // delete date holiday
        $('#new_date').on('click', '.btn_delete_date', function(){

            id = $(this).attr('data-id')
            $('#date_'+id).remove();
        })

        $('#select_all').click(function(){
            if($(this).is(":checked")){
                var selected = [];
                $('#outlet').find("option").each(function(i,e){
                    selected[selected.length]=$(e).attr("value");
                });
                $('#outlet').val(selected);
                $('#outlet').trigger('change');
            }else{
                $('#outlet').val("");
                $('#outlet').trigger('change');
            }
        })
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
                <span class="caption-subject font-blue sbold uppercase">Update Outlet Holiday</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('outlet/holiday/'.$holiday['id_holiday']) }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Name
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul/ nama hari libur" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="holiday_name" value="{{ $holiday['holiday_name'] }}" placeholder="Holiday Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox1" name="yearly" class="md-checkboxbtn" @if($holiday['yearly'] == 1) checked @endif>
                                <label for="checkbox1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Yearly </label>
                                    <i class="fa fa-question-circle tooltips" data-original-title="jika dicentang maka akan di set hari libur di tanggal yang sama setiap tahun" data-container="body"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Date
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal libur" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div id="new_date"></div>
                            <button type="button" class="btn btn-primary" id="btn_new_date">
                                <i class="fa fa-plus"></i>
                                Add New Date
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Outlet
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang akan diberlakukan hari libur tersebut" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="select_all" class="md-checkboxbtn" >
                                    <label for="select_all">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>  Select All Outlet </label>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Centang jika hari libur berlaku untuk semua outlet" data-container="body"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"></label>
                        <div class="col-md-9">
                            <select id="outlet" class="form-control select2-multiple" multiple data-placeholder="Select Outlet" name="id_outlet[]" required>
                                <optgroup label="Outlet List">
                                    @if (!empty($outlet))
                                        @foreach($outlet as $suw)
                                            <option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            @if(MyHelper::hasAccess([41], $grantedFeature))
                                <button type="submit" class="btn green">Submit</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection