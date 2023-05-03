<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-yellow sbold uppercase">Setting Fee Disburse</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{url('disburse/setting/fee-disburse')}}" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Fee Disburse
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah biaya transfer" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input class="form-control" type="text" id="input-fee-disburse" name="value" @if(isset($fee_disburse['value'])) value="{{$fee_disburse['value']}}" @endif required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align: center">
                <button type="submit" class="btn green">Submit</button>
            </div>
        </form>
    </div>
</div>