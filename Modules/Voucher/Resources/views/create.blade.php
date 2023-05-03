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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.related').click(function() {
                var nilai = $(this).val();

                $('.'+nilai).show();
                $('.'+nilai+'Op').hide();
                $('.'+nilai+'Form').prop('required', true);
                $('.'+nilai+'FormOp').removeAttr('required');
                $('.'+nilai+'FormOp').val('');
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
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Create Voucher</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Promo ID</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Promo ID" class="form-control" name="promo_id" value="{{ old('promo_id') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="Voucher Name" class="form-control" name="voucher_name" value="{{ old('voucher_name') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Redem Point</label>
                        <div class="col-md-9">
                            <input type="number" maxlength="10" placeholder="Voucher Point" class="form-control" name="voucher_point" value="{{ old('voucher_point') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Voucher Day Valid </label>
                        <div class="col-md-9">
                            <input type="number" placeholder="Valid ... (day)" class="form-control" name="voucher_days_valid" value="{{ old('voucher_days_valid') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Related </label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" class="related" name="related" value="product" required>  Product
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" class="related" name="related" value="treatment" required>  Treatment
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group product treatmentOp" style="display: none;">
                        <label for="multiple" class="control-label col-md-3">Product</label>
                        <div class="col-md-9">
                            <select id="multiple" class="form-control select2-multiple productForm treatmentFormOp" name="id_product" data-placeholder="Product">
                                <optgroup label="Product List">
                                    @if (!empty($product))
                                        <option></option>
                                        @foreach($product as $suw)
                                            <option value="{{ $suw['id_product'] }}">{{ $suw['product_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group treatment productOp" style="display: none;">
                        <label for="multiple" class="control-label col-md-3">Treatment</label>
                        <div class="col-md-9">
                            <select id="multiple" class="form-control select2-multiple treatmentForm productFormOp" name=" id_treatment" data-placeholder="Treatment">
                                <optgroup label="Treatment List">
                                    @if (!empty($treatment))
                                        <option></option>
                                        @foreach($treatment as $suw)
                                            <option value="{{ $suw['id_treatment'] }}">{{ $suw['treatment_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Outlet Available</label>
                        <div class="col-md-9">
                            <select id="multiple" class="form-control select2-multiple" name=" id_outlet[]" multiple data-placeholder="Select Available Outlet" required>
                                <optgroup label="Available Outlet">
                                    @if (!empty($outlet))
                                        <option></option>
                                        <option value="all">All</option>
                                        @php
                                            $gabungan = "";
                                        @endphp
                                        @foreach($outlet as $suw)
                                            @php
                                                $gabungan = $gabungan."|".$suw['id_outlet'];
                                            @endphp
                                            <option value="{{ $suw['id_outlet'] }}">{{ $suw['outlet_code'] }} - {{ $suw['outlet_name'] }}</option>
                                        @endforeach
                                        <input type="hidden" name="outlet" value="{{ $gabungan }}">
                                    @endif
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection