<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs            = session('configs');
?>
<form class="form-horizontal" id="form_submit" role="form" action="{{url('tukang-sedot/update', $merchant['id_merchant'])}}" method="post">
                   
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Complete Step</label>
            <div class="col-md-8">
                @if($merchant['merchant_completed_step'] == 1)
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #1BBC9B;padding: 5px 12px;color: #fff;">Completed</span>
                @else
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E87E04;padding: 5px 12px;color: #fff;">Not Complete</span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Status</label>
            <div class="col-md-8">
                @if($merchant['merchant_status'] == 'Pending')
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ffe066;padding: 5px 12px;color: #fff;">Pending</span>
                @elseif($merchant['merchant_status'] == 'Active')
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Active</span>
                @elseif($merchant['merchant_status'] == 'Rejected')
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                @elseif($merchant['merchant_status'] == 'Inactive')
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Inactive</span>
                @else
                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #faf21e;padding: 5px 12px;color: #fff;">{{$merchant['merchant_status'] }}</span>
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
                        <td>: {{$merchant['name']}}</td>
                    </tr>
                    <tr>
                        <td>Phone </td>
                        <td>: {{$merchant['phone']}}</td>
                    </tr>
                    <tr>
                        <td>Email </td>
                        <td>: {{$merchant['email']}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <input name="merchant_name" class="form-control" required placeholder="Name" value="{{$merchant['outlet_name']}}" disabled>
            </div>
            <div class="col-md-4" style="margin-left: -2%">
                <a class="btn btn-primary" href="{{url('outlet/detail', $merchant['outlet_code'])}}">Detail Outlet</a>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">License Number
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor ijin usaha" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_license_number" class="form-control" maxlength="25" required placeholder="License Number" value="{{$merchant['outlet_license_number']}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Email
                <i class="fa fa-question-circle tooltips" data-original-title="Nama jam kerja" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_email" class="form-control" required placeholder="Name" value="{{$merchant['outlet_email']}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Phone <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon perusahaan" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_phone" class="form-control" required placeholder="Phone" value="{{$merchant['outlet_phone']}}" disabled>
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
                        <option value="{{$val['id_province']}}" @if($val['id_province'] == $merchant['id_province']) selected @endif>{{$val['province_name']}}</option>
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
                        <option value="{{$val['id_city']}}" @if($val['id_city'] == $merchant['id_city']) selected @endif>{{$val['city_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Address <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap perusahaan" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <textarea name="merchant_address" class="form-control" required placeholder="Address" disabled>{{$merchant['outlet_address']}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Postal Code <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Kode pos perusahaan" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_postal_code" class="form-control" required placeholder="Postal Code" value="{{$merchant['outlet_postal_code']}}" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">PIC Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama penanggung jawab" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_pic_name" class="form-control" required placeholder="PIC Name" value="{{$merchant['merchant_pic_name']}}" @if($merchant['merchant_status'] == 'Pending' || $merchant['merchant_status'] == 'Rejected') readonly @endif>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">PIC ID Card Number <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nomot ktp penanggung jawab" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_pic_id_card_number" class="form-control" required placeholder="PIC ID Card Number" value="{{$merchant['merchant_pic_id_card_number']}}" @if($merchant['merchant_status'] == 'Pending' || $merchant['merchant_status'] == 'Rejected') readonly @endif>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">PIC Email <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="alamat email penanggung jawab" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_pic_email" class="form-control" required placeholder="PIC Email" value="{{$merchant['merchant_pic_email']}}" @if($merchant['merchant_status'] == 'Pending' || $merchant['merchant_status'] == 'Rejected') readonly @endif>
            </div>
        </div>
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">PIC Phone <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="nomot telepon penanggung jawab" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <input name="merchant_pic_phone" class="form-control" required placeholder="PIC Phone" value="{{$merchant['merchant_pic_phone']}}" @if($merchant['merchant_status'] == 'Pending' || $merchant['merchant_status'] == 'Rejected') readonly @endif>
            </div>
        </div>
    </div>
    <input type="hidden" name="action_type" id="action_type">
    {{ csrf_field() }}
    <div class="row" style="text-align: center">
    @if($merchant['merchant_status'] == 'Active' || $merchant['merchant_status'] == 'Inactive')
         <button onclick="submit()" class="btn blue">Submit</button>
    @elseif($merchant['merchant_status'] == 'Pending')
         <a class="btn red save" data-name="{{ $merchant['outlet_name'] }}" data-status="rejected"  @if($merchant['merchant_completed_step'] == 0) disabled @endif>Reject</a>
    @endif
    @if($merchant['merchant_status'] == 'Pending' || $merchant['merchant_status'] == 'Rejected')
        <a class="btn green-jungle save" data-name="{{ $merchant['outlet_name'] }}" data-status="approve" @if($merchant['merchant_completed_step'] == 0) disabled @endif>Approve</a>
    @endif
    </div>
</form>