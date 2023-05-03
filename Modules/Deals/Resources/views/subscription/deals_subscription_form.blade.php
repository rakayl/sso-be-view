<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Deals Voucher Type
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembuatan voucher, di list secara manual, auto generate atau unlimited" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-4">
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
            <div class="col-md-4">
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

<div class="form-group" id="generateVoucher" @if (old('deals_total_voucher')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-4">
            <label class="control-label">Total Deals Voucher <span class="required" aria-required="true"> * </span>
            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah deals yang tersedia" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control generateVoucher" name="deals_total_voucher" value="{{ old('deals_total_voucher') }}" placeholder="Total Deals Voucher">
        </div>
    </div>
</div>

<br>
<div class="form-group">
    <div class="input-icon right">
        <label class="col-md-3 control-label">
        Deals Voucher Price
        <span class="required" aria-required="true"> * </span>  
        <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-icon right">
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio4" value="free" class="prices md-radiobtn" required @if (old('prices_by') == "free") checked @endif>
                        <label for="radio4">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Free </label>
                    </div>
                </div>
            </div>
            @if(MyHelper::hasAccess([18], $configs))
            <div class="col-md-3">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" name="prices_by" id="radio5" value="point" class="prices md-radiobtn" required @if (old('prices_by') == "point") checked @endif>
                            <label for="radio5">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Point </label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="md-radio-inline">
                    <div class="md-radio">
                        <input type="radio" name="prices_by" id="radio6" value="money" class="prices md-radiobtn" required @if (old('prices_by') == "money") checked @endif>
                        <label for="radio6">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span> Money </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="prices" @if (old('prices_by')) style="display: block;" @else style="display: none;" @endif>
    <label class="col-md-3 control-label"></label>
    <div class="col-md-9">
        <div class="col-md-3">
            <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
        </div>
        <div class="col-md-9 payment" id="point"  @if (old('prices_by') == "point") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ old('deals_voucher_price_point') }}" placeholder="Input point values">
        </div>
        <div class="col-md-9 payment" id="money" @if (old('prices_by') == "money") style="display: block;" @else style="display: none;" @endif>
            <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ old('deals_voucher_price_cash') }}" placeholder="Input money values">
        </div>
    </div>
</div>
