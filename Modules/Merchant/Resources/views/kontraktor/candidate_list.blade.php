<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".sweetalert-delete").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let id     	= $(this).data('id');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to delete this candidate?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, delete it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{ url('tukang-sedot/candidate/delete') }}"+'/'+id,
                                        data : "_token="+token+"&id_merchant="+id,
                                        success : function(result) {
                                            if (result.status == "success") {
                                                swal({
                                                    title: 'Deleted!',
                                                    text: 'Candidate has been deleted.',
                                                    type: 'success',
                                                    showCancelButton: false,
                                                    showConfirmButton: false
                                                })
                                                SweetAlert.init()
                                                location.href = "{{url('tukang-sedot/candidate')}}";
                                            }
                                            else if(result.status == "fail"){
                                                swal("Error!", result.messages[0], "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to delete candidate.", "error")
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
            SweetAlert.init()
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
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <?php
    $date_start = '';
    $date_end = '';

    if(Session::has('filter-merchant-candidate')){
        $search_param = Session::get('filter-merchant-candidate');
        if(isset($search_param['date_start'])){
            $date_start = $search_param['date_start'];
        }

        if(isset($search_param['date_end'])){
            $date_end = $search_param['date_end'];
        }

        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('merchant::filter_list')
    </form>

    <br>
    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" width="10%"> Action </th>
                <th scope="col" width="10%"> Status </th>
                <th scope="col" width="10%"> Complete Step </th>
                <th scope="col" width="10%"> Register Date </th>
                <th scope="col" width="10%"> Name </th>
                <th scope="col" width="10%"> Email </th>
                <th scope="col" width="10%"> Phone </th>
                <th scope="col" width="10%"> PIC Name </th>
                <th scope="col" width="10%"> PIC Phone </th>
                <th scope="col" width="10%"> PIC Email </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
                @foreach($data as $val)
                    <tr>
                        <td>
                            @if(MyHelper::hasAccess([324,326], $grantedFeature))
                                <a class="btn btn-sm btn-info" href="{{ url('tukang-sedot/candidate/detail', $val['id_merchant']) }}"><i class="fa fa-search"></i></a>
                            @endif
                            @if(MyHelper::hasAccess([327], $grantedFeature))
                                <a class="btn btn-sm red sweetalert-delete btn-primary" data-id="{{ $val['id_merchant'] }}" data-name="{{ $val['outlet_name'] }}"><i class="fa fa-trash-o"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($val['merchant_status'] == 'Pending')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ffe066;padding: 5px 12px;color: #fff;">Pending</span>
                            @elseif($val['merchant_status'] == 'Rejected')
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$val['merchant_status'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($val['merchant_completed_step'] == 1)
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #1BBC9B;padding: 5px 12px;color: #fff;">Completed</span>
                            @else
                                <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E87E04;padding: 5px 12px;color: #fff;">Not Complete</span>
                            @endif
                        </td>
                        <td>{{ date('d M Y H:i', strtotime($val['created_at'])) }}</td>
                        <td>{{$val['outlet_name']}}</td>
                        <td>{{$val['outlet_email']}}</td>
                        <td>{{$val['outlet_phone']}}</td>
                        <td>{{$val['merchant_pic_name']}}</td>
                        <td>{{$val['merchant_pic_phone']}}</td>
                        <td>{{$val['merchant_pic_email']}}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
            @endif
            </tbody>
        </table>
    </div>
    <br>
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection