<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-yellow sbold uppercase">Setting Fee Special Outlet</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" id="form_fee_outlet_special" action="{{url('disburse/setting/fee-outlet-special/update')}}" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="row" style="margin-left: 0.2%;">
                    <div class="col-md-12">
                        <b>Please Select Outlet to setting special with fee</b><br><br>
                        <label class="mt-checkbox"><input value="all" onchange="checkboxEvent(this)" type="checkbox" id="checkall" class="md-check checkbox-fee-special-outlet" /> <span></span> Check All Outlet Special</label>
                        <table class="table table-striped table-bordered table-hover" width="100%" id="tableListOutlet">
                            <thead>
                            <tr>
                                <th>Checkbox</th>
                                <th>Outlet</th>
                                <th>Status Mitra</th>
                                <th>Special Outlet Fee </th>
                            </tr>
                            </thead>
                            <tbody id="tableListOutletBody"></tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 7%;">
                    <label class="col-md-2 control-label">Percent Fee<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="jumlah fee yang akan di bebankan ke pihak outlet" data-container="body"></i></label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="outlet_special_fee"><span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_outlet">
            </div>
        </form>
        <div class="form-actions" style="text-align: center">
            <button onclick="submitFeeSpecialOutlet()" class="btn green">Submit</button>
        </div>
    </div>
</div>