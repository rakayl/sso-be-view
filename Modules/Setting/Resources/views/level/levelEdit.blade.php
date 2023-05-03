@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
         $(document).ready(function(){
            $('#day').multiDatesPicker();
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
                <span class="caption-subject font-dark sbold uppercase">Edit Level</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal form-bordered" action="{{ url('setting/level/update', $level['id_level']) }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Level Name</label>
                        <div class="col-md-9">
                            <input type="text" name="level_name" class="form-control" value="{{ $level['level_name'] }}" />
                        </div>
                    </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Level Parameter</label>
                        <div class="col-md-9">
                            <input type="text" name="level_parameters" class="form-control" value="{{ $level['level_parameters'] }}" />
                        </div>
                    </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Range Start</label>
                        <div class="col-md-9">
                            <input type="number" name="level_range_start" class="form-control" value="{{ $level['level_range_start'] }}" />
                        </div>
                    </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Range End</label>
                        <div class="col-md-9">
                            <input type="number" name="level_range_end" class="form-control" value="{{ $level['level_range_end'] }}" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">
                                        <i class="fa fa-check"></i> Submit</button>
                                    <button type="button" class="btn default">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection