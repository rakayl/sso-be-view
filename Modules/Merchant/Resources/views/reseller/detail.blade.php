@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        var SweetAlert = function() {
            return {
                init: function() {
                    $(".save").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        let status    = $(this).data('status');

                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want change to status "+status.toLowerCase()+" ?",
                                    text: "Your will not be able to recover this data!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, save it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    $('#action_type').val(status);
                                    $('form#form_submit').submit();
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
    @if($detail['reseller_merchant_status']=="Pending")
    <a href="{{url('merchant/reseller/candidate')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @else
    <a href="{{url('merchant/reseller')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @endif
    @include('layouts.notifications')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Reseller Candidate Detail</span>
            </div>
        </div>
        <div class="portlet-body form">
           @if($detail['reseller_merchant_status']=="Pending")
                <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/reseller/candidate/update', $detail['id_user_reseller_merchant'])}}" method="post">
            @else
                <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/reseller/update', $detail['id_user_reseller_merchant'])}}" method="post">
            @endif
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Nama User
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama reseller" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input type="hidden" class="form-control" required name="id_user_reseller_merchant" value="{{$detail['id_user_reseller_merchant']}}">
                            <input class="form-control" required placeholder="Name" value="{{$detail['user_name']}}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Nama Merhcant
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama merchant" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <input class="form-control" required placeholder="Name" value="{{$detail['outlet']}}" disabled>
                        </div>
                    </div>
                    @if($detail['reseller_merchant_status'] != "Pending")
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Approved {{$detail['reseller_merchant_status']}}
                                <i class="fa fa-question-circle tooltips" data-original-title="User yang melakukan perubahan status reseller" data-container="body"></i>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control" value="{{$detail['approved']}}" disabled>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Notes User
                            <i class="fa fa-question-circle tooltips" data-original-title="Notes yang di isi oleh user ketika request registrasi reseller" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <textarea class="form-control"  disabled>{{$detail['notes_user']??''}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Notes
                            <i class="fa fa-question-circle tooltips" data-original-title="Notes yang ditambahkan ketika proses Approve atau Reject pengajuan reseller" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <textarea name="notes" class="form-control" placeholder="Masukkan Notes">{{$detail['notes']}}</textarea>
                        </div>
                    </div>
                    @if($detail['reseller_merchant_status']!="Pending")
                        @if($detail['auto_grading']==1)
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Grading
                                <i class="fa fa-question-circle tooltips" data-original-title="Grade reseller" data-container="body"></i>
                            </label>
                            <div class="col-md-8">
                                <input class="form-control" value="{{$detail['grading']}}" disabled>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">Grading
                                <i class="fa fa-question-circle tooltips" data-original-title="Grade reseller" data-container="body"></i>
                            </label>
                            <div class="col-md-8">
                                <select class="form-control" required name="id_merchant_grading"> 
                                    <option>Pilih Grading</option>
                                    @foreach($detail['gradings'] as $value)
                                    <option value='{{$value['id_merchant_grading']}}' @if($value['id_merchant_grading'] == $detail['id_merchant_grading']) selected @endif >
                                        {{$value['grading_name']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                    @endif
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Status <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Aksi yang akan dilakukan terhadap request user" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            @if($detail['reseller_merchant_status']=="Pending")
                            <select class="form-control"  name="reseller_merchant_status">
                                <option value="Active">Active</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            @else
                            <select class="form-control"  name="reseller_merchant_status">
                                <option @if($detail['reseller_merchant_status']=="Active") selected @endif value="Active">Active</option>
                                <option @if($detail['reseller_merchant_status']=="Inactive") selected @endif value="Inactive">Inactive</option>
                                <!--<option @if($detail['notes_user']??''=="Rejected") selected @endif value="Rejected">Rejected</option>-->
                            </select>
                            @endif
                            
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row" style="text-align: center">
                     <button type="submit" class="btn blue">@if($detail['notes_user']??''=="Pending") Submit @else Update @endif</button>
                </div>
            </form>
        </div>
    </div>
@endsection