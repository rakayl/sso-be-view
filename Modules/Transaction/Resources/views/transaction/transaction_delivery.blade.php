@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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

    <form role="form" action="{{ url('transaction/'.$key.'/'.date('YmdHis').'/filter') }}" method="post">
		@include('transaction::transaction.transaction_filter')
	</form>

    @include('layouts.notifications')

    @if (!empty($search))
	    <div class="alert alert-block alert-info fade in">
			<button type="button" class="close" data-dismiss="alert"></button>
			<h4 class="alert-heading">Displaying search result :</h4>
            @if(isset($trxTotal))<p>{{ $trxTotal }} data</p><br>@else<p>0 data</p><br>@endif
        <a href="{{ url('transaction/'.$key.'/'.date('YmdHis')) }}" class="btn btn-sm btn-warning">Reset</a>
			<br>
		</div>
    @endif

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">List Transaction {{ strtolower($key) == 'all' ? '' : $key }}</span>
            </div>
            <div class="actions">
                @if(isset($trx) && !empty($trx))
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1"><i class="fa fa-download"></i> Export</a>
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1&detail=1"><i class="fa fa-download"></i> Export Detail</a>
                @endif
            </div>
        </div>
        <div class="portlet-body">
            <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered table-hover dt-responsive">
            <thead>
              <tr>
                  <th>Actions</th>
                  <th>Date</th>
                  <th>Outlet</th>
                  <th>Transaction Type</th>
                  <th>Receipt Number</th>
                  <th>Customer Name</th>
                  <th>Phone</th>
                  <th>Total Price</th>
                  <th>Payment Status</th>
                  <th>Transaction Status</th>
                  @if(strtolower($key) == 'delivery')
                  <th>Shipment Status</th>
                  @endif
              </tr>
            </thead>
            <tbody>
                @if(!empty($trx))
                    @foreach($trx as $res)
                        <tr>
                            <td>
                                <a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail') }}/{{ $res['id_transaction'] }}/{{ $key }}"><i class="icon-pencil"></i> Detail </a>
                                {{-- <a class="btn btn-block red btn-xs" href="{{ url('transaction/delete', $res['transaction_receipt_number']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-close"></i> Delete </a> --}}
                            </td>
                            <td>{{ date('d M Y H:i:s', strtotime($res['transaction_date'])) }}</td>
                            <td>{{ $res['outlet_code'] }} - {{ $res['outlet_name'] }}</td>
                            <td><span class="badge bg-{{$res['pickup_by'] == 'Customer' ? 'green-jungle':'blue'}}">{{$res['pickup_by'] == 'Customer' ? 'Pickup Order':'Delivery'}}</span></td>
                            <td>{{ $res['transaction_receipt_number'] }}</td>
                            @if (isset($res['name']))
                              <td>{{ $res['name'] }}</td>
                            @else
                              <td>{{ $res['user']['name'] }}</td>
                            @endif

                            @if (isset($res['phone']))
                              <td>{{ $res['phone'] }}</td>
                            @else
                              <td>{{ $res['user']['phone'] }}</td>
                            @endif

                            <td>Rp {{ number_format($res['transaction_grandtotal'], 2) }}</td>
                            <td>
                                @if($res['transaction_payment_status'] == 'Completed')
                                    <span class="badge" style="background-color: #A6BA35;">Completed</span>
                                @elseif($res['transaction_payment_status'] == 'Pending')
                                    <span class="badge" style="background-color: #FD6437">Pending</span>
                                @elseif($res['transaction_payment_status'] == 'Cancelled')
                                    <span class="badge" style="background-color: #EF1E31">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($res['reject_at']))
                                    <span class="badge" style="background-color: #EF1E31">Reject : {{$res['reject_reason']}}</span>
                                @elseif(!empty($res['taken_by_system_at']))
                                    <span class="badge bg-green-jungle">Taken by System</span>
                                @elseif(!empty($res['taken_at']) && $res['pickup_by'] == 'Customer')
                                    <span class="badge bg-green-jungle">Taken by Customer</span>
                                @elseif(!empty($res['taken_at']) && $res['pickup_by'] != 'Customer')
                                    <span class="badge bg-green-jungle">Taken by Driver</span>
                                @elseif(!empty($res['ready_at']) && empty($res['taken_at']))
                                    <span class="badge" style="background-color: #7DB8B2">Ready</span>
                                @elseif(!empty($res['receive_at']) && empty($res['ready_at']))
                                    <span class="badge" style="background-color: #006451">Received</span>
                                @elseif(empty($res['receive_at']))
                                    <span class="badge" style="background-color: #FD6437">Pending</span>
                                @endif
                            </td>
                            @if(strtolower($key) == 'delivery')
                            @php 
                            $bg = 'default';
                            switch(strtolower($res['latest_status'])){
                                case 'finding driver':
                                case 'driver found':
                                    $bg = 'yellow-crusta';
                                    break;
                                case 'enroute pickup':
                                case 'item picked by driver':
                                    $bg = 'yellow-gold';
                                    break;
                                case 'enroute drop':
                                    $bg = 'green-jungle';
                                    break;
                                case 'completed':
                                    $bg = 'blue-sharp';
                                    break;
                                case 'driver not found':
                                case 'rejected':
                                case 'cancelled':
                                    $bg = 'red';
                                    break;
                            }
                            @endphp
                            <td><span class="badge bg-{{$bg}}">{{$res['latest_status']??''}}</span></td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
            </div>
            @if(isset($trxPerPage) && isset($trxUpTo) && isset($trxTotal))
                Showing {{$trxPerPage}} to {{$trxUpTo}} of {{ $trxTotal }} entries<br>
            @endif
            @if ($trxPaginator)
                {{ $trxPaginator->links() }}
            @endif
        </div>
    </div>
@endsection
