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
            datatables('no-filter');
        });

        function dataAchievement() {
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/membership/detail/'.$id_membership)}}";

            var data = {
                _token : token
            };

            $.ajax({
                type : "POST",
                url : url,
                data : data,
                success : function(result) {
                    if(result.status == 'success'){
                        var dt = result.result;
                        document.getElementById("membership_name").innerHTML = ": "+dt.membership_name;
                        document.getElementById("membership_rule").innerHTML = ": Minimum "+dt.min_total_achievement+" achievement";
                        document.getElementById("membership_point_received").innerHTML = ": "+dt.benefit_cashback_multiplier+" %";
                        document.getElementById("membership_max_point").innerHTML = ": "+dt.cashback_maximum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                        $("#membership_image").append("<img src='"+dt.membership_image+"' width='75px'>");
                    }else{
                        toastr.warning('Failed get data detail membership');
                    }

                },
                error: function (jqXHR, exception) {
                    toastr.warning('Failed get data detail membership');
                }
            });
        }

        function datatables(type){
            $("#tbodyListUser").empty();
            var data_display = 20;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('achievement/report/membership/list-user/'.$id_membership)}}";

            var dt = 0;
            var tab = $.fn.dataTable.isDataTable( '#tableListUser' );
            if(tab){
                $('#tableListUser').DataTable().destroy();
            }

            if(type == 'filter'){
                var data_filter = $('#filter-user').serializeArray();
                var rule = '';
                var conditions = [];
                for(var i=0;i<data_filter.length;i++){
                    var check = data_filter[i].name.indexOf("conditions");

                    if(check < 0 && data_filter[i].name === 'rule'){
                        rule = data_filter[i].value;
                    }else if(check >= 0){
                        var split = data_filter[i].name.split('[');
                        var key = split[1].replace("]", "");
                        var name = split[2].replace("]", "");

                        if(typeof conditions[key] === "undefined" || conditions[key] === null){
                            conditions.push({[name] : data_filter[i].value});
                        }else{
                            var obj = conditions[key];
                            Object.assign(obj, {[name] : data_filter[i].value});
                        }
                    }
                }

                var data = {
                    _token : token,
                    conditions : conditions,
                    rule : rule
                };
            }else{
                var data = {
                    _token : token
                };
            }

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
                }
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
        <div class="col-md-9">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-blue sbold uppercase ">Membership Detail</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-8">
                            <table>
                                <tr>
                                    <td width="60%">Membership Name</td>
                                    <td id="membership_name"></td>
                                </tr>
                                <tr>
                                    <td width="60%">Membership Rule</td>
                                    <td id="membership_rule"></td>
                                </tr>
                                <tr>
                                    <td width="60%">{{env('POINT_NAME', 'Points')}} Received</td>
                                    <td id="membership_point_received"></td>
                                </tr>
                                <tr>
                                    <td width="60%">{{env('POINT_NAME', 'Points')}} Maximum</td>
                                    <td id="membership_max_point"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2" id="membership_image" style="margin-left: 5%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    @include('achievement::report.membership.filter_membership_user')
    <br>

    <div class="row">
        <div class="col-md-12">
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
                            <th scope="col" width="25%"> Date Time Get Membership </th>
                            <th scope="col" width="25%"> Total Curent Point </th>
                        </tr>
                        </thead>
                        <tbody id="tbodyListUser"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
