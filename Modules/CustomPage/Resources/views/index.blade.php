<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

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
                buttons: [],
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

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Custom Page</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a href="{{ url('custom-page/create') }}"><button id="sample_editable_1_new" class="btn green"> Add New Custom Page
                                <i class="fa fa-plus"></i>
                            </button></a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Title </th>
                        <th> Menu Title </th>
                        <th> Button </th>
                        <th> Value Type </th>
                        @if(MyHelper::hasAccess([156,157], $grantedFeature))
                            <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($result))
                        @foreach($result as $res)
                            <tr>
                                <td> {{ $res['custom_page_title'] }} </td>
                                <td> {{ $res['custom_page_menu'] }} </td>
                                <td> {{ $res['custom_page_button_form'] }} </td>
                                <td> {{ $res['custom_page_button_form_text'] }} </td>
                                @if(MyHelper::hasAccess([156,157], $grantedFeature))
                                    <td>
                                        @if(MyHelper::hasAccess([156], $grantedFeature))
                                            <a href="{{ url('custom-page/detail', $res['id_custom_page']) }}" class="btn yellow"><i class="fa fa-list"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([156], $grantedFeature))
                                            <a href="{{ url('custom-page/edit', $res['id_custom_page']) }}" class="btn blue"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([157], $grantedFeature))
                                            <a data-toggle="confirmation" href="{{ url('custom-page/delete', $res['id_custom_page']) }}" data-popout="true" class="btn red delete" data-id="{{ $res['id_custom_page'] }}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
