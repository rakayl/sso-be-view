<div class="modal fade bs-modal-lg" id="addBadge" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <form role="form" action="{{ url('quest/create') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New Quest Rule</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="detail-container">
                            <div class="portlet light bordered detail-container-item">
                                <div class="portlet-body row">
                                    <div class="col-md-1 text-right" style="text-align: -webkit-right;">
                                        <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">
                                                Name
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="detail[0][name]" placeholder="Detail Quest" required maxlength="40" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">
                                                Short Description
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <textarea name="detail[0][short_description]" class="form-control" placeholder="Quest Detail Short Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Total Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select quest rule" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <select class="form-control select2 quest_rule" name="detail[0][quest_rule]" data-placeholder="Select Quest Rule" required>
                                                            <option></option>
                                                            <option value="nominal_transaction">Transaction Nominal</option>
                                                            <option value="total_transaction">Transaction Total</option>
                                                            <option value="total_product">Product Total</option>
                                                            <option value="total_outlet">Outlet Different</option>
                                                            <option value="total_province">Province Different</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group additional_rule">
                                            <label class="col-md-3 control-label">
                                                Additional Rule
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-checkbox-inline">
                                                    <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                                        <input type="checkbox" class="rule_trx"> Transaction
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox rule_product_add">
                                                        <input type="checkbox" class="rule_product"> Product
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox additionalnya not_total_province">
                                                        <input type="checkbox" class="rule_additional"> Additional
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group trx_rule_form">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Transaction Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product_rule_form">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Product Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[0][id_product]">
                                                            <option></option>
                                                            @foreach ($product as $item)
                                                                <option value="{{$item['id_product']}}">{{$item['product_code'] ?? ''}} - {{$item['product_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 not_total_product">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control total_product product_total_rule" name="detail[0][product_total]" placeholder="Total Product">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group has_variant">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Product Variant Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the quest is not based on the product variant" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mt-checkbox-inline">
                                                        <label class="mt-checkbox" style="margin-left: 15px;">
                                                            <input type="checkbox" class="use_variant rule_product_variant"> Use Variant
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="detail[0][id_product_variant_group]">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group additional_rule_form">
                                            <div class="input-icon right">
                                                <label class="col-md-3 control-label">
                                                Additional Rule
                                                <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 additional_rule_type" data-placeholder="Select Province" name="detail[${counter_rule}][additional_rule_type]">
                                                        <option value="province" class="province_option">Province</option>
                                                        <option value="outlet">Outlet</option>
                                                        <option value="outlet_group">Outlet Group Filter</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 select_province">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 id_province province_total_rule" data-placeholder="Select Province" name="detail[0][id_province]">
                                                        <option></option>
                                                        @foreach ($province as $item)
                                                            <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 select_outlet">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="detail[0][id_outlet]">
                                                        <option></option>
                                                        @foreach ($outlet as $item)
                                                            <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 select_outlet_group">
                                                <div class="input-icon right">
                                                    <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="detail[0][id_outlet_group]">
                                                        <option></option>
                                                        @foreach ($outlet_group_filters as $item)
                                                            <option value="{{$item['id_outlet_group']}}">{{$item['outlet_group_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form_switch nominal_transaction_form">
                                            <label class="col-md-3 control-label">
                                                Transaction Nominal
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Transaction Nominal" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control digit_mask" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form_switch total_transaction_form">
                                            <label class="col-md-3 control-label">
                                                Transaction Total
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Transaction Total" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control digit_mask" name="detail[0][trx_total]" placeholder="Transaction Total">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form_switch total_product_form">
                                            <label class="col-md-3 control-label">
                                                Product Total
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Product Total" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control digit_mask" name="detail[0][product_total]" placeholder="Product Total">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form_switch total_outlet_form">
                                            <label class="col-md-3 control-label">
                                                Outlet Total
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Outlet Total" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control digit_mask" name="detail[0][different_outlet]" placeholder="Outlet Total">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form_switch total_province_form">
                                            <label class="col-md-3 control-label">
                                                Province Total
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Province Total" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-icon right">
                                                    <input type="text" class="form-control digit_mask" name="detail[0][different_province]" placeholder="Province Total">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="javascript:;" class="btn btn-success" onclick="addRule.bind(this)()">
                                <i class="fa fa-plus"></i> Add New Input
                            </a>
                        </div>
                    </div>
                    <div class="preview col-md-3 pull-right" style="right: 0;top: 20px; position: sticky">
                        <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_detail_preview.png'}}" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ csrf_field() }}
                <input type="text" hidden name="id_quest" value="{{$data['quest']['id_quest']}}">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-lg" id="editBadge" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <form role="form" action="{{ url('quest/update/detail') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Quest Rule</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="detail-container">
                            <div class="detail-container-item">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Name
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nama rule quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" placeholder="Detail Quest" required maxlength="40" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Short Description
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <textarea name="short_description" class="form-control" placeholder="Quest Detail Short Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Total Rule
                                        <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Syarat penyelesaian quest secara global.<br/>
                                            <b>Transaction Nominal</b>: Total Nominal transaksi<br/>
                                            <b>Transaction Total</b>: Jumlah melakukan transaksi<br/>
                                            <b>Total Product</b>: Total produk yang dibeli<br/>
                                            <b>Outlet Different</b>: Transaksi di beberapa outlet<br/>
                                            <b>Province Different</b>: Transaksi di beberapa provinsi<br/>" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <select class="form-control select2 quest_rule" name="quest_rule" required>
                                                    <option></option>
                                                    <option value="nominal_transaction">Transaction Nominal</option>
                                                    <option value="total_transaction">Transaction Total</option>
                                                    <option value="total_product">Product Total</option>
                                                    <option value="total_outlet">Outlet Different</option>
                                                    <option value="total_province">Province Different</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group additional_rule">
                                    <label class="col-md-3 control-label">
                                        Additional Rule
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Syarat tambahan penyelesaian quest untuk setiap transaksinya.<br/>
                                                <b>Transaction</b>: Nominal minimal setiap transaksi<br/>
                                                <b>Product</b>: Jumlah melakukan transaksi<br/>
                                                <b>Additional</b>: Outlet / Provinsi dilakukannya transaksi<br/>
                                        " data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                                <input type="checkbox" class="rule_trx"> Transaction
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox rule_product_add">
                                                <input type="checkbox" class="rule_product"> Product
                                                <span></span>
                                            </label>
                                            <label class="mt-checkbox additionalnya not_total_province">
                                                <input type="checkbox" class="rule_additional"> Additional
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group trx_rule_form">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Transaction Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Nominal transaksi yang akan diperhitungkan dalam syarat quest" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form-control digit_mask nominal_transaksi" name="trx_nominal" placeholder="Transaction Nominal">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_rule_form">
                                    <div class="form-group">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                            Product Rule
                                            <i class="fa fa-question-circle tooltips" data-original-title="Produk yang harus dibeli" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-icon right">
                                                <select class="form-control select2 id_product" data-placeholder="Select Product" name="id_product">
                                                    <option></option>
                                                    @foreach ($product as $item)
                                                        <option value="{{$item['id_product']}}">{{$item['product_code'] ?? ''}} - {{$item['product_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 not_total_product">
                                            <div class="input-icon right">
                                                <div class="input-group">
                                                    <input type="text" class="form-control total_product product_total_rule" name="product_total" placeholder="Total Product">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group has_variant">
                                        <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                            Product Variant Rule
                                            <i class="fa fa-question-circle tooltips" data-original-title="Product variant yang harus dibeli" data-container="body"></i>
                                            </label>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-checkbox-inline">
                                                <label class="mt-checkbox" style="margin-left: 15px;">
                                                    <input type="checkbox" class="use_variant rule_product_variant"> Use Variant
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                            <div class="input-icon right">
                                                <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="id_product_variant_group">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group additional_rule_form">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Additional Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Outlet/provinsi tempat dilakukan transaksi" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <select class="form-control select2 additional_rule_type" data-placeholder="Select Province" name="detail[${counter_rule}][additional_rule_type]">
                                                <option value="province" class="province_option">Province</option>
                                                <option value="outlet">Outlet</option>
                                                <option value="outlet_group">Outlet Group Filter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 select_province">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_province province_total_rule" data-placeholder="Select Province" name="id_province">
                                                <option></option>
                                                @foreach ($province as $item)
                                                    <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 select_outlet">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="id_outlet">
                                                <option></option>
                                                @foreach ($outlet as $item)
                                                    <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 select_outlet_group">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="id_outlet_group">
                                                <option></option>
                                                @foreach ($outlet_group_filters as $item)
                                                    <option value="{{$item['id_outlet_group']}}">{{$item['outlet_group_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_switch nominal_transaction_form">
                                    <label class="col-md-3 control-label">
                                        Transaction Nominal
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Total nominal transaksi untuk menyelesaikan quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control digit_mask" name="trx_nominal" placeholder="Transaction Nominal">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_switch total_transaction_form">
                                    <label class="col-md-3 control-label">
                                        Transaction Total
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi yang harus dilakukan untuk menyelesaikan quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control digit_mask" name="trx_total" placeholder="Transaction Total">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_switch total_product_form">
                                    <label class="col-md-3 control-label">
                                        Product Total
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli untuk menyelesaikan quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control digit_mask" name="product_total" placeholder="Product Total">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_switch total_outlet_form">
                                    <label class="col-md-3 control-label">
                                        Outlet Total
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah outlet yang harus dilakukan transaksi untuk menyelesaikan quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control digit_mask" name="different_outlet" placeholder="Outlet Total">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form_switch total_province_form">
                                    <label class="col-md-3 control-label">
                                        Province Total
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah provinsi tempat transaksi untuk menyelesaikan quest" data-container="body"></i>
                                    </label>
                                    <div class="col-md-9">
                                        <div class="input-icon right">
                                            <input type="text" class="form-control digit_mask" name="different_province" placeholder="Province Total">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview col-md-3 pull-right" style="right: 0;top: 20px; position: sticky">
                        <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_detail_preview.png'}}" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden name='id_quest_detail'>
                {{ csrf_field() }}
                <input type="text" name="id_quest_detail" hidden>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalEditBenefit" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 700px;">
        <form role="form" action="{{ url('quest/detail/'.$data['quest']['id_quest'].'/update/benefit') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Quest Benefit</h4>
            </div>
            <div class="modal-body" style="padding: 20ox;display: table;width: 100%;">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                            Benefit
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Hadiah yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2" id="benefit-selector" name="quest_benefit[benefit_type]" data-placeholder="Benefit Type" required>
                                <option value="point" {{old('quest_benefit.benefit_type', $data['quest']['quest_benefit']['benefit_type']) == 'point' ? 'selected' : ''}}>{{env('POINT_NAME', 'Points')}}</option>
                                <option value="voucher" {{old('quest_benefit.benefit_type', $data['quest']['quest_benefit']['benefit_type']) == 'voucher' ? 'selected' : ''}}>Voucher</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="benefit-voucher">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                            Benefit Voucher
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Voucher yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2" name="quest_benefit[id_deals]" data-placeholder="Select Voucher" required>
                                <option></option>
                                @foreach($deals as $deal)
                                    @if($deal['deals_total_voucher'] > $deal['deals_total_claimed'] || $deal['deals_voucher_type'] == 'Unlimited')
                                        <option value="{{$deal['id_deals']}}" {{$data['quest']['quest_benefit']['id_deals'] == $deal['id_deals'] ? 'selected' : ''}}>{{$deal['deals_title']}} ({{($deal['deals_voucher_expired'] ?? null) ? date('d F Y H:i', strtotime($deal['deals_voucher_expired'])) : ($deal['deals_voucher_duration'] ?? '-') . ' days'}})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="number" min="1" class="form-control" name="quest_benefit[value]" placeholder="Total Voucher" required value="{{old('quest_benefit.value', $data['quest']['quest_benefit']['value'])}}"/>
                                <span class="input-group-addon">Voucher/User</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="benefit-point">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                            Benefit Point Nominal
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nominal point yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="number" min=0 class="form-control" name="quest_benefit[value]" placeholder="Nominal Point" required  value="{{old('quest_benefit.value', $data['quest']['quest_benefit']['value'])}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                            Autoclaim Benefit
                            <i class="fa fa-question-circle tooltips" data-original-title="Apakah misi harus di claim manual atau otomatis" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" name="quest_benefit[autoclaim_benefit]" value="0">
                            <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest_benefit[autoclaim_benefit]" {{$data['quest']['quest_benefit']['autoclaim_benefit'] ? 'checked' : ''}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden name='id_quest_detail'>
                {{ csrf_field() }}
                <input type="text" name="id_quest_detail" hidden>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modalEditQuest" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <form role="form" action="{{ url('quest/detail/'.$data['quest']['id_quest'].'/update/quest') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Quest Detail</h4>
            </div>
            <div class="modal-body" style="padding: 20ox;display: table;width: 100%;">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                    Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Quest Name" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="quest[name]" value="{{ old('quest.name', $data['quest']['name']) }}" placeholder="Quest" required maxlength="40">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                User Rule Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="User Rule Type" data-container="body"></i>
                            </label>
                            <div class="col-md-3">
                                <select class="form-control select2" name="quest[user_rule_type]" data-placeholder="User Rule Type" required onchange="changeUserRuleType(this.value)">
                                    <option></option>
                                    <option value="all" @if(is_null($data['quest']['user_rule_subject'])) selected @endif>All User</option>
                                    <option value="with_rule" @if(!is_null($data['quest']['user_rule_subject'])) selected @endif>With Rule</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="detail_user_rule" @if(is_null($data['quest']['user_rule_subject'])) style="display: none" @endif>
                            <label class="col-md-3 control-label">
                                User Rule
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="User Rule" data-container="body"></i>
                            </label>
                            <div class="col-md-3">
                                <select class="form-control select2" id="user_rule_subject" name="quest[user_rule_subject]" data-placeholder="Rule Subject" @if(!is_null($data['quest']['user_rule_subject'])) required @endif>
                                    <option></option>
                                    <option value="r_quartile" {{$data['quest']['user_rule_subject'] == 'r_quartile' ? 'selected' : ''}}>R</option>
                                    <option value="f_quartile" {{$data['quest']['user_rule_subject'] == 'f_quartile' ? 'selected' : ''}}>F</option>
                                    <option value="m_quartile" {{$data['quest']['user_rule_subject'] == 'm_quartile' ? 'selected' : ''}}>M</option>
                                    <option value="RFMScore" {{$data['quest']['user_rule_subject'] == 'RFMScore' ? 'selected' : ''}}>RFM</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" id="user_rule_operator" name="quest[user_rule_operator]" data-placeholder="Rule Operator" @if(!is_null($data['quest']['user_rule_subject'])) required @endif>
                                    <option></option>
                                    <option value=">" {{$data['quest']['user_rule_operator'] == '>' ? 'selected' : ''}}>></option>
                                    <option value=">=" {{$data['quest']['user_rule_operator'] == '>=' ? 'selected' : ''}}>>=</option>
                                    <option value="=" {{$data['quest']['user_rule_operator'] == '=' ? 'selected' : ''}}>=</option>
                                    <option value="<" {{$data['quest']['user_rule_operator'] == '<' ? 'selected' : ''}}><</option>
                                    <option value="<=" {{$data['quest']['user_rule_operator'] == '<=' ? 'selected' : ''}}><=</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="quest[user_rule_parameter]" id="user_rule_parameter" class="form-control" placeholder="Rule Param" value="{{$data['quest']['user_rule_parameter']}}" @if(!is_null($data['quest']['user_rule_subject'])) required @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Image Quest
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Gambar Quest" data-container="body"></i>
                                <br>
                                <span class="required" aria-required="true"> (500*500) </span>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                        <img src="{{$data['quest']['image']}}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                        <div id="classImage">
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/*" class="file" name="quest[image]">
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> 
                                Quest Publish Periode 
                                <span class="required" aria-required="true"> * </span> 
                                <i class="fa fa-question-circle tooltips" data-original-title="Periode quest untuk ditampilkan dan dapat di klaim" data-container="body"></i>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="text" class="form_datetime form-control" name="quest[publish_start]" value="{{ old('quest.publish_start', date('d F Y - H:i', strtotime($data['quest']['publish_start']))) }}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-1 text-center"> - </div>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="text" class="form_datetime form-control" name="quest[publish_end]" value="{{ old('quest.publish_end', date('d F Y - H:i', strtotime($data['quest']['publish_end']))) }}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">
                                Quest Calculation Start Date
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode perhitungan quest" data-container="body"></i>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="text" class="form_datetime form-control" name="quest[date_start]" value="{{ old('quest.date_start', date('d F Y - H:i', strtotime($data['quest']['date_start']))) }}" autocomplete="off" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-3 control-label">
                                Quest Maximum Complete Periode
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Periode penyelesaian quest oleh user" data-container="body"></i>
                                </label>
                                <div class="col-md-3">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="quest[quest_period_type]" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'dates' || $data['quest']['date_end']) checked @endif required>
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
                                            <input type="radio" name="quest[quest_period_type]" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'duration' || $data['quest']['max_complete_day']) checked @endif required>
                                            <label for="radio10">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Duration </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-3 col-md-3 control-label">
                                    Complete before
                                </div>
                                <div class="col-md-5 dates-only">
                                    <div class="input-icon right">
                                        <input type="text" class="form_datetime form-control" name="quest[date_end]" value="{{ old('quest.date_end', $data['quest']['date_end'] ? date('d F Y - H:i', strtotime($data['quest']['date_end'])) : '') }}" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-5 duration-only">
                                    <div class="input-group">
                                        <input type="text" class="form-control digit_mask" name="quest[max_complete_day]" placeholder="Max Complete Day" required  value="{{old('quest.max_complete_day', $data['quest']['max_complete_day'])}}" />
                                        <div class="input-group-addon">day after claimed</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Short Description
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <textarea name="quest[short_description]" class="form-control" placeholder="Quest Short Description" required id="input-quest-short-description">{{ old('quest.short_description', $data['quest']['short_description']) }}</textarea>
                                    <div class="portlet-body" style="margin-bottom: 15px">
                                        <span style="margin-bottom: 5px">You can use this variables to display dynamic information:</span>
                                        <div>
                                            @if($data['quest']['quest_benefit']['benefit_type'] == 'voucher')
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%deals_title%')">%deals_title%</button>
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%voucher_qty%')">%voucher_qty%</button>
                                            @else
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%point_received%')">%point_received%</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Autoclaim Quest
                                <i class="fa fa-question-circle tooltips" data-original-title="Apakah misi harus di claim manual atau otomatis" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" name="quest[autoclaim_quest]" value="0">
                                <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest[autoclaim_quest]" id="autoclaim-selector" {{$data['quest']['autoclaim_quest'] ? 'checked' : ''}}>
                            </div>
                        </div>
                        <div class="form-group manualclaim-only">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Quest Claim Limit
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal klaim untuk quest. Masukan 0 untuk tidak terbatas" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control digit_mask" name="quest[quest_limit]" placeholder="Claim limit" required value="{{old('quest.quest_limit', $data['quest']['quest_limit'])}}" required />
                            </div>
                        </div>
                    </div>
                    <div class="preview col-md-3 pull-right" style="right: 0;top: 50px; position: sticky">
                        <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_preview1.png'}}" class="img-responsive">
                        <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_preview2.png'}}" class="img-responsive" style="padding-top: 10px">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" hidden name='id_quest_detail'>
                {{ csrf_field() }}
                <input type="text" name="id_quest_detail" hidden>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" class="btn green">Save changes</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
