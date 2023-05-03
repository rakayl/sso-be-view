<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-yellow sbold uppercase">Setting Send Email To (Disburse)</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{url('disburse/setting/send-email-to')}}" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Outlet Mitra
                        <i class="fa fa-question-circle tooltips" data-original-title="ketika diburse sukses, informasi detail akan dikirim ke email bank atau email outlet" data-container="body"></i></label>
                    <div class="col-md-3">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="optionsRadios2" name="outlet_franchise" class="md-radiobtn publishType" value="Email Bank" @if($send_email_to['outlet_franchise'] == 'Email Bank') checked @endif>
                                <label for="optionsRadios2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Email Bank </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="optionsRadios1" name="outlet_franchise" class="md-radiobtn publishType" value="Email Outlet" @if($send_email_to['outlet_franchise'] == 'Email Outlet' || empty($send_email_to['outlet_franchise'])) checked @endif>
                                <label for="optionsRadios1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Email Outlet </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Outlet Pusat
                        <i class="fa fa-question-circle tooltips" data-original-title="ketika diburse sukses, informasi detail akan dikirim ke email bank atau email outlet" data-container="body"></i></label>
                    <div class="col-md-3">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="optionsRadios3" name="outlet_central" class="md-radiobtn publishType" value="Email Bank" @if($send_email_to['outlet_central'] == 'Email Bank') checked @endif>
                                <label for="optionsRadios3">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Email Bank </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="optionsRadios4" name="outlet_central" class="md-radiobtn publishType" value="Email Outlet" @if($send_email_to['outlet_central'] == 'Email Outlet' || empty($send_email_to['outlet_central'])) checked @endif>
                                <label for="optionsRadios4">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Email Outlet </label>
                            </div>
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