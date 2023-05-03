<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Type
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembuatan voucher, di list secara manual, auto generate atau unlimited" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="deals_voucher_type" id="radio1" value="Auto generated" class="voucherType" @if (old('deals_voucher_type') == "Auto generated") checked @endif> 
                        <label for="radio1">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Auto Generated </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="deals_voucher_type" id="radio2" value="List Vouchers" class="voucherType" @if (old('deals_voucher_type') == "List Vouchers") checked @endif required> 
                        <label for="radio2">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> List Voucher </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="deals_voucher_type" id="radio3" value="Unlimited" class="voucherType" @if (old('deals_voucher_type') == "Unlimited") checked @endif required> 
                        <label for="radio3">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Unlimited </label>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="form-group" id="listVoucher" @if (old('voucher_code')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Input Voucher 
                <span class="required" aria-required="true"> * </span> 
                <br> <small> Separated by new line </small>
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="voucher_code" class="form-control listVoucher" rows="10">{{ old('voucher_code') }}</textarea>
        </div>
    </div>
</div>

<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Total Voucher <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Total Voucher">
        </div>
    </div>
</div>

<br>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Price
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <input type="hidden" name="prices_by" value="point">
        <div class="input-icon right">
            <input type="number" class="form-control" name="deals_voucher_price_point" value="{{ old('deals_voucher_price_point') }}" placeholder="Input point values">
        </div>
    </div>
</div>

<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Voucher Expiry
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('duration') == "dates") checked @endif>
                        <label for="radio9">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> By Date </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('duration') == "duration") checked @endif>
                        <label for="radio10">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Duration </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="times"  @if (old('duration')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 voucherTime" id="dates" @if (old('duration') == "dates") style="display: block;" @else style="display: none;" @endif>
            <div class="input-group">
                <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" value="{{ old('deals_voucher_expired') }}">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-calendar"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-md-9 voucherTime" id="duration" @if (old('duration') == "duration") style="display: block;" @else style="display: none;" @endif>
            <div class="input-group">
                <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ old('deals_voucher_duration') }}">
                <span class="input-group-addon">
                    day after claimed
                </span>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        User Limit
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Batasan user untuk claim voucher, input 0 untuk unlimited" data-container="body"></i>
        </label>
    </div>

    <div class="col-md-4">
        <div class="input-icon right">
            <input type="number" class="form-control" name="user_limit" value="{{ old('user_limit') }}" placeholder="User limit" maxlength="30">
        </div>
    </div>
</div>