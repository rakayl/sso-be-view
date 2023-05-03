@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.js') }}" type="text/javascript"></script>
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase">Create Holiday</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('setting/holiday/save') }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Holiday Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="holiday_name" value="{{ old('holiday_name') }}">
                        </div>
                    </div>
                    <div class="form-group mt-repeater" style="padding-left: 10px">
                        <div data-repeater-list="day">
                            <div data-repeater-item class="mt-repeater mt-overflow">
                                <label class="control-label col-md-3">Day</label>
                                <div class="col-md-9">
                                    <div class="mt-repeater-cell ">
                                        <input type="date" placeholder="select Date" class="form-control mt-repeater-input-inline" name="day"/ value="{{ old('day', date('Y-m-d')) }}">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                        <label class="control-label col-md-3"></label>
                        <div class="col-md-9">
                            <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                            <i class="fa fa-plus"></i> Add new day</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Outlets</label>
                        <div class="col-md-9">
                            <select id="multiple" class="form-control select2-multiple" multiple name="id_outlet[]" data-placeholder="select outlet">
                            <optgroup label="Outlet List">
                                @if (!empty($outlet))
                                    @foreach($outlet as $ou)
                                        <option value="{{ $ou['id_outlet'] }}" @if(old('id_outlet') != "") @if(old('id_outlet') == $ou['id_outlet']) selected @endif @endif >{{ $ou['outlet_name'] }}</option>
                                    @endforeach
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
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection