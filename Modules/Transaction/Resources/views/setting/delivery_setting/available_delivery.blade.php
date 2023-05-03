@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .sortable-handle {
        cursor: move;
    }
    tbody tr {
        background: white;
    }
</style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection

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
            <span class="caption-subject font-green bold uppercase">Available Delivery</span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal" action="{{ url('transaction/setting/available-delivery') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Delivery Method</th>
                            <th>Delivery Name</th>
                            <th>Drop to Counter</th>
                            <th>Available Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($delivery as $key => $val)
                            <tr class="bg-grey-opacity">
                                <td>{{ucfirst($val['delivery_method'])}}</td>
                                <td>
                                    <input name="delivery[{{$val['delivery_method']}}][delivery_name]" class="form-control" value="{{$val['delivery_name']}}">
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach($val['service'] as $index=>$service)
                                <tr>
                                    <td>
                                        {{ucfirst($service['code'])}}
                                        <input type="hidden" name="delivery[{{$val['delivery_method']}}][service][{{$index}}][code]" value="{{$service['code']}}">
                                    </td>
                                    <td>
                                        <input name="delivery[{{$val['delivery_method']}}][service][{{$index}}][service_name]" class="form-control" value="{{$service['service_name']}}">
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delivery[{{$val['delivery_method']}}][service][{{$index}}][drop_counter_status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Available" data-off-color="default" data-off-text="Unavailable" value="1" @if(($service['drop_counter_status']??1) == 1) checked @endif>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="delivery[{{$val['delivery_method']}}][service][{{$index}}][available_status]" class="make-switch brand_visibility" data-size="small" data-on-color="info" data-on-text="Enable" data-off-color="default" data-off-text="Disable" value="1" @if($service['available_status'] == 1) checked @endif>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-actions text-center">
                <button onclick="unsaved=false" class="btn green">
                    <i class="fa fa-check"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
