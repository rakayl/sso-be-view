<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
<div class="portlet-body form">
    <form id="form" class="form-horizontal form-info" role="form" action="{{ url('deals-subscription/update') }}" method="post" enctype="multipart/form-data">
        @foreach ($deals as $key => $val)
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
                    <div class="input-icon right">
                        <input type="text" class="form-control" name="deals_title" value="{{ $val['deals_title'] }}" placeholder="Title" required maxlength="30">
                    </div>
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
                    <div class="input-icon right">
                        <input type="text" class="form-control" name="deals_second_title" value="{{ $val['deals_second_title'] }}" placeholder="Second Title" maxlength="30">
                    </div>
                </div>
            </div>

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
                            <input type="text" class="form_datetime form-control" name="deals_start" value="{{ date('d-M-Y H:i', strtotime($val['deals_start'])) }}" required>
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
                            <input type="text" class="form_datetime form-control" name="deals_end" value="{{ date('d-M-Y H:i', strtotime($val['deals_end'])) }}" required>
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
                            <input type="text" class="form_datetime form-control" name="deals_publish_start" value="{{ date('d-M-Y H:i', strtotime($val['deals_publish_start'])) }}" required>
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
                            <input type="text" class="form_datetime form-control" name="deals_publish_end" value="{{ date('d-M-Y H:i', strtotime($val['deals_publish_end'])) }}">
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
                        Total Voucher
                        <span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Total seluruh voucher dalam 1 deals" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-9">
                    <div class="input-icon right">
                        <input type="text" class="form-control total_voucher_subscription" name="total_voucher_subscription" value="{{ $val['total_voucher_subscription'] }}" placeholder="Total Voucher" maxlength="30">
                    </div>
                </div>
            </div>

            {{-- form repeater --}}
            <div class="mt-repeater repeater-radio" style="margin-top: 30px; margin-bottom: 30px;">
                <div data-repeater-list="voucher_subscriptions">
                    @foreach($val['deals_subscriptions'] as $key => $item)
                    <div data-repeater-item class="mt-repeater-item mt-overflow col-md-12" style="border-bottom: 1px #ddd;">
                        <input type="hidden" name="id_deals_subscription" value="{{ $item['id_deals_subscription'] }}">
                        <div class="repeater-btn-remove">
                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-del-right mt-repeater-btn-inline">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <div class="form-group promo-type">
                            <div class="col-md-offset-3 col-md-9">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Promo Type
                                        <span class="required" aria-required="true"> * </span>  
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tipe promosi berdasarkan Promo ID, nominal, atau produk promo" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <div class="col-md-4">
                                            <div class="md-radio-inline">
                                            {{-- radio id radio1-radio6 is reserved in deals subsc form --}}
                                                <div class="md-radio">
                                                    <input id="radio{{$key*3+7}}" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_promo_type" value="promoid" required {{ ($item['promo_type']=="promoid" ? "checked" : "") }}>
                                                    <label for="radio{{$key*3+7}}" class="radio_promo_type">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Promo ID
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input id="radio{{$key*3+8}}" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_nominal_type" value="nominal" required {{ ($item['promo_type']=="nominal" ? "checked" : "") }}>
                                                    <label for="radio{{$key*3+8}}" class="radio_nominal_type">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Nominal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input id="radio{{$key*3+9}}" type="radio" name="deals_promo_id_type" class="md-radiobtn dealsPromoType radio_item_type" value="free item" required {{ ($item['promo_type']=="free item" ? "checked" : "") }}>
                                                    <label for="radio{{$key*3+9}}" class="radio_item_type">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Free Item
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>

                            <div class="dealsPromoTypeShow">
                                <div class="col-md-offset-3 col-md-9">
                                    <div class="col-md-offset-3 col-md-9">
                                        <input type="text" class="form-control dealsPromoTypeValuePromo" name="deals_promo_id_promoid" placeholder="Input Promo ID" value="{{ ($item['promo_type'] == "promoid" ? $item['promo_value'] : "") }}" style="{{ ($item['promo_type']=='promoid' ? 'display: block;' : '') }}">
                                        
                                        <input type="text" class="form-control dealsPromoTypeValuePrice price" name="deals_promo_id_nominal" placeholder="Input nominal" value="{{ ($item['promo_type'] == "nominal" ? $item['promo_value'] : "") }}" style="{{ ($item['promo_type']=='nominal' ? 'display: block;' : '') }}">
                                        
                                        <select class="form-control select2 dealsPromoTypeValueItem" name="deals_promo_id_free_item" data-placeholder="Select Item" style="{{ ($item['promo_type']=='free item' ? 'display: block;' : '') }}">
                                            @if (!empty($products))
                                                @if ($item['promo_type']=='free item')
                                                @foreach ($products as $product)
                                                <option value="{{ $product['id_product'] }}" {{ ($item['promo_value']==$product['id_product'] ? "selected" : "") }}>{{ $product['product_name'] }}</option>
                                                @endforeach
                                                @else
                                                @foreach ($products as $product)
                                                <option value="{{ $product['id_product'] }}">{{ $product['product_name'] }}</option>
                                                @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <label class="col-md-3 control-label">
                                    Voucher Qty
                                    <span class="required" aria-required="true"> * </span>  
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah voucher dalam 1 tipe promo" data-container="body"></i>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control total_voucher" name="total_voucher" placeholder="Voucher Quantity" maxlength="30" value="{{ $item['total_voucher'] }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <label class="col-md-3 control-label">
                                    Voucher Start
                                    <span class="required" aria-required="true"> * </span>  
                                    <i class="fa fa-question-circle tooltips" data-original-title="Berapa hari voucher akan aktif semenjak deals diklaim" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" class="form-control voucher_start" name="voucher_start" required value="{{ $item['voucher_start'] }}">
                                        <span class="input-group-addon">
                                            day(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <label class="col-md-3 control-label">
                                    Voucher End
                                    <span class="required" aria-required="true"> * </span>  
                                    <i class="fa fa-question-circle tooltips" data-original-title="Berapa hari voucher akan kadaluwarsa semenjak deals diklaim" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="number" class="form-control voucher_end" name="voucher_end" required value="{{ $item['voucher_end'] }}">
                                        <span class="input-group-addon">
                                            day(s)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="clearfix">
                    <div class="col-md-offset-3 col-md-9">
                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">Add Voucher</a>
                    </div>
                </div>
            </div>
            {{-- end of form repeater --}}

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
                    <div class="input-icon right">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                <img src="{{ $val['url_deals_image'] }}" alt="">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;">
                            </div>
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
                    <div class="input-icon right">
                        <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="id_outlet[]" multiple required>
                            <optgroup label="Outlet List">
                                @if (!empty($outlet))
                                    @php
                                        $jmlOutlet = count($outlet);
                                        $jmlOutletSelected = count($outlets);
                                    @endphp
                                    
                                    @if ($jmlOutlet == $jmlOutletSelected)
                                        <option value="all" selected>All Outlets</option>
                                        @foreach($outlet as $o_item)
                                            <option value="{{ $o_item['id_outlet'] }}" >{{ $o_item['outlet_code'] }} - {{ $o_item['outlet_name'] }}</option>
                                        @endforeach
                                    @else 
                                        @foreach($outlet as $o_item)
                                            <option value="{{ $o_item['id_outlet'] }}" @if (!empty($outlet)) @if (in_array($o_item['id_outlet'], $outlets)) selected @endif  @endif>{{ $o_item['outlet_code'] }} - {{ $o_item['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                    
                                @endif
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>

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
                                    <input type="radio" name="prices_by" id="radio4" value="free" class="prices md-radiobtn" required @if($val['deals_voucher_price_point']=="" && $val['deals_voucher_price_cash']=="") checked @endif>
                                    <label for="radio4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Free </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="prices_by" id="radio5" value="point" class="prices md-radiobtn" required @if ($val['deals_voucher_price_point'] != "") checked @endif>
                                    <label for="radio5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Point </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" name="prices_by" id="radio6" value="money" class="prices md-radiobtn" required @if ($val['deals_voucher_price_cash'] != "") checked @endif>
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

            <div class="form-group" id="prices" @if($val['deals_voucher_price_point']=="" && $val['deals_voucher_price_cash']=="") style="display: none;" @endif>
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <div class="col-md-3">
                        <label class="control-label">Values <span class="required" aria-required="true"> * </span> </label>
                    </div>
                    <div class="col-md-9 payment" id="point"  @if($val['deals_voucher_price_point']=="") style="display: none;" @endif>
                        <input type="text" class="form-control point moneyOpp freeOpp" name="deals_voucher_price_point" value="{{ $val['deals_voucher_price_point'] }}" placeholder="Input point values">
                    </div>
                    <div class="col-md-9 payment" id="money" @if($val['deals_voucher_price_cash']=="") style="display: none;" @endif>
                        <input type="text" class="form-control money pointOpp freeOpp price" name="deals_voucher_price_cash" value="{{ $val['deals_voucher_price_cash'] }}" placeholder="Input money values">
                    </div>
                </div>
            </div>

        </div>

        @if (MyHelper::hasAccess([142], $grantedFeature)) 
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </div>
        </div>
        @endif
        <input type="hidden" name="id_deals" value="{{ $val['id_deals'] }}">
        <input type="hidden" name="deals_type" value="{{ $val['deals_type'] }}">
        @endforeach
    </form>
</div>