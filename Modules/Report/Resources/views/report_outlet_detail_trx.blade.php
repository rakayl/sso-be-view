@extends('layouts.main')

@section('page-style')
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{Cdn::asset('kk-ass/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{Cdn::asset('kk-ass/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{Cdn::asset('kk-ass/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script>
        $('.select-take').change(function(){
            $('#form').submit();
        })
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
    
    
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">Date Range</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('report/outlet/detail/form') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Start <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_start" value="{{ $date_start }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <label class="col-md-2 control-label">End <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_end" value="{{ $date_end }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Outlet <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-10">
                            <div class="input-icon right">
                                <select class="form-control select2" name="id_outlet" data-placeholder="select outlet" required>
                                <optgroup label="Outlet List">
                                    @if (!empty($all_outlet))
                                        @foreach ($all_outlet as $key => $out)
                                            <option value="{{ $out['id_outlet'] }}" @if (isset($id_outlet) && $id_outlet == $out['id_outlet']) selected @elseif (old('id_outlet') == $out['id_outlet']) selected @endif>{{ $out['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-2 col-md-2">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-settings font-red"></i>
                <span class="caption-subject sbold uppercase font-yellow">Info Outlet</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <tbody>
                        <tr>
                            <td> <b> Code </b> </td>
                            <td> {{ $outlet[0]['outlet_code'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Name </b> </td>
                            <td> {{ $outlet[0]['outlet_name'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Address </b> </td>
                            <td> {{ $outlet[0]['outlet_address'] }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-yellow">Transaction</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="col-md-12 right">
                <form action="" method="POST" id="form">
                {{csrf_field()}}
                <label>Display
                    <span style="display:inline-block">
                    <select name="take" class="form-control select select-take">
                        <option value="10" @if($take == 10) selected @endif>10</option>
                        <option value="50" @if($take == 50) selected @endif>50</option>
                        <option value="100" @if($take == 100) selected @endif>100</option>
                        <option value="500" @if($take == 500) selected @endif>500</option>
                        <option value="9999999999" @if($take == 9999999999) selected @endif>ALL</option>
                    </select>
                    </span>
                    Data per Page
                </label>
                </form>
					</div>
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                    <thead>
                        <tr>
                            <th> Date </th>
                            <th> Type </th>
                            <th> Receipt Number </th>
                            <th> User </th>
                            <th> Grand Total </th>
                            <th> Payment Status</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($transaction))
                            @foreach($transaction as $value)
                                <tr>
                                    <td>{{ date('d F Y H:i', strtotime($value['transaction_date'])) }}</td>
                                    <td>{{ $value['trasaction_type'] }}</td>
                                    <td>{{ $value['transaction_receipt_number'] }}</td>
                                    <td>@if(isset($value['user'])){{ $value['user']['name'] }}@endif</td>
                                    <td>{{ number_format($value['transaction_grandtotal'], 0, ',', '.') }}</td>
                                    <td>{{ $value['transaction_payment_status'] }}</td>
                                    <td>
                                        <a href="{{ url('transaction/detail/'.$value['transaction_receipt_number'].'/'.strtolower($value['trasaction_type'])) }}" data-popout="true" class="btn btn-sm blue"><i class="fa fa-search"></i> Detail</a> 
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                
                <div>
                    Showing {{$from}} to {{$to}} of {{$total}} entries
                </div>
                <div class="pagination pull-right" style="margin-top:-28px;margin-bottom: 0px;">
                    @if ($paginator)
                    {{ $paginator->links() }}
                    @endif
                </div>
            </div>
        </div>
      </div>
    </div>
    
@endsection
