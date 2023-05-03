<div class="portlet-body form">
    @foreach ($voucher as $val)
    <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label">Promo ID</label>
                <div class="col-md-9">
                    <input type="text" placeholder="Promo ID" class="form-control" name="promo_id" value="{{ $val['promo_id'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Name</label>
                <div class="col-md-9">
                    <input type="text" placeholder="Voucher Name" class="form-control" name="voucher_name" value="{{ $val['voucher_name'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Redem Point</label>
                <div class="col-md-9">
                    <input type="number" maxlength="10" placeholder="Voucher Point" class="form-control" name="voucher_point" value="{{ $val['voucher_point'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Voucher Day Valid </label>
                <div class="col-md-9">
                    <input type="number" placeholder="Valid ... (day)" class="form-control" name="voucher_days_valid" value="{{ $val['voucher_days_valid'] }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Related </label>
                <div class="col-md-9">
                    <div class="mt-radio-inline">
                        <label class="mt-radio">
                            <input type="radio" class="related" name="related" value="product" @if (empty($val['treatment'])) checked @endif required>  Product
                            <span></span>
                        </label>
                        <label class="mt-radio">
                            <input type="radio" class="related" name="related" value="treatment" @if (empty($val['product'])) checked @endif required>  Treatment
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group product treatmentOp" @if (empty($val['product'])) style="display: none;" @endif>
                <label for="multiple" class="control-label col-md-3">Product</label>
                <div class="col-md-9">
                    <select id="multiple" class="form-control select2-multiple productForm treatmentFormOp" name="id_product" data-placeholder="Product">
                        <optgroup label="Product List">
                            @if (!empty($product))
                                <option></option>
                                @foreach($product as $suw)
                                    <option value="{{ $suw['id_product'] }}" @if ($val['id_product'] == $suw['id_product']) selected @endif>{{ $suw['product_name'] }}</option>
                                @endforeach
                            @endif
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group treatment productOp" @if (empty($val['treatment'])) style="display: none;" @endif >
                <label for="multiple" class="control-label col-md-3">Treatment</label>
                <div class="col-md-9">
                    <select id="multiple" class="form-control select2-multiple treatmentForm productFormOp" name=" id_treatment" data-placeholder="Treatment">
                        <optgroup label="Treatment List">
                            @if (!empty($treatment))
                                <option></option>
                                @foreach($treatment as $suw)
                                    <option value="{{ $suw['id_treatment'] }}" @if ($val['id_treatment'] == $suw['id_treatment']) selected @endif>{{ $suw['treatment_name'] }}</option>
                                @endforeach
                            @endif
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="multiple" class="control-label col-md-3">Outlet Available</label>
                <div class="col-md-9">
                    <select id="multiple" class="form-control select2-multiple" name=" id_outlet[]" multiple data-placeholder="Select Available Outlet" required>
                        <optgroup label="Available Outlet">
                            @if (!empty($outlet))
                                <option></option>
                                @if ($all == 1)
                                    <option value="all" selected>All</option>
                                    @php
                                        $gabungan = "";
                                    @endphp
                                    @foreach($outlet as $suw)
                                        @php
                                            $gabungan = $gabungan."|".$suw['id_outlet'];
                                        @endphp
                                        <option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                    @endforeach
                                    <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                @else
                                    <option value="all">All</option>
                                    @php
                                        $outletPilihan = array_pluck($val['outlets'], 'id_outlet');
                                        $gabungan = "";
                                    @endphp
                                    @foreach($outlet as $suw)
                                        @php
                                            $gabungan = $gabungan."|".$suw['id_outlet'];
                                        @endphp
                                        <option value="{{ $suw['id_outlet'] }}" @if (in_array($suw['id_outlet'], $outletPilihan)) selected  @endif>{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                    @endforeach
                                    <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                @endif
                            @endif
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                    <input type="hidden" name="id_voucher" value="{{ $val['id_voucher'] }}">
                    <!-- <button type="button" class="btn default">Cancel</button> -->
                </div>
            </div>
        </div>
    </form>
    @endforeach
</div>