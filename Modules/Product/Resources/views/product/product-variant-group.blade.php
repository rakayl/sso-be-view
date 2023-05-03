<form class="form-horizontal" id="form_product_variant_group" action="{{url('product/product-variant-group/'.$product[0]['product_code'])}}" method="POST">
    {{ csrf_field() }}
    <div class="form-body">
        @if(!empty($variant_use_transaction))
            <div class="alert alert-warning text-brown">Can not inactive variant because variant already use : {{implode(', ', $variant_use_transaction)}}</div>
        @endif
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Use Variant
                <i class="fa fa-question-circle tooltips" data-original-title="Status penggunaan variant" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="icheck-list" style="margin-top: 1.5%">
                    <label><input type="checkbox" class="icheck" id="checkbox-variant" name="product_variant_status" @if(!empty($variant_price)) checked @endif @if(!empty($variant_use_transaction)) disabled @endif> </label>
                </div>
            </div>
        </div>
        <div id="variants" @if(empty($variant_price)) style="display: none" @endif>
            <div class="form-group">
                <label for="multiple" class="control-label col-md-3">Variant Color
                </label>
                <div class="col-md-8" id="variant_color" style="margin-top: 0.5%">
                    <a data-toggle="modal" href="#modalVariantColor" class="btn btn-sm green" style="margin-bottom: 1%">Add <i class="fa fa-plus-circle"></i></a>
                    <input type="hidden" id="variant_color_id" name="variant_color_id" value="{{$variant_color['id_product_variant']??0}}">
                    @foreach($variant_color['variant_child']??[] as $key=>$val)
                        <div class="row" id="variant_color_{{str_replace(" ", "_", $val['variant_name'])}}" style="margin-bottom: 0.5%">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="variant_color[{{$key}}][name]" value="{{$val['variant_name']}}" readonly>
                                <input type="hidden" name="variant_color[{{$key}}][id]" value="{{$val['id_product_variant']}}" readonly>
                            </div>
                            <div class="col-md-4"><a class="btn btn-danger" onclick="deleteVariantColor(`{{$val['variant_name']}}`)"><i class="fa fa-trash"></i></a></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="multiple" class="control-label col-md-3">Variant Size
                </label>
                <div class="col-md-8" id="variant_size" style="margin-top: 0.5%">
                    <a data-toggle="modal" href="#modalVariantSize" class="btn btn-sm green" style="margin-bottom: 1%">Add <i class="fa fa-plus-circle"></i></a>
                    <input type="hidden" id="variant_size_id" name="variant_size_id" value="{{$variant_size['id_product_variant']??0}}">
                    @foreach($variant_size['variant_child']??[] as $key=>$val)
                        <div class="row" id="variant_size_{{str_replace(" ", "_", $val['variant_name'])}}" style="margin-bottom: 0.5%">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="variant_size[{{$key}}][name]" value="{{$val['variant_name']}}" readonly>
                                <input type="hidden" name="variant_size[{{$key}}][id]" value="{{$val['id_product_variant']}}" readonly>
                            </div>
                            <div class="col-md-4"><a class="btn btn-danger" onclick="deleteVariantSize(`{{$val['variant_name']}}`)"><i class="fa fa-trash"></i></a></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="variant_price">
                @foreach($variant_price as $key=>$val)
                    <hr style="border-top: 1px dashed black;">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Name
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="variant_price[{{$key}}][name]" value="{{$val['name']}}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Price
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control price" name="variant_price[{{$key}}][price]" id="price_var_{{$key}}" value="{{$val['price']}}" placeholder="Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Stock
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control onlynumber" name="variant_price[{{$key}}][stock]" value="{{$val['stock']}}" id="stock_var_{{$key}}" placeholder="Stock">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Visibility
                        </label>
                        <div class="col-md-6">
                            <select class="form-control select2-multiple" id="visibility_var_{{$key}}" name="variant_price[{{$key}}][visibility]" data-placeholder="Select">
                                <option value="1" @if($val['visibility'] == 'Visible') selected @endif>Visible</option>
                                <option value="0" @if($val['visibility'] == 'Hidden') selected @endif>Hidden</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="variant_price[{{$key}}][data]" value="{{json_encode($val['data'])}}">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Wholesaler</label>
                        <div class="col-md-8" id="div_variant_wholesaler_{{$key}}">
                            <a class="btn yellow btn-sm" style="margin-bottom: 2%" onclick="addVariantWholesaler('{{$key}}_{{count($val['wholesaler_price'])}}')">Add Wholesale Price</a>
                            @foreach($val['wholesaler_price'] as $index=>$wholesaler)
                                <div class="row" style="margin-bottom: 2%" id="variant_wholesaler_{{$key}}_{{$index}}">
                                    <div class="col-md-5">
                                        <div class="input-group">
                            <span class="input-group-addon">
                                min
                            </span>
                                            <input class="form-control price" required name="variant_price[{{$key}}][wholesaler_price][{{$index}}][minimum]" value="{{$wholesaler['minimum']}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <input class="form-control price" required name="variant_price[{{$key}}][wholesaler_price][{{$index}}][unit_price]" value="{{(int)$wholesaler['unit_price']}}">
                                            <span class="input-group-addon">
                                /pcs
                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn red" style="margin-bottom: 2%" onclick="deleteVariantWholesaler('{{$key.'_'.$index}}')"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" value="{{$val['id_product_variant_group']}}" name="variant_price[{{$key}}][id_product_variant_group]">
                @endforeach
            </div>
            <input type="hidden" value="{{$product[0]['id_product']}}" name="id_product">
            <input type="hidden" value="{{$product[0]['id_merchant']}}" name="id_merchant">
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <button type="submit" class="btn btn-success mr-2">Submit</button>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modalVariantColor" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">
                        Variant Color Name
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="variant_name_color" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center">
                <a class="btn green" onclick="addVariantColor()">Add</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVariantSize" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-4 control-label">
                        Variant Size Name
                    </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="variant_name_size" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center">
                <a class="btn green" onclick="addVariantSize()">Add</a>
            </div>
        </div>
    </div>
</div>
