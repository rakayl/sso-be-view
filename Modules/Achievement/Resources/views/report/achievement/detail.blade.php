@extends('layouts.main-closed')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        td {
            height: 25px;
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

    <script>
        $(document).ready(function () {
            dataAchievement();
            datatables();
        });

        function dataAchievement() {
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/detail/'.$id_achievement_group)}}";

            var data = {
                _token : token
            };

            $.ajax({
                type : "POST",
                url : url,
                data : data,
                success : function(result) {
                    if(result.data_achievement){
                        var dt = result.data_achievement;
                        document.getElementById("achievement_name").innerHTML = ": "+dt.name;
                        document.getElementById("achievement_category").innerHTML = ": "+dt.category_name;

                        var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        var original_date_start = new Date(dt.date_start);
                        var convert_date_start = original_date_start.getDate() +' '+ (month[original_date_start.getMonth()]) + " " + original_date_start.getFullYear() + " " + original_date_start.getHours() + ":" + original_date_start.getMinutes();
                        var original_date_end = new Date(dt.date_end);
                        var convert_date_end = original_date_end.getDate() +' '+ (month[original_date_end.getMonth()]) + " " + original_date_end.getFullYear() + " " + original_date_end.getHours() + ":" + original_date_end.getMinutes();

                        document.getElementById("achievement_date_start").innerHTML = ": "+convert_date_start;
                        document.getElementById("achievement_date_end").innerHTML = ": "+convert_date_end;
                        document.getElementById("achievement_total_user").innerHTML = ": "+dt.total_user;
                    }

                    if(result.data_badge){
                        var html = '';

                        for(var i=0;i<result.data_badge.length;i++){
                            var item = result.data_badge[i];
                            html += '<div class="profile-info portlet light bordered">';
                            html += '<div class="portlet-title">';
                            html += '<div class="col-md-6" style="display: flex;">';
                            html += '<img src="'+item.logo_badge+'" style="width: 40px;height: 40px;" class="img-responsive" alt="">';
                            html += '<span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">&nbsp;&nbsp;'+item.name+'</span>';
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="portlet-body">';
                            html += '<div class="row" style="padding: 5px;position: relative;">';
                            html += '<div class="col-md-12">';
                            html += '<div class="row static-info">';
                            html += '<div class="col-md-5 value">Total User</div>';
                            html += '<div class="col-md-7 value">: '+item.total_badge_user+' user</div>';
                            html += '</div>';

                            if(item.id_product !== null || item.product_total !== null) {
                                html += '<div class="row static-info">';
                                html += ' <div class="col-md-5 value">Product Rule</div>';
                                html += '</div>';
                                html += '<div class="row static-info">';
                                if(item.id_product !== null){
                                    html += '<div class="col-md-5 name">Product</div>';
                                    html += '<div class="col-md-7 value">: '+item.product.product_name+'</div>';
                                }
                                if(item.product_total !== null){
                                    html += '<div class="col-md-5 name">Product Total</div>';
                                    html += '<div class="col-md-7 value">: '+item.product_total+'</div>';
                                }
                                html += '</div>';
                            }

                            if(item.id_outlet !== null || item.different_outlet !== null) {
                                html += '<div class="row static-info">';
                                html += ' <div class="col-md-5 value">Outlet Rule</div>';
                                html += '</div>';
                                html += '<div class="row static-info">';
                                if(item.id_outlet !== null){
                                    html += '<div class="col-md-5 name">Outlet</div>';
                                    html += '<div class="col-md-7 value">: '+item.outlet.outlet_name+'</div>';
                                }
                                if(item.different_outlet !== null){
                                    html += '<div class="col-md-5 name">Outlet Different ?</div>';
                                    html += '<div class="col-md-7 value">: '+item.different_outlet+' Oultet</div>';
                                }
                                html += '</div>';
                            }

                            if(item.id_province !== null || item.different_province !== null) {
                                html += '<div class="row static-info">';
                                html += ' <div class="col-md-5 value">Province Rule</div>';
                                html += '</div>';
                                html += '<div class="row static-info">';
                                if(item.id_province !== null){
                                    html += '<div class="col-md-5 name">Province</div>';
                                    html += '<div class="col-md-7 value">: '+item.province.province_name+'</div>';
                                }
                                if(item.different_province !== null){
                                    html += '<div class="col-md-5 name">Province Different ?</div>';
                                    html += '<div class="col-md-7 value">: '+item.different_province+' Provice</div>';
                                }
                                html += '</div>';
                            }

                            if(item.trx_nominal !== null || item.trx_total !== null) {
                                html += '<div class="row static-info">';
                                html += ' <div class="col-md-5 value">Transaction Rule</div>';
                                html += '</div>';
                                html += '<div class="row static-info">';
                                if(item.trx_nominal !== null){
                                    html += '<div class="col-md-5 name">Transaction Nominal</div>';
                                    html += '<div class="col-md-7 value">: Minimum '+item.trx_nominal+'</div>';
                                }
                                html += '</div>';

                                html += '<div class="row static-info">';
                                if(item.trx_total !== null){
                                    html += '<div class="col-md-5 name">Transaction Total</div>';
                                    html += '<div class="col-md-7 value">: Minimum '+item.trx_total+'</div>';
                                }
                                html += '</div>';
                            }

                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                        $("#body-badge").append(html);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed get data achievement');
                }
            });
        }

        function datatables(){
            $("#tbodyListUser").empty();
            var data_display = 10;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/list-user/'.$id_achievement_group)}}";

            var dt = 0;
            var tab = $.fn.dataTable.isDataTable( '#tableListUser' );
            if(tab){
                $('#tableListUser').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableListUser').DataTable( {
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
                        targets: 3,
                        render: function ( data, type, row, meta ) {
                            try {
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                var achievement_detail = row.achievement_detail;
                                var original_date = new Date(achievement_detail[achievement_detail.length -1].date);
                                var convert_date = original_date.getDate() +' '+ (month[original_date.getMonth()]) + " " + original_date.getFullYear() + " " + original_date.getHours() + ":" + original_date.getMinutes() + ":" + original_date.getSeconds();
                                return convert_date;
                            }catch (err) {
                                return '-';
                            }
                        }
                    },
                    {
                        targets: 4,
                        render: function ( data, type, row, meta ) {
                            try {
                                var achievement_detail = row.achievement_detail;
                                return achievement_detail[0].name;
                            }catch (err) {
                                return '-';
                            }
                        }
                    },
                    {
                        targets: 5,
                        render: function ( data, type, row, meta ) {
                            try {
                                var achievement_detail = row.achievement_detail;
                                var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                var html = "";
                                html += '<ul>';
                                for(var i=0;i<achievement_detail.length;i++){
                                    var original_date = new Date(achievement_detail[i].date);
                                    var convert_date = original_date.getDate() +' '+ (month[original_date.getMonth()]) + " " + original_date.getFullYear() + " " + original_date.getHours() + ":" + original_date.getMinutes() + ":" + original_date.getSeconds();
                                    html += '<li><b>Name</b>: '+achievement_detail[i].name +'<br><b>Date</b>: '+ convert_date +'</li>';
                                }
                                html += '</ul>';

                                return html;
                            }catch (err) {
                                return '-';
                            }
                        }
                    }
                ]
            });
        }

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

    <div class="row">
        <div class="col-md-7">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase ">Achievement Detail</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table>
                        <tr>
                            <td width="60%">Achievement Name</td>
                            <td id="achievement_name"></td>
                        </tr>
                        <tr>
                            <td width="60%">Achievement Category</td>
                            <td id="achievement_category"></td>
                        </tr>
                        <tr>
                            <td width="60%">Achievement Date Start</td>
                            <td id="achievement_date_start"></td>
                        </tr>
                        <tr>
                            <td width="60%">Achievement Date End</td>
                            <td id="achievement_date_end"></td>
                        </tr>
                        <tr>
                            <td width="60%">Total User</td>
                            <td id="achievement_total_user"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase">List User</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <table class="table table-striped table-bordered table-hover" id="tableListUser">
                        <thead>
                        <tr>
                            <th scope="col" width="30%"> User Name </th>
                            <th scope="col" width="30%"> User Phone </th>
                            <th scope="col" width="10%"> User Email </th>
                            <th scope="col" width="25%"> Date First Badge </th>
                            <th scope="col" width="25%"> Current Badge </th>
                            <th scope="col" width="25%"> Detail Badge User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyListUser"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="profile-info portlet light bordered">
                <div class="portlet-title">
                    <span class="caption-subject font-blue sbold uppercase" style="font-size: 16px">List Badge</span>
                </div>
                <div class="portlet-body" id="body-badge">
                </div>
            </div>
        </div>
    </div>
@endsection
