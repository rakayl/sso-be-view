<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
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

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('outlet/delete/holiday') }}",
                data : "_token="+token+"&id_holiday="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Outlet holiday has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete outlet.");
                    }
                }
            });
        });
    </script>
    <script>
         $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        var number = 1;
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
        $(document).on('click', '.btn_delete_date', function(){
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
    @if(MyHelper::hasAccess([36], $grantedFeature))
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
                <span class="caption-subject font-blue sbold uppercase">New Outlet Holiday</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('outlet/create/holiday') }}" method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="holiday_name" value="{{ old('holiday_name') }}" placeholder="Holiday Name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox1" name="yearly" class="md-checkboxbtn" >
                                <label for="checkbox1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Yearly </label>
                                    <i class="fa fa-question-circle tooltips" data-original-title="jika dicentang maka akan di set hari libur di tanggal yang sama setiap tahun" data-container="body"></i>
                                    </label>
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
                            <input type="text" class="form-control datepicker" name="date_holiday[]" value="{{ old('holiday_date') }}" placeholder="Holiday Date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 control-label"></div>
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
                                    </label>
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
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Outlet Holiday</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Holiday Name</th>
                        <th> Yearly</th>
                        <th> Holiday Date </th>
                        <th> Outlet </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($holiday))
                        @foreach($holiday as $value)
                            <tr>
                                <td>{{ $value['holiday_name'] }}</td>
                                <td style="text-align: center;">@if($value['yearly'] == 1) <i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i> @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                <td>
                                    @foreach($value['date_holidays'] as $date)
                                        @if($value['yearly'] == '1')
                                            {{ date('d F', strtotime($date['date'])) }}
                                        @else
                                            {{ date('d F Y', strtotime($date['date'])) }}
                                        @endif
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($value['outlets'] as $data_outlet)
                                        {{$data_outlet['outlet_name']}} <br>
                                    @endforeach
                                </td>
                                <td style="width: 85px;">
                                    @if(MyHelper::hasAccess([38], $grantedFeature))
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_holiday'] }}"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                    @if(MyHelper::hasAccess([37], $grantedFeature))
                                        <a href="{{ url('outlet/holiday') }}/{{ $value['id_holiday'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection