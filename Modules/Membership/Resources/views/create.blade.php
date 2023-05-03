@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-input-mask.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
            placeholder: 'Category Description',
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">Create Membership</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Membership Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="membership_name" value="{{ old('membership_name') }}">
                        </div>
                    </div>
					<hr>
                    <h4>Requirements</h4>
					<div class="form-group">
                        <label class="col-md-3 control-label">Transaction Value</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_number" name="min_total_value" value="{{ old('min_total_value') }}">
                        </div>
						<label class="col-md-3 control-label">Retain Transaction Value</label>
                        <div class="col-md-3">
                            <input type="text"  class="form-control mask_number" name="retain_min_total_value" value="{{ old('retain_min_total_value') }}">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-3 control-label">Transaction Count</label>
                        <div class="col-md-3">
                            <input type="text"  class="form-control mask_number" name="min_total_count" value="{{ old('min_total_count') }}">
                        </div>
						 <label class="col-md-3 control-label">Retain Transaction Count</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_number" name="retain_min_total_count" value="{{ old('retain_min_total_count') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Retain Days</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_number" name="retain_days" value="{{ old('retain_days') }}">
                        </div>
                    </div>
					<hr>
                    <h4>Benefits</h4>
					<div class="form-group">
                        <label class="col-md-3 control-label">Point Multiplier</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_decimal" name="benefit_point_multiplier" value="{{ old('benefit_point_multiplier') }}" style="text-algin:left !important;">
                        </div>
						 <label class="col-md-3 control-label">Cashback Multiplier</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_decimal" name="benefit_cashback_multiplier" value="{{ old('benefit_cashback_multiplier') }}" style="text-algin:left !important;">
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-3 control-label">Promo ID</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="benefit_promo_id" value="{{ old('benefit_promo_id') }}">
                        </div>
						 <label class="col-md-3 control-label">Discount</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control mask_number" name="benefit_discount" value="{{ old('benefit_discount') }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-5 col-md-4">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection