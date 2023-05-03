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
                <span class="caption-subject sbold uppercase font-blue">Edit Manual Payment</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('transaction/manual-payment-update', $list['id_manual_payment']) }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Is Virtual</label>
                        <div class="col-md-9">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="radio14" name="is_virtual_account" class="md-radiobtn" value="1" @if ($list['is_virtual_account'] == '1') checked @endif>
                                    <label for="radio14">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Yes </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="radio16" name="is_virtual_account" class="md-radiobtn" value="0" @if ($list['is_virtual_account'] == '0') checked @endif>
                                    <label for="radio16">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> No </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" placeholder="Payment name" class="form-control" name="manual_payment_name" value="{{ $list['manual_payment_name'] }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Logo</label>
                        <div class="col-md-9">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail">
                                  <img src="{{ env('STORAGE_URL_API').$list['manual_payment_logo'] }}" alt="">
                              </div>
                              <div class="fileinput-preview fileinput-exists thumbnail"></div>
                              <div>
                                  <span class="btn default btn-file">
                                  <span class="fileinput-new"> Select image </span>
                                  <span class="fileinput-exists"> Change </span>
                                  <input type="file" accept="image/*" name="manual_payment_logo">
                                  </span>
                                  <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                              </div>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Account Number
                        </label>
                        <div class="col-md-6">
                            <input type="text" placeholder="Account number" class="form-control" name="account_number" value="{{ $list['account_number'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Account Name
                        </label>
                        <div class="col-md-6">
                            <input type="text" placeholder="Account name" class="form-control" name="account_name" value="{{ $list['account_name'] }}">
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label class="col-md-3 control-label">Method Name
                        </label>
                        <div class="col-md-6">
                            <input type="text" name="method_name_new" class="form-control input-large" value="{{ $list['method'] }}" data-role="tagsinput">
                        </div>
                    </div>
                    <input type="hidden" name="method_name_old" value="{{ $list['method'] }}"> --}}
                </div>
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
@endsection