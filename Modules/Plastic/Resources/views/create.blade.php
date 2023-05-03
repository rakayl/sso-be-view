<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('#capacity').keypress(function (e) {
            var regex = new RegExp("^[0-9 .]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str) || e.which == 8) {
                return true;
            }

            e.preventDefault();
            return false;
        });

        $( ".price" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        }
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
                <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('product-plastic/store')}}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Plastic Code
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan kode plastic" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="product_code" value="{{ old('product_code') }}" placeholder="Plastic Code" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Plastic Type <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe plastik" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="id_plastic_type" data-placeholder="Select type" required>
                                    <option></option>
                                    @foreach($plastic_type as $pt)
                                        <option value="{{$pt['id_plastic_type']}}" @if(old('id_plastic_type') == $pt['id_plastic_type']) selected @endif>{{$pt['plastic_type_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Plastic Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama plastic" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" placeholder="Plastic Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Capacity Plastic
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" maxlength="3" data-original-title="Masukkan kapasitas plastik" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"> Max </span>
                                <input type="text" class="form-control" id="capacity" name="product_capacity" value="{{ old('product_capacity') }}" placeholder="Capacity Plastic" required>
                                <span class="input-group-addon"> Item </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Global Price
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan price plastic" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control price" name="global_price" value="{{ old('global_price') }}" placeholder="Plastic Price" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Length
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan panjang plastik, satuan dalam cm" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="product_length" value="{{ old('product_length') }}" placeholder="Length" required>
                                <span class="input-group-addon"> cm </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Width
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan lebar plastik, satuan dalam cm" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="product_width" value="{{ old('product_width') }}" placeholder="Width" required>
                                <span class="input-group-addon"> cm </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Height
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan tinggi plastik, satuan dalam cm" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="product_height" value="{{ old('product_height') }}" placeholder="Height" required>
                                <span class="input-group-addon"> cm </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Visible
                            <i class="fa fa-question-circle tooltips" data-original-title="Setting apakah produk plastik akan ditampilkan di aplikasi" data-container="body"></i>
                        </label>
                        <div class="input-icon right">
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio1" name="product_visibility" class="md-radiobtn req-type" value="Visible" @if(old('product_visibility') == 'Visible' || empty(old('product_visibility'))) checked @endif required>
                                        <label for="radio1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Visible</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio2" name="product_visibility" class="md-radiobtn req-type" value="Hidden" @if(old('product_visibility') == 'Hidden') checked @endif required>
                                        <label for="radio2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Hidden </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="product_type" value="plastic">
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection