<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
 @extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
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
                <span class="caption-subject font-blue sbold uppercase">News Featured</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="alert alert-info">
                Select one or more news to display in the E-learning menu in the application. The news data will display at the top list.
            </div>
            <form class="form-horizontal" role="form" action="{{ url('news/featured') }}" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Top Video
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="video[]" multiple>
                                <option></option>
                                @foreach($video as $value)
                                    <option value="{{$value['id_news']}}" @if($value['news_featured_status'] == 1) selected @endif>{{$value['news_title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Top Article
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="article[]" multiple>
                                <option></option>
                                @foreach($article as $value)
                                    <option value="{{$value['id_news']}}" @if($value['news_featured_status'] == 1) selected @endif>{{$value['news_title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Top Online Class
                        </label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="online_class[]" multiple>
                                <option></option>
                                @foreach($online_class as $value)
                                    <option value="{{$value['id_news']}}" @if($value['news_featured_status'] == 1) selected @endif>{{$value['news_title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align: center">
                    {{ csrf_field() }}
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </form>
        </div>
    </div>



@endsection