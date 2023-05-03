<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@include('filter-v2')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dropleft .dropdown-menu{
        	top: -100% !important;
        	left: -180px !important;
        	right: auto;
        }
		.btn-group > .dropdown-menu::after, .dropleft > .dropdown-toggle > .dropdown-menu::after, .dropdown > .dropdown-menu::after {
            opacity: 0;
		}
		.btn-group > .dropdown-menu::before, .dropleft > .dropdown-toggle > .dropdown-menu::before, .dropdown > .dropdown-menu::before {
            opacity: 0;
		}
        .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    @yield('filter_script')
<script>
    rules={
        all_transaction:{
            display:'All Quest',
            operator:[],
            opsi:[]
        },
        publish_date:{
            display:'Publish date',
            operator:[
                ['=','='],
                ['<','<'],
                ['>','>'],
                ['<=','<='],
                ['>=','>=']
            ],
            opsi:[],
            type:'date'
        },
        name:{
            display:'Name',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
            placeholder:'Quest Name'
        },
        status:{
            display:'Status',
            operator:[],
            opsi:[
                ['pending', 'Pending'],
                ['not_started', 'Not Started'],
                ['on_going', 'On Going'],
                ['end', 'End'],
                ['stop', 'Stop'],
            ],
            type:'multiple_select',
            placeholder: 'Select Quest Status'
        },
        benefit_type:{
            display:'Benefit Type',
            operator:[],
            opsi:[
                ['point', 'Point'],
                ['voucher', 'Voucher'],
            ],
            placeholder: 'Select Quest Benefit'
        },
        benefit_deals:{
            display:'Benefit Deals',
            operator:[],
            opsi:{!!json_encode(array_map(function($item) {
                return [$item['id_deals'], $item['deals_title']];
            }, $deals))!!},
            type:'multiple_select',
            placeholder: 'Select Benefit Deals'
        },
        benefit_point:{
            display:'Benefit Point',
            operator:[
                ['=','='],
                ['<','<'],
                ['>','>'],
                ['<=','<='],
                ['>=','>=']
            ],
            opsi:[],
            type:'number',
            append_text:'Point'
        },
        user_type:{
            display:'User Type',
            operator:[],
            opsi:[
                ['all', 'All'],
                ['with_filter', 'With Filter'],
            ],
        },
        date_start:{
            display:'Calculation Date Start',
            operator:[
                ['=','='],
                ['<','<'],
                ['>','>'],
                ['<=','<='],
                ['>=','>=']
            ],
            opsi:[],
            type:'date'
        },
    };
    var table;
</script>
<script>
    function removeQuest(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        $.blockUI({ message: '<h1> Please Wait...</h1>' })
        $.post( "{{ url('quest/delete') }}", { id_quest: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            if (data.status == 'success') {
                toastr.info("Success delete");
            } else {
                toastr.warning(data.messages[0]);
            }
            $('#table-quest').DataTable().ajax.reload(null, false);
            $.unblockUI();
        });
    }

    $(document).ready(function() {
        $('#table-quest').dataTable({
            ajax: {
                url : "{{url()->current()}}",
                type: 'GET',
                data: function (data) {
                    const info = $('#table-quest').DataTable().page.info();
                    data.page = (info.start / info.length) + 1;
                },
                dataSrc: (res) => {
                    $('#list-filter-result-counter').text(res.total);
                    return res.data;
                }
            },
            serverSide: true,
            columns: [
                {data: 'name'},
                {
                    data: 'stop_at',
                    render: function (value, type, row) {
                        if (value) {
                            return '<span class="badge bg-red">Stop</span>'
                        } else if (!row.is_complete) {
                            return '<span class="badge badge-secondary">Pending</span>'
                        } else if (Date.parse(row.date_start) > Date.parse(row.time_server)) {
                            return '<span class="badge bg-yellow">Not Started</span>'
                        } else if (Date.parse(row.publish_end) >= Date.parse(row.time_server)) {
                            return '<span class="badge bg-green-jungle">On Going</span>'
                        } else if (Date.parse(row.publish_end) < Date.parse(row.time_server)) {
                            return '<span class="badge bg-red">End</span>'
                        }
                        return '';
                    },
                    orderable: false
                },
                {
                    data: 'publish_start',
                    render: function (value) {
                        return (new Date(value)).toLocaleString('id-ID', {day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"})
                    }
                },
                {
                    data: 'publish_end',
                    render: function (value) {
                        return (new Date(value)).toLocaleString('id-ID', {day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"})
                    }
                },
                {
                    data: 'date_start',
                    render: function (value) {
                        return (new Date(value)).toLocaleString('id-ID', {day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit"})
                    }
                },
                {
                    data: 'benefit_type',
                    render: value => value.charAt(0).toUpperCase() + value.slice(1)
                },
                {
                    data: 'id_quest',
                    render: function(value, type, row) {
                        return `
                            <a href="{{url('quest/detail')}}/${value}" class="btn blue btn-sm" style="margin-bottom:5px">Detail</a>
                            @if(MyHelper::hasAccess([225], $grantedFeature))
                            ${row.is_complete ? '' : `<a href="javascript:;" onclick="removeQuest(this, ${value})" class="btn red btn-sm"> Remove </a>`}
                            @endif
                        `;
                    },
                    orderable: false
                },
            ],
            searching: false
        });
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
    @yield('filter_view')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Quest List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="table-infinite">
                <table class="table table-striped table-bordered table-hover" width="100%" id="table-quest">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Publish Start</th>
                            <th>Publish End</th>
                            <th>Calculation Start</th>
                            <th>Benefit Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
