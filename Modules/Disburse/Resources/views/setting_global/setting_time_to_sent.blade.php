<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-yellow sbold uppercase">Setting Time To Sent Disburse</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{url('disburse/setting/time-to-sent')}}" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Time to Sent
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="jumlah hari pengiriman dari tanggal transaksi" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">h+</span>
                            <input class="form-control" type="text" name="value" @if(isset($time_to_sent['value'])) value="{{$time_to_sent['value']}}" @endif required>
                            <span class="input-group-addon">from transaction date</span>
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