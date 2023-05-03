@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
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

<div class="portlet light form-fit bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Setting Cashback Calculation</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" action="#" method="post" id="form">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Product bundling cashback status
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah produk bundling akan diikutsertakan dalam perhitungan cashback atau tidak" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <select class="select2 form-control" name="cashback_include_bundling">
                        <option value="0">Not earning cashback</option>
                        <option value="1" {{$status['cashback_include_bundling'] ? 'selected' : ''}}>Earning cashback</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-10">
                    <button class="btn green" type="submit">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
