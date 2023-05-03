<?php
    use App\Lib\MyHelper;
    $configs = session('configs');
 ?>
@extends('layouts.main')
@include('transaction::transaction.transaction_detail')

@section('page-style')
@yield('sub-page-style')
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

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark sbold uppercase font-blue">Detail Feedback</span>
        </div>
    </div>
    <div class="portlet-body form form-horizontal" id="detailFeedback">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_rating" data-toggle="tab"> Rating </a>
            </li>
            <li>
                <a href="#tab_transaction" data-toggle="tab"> Transaction </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane in active" id="tab_rating">
                <div class="row">
                    <label class="col-md-3  text-right">Create Feedback Date</label>
                    <div class="col-md-5">
                        {{date('d M Y',strtotime($feedback['created_at']))}}<br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Receipt Number</label>
                    <div class="col-md-5">
                        {{$feedback['transaction']['transaction_receipt_number']}}
                        <br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">User</label>
                    <div class="col-md-5">
                        <a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a>
                        <br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Outlet</label>
                    <div class="col-md-5">
                        <a href="{{url('outlet/detail'.'/'.$feedback['outlet']['outlet_code'])}}">{{$feedback['outlet']['outlet_code']}} - {{$feedback['outlet']['outlet_name']}}</a>
                        <br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Grand Total</label>
                    <div class="col-md-5">
                        Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}<br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Vote</label>
                    <div class="col-md-5">
                        {{$rating_items[$feedback['rating_value']]??$feedback['rating_item_text']}}<br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Note</label>
                    <div class="col-md-5">
                        {{$feedback['notes']}}<br/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3  text-right">Image</label>
                    <div class="col-md-9">@if(empty($feedback['image']))No Image @else <div class="row"><div class="col-md-6"><img src="{{env('STORAGE_URL_API')}}{{$feedback['image']}}" class="img-responsive"></div></div> @endif</div>
                </div>

            </div>
            <div class="tab-pane" id="tab_transaction">
                @yield('sub-content')
            </div>
        </div>
    </div>
</div>
@endsection