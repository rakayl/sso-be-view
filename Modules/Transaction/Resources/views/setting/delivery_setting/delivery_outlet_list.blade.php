@extends('layouts.main')

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Order</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Delivery Settings</span>
            <i class="fa fa-circle"></i>
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
        <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">List Delivery</span>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover dt-responsive">
            <thead>
            <tr>
                <th>Delivery Method</th>
                <th>Delivery Name</th>
                <th>Status</th>
                <th>Outlet Delivery ON</th>
                <th>Outlet Delivery OFF</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="sortable">
            @foreach($delivery as $key => $value)
                <tr>
                    <td>{{ucfirst($value['delivery_method'])}}</td>
                    <td>{{$value['delivery_name']}}</td>
                    <td>@if($value['available_status'] == 1) Enable @else Disable @endif</td>
                    <td>{{number_format($value['count_outlet_on'])}}</td>
                    <td>{{number_format($value['count_outlet_off'])}}</td>
                    <td>
                        <a href="{{ url('transaction/setting/delivery-outlet/detail') }}/{{$value['code']}}" class="btn btn-sm blue"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
