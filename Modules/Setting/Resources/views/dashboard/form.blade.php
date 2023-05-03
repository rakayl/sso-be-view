<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/portlet-draggable.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    var manual=1;
    function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }

    $(document).ready(function() {
        var table = $('#sample_1').DataTable({
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
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                pageLength: 10,
                "searching": false,
                "paging": false,
                rowReorder: {
                    selector: 'tr',
                },
                columnDefs: [
                    { targets: [0,1,2], orderable: false},
                    { targets: [2], visible: false}
                ],
        });

        //update order section
        table.on( 'row-reorder', function ( e, diff, edit ) {
            var token = "{{ csrf_token() }}";
            var order = [];
            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table.row( diff[i].node ).data();
                order.push({
                    id: rowData[2],
                    position: diff[i].newData
                });
            }

            if(order.length > 0){
                $.ajax({
                    type : "POST",
                    url : "{{ url('setting/dashboard/order-section') }}",
                    data: {
                        order:order,
                        _token: token
                    },
                    success : function(result) {
                        if (result == "success") {
                            toastr.info("Section order dashboard has been updated.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to update order section dashboard.");
                        }
                    }
                });
            }
        } );
        $('table').on('switchChange.bootstrapSwitch','.section_visibility',function(){
            if(!manual){
                manual=1;
                return false;
            }
            var token  = "{{ csrf_token() }}";
            var switcher=$(this);
            var newState=switcher.bootstrapSwitch('state');
            $.ajax({
                method:'POST',
                url:"{{url('setting/dashboard/visibility-section')}}",
                data:{
                    _token:token,
                    id_dashboard_user:switcher.data('id'),
                    section_visible:newState?1:0
                },
                success:function(data){
                    if(data.status == 'success'){
                        toastr.info("Success update section visibility");
                    }else{
                        manual=0;
                        toastr.warning("Fail update section visibility");
                        switcher.bootstrapSwitch('state',!newState);
                    }
                }
            }).fail(function(data){
                manual=0;
                toastr.warning("Fail update section visibility");
                switcher.bootstrapSwitch('state',!newState);
            });
        });

    });

       //delete section
    $('#sample_2').on('click', '.delete-section', function() {
        var token  = "{{ csrf_token() }}";
        var column = $(this).parents('tr');
        var id     = $(this).data('id');
        var column2 = $('#dashboard'+id);

        $.ajax({
            type : "POST",
            url : "{{ url('setting/dashboard/delete') }}",
            data : "_token="+token+"&id_dashboard_user="+id,
            success : function(result) {
                if (result == "success") {
                    $('#sample_2').DataTable().row(column).remove().draw();
                    $('#sample_1').DataTable().row(column2).remove().draw();
                    $('.numberSection').each(function(i, item){
                        $( this ).text(i+1)
                    })
                    toastr.info("Section dashboard has been deleted.");
                }
                else {
                    toastr.warning("Something went wrong. Failed to section dashboard.");
                }
            }
        });
    });

    //update section title
    $(".title").focusout(function(){
        var token   = "{{ csrf_token() }}";
        var id      = $(this).data('id');
        var old     = $(this).data('old');
        var value   = $(this).val();

        if(value != old){
            $.ajax({
                type : "POST",
                url : "{{ url('setting/dashboard/ajax') }}",
                data : "_token="+token+"&id_dashboard_user="+id+"&section_title="+value,
                success : function(result) {
                    if (result.status == "success") {
                        toastr.info("Section title has been updated.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update section title.");
                        $(this).val(old);
                    }
                }
            });
        }
    });

    //update order card
    $(function () {
        $( ".cardopt" ).sortable({
            items: "div.rowcard",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                updateCardOrder($(this).attr('data-id'), $(this).attr('data-start'));
            }
        });

        function updateCardOrder(id_dashboard, start) {
            var order = [];
            var child = [];
            var totalChild = 0;
            $('div.rowcard').each(function(index,element) {
                if($(this).attr('data-id-dash') == id_dashboard){
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1-start
                    });
                }
            });

            console.log(order)

            var token   = "{{ csrf_token() }}";
            $.ajax({
                type : "POST",
                url : "{{ url('setting/dashboard/order-card') }}",
                data: {
                    order:order,
                    _token: token
                },
                success : function(result) {
                    if (result == "success") {
                        toastr.info("Card order dashboard has been updated.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to update order card dashboard.");
                    }
                }
            });

        }
    });

    //update select card
    $(document).on('change','.select-card', function(){
        var id = $(this).attr('data-id');
        var select = $(this);
        console.log(id)
        if(id){
            var card = {
                id :  id,
                card_name : $(this).val()
            }
        }else{
            var card = {
                card_name : $(this).val()
            }
        }

        var token   = "{{ csrf_token() }}";
        var id_dash = $(this).attr('data-id-dash');

         $.ajax({
            type : "POST",
            url : "{{ url('setting/dashboard/ajax') }}",
            data : {
                id_dashboard_user:id_dash,
                card:card,
                _token: token
            },
            success : function(result) {
                if (result.status == "success") {
                    console.log(result)
                    select.attr('data-id',result.result.id_dashboard_card)
                    console.log($(this))
                    toastr.info("Card has been updated.");
                }
                else {
                    toastr.warning("Something went wrong. Failed to update card.");
                }
            }
        });
    })

    //delete card
    $('.repeat').repeater({
        show: function () {
            $(".select2").select2({
                placeholder: "Search"
            });
            $(this).attr('data-id', null)
            $('.select2', this).attr('data-id', null)
            $(this).slideDown();
        },
        hide: function (remove) {
            if(confirm('Are you sure you want to remove this item?')) {
                if($(this).attr('data-id') && $(this).find('select').val()){
                    var token   = "{{ csrf_token() }}";
                    var id = $(this).attr('data-id')
                    var id_dash = $(this).attr('data-id-dash')
                    $.ajax({
                        type : "POST",
                        url : "{{ url('setting/dashboard/ajax') }}",
                        data : {
                            id_dashboard_user:id_dash,
                            card:{
                                id: id
                            },
                            _token: token
                        },
                        success : function(result) {
                            if (result.status == "success") {
                                toastr.info("Card has been deleted.");
                                $(this).slideUp(remove);
                            }
                            else {
                                toastr.warning("Something went wrong. Failed to delete card.");
                            }
                        }
                    });
                }else{
                    $(this).slideUp(remove);
                }
            }
    }
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
                <span class="caption-subject font-blue sbold uppercase">Default Date Range</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('setting/dashboard/default-date')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Default Date Range
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="default rentang tanggal data yang ditampilkan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select name="default_date_range" class="form-control select2" style="width:100%" required>
                                <option></option>
                                <option @if(isset($dashboard['date_range']) && $dashboard['date_range'] == '7 days') selected @endif value="7 days">Last 1 Week</option>
                                <option @if(isset($dashboard['date_range']) && $dashboard['date_range'] == '30 days') selected @endif value="30 days">Last 30 Days</option>
                                <option @if(isset($dashboard['date_range']) && $dashboard['date_range'] == 'this month') selected @endif value="this month">This Month</option>
                                <option @if(isset($dashboard['date_range']) && $dashboard['date_range'] == '3 months') selected @endif value="3 months">Last 3 Months</option>
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">New Section</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-2 control-label">
                            Section Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Judul section" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-10" style="padding:0">
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="section_title" value="{{ old('section_title') }}" placeholder="Section Title" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-2 control-label">
                            Card
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="data yang akan ditampilkan" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-10">
                            <div class="repeat">
                                <div data-repeater-list="cards">
                                    <div data-repeater-item="" class="row" style="margin-bottom: 15px;">
                                        <div class="col-md-7">
                                            <select name="card" class="form-control select2" style="width:100%" required>
                                                <option></option>                                                <optgroup label="Customer">
                                                    <option value="New Customer">New Customer</option>
                                                    <option value="Total Customer">Total Customer</option>
                                                    <option value="Total Male Customer">Total Male Customer</option>
                                                    <option value="Total Female Customer">Total Female Customer</option>
                                                    <option value="Total Customer Verified">Total Customer Verified</option>
                                                    <option value="Total Customer Not Verified">Total Customer Not Verified</option>
                                                    <option value="Device Android">Device Android</option>
                                                    <option value="Device IOS">Device IOS</option>
                                                    <option value="Total Customer Subscribed">Total Customer Subscribed</option>
                                                    <option value="Total Customer Unsubscribed">Total Customer Unsubscribed</option>
                                                    <option value="Top 10 Customer Table">Top 10 Customer Table</option>
                                                    <option value="Top 10 Customer Graphic">Top 10 Customer Graphic</option>
                                                </optgroup>
                                                <optgroup label="Admin">
                                                    <option value="Total Super Admin">Total Super Admin</option>
                                                    <option value="Total Admin">Total Admin</option>
                                                    <option value="Total Admin Outlet">Total Admin Outlet</option>
                                                </optgroup>
                                                <optgroup label="User">
                                                    <option value="Total User">Total User</option>
                                                    <option value="Top 10 User Table">Top 10 User Table</option>
                                                    <option value="Top 10 User Graphic">Top 10 User Graphic</option>
                                                </optgroup>
                                                <optgroup label="Transaction">
                                                    <option value="Total All Transaction Count">Total All Transaction Count</option>
                                                    <option value="Total Online Transaction Count">Total Online Transaction Count</option>
                                                    <option value="Total Offline Transaction Member Count">Total Offline Transaction Member Count</option>
                                                    <option value="Total Offline Transaction Non Member Count">Total Offline Transaction Non Member Count</option>
                                                    <option value="Total All Transaction Value">Total All Transaction Value</option>
                                                    <option value="Total Online Transaction Value">Total Online Transaction Value</option>
                                                    <option value="Total Offline Transaction Member Value">Total Offline Transaction Member Value</option>
                                                    <option value="Total Offline Transaction Non Member Value">Total Offline Transaction Non Member Value</option>
                                                    <option value="All Transaction Average">All Transaction Average</option>
                                                    <option value="Online Transaction Average">Online Transaction Average</option>
                                                    <option value="Offline Transaction Member Average">Offline Transaction Member Average</option>
                                                    <option value="Offline Transaction Non Member Average">Offline Transaction Non Member Average</option>
                                                    <option value="All Transaction Average per Day">All Transaction Average per Day</option>
                                                    <option value="Online Transaction Average per Day">Online Transaction Average per Day</option>
                                                    <option value="Offline Transaction Member Average per Day">Offline Transaction Member Average per Day</option>
                                                    <option value="Offline Transaction Non Member Average per Day">Offline Transaction Non Member Average per Day</option>
                                                </optgroup>
                                                <optgroup label="Outlet">
                                                    <option value="Top 10 Outlet By All Transaction Count Table">Top 10 Outlet By All Transaction Count Table</option>
                                                    <option value="Top 10 Outlet By Online Transaction Count Table">Top 10 Outlet By Online Transaction Count Table</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Member Count Table">Top 10 Outlet By Offline Transaction Member Count Table</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Non Member Count Table">Top 10 Outlet By Offline Transaction Non Member Count Table</option>
                                                    <option value="Top 10 Outlet By All Transaction Count Graphic">Top 10 Outlet By All Transaction Count Graphic</option>
                                                    <option value="Top 10 Outlet By Online Transaction Count Graphic">Top 10 Outlet By Online Transaction Count Graphic</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Member Count Graphic">Top 10 Outlet By Offline Transaction Member Count Graphic</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Non Member Count Graphic">Top 10 Outlet By Offline Transaction Non Member Count Graphic</option>
                                                    <option value="Top 10 Outlet By All Transaction Value Table">Top 10 Outlet By All Transaction Value Table</option>
                                                    <option value="Top 10 Outlet By Online Transaction Value Table">Top 10 Outlet By Online Transaction Value Table</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Member Value Table">Top 10 Outlet By Offline Transaction Member Value Table</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Non Member Value Table">Top 10 Outlet By Offline Transaction Non Member Value Table</option>
                                                    <option value="Top 10 Outlet By All Transaction Value Graphic">Top 10 Outlet By All Transaction Value Graphic</option>
                                                    <option value="Top 10 Outlet By Online Transaction Value Graphic">Top 10 Outlet By Online Transaction Value Graphic</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Member Value Graphic">Top 10 Outlet By Offline Transaction Member Value Graphic</option>
                                                    <option value="Top 10 Outlet By Offline Transaction Non Member Value Graphic">Top 10 Outlet By Offline Transaction Non Member Value Graphic</option>
                                                </optgroup>
                                                <optgroup label="Product">
                                                    <option value="Top 10 Product By Recurring Table">Top 10 Product By Recurring Table</option>
                                                    <option value="Top 10 Product By Recurring Graphic">Top 10 Product By Recurring Graphic</option>
                                                    <option value="Top 10 Product By Quantity Table">Top 10 Product By Quantity Table</option>
                                                    <option value="Top 10 Product By Quantity Graphic">Top 10 Product By Quantity Graphic</option>
                                                </optgroup> 
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
                                    <i class="fa fa-plus"></i> Add Card</a>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Order and Visibility Section Dashboard</span>
            </div>
        </div>
        <div class="portlet-body form">
                <div class="alert alert-warning deteksi-trigger">
                    <p> The menu below is used to set the order and visibility of section displayed in home page. </p>
                    <p> To arrange the order of section, drag and drop the table row according to the order of the desired section. </p>
                </div>
            <table class="table table-striped table-bordered dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> No </th>
                        <th> Section Title </th>
                        <th> Id </th>
                        <th> Visibility </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($dashboard))
                        @foreach($dashboard as $key => $value)
                            @if(is_integer($key))
                            <tr id="dashboard{{$value['id_dashboard_user']}}">
                                <td class="numberSection">{{ $key+1 }}</td>
                                <td>
                                    {{ $value['section_title'] }}
                                </td>
                                <td>
                                    {{ $value['id_dashboard_user'] }}
                                </td>
                                <td>
                                    <input type="checkbox" class="make-switch section_visibility" data-size="small" data-on-color="info" data-on-text="Visible" data-off-color="default" data-id="{{$value['id_dashboard_user']}}" data-off-text="Hidden" value="1" @if($value['section_visible']??false) checked @endif>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Section Dashboard</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered" width="100%" id="sample_2">
                <thead>
                    <tr>
                        <th> Section Title </th>
                        <th> Card</th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($dashboard))
                    @php $start = 0; @endphp
                        @foreach($dashboard as $key => $value)
                            @if(is_integer($key))
                            <tr>
                                <td>
                                    <input type="text" class="form-control title"  data-id="{{ $value['id_dashboard_user'] }}" name="section_title" value="{{ $value['section_title'] }}" placeholder="Section Title" required>
                                </td>
                                <td>
                                    <div class="portlet light bordered">
                                        <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                                            <div class="form-body" style="padding-bottom:0">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="repeat">
                                                            <div data-repeater-list="cards" class="cardopt" data-id="{{ $value['id_dashboard_user'] }}" data-start="{{ $start }}">
                                                                @foreach($value['dashboard_card'] as $q => $card)
                                                                <div data-repeater-item="" class="row rowcard" style="margin-bottom: 15px;" data-id="{{ $card['id_dashboard_card'] }}" data-id-dash="{{ $value['id_dashboard_user'] }}">
                                                                    <div class="col-md-10">

                                                                        <select name="card" class="form-control select2 select-card" style="width:100%" required data-id="{{ $card['id_dashboard_card'] }}" data-id-dash="{{ $value['id_dashboard_user'] }}">
                                                                            <option></option>
                                                                            <optgroup label="Customer">
                                                                                <option @if($card['card_name'] == 'New Customer') selected @endif value="New Customer">New Customer</option>
                                                                                <option @if($card['card_name'] == 'Total Customer') selected @endif value="Total Customer">Total Customer</option>
                                                                                <option @if($card['card_name'] == 'Total Male Customer') selected @endif value="Total Male Customer">Total Male Customer</option>
                                                                                <option @if($card['card_name'] == 'Total Female Customer') selected @endif value="Total Female Customer">Total Female Customer</option>
                                                                                <option @if($card['card_name'] == 'Total Customer Verified') selected @endif value="Total Customer Verified">Total Customer Verified</option>
                                                                                <option @if($card['card_name'] == 'Total Customer Not Verified') selected @endif value="Total Customer Not Verified">Total Customer Not Verified</option>
                                                                                <option @if($card['card_name'] == 'Device Android') selected @endif value="Device Android">Device Android</option>
                                                                                <option @if($card['card_name'] == 'Device IOS') selected @endif value="Device IOS">Device IOS</option>
                                                                                <option @if($card['card_name'] == 'Total Customer Subscribed') selected @endif value="Total Customer Subscribed">Total Customer Subscribed</option>
                                                                                <option @if($card['card_name'] == 'Total Customer Unsubscribed') selected @endif value="Total Customer Unsubscribed">Total Customer Unsubscribed</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Customer Table') selected @endif value="Top 10 Customer Table">Top 10 Customer Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Customer Graphic') selected @endif value="Top 10 Customer Graphic">Top 10 Customer Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Customer Table') selected @endif value="Top 10 Customer Table">Top 10 Customer Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Customer Graphic') selected @endif value="Top 10 Customer Graphic">Top 10 Customer Graphic</option>
                                                                            </optgroup>
                                                                            <optgroup label="Admin">
                                                                                <option @if($card['card_name'] == 'Total Super Admin') selected @endif value="Total Super Admin">Total Super Admin</option>
                                                                                <option @if($card['card_name'] == 'Total Admin') selected @endif value="Total Admin">Total Admin</option>
                                                                                <option @if($card['card_name'] == 'Total Admin Outlet') selected @endif value="Total Admin Outlet">Total Admin Outlet</option>
                                                                            </optgroup>
                                                                            <optgroup label="User">
                                                                                <option @if($card['card_name'] == 'Total User') selected @endif value="Total User">Total User</option>
                                                                                <option @if($card['card_name'] == 'Top 10 User Table') selected @endif value="Top 10 User Table">Top 10 User Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 User Graphic') selected @endif value="Top 10 User Graphic">Top 10 User Graphic</option>
                                                                            </optgroup>
                                                                            <optgroup label="Transaction">
                                                                                <option @if($card['card_name'] == 'Total All Transaction Count') selected @endif value="Total All Transaction Count">Total All Transaction Count</option>
                                                                                <option @if($card['card_name'] == 'Total Online Transaction Count') selected @endif value="Total Online Transaction Count">Total Online Transaction Count</option>
                                                                                <option @if($card['card_name'] == 'Total Offline Transaction Member Count') selected @endif value="Total Offline Transaction Member Count">Total Offline Transaction Member Count</option>
                                                                                <option @if($card['card_name'] == 'Total Offline Transaction Non Member Count') selected @endif value="Total Offline Transaction Non Member Count">Total Offline Transaction Non Member Count</option>
                                                                                <option @if($card['card_name'] == 'Total All Transaction Value') selected @endif value="Total All Transaction Value">Total All Transaction Value</option>
                                                                                <option @if($card['card_name'] == 'Total Online Transaction Value') selected @endif value="Total Online Transaction Value">Total Online Transaction Value</option>
                                                                                <option @if($card['card_name'] == 'Total Offline Transaction Member Value') selected @endif value="Total Offline Transaction Member Value">Total Offline Transaction Member Value</option>
                                                                                <option @if($card['card_name'] == 'Total Offline Transaction Non Member Value') selected @endif value="Total Offline Transaction Non Member Value">Total Offline Transaction Non Member Value</option>
                                                                                <option @if($card['card_name'] == 'All Transaction Average') selected @endif value="All Transaction Average">All Transaction Average</option>
                                                                                <option @if($card['card_name'] == 'Online Transaction Average') selected @endif value="Online Transaction Average">Online Transaction Average</option>
                                                                                <option @if($card['card_name'] == 'Offline Transaction Member Average') selected @endif value="Offline Transaction Member Average">Offline Transaction Member Average</option>
                                                                                <option @if($card['card_name'] == 'Offline Transaction Non Member Average') selected @endif value="Offline Transaction Non Member Average">Offline Transaction Non Member Average</option>
                                                                                <option @if($card['card_name'] == 'All Transaction Average per Day') selected @endif value="All Transaction Average per Day">All Transaction Average per Day</option>
                                                                                <option @if($card['card_name'] == 'Online Transaction Average per Day') selected @endif value="Online Transaction Average per Day">Online Transaction Average per Day</option>
                                                                                <option @if($card['card_name'] == 'Offline Transaction Member Average per Day') selected @endif value="Offline Transaction Member Average per Day">Offline Transaction Member Average per Day</option>
                                                                                <option @if($card['card_name'] == 'Offline Transaction Non Member Average per Day') selected @endif value="Offline Transaction Non Member Average per Day">Offline Transaction Non Member Average per Day</option>
                                                                            </optgroup>
                                                                            <optgroup label="Outlet">
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By All Transaction Count Table') selected @endif value="Top 10 Outlet By All Transaction Count Table">Top 10 Outlet By All Transaction Count Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Online Transaction Count Table') selected @endif value="Top 10 Outlet By Online Transaction Count Table">Top 10 Outlet By Online Transaction Count Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Member Count Table') selected @endif value="Top 10 Outlet By Offline Transaction Member Count Table">Top 10 Outlet By Offline Transaction Member Count Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Non Member Count Table') selected @endif value="Top 10 Outlet By Offline Transaction Non Member Count Table">Top 10 Outlet By Offline Transaction Non Member Count Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By All Transaction Count Graphic') selected @endif value="Top 10 Outlet By All Transaction Count Graphic">Top 10 Outlet By All Transaction Count Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Online Transaction Count Graphic') selected @endif value="Top 10 Outlet By Online Transaction Count Graphic">Top 10 Outlet By Online Transaction Count Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Member Count Graphic') selected @endif value="Top 10 Outlet By Offline Transaction Member Count Graphic">Top 10 Outlet By Offline Transaction Member Count Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Non Member Count Graphic') selected @endif value="Top 10 Outlet By Offline Transaction Non Member Count Graphic">Top 10 Outlet By Offline Transaction Non Member Count Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By All Transaction Value Table') selected @endif value="Top 10 Outlet By All Transaction Value Table">Top 10 Outlet By All Transaction Value Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Online Transaction Value Table') selected @endif value="Top 10 Outlet By Online Transaction Value Table">Top 10 Outlet By Online Transaction Value Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Member Value Table') selected @endif value="Top 10 Outlet By Offline Transaction Member Value Table">Top 10 Outlet By Offline Transaction Member Value Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Non Member Value Table') selected @endif value="Top 10 Outlet By Offline Transaction Non Member Value Table">Top 10 Outlet By Offline Transaction Non Member Value Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By All Transaction Value Graphic') selected @endif value="Top 10 Outlet By All Transaction Value Graphic">Top 10 Outlet By All Transaction Value Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Online Transaction Value Graphic') selected @endif value="Top 10 Outlet By Online Transaction Value Graphic">Top 10 Outlet By Online Transaction Value Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Member Value Graphic') selected @endif value="Top 10 Outlet By Offline Transaction Member Value Graphic">Top 10 Outlet By Offline Transaction Member Value Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Outlet By Offline Transaction Non Member Value Graphic') selected @endif value="Top 10 Outlet By Offline Transaction Non Member Value Graphic">Top 10 Outlet By Offline Transaction Non Member Value Graphic</option>
                                                                            </optgroup>
                                                                            <optgroup label="Product">
                                                                                <option @if($card['card_name'] == 'Top 10 Product By Recurring Table') selected @endif value="Top 10 Product By Recurring Table">Top 10 Product By Recurring Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Product By Recurring Graphic') selected @endif value="Top 10 Product By Recurring Graphic">Top 10 Product By Recurring Graphic</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Product By Quantity Table') selected @endif value="Top 10 Product By Quantity Table">Top 10 Product By Quantity Table</option>
                                                                                <option @if($card['card_name'] == 'Top 10 Product By Quantity Graphic') selected @endif value="Top 10 Product By Quantity Graphic">Top 10 Product By Quantity Graphic</option>
                                                                            </optgroup>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-danger">
                                                                            <i class="fa fa-close"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                @php $start++; @endphp
                                                                @endforeach
                                                            </div>
                                                            <hr>
                                                            <a href="javascript:;" data-repeater-create="" class="btn btn-info mt-repeater-add">
                                                                <i class="fa fa-plus"></i> Add Card</a>
                                                            <br>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete-section" data-id="{{ $value['id_dashboard_user'] }}"><i class="fa fa-trash-o"></i> Delete</a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection