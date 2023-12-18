<br>
<br>
<br>
<div class="form-body">
    <div class="row">
        <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                        <li @if($detail['transaction_status_code']==3||$detail['step_number']==7) class="active" @endif>
                                <a @if($detail['transaction_status_code']==3||in_array($detail['step_number'], [1,2,3,4,5,6,7])) data-toggle="tab" href="#step1" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Pemilihan Vendor </a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==1) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [1,2,3,4,5,6,7])) data-toggle="tab" href="#step2" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Konfirmasi Vendor </a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==2) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [2,3,4,5,6,7])) data-toggle="tab" href="#step3" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Survey Lokasi </a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==3) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [3,4,5,6,7])) data-toggle="tab" href="#step4" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Pengerjaan Sedot WC </a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==4) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [4,5,6,7])) data-toggle="tab" href="#step5" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Perhitungan Biaya </a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==5) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [5,6,7])) data-toggle="tab" href="#step6" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Pembayaran</a>
                        </li>
                        <li @if($detail['transaction_status_code']!=3&&$detail['step_number']==6) class="active" @endif>
                                <a  @if($detail['transaction_status_code']!=3&&in_array($detail['step_number'], [6,7])) data-toggle="tab" href="#step7" @else style="opacity: 0.5 !important;pointer-events: none;" @endif><i class="fa fa-cog"></i> Verifikasi Pembuangan Limbah</a>
                        </li>
                </ul>
        </div>
        <div class="col-md-9">
                <div class="tab-content">
                        <div class="tab-pane @if($detail['transaction_status_code']==3||$detail['step_number']==6) active @endif" id="step1">
                                @include('transaction::sedot.steps.step1')
                        </div>
                        <div class="tab-pane @if($detail['transaction_status_code']!=3&&$detail['step_number']==1) active @endif" id="step2">
                               @include('transaction::sedot.steps.step2')
                        </div>
                        <div class="tab-pane @if($detail['step_number']==2) active @endif" id="step3">
                                @include('transaction::sedot.steps.step3')
                        </div>
                        <div class="tab-pane @if($detail['step_number']==3) active @endif" id="step4">
                                @include('transaction::sedot.steps.step4')
                        </div>
                        <div class="tab-pane @if($detail['step_number']==4) active @endif" id="step5">
                                @include('transaction::sedot.steps.step5')
                        </div>
                        <div class="tab-pane @if($detail['step_number']==5) active @endif" id="step6">
                                @include('transaction::sedot.steps.step6')
                        </div>
                        <div class="tab-pane @if($detail['step_number']==6) active @endif" id="step7">
                                @include('transaction::sedot.steps.step7')
                        </div>
                </div>
        </div>
    </div>
</div>