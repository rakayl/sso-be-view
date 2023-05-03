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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
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
                url : "{{ url('news/category/delete') }}",
                data : "_token="+token+"&id_news_category="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("News has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete news.");
                    }
                }
            });
        });

        $('#sample_1').on('click', '.editOK', function() {
            var token  = "{{ csrf_token() }}";
            var dataEdit = $(this).parents('tr').find('td .form-edit input[type="text"]');
            var preview = $(this).parents('tr').find('td .preview');
            if(dataEdit.val()!=preview.text()){
                if(!dataEdit.val().length){
                    return false;
                }
                var column = $(this).parents('tr');
                var id     = $(this).data('id');

                $.ajax({
                    type : "POST",
                    url : "{{ url('news/category/update') }}",
                    data : "_token="+token+"&id_news_category="+id+"&category_name="+dataEdit.val(),
                    success : function(result) {
                        if (result == "success") {
                            $(preview).parents('tr').find('.preview').text(dataEdit.val());
                            $(preview).parents('tr').find('.preview').removeClass('hidden');
                            $(preview).parents('tr').find('.form-edit').addClass('hidden');
                            toastr.info("Category has been updated.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to update news category.");
                        }
                    }
                });
            }else{
                $(this).parents('tr').find('.preview').removeClass('hidden');
                $(this).parents('tr').find('.form-edit').addClass('hidden');
            }
        });

        $('#sample_1').on('click', '.edit', function() {
            var dataEdit = $(this).parents('tr').find('td')[0];
            $(dataEdit).find('.preview').addClass('hidden');
            $(dataEdit).find('.form-edit input').val($(dataEdit).find('.preview').text());
            $(dataEdit).find('.form-edit').removeClass('hidden');
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
                <span>News</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>News Category</span>
            </li>
        </ul>
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">News Category List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Category Name </th>
                        <th> Date Create </th>
                        <th> Last Update </th>
                        @if(MyHelper::hasAccess([166,167], $grantedFeature))
                        <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($categories))
                        @foreach($categories as $key => $category)
                            <tr id="categoryNo{{$category['id_news_category']}}">
                                <td><span class="preview">{{ $category['category_name'] }}</span>
                                    <div class="hidden form-edit form-group">
                                        <div class="input-group">
                                            <input type="text" class="new-value form-control" value="{{ $category['category_name'] }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary editOK" data-id="{{$category['id_news_category']}}">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ date('d M Y H:i',strtotime($category['created_at'])) }}</td>
                                <td>{{ date('d M Y H:i',strtotime($category['updated_at'])) }}</td>
                                @if(MyHelper::hasAccess([166,167], $grantedFeature))
                                <td>
                                    @if(MyHelper::hasAccess([166], $grantedFeature))
                                    <button class="edit btn btn-sm btn-info"><i class="fa fa-edit" data-id="{{$category['id_news_category']}}" type="button"></i> Edit</button> 
                                    @endif
                                    @if(MyHelper::hasAccess([167], $grantedFeature))
                                    <button  data-id="{{$category['id_news_category']}}" data-toggle="confirmation" data-btn-ok-label="Yes" data-btn-ok-class="btn-success" data-btn-ok-icon-content="check" data-btn-cancel-label="Cancel" data-btn-cancel-class="btn-danger"  data-btn-cancel-icon-content="close"
                                    data-title="Are you sure delete this category?" data-content="This might be dangerous" class="btn btn-sm btn-danger btn-flat delete"><i class="fa fa-trash"></i> Delete</button>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-muted text-center" colspan="5">No categories found. <a href="{{url('news/category/create')}}">Create now!</a></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection