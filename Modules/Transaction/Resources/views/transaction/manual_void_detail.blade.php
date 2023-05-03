@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
@endsection

@section('page-script')
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

    <div class="form-group">
        <a href="{{url('transaction/failed-void-payment')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Failed Void Payment Detail</span>
            </div>
        </div>
        <div class="portlet-body">
        </div>
    </div>
@endsection
