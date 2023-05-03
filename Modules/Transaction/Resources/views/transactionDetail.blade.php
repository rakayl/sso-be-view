<?php
    use App\Lib\MyHelper;
	$configs = session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from MAX total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from MAX total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
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
                <span class="caption-subject font-red sbold uppercase">Detail Transaction</span>
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
                                    <span class="caption-subject font-green sbold uppercase">Transaction</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                               <label>Receipt Number</label>
                               <h5 style="font-weight: bold;">- {{ $result['transaction_receipt_number'] }}</h5>

                                <label>Note</label>
                                <h5 style="font-weight: bold;">- {{ $result['transaction_notes'] }}</h5>

                                <label>Price</label>
                                <h5 style="font-weight: bold;">- Rp {{ number_format($result['transaction_subtotal'], 2) }}</h5>

                                <label>Tax</label>
                                <h5 style="font-weight: bold;">- Rp {{ number_format($result['transaction_tax'], 2) }}</h5>

                                <label>Delivery</label>
                                <h5 style="font-weight: bold;">- Rp {{ number_format($result['transaction_shipment'], 2) }}</h5>

                                <label>Grand Total</label>
                                <h5 style="font-weight: bold;">- Rp {{ number_format($result['transaction_grandtotal'], 2) }}</h5>

                                @if(MyHelper::hasAccess([18], $configs))
                                <label>Point</label>
                                <h5 style="font-weight: bold;">- {{ $result['transaction_point_earned'] }}</h5>
                                @endif

                                @if(MyHelper::hasAccess([19], $configs))
                                <label>Cashback</label>
                                <h5 style="font-weight: bold;">- {{ $result['transaction_cashback_earned'] }}</h5>
                                @endif

                                <label>Status</label>
                                <h5 style="font-weight: bold;">- {{ $result['transaction_payment_status'] }}</h5>

                                <label>Membership</label>
                                <h5 style="font-weight: bold;">- {{ $result['membership_level'] }}</h5>

                                <label>Promo Id</label>
                                <h5 style="font-weight: bold;">- {{ $result['membership_promo_id'] }}</h5>

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
                               <h5 style="font-weight: bold;">- {{ $result['user']['name'] }}</h5>

                               <label>Phone</label>
                               <h5 style="font-weight: bold;">- {{ $result['user']['phone'] }}</h5>

                               <label>Email</label>
                               <h5 style="font-weight: bold;">- {{ $result['user']['email'] }}</h5>

                               <label>Gender</label>
                               <h5 style="font-weight: bold;">- {{ $result['user']['gender'] }}</h5>

                               <label>Provider</label>
                               <h5 style="font-weight: bold;">- {{ $result['user']['provider'] }}</h5>

                               <label>Birthday</label>
                               <h5 style="font-weight: bold;">- {{ $result['user']['birthday'] }}</h5>

                               @if(MyHelper::hasAccess([18], $configs))
                                <label>Point</label>
                                <h5 style="font-weight: bold;">- {{ $result['user']['points'] }}</h5>
                               @endif

                                @if(MyHelper::hasAccess([19], $configs))
                                    <label>Balance</label>
                                    @if(empty($result['user']['balance']))
                                        <h5 style="font-weight: bold;">- 0</h5>
                                    @else
                                        <h5 style="font-weight: bold;">- {{ $result['user']['balance'] }}</h5>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span class="caption-subject font-green sbold uppercase">Payment</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                           <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                            <thead>
                              <tr>
                                  <th>Payment Type</th>
                                  <th>Payment Name</th>
                                  <th>Payment Ammount</th>
                                  <th>Date</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if ($result['trasaction_payment_type'] == 'Offline')
                                    @if(!empty($result['payment_offline']))
                                        @foreach($result['payment_offline'] as $res)
                                            <tr>
                                                <td>{{ $res['payment_type'] }}</td>
                                                <td>{{ $res['payment_bank'] }}</td>
                                                <td>Rp {{ number_format($res['payment_amount'], 2) }}</td>
                                                <td>{{ date('Y-m-d H:i:s', strtotime($res['created_at'])) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @else
                                     @if(!empty($result['payment']))
                                        <tr>
                                            <td>{{ $result['payment']['payment_method'] }}</td>
                                            <td>{{ $result['payment']['payment_bank'] }}</td>
                                            <td>Rp {{ number_format($result['payment']['payment_nominal'], 2) }}</td>
                                            <td>{{ date('Y-m-d H:i:s', strtotime($result['payment']['created_at'])) }}</td>
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-layers font-green"></i>
                                <span class="caption-subject font-green sbold uppercase">Product Transaction</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                           <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                            <thead>
                              <tr>
                                  <th>Product Code</th>
                                  <th>Product Name</th>
                                  <th>Product Category</th>
                                  <th>Quality</th>
                                  <th>Subtotal</th>
                                  <th>Notes</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if(!empty($result['product_transaction']))
                                    @foreach($result['product_transaction'] as $res)
                                        <tr>
                                            <td>{{ $res['product']['product_code'] }}</td>
                                            <td>{{ $res['product']['product_name'] }}</td>
                                            <td>{{ $res['product']['product_category']['product_category_name'] }}</td>
                                            <td>{{ $res['transaction_product_qty'] }}</td>
                                            <td>Rp {{ number_format($res['transaction_product_subtotal'], 2) }}</td>
                                            <td>{{ $res['transaction_product_note'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
    </div>
@endsection