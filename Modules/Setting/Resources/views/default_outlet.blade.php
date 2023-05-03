@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">{{ $sub_title }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal form-bordered" action="{{ url('setting/update', $id) }}" method="post">
            	{{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group last">
                    	<input type="hidden" name="key" value="{{ $key }}">
                        <label class="control-label col-md-{{$colLabel}}">
                            {{ $label }}
                            <i class="fa fa-question-circle tooltips" data-original-title="Outlet yang akan digunakan untuk penentuan harga produk catering order" data-container="body"></i>
                        </label>
                        <div class="col-md-{{$colInput}}">
                            <select name="value" class="select2 form-control">
                                @foreach($outlets as $outlet)
                                <option value="{{$outlet['id_outlet']}}" @if($outlet['id_outlet']==$value) selected @endif>{{$outlet['outlet_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-{{$colLabel}} col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
