<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-yellow sbold uppercase">Setting Approver Payouts</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{url('disburse/setting/approver')}}" method="post">
            {{ csrf_field() }}
            <div class="form-body">

                <div class="form-group">
                    <label class="col-md-3 control-label">Approver Status<span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="jumlah fee yang akan di bebankan ke pihak outlet" data-container="body"></i></label>
                    <div class="col-md-2">
                        <input type="checkbox" class="make-switch" name="approver" data-on-text="by Sistem" data-off-text="by Admin" @if(isset($approver['value']) && $approver['value'] == 1) checked @endif>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align: center">
                <button type="submit" class="btn green">Submit</button>
            </div>
        </form>
    </div>
</div>