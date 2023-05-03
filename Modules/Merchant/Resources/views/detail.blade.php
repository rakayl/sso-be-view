<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs     = session('configs');
?>

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
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js') }}" type="text/javascript"></script>
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
        
        var noGrading = {{(empty($detail['merchant_gradings']) ? 1: count($detail['merchant_gradings']))}}

        function activeReseller() {
            var reseller_status = $("input[name='reseller_status']:checked").val();
            
            if(reseller_status == 'on'){
                $(`#active_reseller`).show();

                for (let i = 0; i < noGrading; i++) {
                    $(`#merchant_grading_grading_name_${i}`).prop('required',true);
                    $(`#merchant_grading_min_qty_${i}`).prop('required',true);
                    $(`#merchant_grading_min_nominal_${i}`).prop('required',true);
                }
            }else{ 
                $(`#active_reseller`).hide();

                for (let i = 0; i < noGrading; i++) {
                    $(`#merchant_grading_grading_name_${i}`).prop('required',false);
                    $(`#merchant_grading_min_qty_${i}`).prop('required',false);
                    $(`#merchant_grading_min_nominal_${i}`).prop('required',false);
                }
            }
        }

        function addGrading() {
            var html = `
                <div id="merchant_grading_${noGrading}">
                    <div class="form-group">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="merchant_grading_grading_name_${noGrading}" name="merchant_grading[${noGrading}][grading_name]" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="text" class="form-control digit_mask" id="merchant_grading_min_qty_${noGrading}" name="merchant_grading[${noGrading}][min_qty]" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="text" class="form-control digit_mask" id="merchant_grading_min_nominal_${noGrading}" name="merchant_grading[${noGrading}][min_nominal]" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <a class="btn btn-danger btn" onclick="deleteGrading(${noGrading})">&nbsp;<i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            `;
            $('#merchant_gradings').append(html);
            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999',
                prefix : "",
            });
            noGrading++;
        }

        function deleteGrading(index) {
            $(`#merchant_grading_${index}`).remove();
            noGrading--;
        }

        function submitGrading() {
            var data = $('#form_grading').serialize();
            
            if(noGrading>0){
                if (!$('form#form_grading')[0].checkValidity()) {
                    toastr.warning("Incompleted Data. Please fill blank input.");
                }else{
                    $('form#form_grading').submit();
                }
            }else{
                toastr.warning("Please at least make one grading");
            }

        }
        
        jQuery(document).ready(function() {
            SweetAlert.init()

            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999',
                prefix : "",
            });
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

    @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
        <a href="{{url('merchant')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @else
        <a href="{{url('merchant/candidate')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    @endif

    @include('layouts.notifications')
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">{{ (($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive') ? $sub_title: 'Merchant Candidate Detail')}}</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#merchant_info" data-toggle="tab"> Info </a>
                </li>
                @if(MyHelper::hasAccess([141], $configs))
                <li>
                    <a href="#merchant_grading" data-toggle="tab"> Grading </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="portlet-body form form-horizontal">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="merchant_info">
                    @if($detail['merchant_completed_step'] == 0)
                    <div class="alert alert-warning">
                        Can not reject or approve this candidate because the candidate has not completed the registration stage.
                    </div>
                    @endif
                    @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
                        <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/update', $detail['id_merchant'])}}" method="post">
                    @else
                        <form class="form-horizontal" id="form_submit" role="form" action="{{url('merchant/candidate/update', $detail['id_merchant'])}}" method="post">
                    @endif
                        <div class="form-body">
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Complete Step</label>
                                <div class="col-md-8">
                                    @if($detail['merchant_completed_step'] == 1)
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #1BBC9B;padding: 5px 12px;color: #fff;">Completed</span>
                                    @else
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E87E04;padding: 5px 12px;color: #fff;">Not Complete</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Status</label>
                                <div class="col-md-8">
                                    @if($detail['merchant_status'] == 'Pending')
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ffe066;padding: 5px 12px;color: #fff;">Pending</span>
                                    @elseif($detail['merchant_status'] == 'Active')
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Active</span>
                                    @elseif($detail['merchant_status'] == 'Rejected')
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                                    @elseif($detail['merchant_status'] == 'Inactive')
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Inactive</span>
                                    @else
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$detail['merchant_status'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Data User
                                </label>
                                <div class="col-md-8" style="margin-top: 1%">
                                    <table>
                                        <tr>
                                            <td>Name </td>
                                            <td>: {{$detail['name']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone </td>
                                            <td>: {{$detail['phone']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email </td>
                                            <td>: {{$detail['email']}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Name <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                    <input name="merchant_name" class="form-control" required placeholder="Name" value="{{$detail['outlet_name']}}" disabled>
                                </div>
                                <div class="col-md-4" style="margin-left: -2%">
                                    <a class="btn btn-primary" href="{{url('outlet/detail', $detail['outlet_code'])}}">Detail Outlet</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">License Number
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomor ijin usaha" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_license_number" class="form-control" maxlength="25" required placeholder="License Number" value="{{$detail['outlet_license_number']}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Email
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_email" class="form-control" required placeholder="Name" value="{{$detail['outlet_email']}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Phone <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon perusahaan" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_phone" class="form-control" required placeholder="Phone" value="{{$detail['outlet_phone']}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Province <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Provinsi" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="id_province" disabled>
                                        <option></option>
                                        @foreach($provinces as $val)
                                            <option value="{{$val['id_province']}}" @if($val['id_province'] == $detail['id_province']) selected @endif>{{$val['province_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">City <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kota" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="id_city" disabled>
                                        <option></option>
                                        @foreach($cities as $val)
                                            <option value="{{$val['id_city']}}" @if($val['id_city'] == $detail['id_city']) selected @endif>{{$val['city_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Address <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap perusahaan" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <textarea name="merchant_address" class="form-control" required placeholder="Address" disabled>{{$detail['outlet_address']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">Postal Code <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Kode pos perusahaan" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_postal_code" class="form-control" required placeholder="Postal Code" value="{{$detail['outlet_postal_code']}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">PIC Name <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama penanggung jawab" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_pic_name" class="form-control" required placeholder="PIC Name" value="{{$detail['merchant_pic_name']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">PIC ID Card Number <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nomot ktp penanggung jawab" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_pic_id_card_number" class="form-control" required placeholder="PIC ID Card Number" value="{{$detail['merchant_pic_id_card_number']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">PIC Email <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="alamat email penanggung jawab" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_pic_email" class="form-control" required placeholder="PIC Email" value="{{$detail['merchant_pic_email']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">PIC Phone <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="nomot telepon penanggung jawab" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input name="merchant_pic_phone" class="form-control" required placeholder="PIC Phone" value="{{$detail['merchant_pic_phone']}}" @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected') readonly @endif>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action_type" id="action_type">
                        {{ csrf_field() }}
                        <div class="row" style="text-align: center">
                        @if($detail['merchant_status'] == 'Active' || $detail['merchant_status'] == 'Inactive')
                             <button onclick="submit()" class="btn blue">Submit</button>
                        @elseif($detail['merchant_status'] == 'Pending')
                             <a class="btn red save" data-name="{{ $detail['outlet_name'] }}" data-status="rejected"  @if($detail['merchant_completed_step'] == 0) disabled @endif>Reject</a>
                        @endif
                        @if($detail['merchant_status'] == 'Pending' || $detail['merchant_status'] == 'Rejected')
                            <a class="btn green-jungle save" data-name="{{ $detail['outlet_name'] }}" data-status="approve" @if($detail['merchant_completed_step'] == 0) disabled @endif>Approve</a>
                        @endif
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="merchant_grading">
                    <form class="form-horizontal" id="form_grading" role="form" action="{{url('merchant/grading', $detail['id_merchant'])}}" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label for="example-search-input" class="control-label col-md-2">Reseller</label>
                                <div class="col-md-5">
                                    <input type="checkbox" class="make-switch" data-size="small" data-on-color="success" onchange="activeReseller()" data-on-text="Active" name="reseller_status" data-off-color="default" data-off-text="Inactive" id="reseller_status" {{$detail['reseller_status']??1?'checked':''}}>
                                </div>
                            </div>
                            <div id="active_reseller" style="display: {{$detail['reseller_status']??1?'block':'none'}};">
                                <div class="form-group">
                                    <label for="example-search-input" class="control-label col-md-2">Grading</label>
                                    <div class="col-md-5">
                                        <div class="mt-radio-list" style="padding-top: 7px; !important">
                                            <label class="mt-radio mt-radio-outline"> Automatic
                                                <input type="radio" value="1" name="auto_grading" @if(isset($detail['auto_grading']) && $detail['auto_grading'] == "1") checked @elseif(old('auto_grading') == "1") checked @endif required/>
                                                <span></span>
                                            </label>
                                            <label class="mt-radio mt-radio-outline"> Manual
                                                <input type="radio" value="0" name="auto_grading" @if(isset($detail['auto_grading']) && $detail['auto_grading'] == "0") checked  @elseif(old('auto_grading') == "0" || (empty(old('auto_grading')) && empty($detail)) ) checked @endif required/>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3 text-center">
                                        <b>Grading Name</b>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <b>Qty</b>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <b>Nominal</b>
                                    </div>
                                </div>
                                <div id="merchant_gradings">
                                    @if(empty($detail['merchant_gradings']))
                                        <div id="merchant_grading_0">
                                            <div class="form-group">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="merchant_grading_grading_name_0" name="merchant_grading[0][grading_name]" {{$detail['reseller_status']??1?'required':''}}>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask" id="merchant_grading_min_qty_0" name="merchant_grading[0][min_qty]" {{$detail['reseller_status']??1?'required':''}}>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask" id="merchant_grading_min_nominal_0" name="merchant_grading[0][min_nominal]" {{$detail['reseller_status']??1?'required':''}}>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <a class="btn btn-danger btn" onclick="deleteGrading(0)">&nbsp;<i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @foreach($detail['merchant_gradings'] as $key=>$value)
                                            <div id="merchant_grading_{{$key}}">
                                                <div class="form-group">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="merchant_grading_grading_name_{{$key}}" name="merchant_grading[{{$key}}][grading_name]" value="{{ $value['grading_name'] }}" {{$detail['reseller_status']??1?'required':''}}>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask" id="merchant_grading_min_qty_{{$key}}" name="merchant_grading[{{$key}}][min_qty]" value="{{ $value['min_qty'] }}" {{$detail['reseller_status']??1?'required':''}} >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask" id="merchant_grading_min_nominal_{{$key}}" name="merchant_grading[{{$key}}][min_nominal]" value="{{ $value['min_nominal'] }}" {{$detail['reseller_status']??1?'required':''}}>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a class="btn btn-danger btn" onclick="deleteGrading({{$key}})">&nbsp;<i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary" onclick="addGrading()">&nbsp;<i class="fa fa-plus-circle"></i> Add Grading </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row" style="text-align: center;margin-top: 5%">
                                <a onclick="submitGrading()" class="btn green">Submit</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
