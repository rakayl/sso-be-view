<?php
    use App\Lib\MyHelper;
	$configs = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        function hapus(value){
		swal({
		  title: "Are you sure to decline this manual payment ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Yes, Decline it!",
		  closeOnConfirm: false
		},
		function(){
			DeclineForm.submit();
		});
	}
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Payment Note Confirm',
            tabsize: 2,
            toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
            height: 120
        });
    });
    </script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
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
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Detail Deals Payment Manual</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-green"></i>
                                    <span class="caption-subject font-green sbold uppercase">Deals</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                               <label>Deals Title</label>
                                <a href="{{url('deals/detail/'.$result['deal']['id_deals'].'/'.$result['deal']['deals_promo_id'])}}"><h5 style="font-weight: bold;">{{ $result['deal']['deals_title'] }}</h5></a>

                                <label>Deals Voucher Price Cash</label>
                                <h5 style="font-weight: bold;">Rp {{ number_format($result['deals_user']['voucher_price_cash'], 2) }}</h5>

                                <label>Payment Status</label>
                                <h5 style="font-weight: bold;">{{ $result['deals_user']['paid_status'] }}</h5>

                                <label>Deals Voucher Expired</label>
                                <h5 style="font-weight: bold;">{{ date('d F Y h:i:s', strtotime($result['deals_user']['voucher_expired_at'])) }}</h5>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-green"></i>
                                    <span class="caption-subject font-green sbold uppercase">Customer</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                               <label>Name</label>
                               <a href="{{url('user/detail/'.$result['deals_user']['user']['phone'])}}"><h5 style="font-weight: bold;">{{ $result['deals_user']['user']['name'] }}</h5></a>

                               <label>Phone</label>
                                <h5 style="font-weight: bold;">{{ $result['deals_user']['user']['phone'] }}</h5>

                               <label>Email</label>
                               <h5 style="font-weight: bold;">{{ $result['deals_user']['user']['email'] }}</h5>

                               <label>Gender</label>
                               <h5 style="font-weight: bold;">{{ $result['deals_user']['user']['gender'] }}</h5>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-layers font-green"></i>
                                    <span class="caption-subject font-green sbold uppercase">Payment</span>
                                </div>
                            </div>
                            <div class="portlet-body row">
                                <div class="col-md-6 col-xs-12">
                                    <label>Date Time</label>
                                        <h5 style="font-weight: bold;">{{ date('d F Y',strtotime($result['payment_date'])) }}{{date('h:i:s',strtotime($result['payment_time']))}}</h5>

                                    <label>Bank</label>
                                    <h5 style="font-weight: bold;">{{ $result['payment_bank'] }}</h5>

                                    <label>Payment Method</label>
                                    <h5 style="font-weight: bold;">{{ $result['payment_method'] }}</h5>

                                    <label>Account Number</label>
                                    <h5 style="font-weight: bold;">{{ $result['payment_account_number'] }}</h5>

                                    <label>Account Name</label>
                                    <h5 style="font-weight: bold;">{{ $result['payment_account_name'] }}</h5>

                                    <label>Nominal</label>
                                    <h5 style="font-weight: bold;">Rp {{ number_format($result['payment_nominal']) }}</h5>

                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label>Receipt</label>
                                    <br>
                                    <a data-toggle="modal" data-target="#modalReceipt">
                                    <img style="width:200px" src="{{env('STORAGE_URL_API')}}{{ $result['payment_receipt_image'] }}">
                                    </a>
                                    <br><br>

                                    <label>Note</label>
                                    <h5 style="font-weight: bold;">{{ $result['payment_note'] }}</h5>
                                </div>

                                @if(empty($result['confirmed_at']) && empty($result['cancelled_at']))
                                <div class="col-md-12 col-xs-12" style="text-align:center; margin-top:30px">
                                    <a class="btn green" data-toggle="modal" data-target="#modalAccept"> Accept</a>
                                    <a onClick="hapus('{{$result['id_deals_payment_manual']}}')" class="btn red"> Decline</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(!empty($result['id_user_confirming']))
                        <div class="col-md-12 col-sm-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class=" icon-layers font-green"></i>
                                        <span class="caption-subject font-green sbold uppercase">Payment Confirm</span>
                                    </div>
                                </div>
                                <div class="portlet-body row">
                                    <div class="col-md-6 col-xs-12">
                                        @if(!empty($result['confirmed_at']))
                                        <label>Accepted At</label>
                                        <h5 style="font-weight: bold;">{{ date('d F Y h:i:s', strtotime($result['confirmed_at'])) }}</h5>
                                        @endif

                                        @if(!empty($result['cancelled_at']))
                                        <label>Declined At</label>
                                        <h5 style="font-weight: bold;">{{ date('d F Y h:i:s', strtotime($result['cancelled_at'])) }}</h5>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        @if(!empty($result['confirmed_at']))
                                        <label>Accepted By</label>
                                        <h5 style="font-weight: bold;">{{ $result['user']['name'] }}</h5>
                                        @endif

                                        @if(!empty($result['cancelled_at']))
                                        <label>Declined By</label>
                                        <h5 style="font-weight: bold;">{{ $result['user']['name'] }}</h5>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                    @if(!empty($result['confirmed_at']))
                                    <label>Note Confirm</label>
                                    <strong><?php echo $result['payment_note_confirm'] ?></strong>
                                    @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-modal-lg" id="modalAccept" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Accept Transaction Payment Manual</h4>
                </div>
                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-body form">
                    <input type="hidden" name="id_deals_payment_manual" value="{{$result['id_deals_payment_manual']}}">
                    <input type="hidden" name="status" value="accept">
                        <div class="form-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-2 control-label">
                                    Note Confirm
                                    {{-- <span class="required" aria-required="true"> * </span>   --}}
                                </label>
                                <div class="col-md-10">
                                    <textarea name="payment_note_confirm" class="form-control summernote"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn green">Accept</button>
                        <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-modal-lg" id="modalReceipt" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Receipt Transaction Payment Manual</h4>
                </div>
                <div class="modal-body" style="text-align:center">
                    <img style="width:80%" src="{{ env('STORAGE_URL_API')}}{{ $result['payment_receipt_image'] }}">
                </div>
            </div>
        </div>
    </div>

    <form id="DeclineForm" method="post" action="">
        {{csrf_field()}}
        <input type="hidden" name="id_deals_payment_manual" value="{{$result['id_deals_payment_manual']}}">
        <input type="hidden" name="status" value="decline">
    </form>
@endsection