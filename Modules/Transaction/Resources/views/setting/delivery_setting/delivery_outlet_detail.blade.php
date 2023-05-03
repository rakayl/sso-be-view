@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

    <script>
        var arrOutletNotAvailable = <?php echo json_encode($delivery_outlet_not_available)?>;
        var arrOutletHide = <?php echo json_encode($delivery_outlet_hide)?>;
        $(document).ready(function () {
            $("#outlet_group_filter").val(<?php echo $id_outlet_group_filter?>)
            loadTable();
        });

        function loadTable() {
            $("#tableListOutletBody").empty();
            var data_display = 30;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('outlet/delivery-outlet-ajax')}}";
            var tab = $.fn.dataTable.isDataTable( '#tableListOutlet' );
            var code = '{{$code}}';
            var conditions = <?php echo json_encode($conditions)?>;
            var id_outlet_group_filter = "{{$id_outlet_group_filter}}";
            var filter_type = "{{$filter_type}}";
            if(tab){
                $('#tableListOutlet').DataTable().destroy();
            }

            var data = {
                _token : token,
                "id_outlet_group_filter" : id_outlet_group_filter,
                "conditions" : conditions,
                "filter_type" : filter_type
            };

            $('#tableListOutlet').DataTable( {
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "bInfo": true,
                "iDisplayLength": data_display,
                "bProcessing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    url : url,
                    dataType: "json",
                    type: "POST",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                columnDefs: [
                    {
                        targets: 1,
                        render: function ( data, type, row, meta ) {
                            var status = 1;

                            for(var i=0;i<row.delivery_outlet.length;i++){
                                if(row.delivery_outlet[i]['code'] == code && row.delivery_outlet[i]['show_status'] == 0){
                                    status = 0;
                                }
                            }

                            if(arrOutletHide.indexOf(data) >= 0){
                                status = 0;
                            }

                            if(status == 1){
                                var html = '<input type="checkbox" id="switch_show_'+data+'" onchange=inputOutletShowHide('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="Show" data-off-color="default" data-off-text="Hide" value="1" checked>';
                            }else{
                                var html = '<input type="checkbox" id="switch_show_'+data+'" onchange=inputOutletShowHide('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="Show" data-off-color="default" data-off-text="Hide" value="1">';
                            }
                            return html;
                        }
                    },
                    {
                        targets: 2,
                        render: function ( data, type, row, meta ) {
                            var status = 1;

                            for(var i=0;i<row.delivery_outlet.length;i++){
                                if(row.delivery_outlet[i]['code'] == code && row.delivery_outlet[i]['available_status'] == 0){
                                    status = 0;
                                }
                            }

                            if(arrOutletNotAvailable.indexOf(data) >= 0){
                                status = 0;
                            }

                            if(status == 1){
                                var html = '<input type="checkbox" id="switch_'+data+'" onchange=inputOutlet('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disbale" value="1" checked>';
                            }else{
                                var html = '<input type="checkbox" id="switch_'+data+'" onchange=inputOutlet('+data+') class="make-switch" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disable" value="1">';
                            }
                            return html;
                        }
                    }
                ],
                "fnDrawCallback": function() {
                    $(".make-switch").bootstrapSwitch();
                },
            });
        }

        function inputOutlet(data) {
            var state = $('#switch_'+data).prop('checked');
            if(state == false){
                var index = arrOutletNotAvailable.indexOf(data);
                if (index < 0) {
                    arrOutletNotAvailable.push(data);
                }
            }else{
                var index = arrOutletNotAvailable.indexOf(data);
                if (index > -1) {
                    arrOutletNotAvailable.splice(index, 1);
                }
            }
            $('#input_outlet_not_available').val(arrOutletNotAvailable);
        }
        
        function inputOutletShowHide(data) {
            var state = $('#switch_show_'+data).prop('checked');
            if(state == false){
                var index = arrOutletHide.indexOf(data);
                if (index < 0) {
                    arrOutletHide.push(data);
                }
            }else{
                var index = arrOutletHide.indexOf(data);
                if (index > -1) {
                    arrOutletHide.splice(index, 1);
                }
            }
            $('#input_outlet_hide').val(arrOutletHide);
        }
        
        function submitForAll() {
            swal({
                    title: "\n\nAre you sure want to update with filter selected ?",
                    text: "Your will not be able to recover this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, update it!",
                    closeOnConfirm: false
                },
                function(){
                    $('#form_filter').attr('action', "?submit_all=1").submit();
                });
        }
    </script>
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Order</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Delivery Settings</span>
            <i class="fa fa-circle"></i>
        </li>
        @if (!empty($sub_title))
        <li>
            <span>{{ $sub_title }}</span>
        </li>
        @endif
    </ul>
</div><br>

<a href="{{url('transaction/setting/delivery-outlet')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

@include('layouts.notifications')

<form role="form" id="form_filter" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
    {{ csrf_field() }}
    @include('transaction::setting.delivery_setting.filter_delivery_outlet_detail')
    <br>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-green bold uppercase">Outlet Availability @if(!empty(explode('_',$code)['1']??''))({{explode('_',$code)['1']}}) @else <?php echo '('.$code.')'?> @endif</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="m-heading-1 border-yellow-lemon m-bordered">
            <p><b>Submit for all</b> : data outlet yang akan diubah adalah data berdasarkan filter yang terpilih.</p>
        </div>
        <div class="row">
            <div class="col-md-2">
                <input type="checkbox" class="make-switch text-nowrap" id="show_status_all" name="show_status_all" data-size="small" data-on-color="info" data-on-text="Show" data-off-color="default" data-off-text="Hide" value="1" checked>
            </div>
            <div class="col-md-2" style="margin-left: -1.5%">
                <input type="checkbox" class="make-switch" data-size="small" id="available_status_all" name="available_status_all" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disbale" value="1" checked>
            </div>
            <div class="col-md-3" style="margin-left: 1.5%">
                <a class="btn btn-success btn-sm" onclick="submitForAll()"> Submit For All</a>
            </div>
        </div>
</form>
        <br>

        <form class="form-horizontal" action="{{ url('transaction/setting/delivery-outlet/detail',$code) }}" method="post">
            <table class="table table-striped table-bordered table-hover" width="100%" id="tableListOutlet">
                <thead>
                <tr>
                    <th>Outlet</th>
                    <th>Show Status</th>
                    <th>Available Status</th>
                </tr>
                </thead>
                <tbody id="tableListOutletBody"></tbody>
            </table>
            <input type="hidden" name="id_outlet_not_available[]" id="input_outlet_not_available" value="{{json_encode($delivery_outlet_not_available)}}">
            <input type="hidden" name="id_outlet_hide[]" id="input_outlet_hide" value="{{json_encode($delivery_outlet_hide)}}">
            <div class="form-actions text-center">
                {{ csrf_field() }}
                <button type="submit" class="btn blue">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
