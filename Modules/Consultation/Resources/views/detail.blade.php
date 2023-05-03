
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .container-chat {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        }

        .darker {
        border-color: #ccc;
        background-color: #ddd;
        }

        .container-chat::after {
        content: "";
        clear: both;
        display: table;
        }

        .container-chat img {
        max-width: 200px;
        width: 100%;
        margin-right: 20px;
        }

        .container-chat img.right {
        float: right;
        margin-left: 20px;
        margin-right:0;
        }

        .time-right {
        float: right;
        color: #aaa;
        margin-right:10px;
        }

        .time-left {
        float: left;
        color: #999;
        }
    </style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="#">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>{{ $title }}</span>
			@if (!empty($sub_title))
				<i class="fa fa-circle"></i>
			@endif
		</li>
		@if (!empty($sub_title))
		<li>
			<span>{{ $sub_title }}</span>
		</li>
		@endif
	</ul>
</div>
<br>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#detail_transaction" data-toggle="tab"> Detail Transaksi </a>
                    </li>
                    <li>
                        <a href="#chat" data-toggle="tab"> Detail Chat </a>
                    </li>
                    <li>
                        <a href="#summary" data-toggle="tab"> Hasil Konsultasi </a>
                    </li>
                    <li>
                        <a href="#product_recomendation" data-toggle="tab"> Rekomendasi Produk </a>
                    </li>
                    <li>
                        <a href="#drug_recomendation" data-toggle="tab"> Resep Obat </a>
                    </li>
				</ul>
			</div>
			<div class="tab-pane active" id="detail_transaction">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<span class="caption-subject bold uppercase">Detail Transaksi</span>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            @if(!empty($result['transaction']))
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                                    <tbody>
                                            <tr>
                                                <td>Nomor Transaksi</td>
                                                <td>TRX{{$result['transaction']['transaction_receipt_number']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Transaksi</td>
                                                <td>{{ date('d F Y', strtotime($result['transaction']['transaction_date'])) }} | {{ date('H:i', strtotime($result['transaction']['transaction_date'])) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Doctor</td>
                                                <td>{{$result['doctor']['doctor_name']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Customer</td>
                                                <td>{{$result['customer']['name']}}</td>
                                            </tr>
                                            <tr>	
                                                <td>Jenis Pembayaran</td>
                                                <td>{{(empty($result['transaction']['trasaction_payment_type']) ? '-' : $result['transaction']['trasaction_payment_type'])}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status Pembayaran </td>
                                                <td>{{$result['transaction']['transaction_payment_status']}}</td>
                                            </tr>
                                            <tr>	
                                                <td>Tipe Konsultasi</td>
                                                <td>{{$result['consultation']['consultation_type']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Konsultasi</td>
                                                <td>{{date('d F Y', strtotime($result['consultation']['schedule_date']))}}</td>
                                            </tr>
                                            <tr>	
                                                <td>Waktu Mulai</td>
                                                <td>{{date('H:i', strtotime($result['consultation']['schedule_start_time']))}}</td>
                                            </tr>
                                            <tr>	
                                                <td>Waktu Selesai</td>
                                                <td>{{date('H:i', strtotime($result['consultation']['schedule_end_time']))}}</td>
                                            </tr>
                                            <tr>	
                                                <td>Status Konsultasi</td>
                                                <td>{{$result['consultation']['consultation_status']}}</td>
                                            </tr>	
                                    </tbody>
                                </table>
                            @else
                                Detail Transaction is empty
                            @endif
                        </div>
                        <!-- END: Comments -->
					</div>
                    <div class="form-actions">
                        <form class="form-horizontal" role="form" action="{{ url('consultation/be/detail/export') }}" method="post">
                            <input type="hidden" name="id_transaction" class="md-radiobtn" value="{{$result['transaction']['id_transaction']}}" required checked>
                            <div class="form-actions">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12" style="margin-left:15px;">
                                        <div class="form-group">
                                            <a href="{{url('consultation/be', $result['transaction']['id_transaction'])}}/edit" class="btn yellow">Manage Status</a>
                                            <button type="submit" id="export_btn" class="btn green">Export</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
				</div>
			</div>
			<div class="tab-pane" id="chat">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<span class="caption-subject bold uppercase"> Detail Chat </span>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            @if(!empty($result['messages']))
                            @foreach($result['messages'] as $key => $message)
                                @if($message['direction'] == 'OUTBOUND')
                                    <div class="container-chat">
                                        <h5><b> {{$result['doctor']['doctor_name']}} </b></h5>
                                        @if($message['content_type'] == 'DOCUMENT')
                                        <a href="{{$message['url']}}" target="_blank"><i class="fa fa-file"> </i> {{$message['caption']}}</a>
                                        @elseif($message['content_type'] == 'IMAGE')
                                        <center>
                                        <img src="{{$message['url']}}" alt="{{$message['caption']}}" width="100%">
                                        <p>{{$message['caption']}}</p>
                                        </center>
                                        @else
                                        <p>{{$message['text']}}</p>
                                        @endif
                                        <span class="time-right">{{date('H:i', strtotime($message['created_at_infobip']))}}</span>
                                    </div>
                                @else
                                    <div class="container-chat darker">
                                        <h5 style="text-align:right; margin-right:10px;"><b> {{$result['customer']['name']}} </b></h5>
                                        @if($message['content_type'] == 'DOCUMENT')
                                        <a href="{{$message['url']}}" target="_blank"><i class="fa fa-file"> </i> {{$message['caption']}}</a>
                                        @elseif($message['content_type'] == 'IMAGE')
                                        <center>
                                        <img src="{{$message['url']}}" alt="{{$message['caption']}}" width="100%">
                                        <p>{{$message['caption']}}</p>
                                        </center>
                                        @else
                                        <p>{{$message['text']}}</p>
                                        @endif
                                        <span class="time-right">{{date('H:i', strtotime($message['created_at_infobip']))}}</span>
                                    </div>
                                @endif
                            @endforeach
                            @else
                                Riwayat Chat Kosong
                            @endif
                        </div>
                        <!-- END: Comments -->
					</div>
				</div>
			</div>
			<div class="tab-pane" id="summary">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue bold uppercase"> Hasil Konsultasi </span>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            @if(!empty($result['consultation']))
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th><b>Keluhan</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['consultation']['disease_complaint']))
                                            @foreach($result['consultation']['disease_complaint'] as $complaint)
                                            <tr>
                                                <td>{{$complaint}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td>-</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                                    <thead>
                                        <tr>
                                            <th><b>Diagnosa</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($result['consultation']['disease_analysis']))
                                            @foreach($result['consultation']['disease_analysis'] as $analysis)
                                            <tr>
                                                <td>{{$analysis}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td>-</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="30%"><b>Anjuran Penanganan</b></td>
                                            <td>{{$result['consultation']['treatment_recomendation']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                Transaction is empty
                            @endif
                        </div>
                        <!-- END: Comments -->
					</div>
				</div>
			</div>
            <div class="tab-pane" id="product_recomendation">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue bold uppercase"> Rekomendasi Produk </span>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            @if(!empty($result['consultation']))
                            <table class="table table-striped table-bordered table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Variant</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['recomendation_product']))
                                        @foreach($result['recomendation_product'] as $res)
                                        <tr>
                                            <td>{{$res['product']['product_name']}}</td>
                                            <td>{{$res['product']['variants'] != null ? $res['product']['variants']['childs'][0]['product_variant_name'] : '-' }}</td>
                                            @php
                                            $product_price = $res['product']['product_price'];
                                            if($res['product']['variants'] != null && isset($res['product']['variants']['childs'][0]['product_variant_group_price'])){
                                                $product_price = $res['product']['variants']['childs'][0]['product_variant_group_price'];
                                            }
                                            @endphp
                                            <td>Rp {{number_format($product_price,0,",",".")}}</td>
                                            <td>{{$res['qty']}}</td>
                                            @php $subtotal = $product_price * $res['qty']; @endphp
                                            <td>Rp {{number_format($subtotal,0,",",".")}}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="5" style="text-align:center">Recomendation Product is empty</td></tr>
                                    @endif
                                </tbody>
                            </table>
                            @else
                                Transaction is empty
                            @endif
                        </div>
                        <!-- END: Comments -->
					</div>
				</div>
			</div>
            <div class="tab-pane" id="drug_recomendation">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue bold uppercase"> Resep Obat </span>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- BEGIN: Comments -->
                        <div class="mt-comments">
                            <table class="table table-striped table-bordered table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Variant</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($result['recomendation_drug']))
                                        @foreach($result['recomendation_drug'] as $res)
                                        <tr>
                                            <td>{{$res['product']['product_name']}}</td>
                                            <td>{{$res['product']['variants'] != null ? $res['product']['variants']['childs'][0]['product_variant_name'] : '-' }}</td>
                                            @php
                                            $product_price = $res['product']['product_price'];
                                            if($res['product']['variants'] != null){
                                                $product_price = $res['product']['variants']['childs'][0]['product_variant_group_price'];
                                            }
                                            @endphp
                                            <td>Rp {{number_format($product_price,0,",",".")}}</td>
                                            <td>{{$res['qty']}}</td>
                                            @php $subtotal = $product_price * $res['qty']; @endphp
                                            <td>Rp {{number_format($subtotal,0,",",".")}}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="5" style="text-align:center">Resep Obat is empty</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- END: Comments -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection