@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/payment.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('.summernote').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
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
                <span class="caption-subject sbold uppercase font-blue">Detail Payment Manual</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('transaction/manualpayment/method/save') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    @if (isset($detail['manual_payment_methods']))
                        @foreach ($detail['manual_payment_methods'] as $key => $payment)
                            <div class="form-group payment-count">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Payment name" class="form-control" name="method_name[]" value="{{ $payment['payment_method_name'] }}" required><br>
                                    <input type="hidden" name="id_method[]" value="{{ $payment['id_manual_payment_method'] }}">
                                    <div id="tutorTarget{{ $key }}">
                                        @if (isset($payment['manual_payment_tutorials']))
                                            @foreach ($payment['manual_payment_tutorials'] as $row => $tutorial)
                                                <div class="col-md-10 tutor{{ ++$row }}{{ $key }}">
                                                    <input type="text" placeholder="Input tutorial" class="form-control" name="tutorial_{{ $key }}[]" value="{{ $tutorial['payment_tutorial'] }}" /> <br> </div>
                                                <div class="col-md-2 tutor{{ $row }}{{ $key }}">
                                                    <a onclick="deleteTutor({{ $row }}{{ $key }})" data-repeater-delete class="btn btn-danger">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-info tutor1" onclick="addTutor({{ $key }})">Add Tutorial</button>
                                    <div class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--pill removeRepeater">
                                        <span>
                                          Delete Payment
                                        </span>
                                    </div>
                                    <div><br><hr style="border-top: 1px solid #e0d8d8;margin-left: -150px;margin-right: -150px;"></div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div id="methodTarget"></div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><button type="button" class="btn btn-sm btn-warning payment">Add Payment</button></label>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ $id_payment }}">
                <input type="hidden" name="old_id" value="{{ $detail['old_id'] }}">
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            $("body").on('click', ".removeRepeater", function() {
                var mbok = $(this).parent().parent();
                mbok.remove();
                // console.log($(this).parent().parent()[0]);
            });
        }
    </script>
@endsection