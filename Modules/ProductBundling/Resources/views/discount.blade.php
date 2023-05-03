<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Discount Type
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe discount yang dipilih (Fixed / Percentage)" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="discount_type1" id="radio1" value="Auto generated" class="discountType" @if (old('discount_type1') == "Auto generated") checked @endif> 
                        <label for="radio1">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Fixed </label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="discount_type1" id="radio2" value="List Vouchers" class="discountType" @if (old('discount_type1') == "List Vouchers") checked @endif required> 
                        <label for="radio2">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Percentage </label>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

<div class="form-group" id="listVoucher" @if (old('voucher_code')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-8">
        <div class="col-md-3">
            <label class="control-label">Values 
                <span class="required" aria-required="true"> * </span> 
                <small> (%) </small>
            </label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">
        </div>
    </div>
</div>

<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-8">
        <div class="col-md-3">
            <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-8">
            <input type="number" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Masukkan nilai">
        </div>
    </div>
</div>
