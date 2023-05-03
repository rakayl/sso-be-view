<div class="form-body">
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Title  
            <span class="required" aria-required="true"> * </span> 
            <i class="fa fa-question-circle tooltips" data-original-title="Judul deals" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" name="deals_title" value="{{ $val['deals_title'] }}" placeholder="Title" required>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Second Title  
            <i class="fa fa-question-circle tooltips" data-original-title="Sub judul deals jika ada" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" name="deals_second_title" value="{{ $val['deals_second_title'] }}" placeholder="Second Title">
        </div>
    </div>


    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Promo Nominal
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Nominal promo" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id" value="{{ $val['deals_promo_id'] }}" placeholder="Input nominal">
        </div>
    </div>

    {{-- <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Content Short
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat tentang deals yang dibuat" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="deals_short_description" class="form-control" required>{{ $val['deals_short_description'] }}</textarea>
        </div>
    </div> --}}

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Content Long
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <textarea name="deals_description" id="field_content_long" class="form-control summernote">{{ $val['deals_description'] }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"> Deals Periode <span class="required" aria-required="true"> * </span> </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="deals_start" value="{{ date('d-M-Y', strtotime($val['deals_start'])) }}" required>
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="deals_end" value="{{ date('d-M-Y', strtotime($val['deals_end'])) }}" required>
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode deals" data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ date('d-M-Y', strtotime($val['deals_publish_start'])) }}" required>
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-icon right">
                <div class="input-group">
                    <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ date('d-M-Y', strtotime($val['deals_publish_end'])) }}" required>
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                        <button class="btn default" type="button">
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai deals dipublish" data-container="body"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Image
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
            <br>
            <span class="required" aria-required="true"> (300*300) </span>
            </label>
        </div>
        <div class="col-md-9">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                  <img src="{{ $val['url_deals_image'] }}" alt="Image Deals">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                <div>
                    <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <input type="file" accept="image/*" name="deals_image" id="file">
                    
                    </span>

                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                </div>
            </div>
        </div>
    </div>

    @php
        if (!empty($val['outlets'])) {
            $outlets = array_pluck($val['outlets'],'id_outlet');
        }
        else {
            $outlets = [];
        }
    @endphp

    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Outlet Available
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang memberlakukan deals tersebut" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9">
            <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple>
                <optgroup label="Product List">
                    <option value="">Select Outlet</option>

                    @if (!empty($outlet))
                        @php
                            $jmlOutlet = count($outlet);
                            $jmlOutletSelected = count($outlets);
                        @endphp

                        @if ($jmlOutlet == $jmlOutletSelected)
                            <option value="all" selected>All Outlets</option>
                            @foreach($outlet as $suw)
                                <option value="{{ $suw['id_outlet'] }}" >{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                            @endforeach
                        @else 
                            @foreach($outlet as $suw)
                                <option value="{{ $suw['id_outlet'] }}" @if (!empty($outlet)) @if (in_array($suw['id_outlet'], $outlets)) selected @endif  @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                            @endforeach
                        @endif
                        
                    @endif
                </optgroup>
            </select>
        </div>
    </div>
    
    @if ($val['deals_voucher_type'] == "Auto generate" && $val['deals_type'] != "Hidden")
    <div class="form-group">
        <label class="col-md-3 control-label">Voucher Total <span class="required" aria-required="true"> * </span></label>
        <div class="col-md-9">
            <input type="text" class="form-control" name="deals_total_voucher" value="{{ $val['deals_total_voucher'] }}" placeholder="Total Voucher" required="">
            
        </div>
    </div>
    @endif
    
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Voucher Price
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Tipe pembayaran voucher (gratis, menggunakan point, atau menggunakan uang)" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-9 payment" id="point" @if (empty($val['deals_voucher_price_point'])) style="display: none;" @endif>
            <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ $val['deals_voucher_price_point'] }}" placeholder="Input point values">
        </div>
    </div>
    
    <br>
    <div class="form-group">
        <div class="input-icon right">
            <label class="col-md-3 control-label">
            Voucher Expiry
            <span class="required" aria-required="true"> * </span>  
            <i class="fa fa-question-circle tooltips" data-original-title="Masa berlaku voucher, bisa diatur berdasarkan durasi deal atau tanggal expirednya" data-container="body"></i>
            </label>
        </div>
        <div class="col-md-3">
            <div class="md-radio-inline">
                <div class="md-radio">
                    <input type="radio" name="duration" id="radio9" value="dates" class="expiry md-radiobtn" required @if (!empty($val['deals_voucher_expired'])) checked @endif>
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
                    <input type="radio" name="duration" id="radio10" value="duration" class="expiry md-radiobtn" required @if (!empty($val['deals_voucher_duration'])) checked @endif>
                    <label for="radio10">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> Duration </label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" id="times" >
        <label class="col-md-3 control-label"></label>
        <div class="col-md-9">
            <div class="col-md-3">
                <label class="control-label">Expiry <span class="required" aria-required="true"> * </span> </label>
            </div>
            <div class="col-md-9 voucherTime" id="dates"  @if (empty($val['deals_voucher_expired'])) style="display: none;" @endif>
                <div class="input-group">
                    <input type="text" class="form_datetime form-control dates durationOpp" name="deals_voucher_expired" @if (!empty($val['deals_voucher_expired'])) value="{{ date('d-M-Y', strtotime($val['deals_voucher_expired'])) }}" @endif>
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-9 voucherTime" id="duration" @if (empty($val['deals_voucher_duration'])) style="display: none;" @endif>
                <div class="input-group">
                    <input type="number" class="form-control duration datesOpp" name="deals_voucher_duration" value="{{ $val['deals_voucher_duration'] }}">
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
                <input type="number" class="form-control" name="user_limit" value="{{ $val['user_limit'] }}" placeholder="User limit" maxlength="30">
            </div>
        </div>
    </div>
</div>