@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $('.timepicker').timepicker({
            autoclose: true,
            showSeconds: false,
        });

        var tmp = [0];
        function valueChanged()
        {
            console.log("tesss");
            if($('.use_reason').is(":checked"))   
                $("#use_reason_field").show();
            else
                $("#use_reason_field").hide();
        }
        
        var i=1;
        function addShift() {
            var html =  '<div class="form-group" id="div_shift_child_'+i+'">'+
                        '<div class="col-md-3" style="text-align: right">'+
                        '<a class="btn btn-danger" onclick="deleteChild('+i+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input name="shift['+i+'][name]" class="form-control shift_name" placeholder="Shift Name" required>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_start_'+i+'" data-placeholder="select time" name="shift['+i+'][start]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_end_'+i+'" data-placeholder="select time" name="shift['+i+'][end]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '</div>';

            $("#div_shift_child").append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            tmp.push(i);
            i++;
        }

        function deleteChild(number){
            $('#div_shift_child_'+number).remove();
            var index = tmp.indexOf(number);
            if(index >= 0){
                tmp.splice(index, 1);
            }
        }

        
        $('.schedule_date').change(function () {
            var id = $(this).find(':selected')[0].id;
            var date = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ url('consultation/be/get-schedule-time') }}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id_doctor_schedule': id,
                    'date' : date
                },
                success: function (data) {
                                
            console.log(data);
                    var $schedule_start_time = $('.schedule_start_time');
                    $schedule_start_time.empty();
                    $schedule_start_time.append('<option value="">-</option>');
                    $.each(data, function( key, value ) {
                      $schedule_start_time.append('<option id="' + value.end_time + '" value="' + value.start_time + '">' + value.start_time + '</option>');
                    });
                    // deleteSoon
                    // for (var i = 0; i < data.length; i++) {
                    //     $schedule_start_time.append('<option id="' + data[i].end_time + '" value="' + data[i].start_time + '">' + data[i].start_time + '</option>');
                    // }
                }
            });
        });

        $('.schedule_start_time').change(function () {
            var id = $(this).find(':selected')[0].id;
            document.getElementById("schedule_end_time").value = id;
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
            <span class="caption-subject font-blue sbold uppercase">{{$sub_title??""}}</span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" id="form_submit" role="form" action="{{url('consultation/be', $result['transaction']['id_transaction'])}}/update" method="POST">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <label for="multiple" class="control-label col-md-3"> Doctor Schedule <span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                    </label>
                    <div class="col-md-4">
                        <input type="hidden" name="id_transaction" value="{{$result['transaction']['id_transaction']}}">
                        @php $dateFormatted = date('d-m-Y', strtotime($result['consultation']['schedule_date'])); @endphp
                        <select class="form-control select2 schedule_date" name="schedule_date" required>
                            @if(!empty($result['schedule']))
                                @foreach($result['schedule'] as $schedule)
                                    <option id="{{$schedule['id_doctor_schedule']}}" value="{{$schedule['date']}}" {{$dateFormatted == $schedule['date'] ? 'selected' : ''}}>[{{$schedule['day']}}] {{$schedule['date']}}</option>
                                @endforeach
                            @else
                                <option>-</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        @php $timeFormatted = date('H:i', strtotime($result['consultation']['schedule_start_time'])); @endphp
                        <select class="form-control select2 schedule_start_time" name="schedule_start_time" required>
                        @if(!empty($result['selected_schedule_time']))
                            @foreach($result['selected_schedule_time'] as $time)
                                <option id="{{$time['end_time']}}" value="{{$time['start_time']}}" {{$timeFormatted == $time['start_time'] ? 'selected' : ''}}>{{$time['start_time']}}</option>
                            @endforeach
                        @else
                            <option>-</option>
                        @endif
                        </select>
                        <input type="hidden" id="schedule_end_time" name="schedule_end_time" value="{{$result['consultation']['schedule_end_time']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="multiple" class="control-label col-md-3">Consultation Status <span class="required" aria-required="true"> * </span>
                        <i class="fa fa-question-circle tooltips" data-original-title="Pilih tipe jam kerja" data-container="body"></i>
                    </label>
                    <div class="col-md-3">
                        <select class="form-control select2" name="consultation_status" required>
                            <option></option>
                            <option value="soon" {{$result['consultation']['consultation_status'] == "soon" ? 'selected' : ''}}>Scheduled</option>
                            <option value="ongoing" {{$result['consultation']['consultation_status'] == "ongoing" ? 'selected' : ''}}>Ongoing</option>
                            <option value="done" {{$result['consultation']['consultation_status'] == "done" ? 'selected' : ''}}>Waiting Result</option>
                            <option value="completed" {{$result['consultation']['consultation_status'] == "completed" ? 'selected' : ''}}>Completed</option>
                            <option value="missed" {{$result['consultation']['consultation_status'] == "missed" ? 'selected' : ''}}>Missed</option>
                            <option value="canceled" {{$result['consultation']['consultation_status'] == "canceled" ? 'selected' : ''}}>Canceled</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                    <center>
                        <label for="multiple" style="padding-top:8px;">Perubahan Data Konsultasi akan tercatat sebagai user pengubah adalah <b>{{$result['modifier_user']['name']}}</b><label>
                            <input type="hidden" name="id_user_modifier" value="{{$result['modifier_user']['id']}}">
                        </div>
                    </center>
                </div>
                <div class="form-group">
                    <label for="multiple" class="control-label col-md-3">Use Reason</label>
                    <div class="col-md-8" style="margin-top: 0.7%">
                        <label><input type="checkbox" class="use_reason" name="use_reason" value="1" onClick="valueChanged()"></label>
                    </div>
                </div>
                <div id="use_reason_field" style="display: none">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Change Status Reason</label>
                        <div class="col-md-7">
                            <textarea type="text" name="reason_status_change" placeholder="Input your address here..." class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align: center">
                <button class="btn blue">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
