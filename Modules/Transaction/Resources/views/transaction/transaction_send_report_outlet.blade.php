@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function changeOutletType(value) {
            if(value == 'all_outlet'){
                document.getElementById('specific_outlet').style.display = 'none';
                $("#specific_outlet").prop('required', false);
            }else if(value == 'no_all'){
                document.getElementById('specific_outlet').style.display = 'block';
                $("#specific_outlet").prop('required', true);
            }
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
                <span class="caption-subject font-dark sbold uppercase font-blue">Send Report To Outlet</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('transaction/send-report-outlet') }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date Start :</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_start" value="{{ date('Y-m-d') }}">
                                <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                            </div>
                        </div>

                        <label class="col-md-2 control-label">Date End :</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_end" value="{{ date('Y-m-d') }}">
                                <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah outlet available mau berdasarkan selected outlet atau outlet group filter" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="outlet_available_type" class="md-radiobtn filterType" value="all_outlet" required onclick="changeOutletType(this.value)">
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> All Outlet</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="outlet_available_type" class="md-radiobtn filterType" value="no_all" required onclick="changeOutletType(this.value)" checked>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Specific Outlet</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="specific_outlet">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Outlets
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet untuk tujuan pengiriman report" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2-multiple" data-placeholder="Select" name="outlet_code" id="available_outlet_group_filter">
                                <option></option>
                                @foreach($outlets as $o)
                                    <option value="{{$o['outlet_code']}}">{{$o['outlet_code']}} - {{$o['outlet_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection