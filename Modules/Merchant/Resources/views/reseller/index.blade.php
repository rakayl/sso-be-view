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
                    $(".sweetalert-active").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let id     	= $(this).data('id');  
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_enkripsi':id
                                        };
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure want to active this reseller?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Yes, active it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('merchant/reseller/active')}}",
                                        data : data,
                                        success : function(response) {
                                            console.log(data)
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Reseller Actived.", "success")
                                                SweetAlert.init()
                                                window.location.reload(true);
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to active reseller.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to active reseller.", "error")
                                            }
                                        }
                                    });
                                });
                        })
                    });
                    $(".sweetalert-inactive").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let id     	= $(this).data('id');
                        var data = {
                            '_token' : '{{csrf_token()}}',
                            'id_enkripsi':id};
                        $(this).click(function() {
                            swal({
                                    title: "Are you sure want to inactive this reseller?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Yes, inactive it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $.ajax({
                                        type : "POST",
                                        url : "{{url('merchant/reseller/inactive')}}",
                                        data : data,
                                        success : function(response) {
                                            console.log(response)
                                            if (response.status == 'success') {
                                                swal("Deleted!", "Reseller Inactive.", "success")
                                                SweetAlert.init()
                                                window.location.reload(true);
                                            }
                                            else if(response.status == "fail"){
                                                swal("Error!", "Failed to inactive reseller.", "error")
                                            }
                                            else {
                                                swal("Error!", "Something went wrong. Failed to inactive reseller.", "error")
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
    if(Session::has('filter-reseller')){
        $search_param = Session::get('filter-reseller');
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
        @include('merchant::reseller.filter')
    </form>

    <br>
    <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col" width="10%"> Name </th>
                <th scope="col" width="10%"> Merchant </th>
                <th scope="col" width="10%"> Grading </th>
                <th scope="col" width="10%"> Status </th>
                <th scope="col" width="10%"> Action </th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($data))
            @php $i = 0; @endphp
                @foreach($data as $val)
                    <tr>
                        <td>{{$val['user_name']}}</td>
                        <td>{{$val['outlet']}}</td>
                        <td>{{$val['grading']}}</td>
                        <td>{{$val['reseller_merchant_status']}}</td>
                        <td>
                        <a class="btn btn-sm btn-info" href="{{ url('merchant/reseller/candidate/detail', $val['id_enkripsi']) }}"><i class="fa fa-search"></i></a>
                        @if($val['reseller_merchant_status']=="Active")
                            <a class="btn btn-sm btn-danger sweetalert-inactive" data-id="{{ $val['id_enkripsi'] }}"><i class="fa fa-close"></i></a>
                        @elseif($val['reseller_merchant_status']=="Inactive")
                            <a class="btn btn-sm btn-success sweetalert-active" data-id="{{ $val['id_enkripsi'] }}"><i class="fa fa-check"></i></a>
                        @endif
                        </td>
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