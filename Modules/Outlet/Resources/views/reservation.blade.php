<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">


<div class="portlet-body form">
    <div class="portlet light bordered">
        
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                <thead>
                    <tr>
                        <th> Day </th>
                        <th> Time Start </th>
                        <th> Time End </th>
                        <th> Limit </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $day = [
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday',
                        'Sunday'
                    ];

                    $dayPick = [];
                @endphp
                @foreach($day as $key => $value)
                    <!-- kalo nggak ada datanya sama sekali -->
                    @if (empty($outlet[0]['reservation']))
                    <tr>
                        <td> {{ $value }}  </td>
                        <td> 
                            <input type="time" data-placeholder="select time start" class="form-control mt-repeater-input-inline" id="start_{{ $key }}"> 
                        </td>
                        <td>
                            <input type="time" data-placeholder="select time end" class="form-control mt-repeater-input-inline" id="end_{{ $key }}">
                        </td>
                        <td style="width: 50px;">
                            <input type="text" data-placeholder="limit" class="form-control" id="limit_{{ $key }}">
                        </td>
                        <td> <a data-toggle="confirmation" data-popout="true" data-day="{{ $value }}" data-id="{{ $key }}" class="btn green resercreate"><i class="fa fa-floppy-o"></i></a> </td>
                    </tr>
                    @else
                        <!-- kalo ada datanya di foreach  -->
                        @foreach ($outlet[0]['reservation'] as $you)
                            <!-- terus disesuaikan dengan hari  -->
                            @if ($you['day'] == $value)
                                @php
                                    array_push($dayPick, $value);
                                @endphp
                                <tr>
                                    <td> {{ $value }}  </td>
                                    <td> 
                                        <input type="time" data-placeholder="select time start" class="form-control mt-repeater-input-inline" id="start_{{ $key }}" value="{{ date('H:i', strtotime($you['hour_start'])) }}"> 
                                    </td>
                                    <td>
                                        <input type="time" data-placeholder="select time end" class="form-control mt-repeater-input-inline" id="end_{{ $key }}" value="{{ date('H:i', strtotime($you['hour_end'])) }}">
                                    </td>
                                    <td style="width: 50px;">
                                        <input type="text" data-placeholder="limit" class="form-control" id="limit_{{ $key }}" value="{{ $you['limit'] }}">
                                    </td>
                                    <td> <a data-toggle="confirmation" data-popout="true" data-day="{{ $value }}" data-id="{{ $key }}" class="btn green resercreate"><i class="fa fa-floppy-o"></i></a> </td>
                                </tr>
                            @endif
                        @endforeach
                        
                        @if (!in_array($value, $dayPick))
                            <tr>
                                <td> {{ $value }}  </td>
                                <td> 
                                    <input type="time" data-placeholder="select time start" class="form-control mt-repeater-input-inline" id="start_{{ $key }}"> 
                                </td>
                                <td>
                                    <input type="time" data-placeholder="select time end" class="form-control mt-repeater-input-inline" id="end_{{ $key }}">
                                </td>
                                <td style="width: 50px;">
                                    <input type="text" data-placeholder="limit" class="form-control" id="limit_{{ $key }}">
                                </td>
                                <td> <a data-toggle="confirmation" data-popout="true" data-day="{{ $value }}" data-id="{{ $key }}" class="btn green resercreate"><i class="fa fa-floppy-o"></i></a> </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>