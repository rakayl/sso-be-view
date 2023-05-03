<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">Code
            </label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="product_code" value="{{$detail['product_code']}}" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">
                Main Image
                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Utama" data-container="body"></i>
            </label>
            <div class="col-md-8">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                        <img src="{{$detail['image']['url_product_photo']??''}}" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                    <div>
                                <span class="btn default btn-file">
                                <span class="fileinput-new"> Select image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo">
                                </span>
                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id_product_photo" value="{{$detail['image']['id_product_photo']??null}}">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Category <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih Kategori Produk" data-container="body"></i>
            </label>
            <div class="col-md-6">
                <div class="input-icon right">
                    <select id="multiple" class="form-control select2-multiple" name="id_product_category" data-placeholder="Select category" required>
                        <option></option>
                        @if (!empty($parent))
                            @foreach($parent as $suw)
                                @foreach ($suw['children']??[] as $child)
                                    <optgroup label="{{ $suw['product_category_name'] }} - {{ $child['product_category_name'] }}">
                                        @foreach ($child['children']??[] as $subChild)
                                            <option value="{{ $subChild['id_product_category'] }}" @if($detail['id_product_category'] == $subChild['id_product_category']) selected @endif>{{ $subChild['product_category_name'] }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
            </label>
            <div class="col-md-6">
                <div class="input-icon right">
                    <input type="text" class="form-control" name="product_name" placeholder="Name" required value="{{$detail['product_name']}}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Need Recipe
                <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk memerlukan resep dari dokter" data-container="body"></i>
            </label>
            <div class="input-icon right">
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio_recipe1" name="need_recipe_status" class="md-radiobtn req-type" value="1" required @if($detail['need_recipe_status'] == 1) checked @endif>
                            <label for="radio_recipe1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Need</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio_recipe2" name="need_recipe_status" class="md-radiobtn req-type" value="0" required @if($detail['need_recipe_status'] == 0) checked @endif>
                            <label for="radio_recipe2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> No Need </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Product Visible
                <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk akan ditampilkan di aplikasi" data-container="body"></i>
            </label>
            <div class="input-icon right">
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" required @if($product[0]['product_visibility'] == 'Visible') checked @endif>
                            <label for="radio1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Visible</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="md-radio-inline">
                        <div class="md-radio">
                            <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" required @if($product[0]['product_visibility'] == 'Hidden') checked @endif>
                            <label for="radio2">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Hidden </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Description
                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
            </label>
            <div class="col-md-6">
                <div class="input-icon right">
                    <textarea name="product_description" class="form-control" style="height: 100px">{{$detail['product_description']}}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Weight <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Berat Produk" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control onlynumber" name="product_weight" placeholder="Weight" required value="{{(int)$detail['product_weight']}}">
                    <span class="input-group-addon">
                        gram
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Length <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Panjang Produk" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control onlynumber" name="product_length" placeholder="Length" required value="{{$detail['product_length']}}">
                    <span class="input-group-addon">
                        cm
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Width <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Lebar Produk" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control onlynumber" name="product_width" placeholder="Width" required value="{{$detail['product_width']}}">
                    <span class="input-group-addon">
                        cm
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Height <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Tinggi Produk" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control onlynumber" name="product_height" placeholder="Height" required value="{{$detail['product_height']}}">
                    <span class="input-group-addon">
                        cm
                    </span>
                </div>
            </div>
        </div>


        <div class="form-group" id="stock" @if(!empty($variant_price)) style="display: none" @endif>
            <label class="col-md-3 control-label">Stock <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Total jumlah produk" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control onlynumber" name="stock" placeholder="Stock" @if(!empty($variant_price)) disabled @else required @endif value="{{$detail['stock']??0}}">
                    <span class="input-group-addon">
                    qty
                </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Base Price <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Base Price Product, jika memiliki variant maka harga base price akan diambil dari harga terendah variant" data-container="body"></i>
            </label>
            <div class="col-md-4">
                <div class="input-icon right">
                    <div class="input-group">
                        <span class="input-group-addon">
                        Rp
                        </span>
                        <input type="text" id="base_price" class="form-control price" name="base_price" placeholder="Base Price" value="{{$detail['base_price']}}" @if(!empty($variant_price)) readonly @else required @endif>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" id="div_parent_wholesaler" @if(!empty($variant_price)) style="display: none" @endif>
            <label for="multiple" class="control-label col-md-3">Wholesaler
                <i class="fa fa-question-circle tooltips" data-original-title="Harga grosir" data-container="body"></i>
            </label>
            <div class="col-md-8" id="div_wholesaler">
                <a class="btn yellow" style="margin-bottom: 2%" onclick="addWholesaler({{count($product[0]['product_wholesaler'])}})">Add Wholesaler <i class="fa fa-plus-circle"></i></a>
                @foreach($product[0]['product_wholesaler'] as $key=>$wholesaler)
                    <div class="row" style="margin-bottom: 2%" id="wholesaler_{{$key}}">
                        <div class="col-md-5">
                            <div class="input-group">
                            <span class="input-group-addon">
                                min
                            </span>
                                <input class="form-control price" required name="product_wholesaler[{{$key}}][minimum]" value="{{$wholesaler['product_wholesaler_minimum']}}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input class="form-control price" required name="product_wholesaler[{{$key}}][unit_price]" value="{{(int)$wholesaler['product_wholesaler_unit_price']}}">
                                <span class="input-group-addon">
                                /pcs
                            </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a class="btn red" onclick="deleteWholesaler({{$key}})"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <input type="hidden" name="id_product" value="{{ $detail['id_product'] }}">

    @if(MyHelper::hasAccess([51], $grantedFeature))
        <div class="form-actions">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-offset-3 col-md-8">
                    <button type="submit" id="submit" class="btn green">Update</button>
                </div>
            </div>
        </div>
    @endif
</form>