@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('content')
@php
  // print_r($point);die();
@endphp
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
                <span class="caption-subject font-red sbold uppercase">Point Log User</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>User Name</th>
                  <th>Point</th>
                  <th>Source</th>
                  <th>Grand Total</th>
                  <th>Point Convers</th>
                  <th>Membership</th>
                  <th>Point Percentage</th>
                  {{-- <th>Actions</th> --}}
              </tr>
            </thead>
            <tbody>
                @if(!empty($point))
                    @foreach($point as $res)
                        <tr>
                            <td>{{ $res['user']['name'] }}</td>
                            <td>{{ $res['point'] }}</td>
                            <td>{{ ucwords($res['source']) }}</td>
                            <td>{{ number_format($res['grand_total']) }}</td>
                            <td>{{ number_format($res['point_conversion']) }}</td>
                            <td>{{ $res['membership_level'] }}</td>
                            <td>{{ $res['membership_point_percentage'] }} %</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
                    @if ($pointPaginator)
                      {{ $pointPaginator->links() }}
                    @endif
        </div>
    </div>
@endsection
