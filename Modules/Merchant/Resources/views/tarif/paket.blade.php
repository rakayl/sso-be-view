<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
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


    </script>
    
<script>
  $(document).ready(function () {
        $("input[data-type='currency']").on({
            keyup: function() {
              formatCurrency($(this));
            },
            blur: function() { 
              formatCurrency($(this), "blur");
            }
        });
        

        function formatNumber(n) {
          // format number 1000000 to 1,234,567
          return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
          // appends $ to value, validates decimal side
          // and puts cursor back in right position.

          // get input value
          var input_val = input.val();

          // don't validate empty input
          if (input_val === "") { return; }

          // original length
          var original_len = input_val.length;

          // initial caret position 
          var caret_pos = input.prop("selectionStart");

          // check for decimal
          if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);


            // join number by .
            input_val = left_side ;

          } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            
          }

          // send updated string to input
          input.val(input_val);

          // put caret back in the right position
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
        }
    })
    function addFormula(param){
		var textvalue = $('#formula').val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula').val(textvaluebaru);
        }
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_tarif':id
                        };
                        $(this).click(function() {
                            swal({
                                    title: "Apakah kamu yakin akan menghapus Tarif ini?",
                                    text: "Anda tidak akan dapat memulihkan data ini!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Ya, Hapus!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('tarif/tarif/delete')}}",
                                        data : data,
                                        success : function(response) {
                                            if (response.status == 'success') {
                                                swal({
                                                    title: 'Success!',
                                                    text: 'Tarif berhasil dihapus.',
                                                    type: "success",
                                                    timer: 2000,
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                });
                                                SweetAlert.init()
                                                window.location.reload();
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", response.messages[0], "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete .", "error")
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
            SweetAlert.init();

        });
    </script>
    
@endsection

@extends('layouts.main')

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$title}} {{$city}}
    </h1>
    @include('layouts.notifications')
    <br>
    
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Tarif Penyedotan</span>
            </div>
        </div>
        <div class="tabbable-line tabbable-full-width">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#formulas" data-toggle="tab"> Formula</a>
                </li>
                <li>
                    <a href="#overview" data-toggle="tab"> List</a>
                </li>
                <li>
                    <a href="#create" data-toggle="tab">Create </a>
                </li>
            </ul>
            <div class="tab-content">
            <div class="tab-pane active" id="formulas">
                <form class="form-horizontal" role="form" action="{{url('tarif/formula/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Formula<span class="required" aria-required="true">*</span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Rumus insentif yang digunakan dalam perhitungan pendapatan hairstylist (value * frekuensi)" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <textarea name="formula" id="formula" class="form-control" placeholder="Enter rumus perhitungan pengosongan tangki">{{$formula['formula']??''}}</textarea>
                                    <br>
                                    <div class="row">
                                          @foreach($textreplace as $key=>$row)
                                                  <div class="col-md-6" style="margin-bottom:5px;">
                                                          <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="{{ $row['message'] }}" onClick="addFormula('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                  </div>
                                          @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" style="text-align:center;">
                                <input type="hidden" name="id_city" value="{{$id_city}}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn blue" id="checkBtn">Update</button>
                            </div>
                        </form>
            </div>
            <div class="tab-pane" id="overview">
                <div class="portlet light">
                    <div class="portlet-body form">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th class="text-nowrap text-center">Action</th>
                                        <th class="text-nowrap text-center">Name Tarif</th>
                                        <th class="text-nowrap text-center">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $dt)
                                            <tr>
                                                <td style="text-align: center;">
                                                   <a href="{{ url('tarif/detail/'.$dt['id_tarif']) }}" class="btn btn-sm blue text-nowrap"><i class="fa fa-search"></i> Detail</a>
                                                   <a class="btn btn-sm delete btn-danger" data-id="{{$dt['id_tarif']}}" type="button" data-toggle="tab"><i class="fa fa-trash"></i></a>
                                                </td>
                                                <td style="text-align: center;">{{$dt['name_tarif']}}</td>
                                                <td style="text-align: center;">{{"Rp " . number_format($dt['price_tarif']??0,2,',','.')}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" style="text-align: center">Data Not Available</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                    </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="create">
                <form class="form-horizontal" role="form" action="{{url('tarif/tarif/create')}}" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Nama Tarif<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama tarif" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="name_tarif" value="{{old('name_tarif')}}" placeholder="Masukkan nama tarif" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Harga Tarif<span class="required" aria-required="true">*</span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Besar harga tarif" data-container="body"></i>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" name="price_tarif" value="{{old('price_tarif')}}" data-type="currency" placeholder="Masukkan besar value" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="id_city" value="{{$id_city}}">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
            </div>
        </div>
        </div>
    </div>
    <br>
@endsection