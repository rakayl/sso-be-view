@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.datepicker').datepicker({
                'format' : 'd MM',
                'todayHighlight' : true,
                'todayBtn' : true,
                'autoclose' : true
            });

            if($('.datepicker').length >= 12){
                $('.mt-repeater-add').attr('disabled', 'disabled')
            }
        })

        function addRepeater(){
            setTimeout(function(){
            if($('.datepicker').length >= 12){
                $('.mt-repeater-add').attr('disabled', 'disabled')
            }
                $('.datepicker').datepicker({
                    'format' : 'd MM',
                    'todayHighlight' : true,
                    'todayBtn' : true,
                    'autoclose' : true
                });
            }, 100);
        }

        $('.repeat').repeater({
        show: function () {
            $(this).slideDown();
        },
		hide: function (remove) {
			if(confirm('Are you sure you want to remove this item?')) {
				$(this).slideUp(remove);
                if($('.datepicker').length <= 12){
                    $('.mt-repeater-add').removeAttr('disabled')
                }
			}
		},
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
                <span class="caption-subject font-green bold uppercase">{{ $subTitle }}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('setting/reset/'.str_replace('-', '_', $menu_active).'/update') }}" method="post">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                            @if($menu_active == 'point-reset')
                                @php $type = 'point'; @endphp
                            @else
                                @php $type = env('POINT_NAME', 'Points'); @endphp
                            @endif
                            <label class="col-md-3 control-label">
                                Reset {{ucwords($type)}} Date
                            <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal {{$type}} customer akan direset ulang. {{ucfirst($type)}} akan direset pada jam 00:00" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="repeat">
                                <div data-repeater-list="setting">
                                @if(isset($result) && is_array($result))
                                    @foreach($result as $data)
                                    <div data-repeater-item class="row" style="padding-bottom:20px;">
                                        <input type="hidden" name="id_setting" value="{{$data['id_setting']}}"/>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control datepicker" placeholder="select date" name="value" value="{{date('d F', strtotime($data['value']))}}" readonly/>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                        <br>
                                    </div>
                                    @endforeach
                                @else
                                <div data-repeater-item class="row" style="padding-bottom:20px;">
                                    <input type="hidden" name="id_setting"/>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control datepicker" placeholder="select date" name="value" readonly/>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                    <br>
                                </div>
                                @endif
                                </div>
                                <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add" onClick="addRepeater()">
                                    <i class="fa fa-plus"></i> Add Date</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
