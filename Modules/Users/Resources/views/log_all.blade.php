@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

        function viewLogDetail(id_log, log_type){
            $.get("{{url('user/ajax/log')}}"+'/'+id_log+'/'+log_type, function(result){
                if(result){
                    document.getElementById("log-url").value = result.url;
                    document.getElementById("log-status").value = result.response_status;
                    document.getElementById("log-request").innerHTML = JSON.stringify(JSON.parse(result.request), null, 4);
                    document.getElementById("log-response").innerHTML = JSON.stringify(JSON.parse(result.response), null, 4);
                    document.getElementById("log-ip").value = result.ip;
                    document.getElementById("log-useragent").value = result.useragent;
                    $('#logModal').modal('show');
                }
            })
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

    <div style="margin-left:15px; margin-right:15px">
        <div class="portlet light portlet-fit bordered row">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase">{{$profile['name']}}</span>
                </div>
                <div class="caption" style="float:right">
                    @if($profile['level'] == 'Super Admin')
                        <span class="sale-num font-red sbold">Super Admin</span>
                    @endif
                    @if($profile['level'] == 'Admin')
                        <span class="sale-num font-red sbold">Admin</span>
                    @endif
                    @if($profile['level'] == 'Customer')
                        <span class="sale-num font-blue sbold">Customer</span>
                    @endif
                    @if($profile['level'] == 'Admin Outlet')
                        <span class="sale-num font-blue sbold">Admin Outlet</span>
                    @endif
                </div>
            </div>
            <div class="portlet-body">
                <div class="profile-info">
                    <ul class="list-group row">
                        <div class="col-md-6">
                            <li class="list-group-item" style="padding: 5px !important;" title="User Phone number & Provider">
                                <i class="fa fa-mobile-phone"></i> {{$profile['phone']}} ({{$profile['provider']}}) </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="User Email">
                                <i class="fa fa-envelope-o"></i> {{$profile['email']}} </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="User Gender">
                                @if($profile['gender'] == 'Male')<i class="fa fa-male"></i> {{$profile['gender']}} </li>@else<i class="fa fa-female"></i> {{$profile['gender']}} </li>
                            @endif
                            <li class="list-group-item" style="padding: 5px !important;" title="User City & Province">
                                <i class="fa fa-map"></i>
                                @if(isset($profile['city']['city_name'])){{$profile['city']['city_name']}}@endif
                                @if(isset($profile['city']['province']['province_name'])) ,{{$profile['city']['province']['province_name']}} @endif
                            </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="User Birthday">
                                <i class="fa fa-birthday-cake"></i> @if($profile['birthday']){{date("d F Y", strtotime($profile['birthday']))}} @endif</li>
                        </div>
                        <div class="col-md-6">
                            <li class="list-group-item" style="padding: 5px !important;" title="User Register date & time">
                                <i class="fa fa-registered"></i> {{date("d F Y", strtotime($profile['created_at']))}} </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="User Membership">
                                <i class="icon-badge"></i> @if(isset($profile['user_membership']['membership_name'])){{$profile['user_membership']['membership_name']}} @endif</li>
                            <li class="list-group-item" style="padding: 5px !important;" title="User Relationship">
                                <i class="fa fa-heart"></i> {{$profile['relationship']}} </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="Total {{env('POINT_NAME', 'Points')}} Obtained By The User">
                                <i class="fa fa-gift"></i> {{number_format($profile['balance_acquisition'], 0, ',', '.')}} </li>
                            <li class="list-group-item" style="padding: 5px !important;" title="Remaining User {{env('POINT_NAME', 'Points')}}">
                                <i class="fa fa-star"></i> {{number_format($profile['balance'], 0, ',', '.')}} </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form role="form" action="{{ url()->current() }}" method="post">
        @include('users::log_all_filter')
    </form>

    @if (!empty($conditions))
        <div class="alert alert-block alert-info fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading">Displaying search result :</h4>
            <p>{{ $count }}</p><br>
            <a href="{{ url()->current() }}" class="btn btn-sm btn-warning">Reset</a>
            <br>
        </div>
    @endif

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Log Activity User</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tabbable-line tabbable-full-width">
                <ul class="nav nav-tabs">
                    <li class=" @if((isset($tipe) && $tipe == 'mobile') || !isset($tipe)) active @endif">
                        <a href="{{url('user/log/'.$phone.'/mobile')}}"> Mobile </a>
                    </li>
                    <li class=" @if(isset($tipe) && $tipe == 'backend') active @endif">
                        <a href="{{url('user/log/'.$phone.'/backend')}}"> Backend </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" style="margin-top:20px">
                <div class="tab-pane @if((isset($tipe) && $tipe == 'mobile') || !isset($tipe)) active @endif" id="log_mobile">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Datetime</th>
                            <th>Module</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Ip Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($log['mobile']))
                            @foreach($log['mobile'] as $datalog)
                                <tr>
                                    <td>
                                        @if(stristr($datalog['useragent'],'iOS'))
                                            <i class="fa fa-apple"></i>
                                        @elseif(stristr($datalog['useragent'],'okhttp'))
                                            <i class="fa fa-android"></i>
                                        @endif
                                    </td>
                                    <td> {{date("d F Y H:i:s", strtotime($datalog['created_at']))}} </td>
                                    <td>{{$datalog['subject']}}</td>
                                    <td>{{$datalog['module']}}</td>
                                    <td>
                                        @if($datalog['response_status'] == 'fail')
                                            <span class="label label-danger label-sm"> Failed
                                            </span>
                                        @else
                                            <span class="label label-success label-sm"> Success
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{$datalog['ip']}}</td>
                                    <td>
                                            <span style="cursor: pointer;" class="label label-info label-sm" onClick="viewLogDetail('{{$datalog['id_log_activities_apps']}}','apps')"> <i class="fa fa-info-circle"></i> Details
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if (isset($mobile_page))
                        {{ $mobile_page->links() }}
                    @endif
                </div>

                <div class="tab-pane @if(isset($tipe) && $tipe == 'backend') active @endif" id="log_backend">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                        <thead>
                        <tr>
                            <th>Datetime</th>
                            <th>Module</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Ip Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($log['backend']))
                            @foreach($log['backend'] as $datalog)
                                <tr>
                                    <td> {{date("d F Y H:i:s", strtotime($datalog['created_at']))}} </td>
                                    <td>{{$datalog['module']}}</td>
                                    <td>{{$datalog['subject']}}</td>
                                    <td>
                                        @if($datalog['response_status'] == 'fail')
                                            <span class="label label-danger label-sm"> Failed
                                            </span>
                                        @else
                                            <span class="label label-success label-sm"> Success
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{$datalog['ip']}}</td>
                                    <td>
                                            <span style="cursor: pointer;" class="label label-info label-sm" onClick="viewLogDetail('{{$datalog['id_log_activities_be']}}', 'be')"> <i class="fa fa-info-circle"></i> Details
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if (isset($backend_page))
                        {{ $backend_page->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="logModal" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Request & Response Detail</h4>
                </div>
                <div class="modal-body form">
                    <form role="form">
                        <div class="form-body">
                            <div class="form-group">
                                <label>URL</label>
                                <input type="text" class="form-control" readonly id="log-url">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" readonly id="log-status">
                            </div>
                            <div class="form-group">
                                <label>IP Address</label>
                                <input type="text" class="form-control" readonly id="log-ip">
                            </div>
                            <div class="form-group">
                                <label>User Agent</label>
                                <input type="text" class="form-control" readonly id="log-useragent">
                            </div>
                            <div class="form-group">
                                <label>Request</label>
                                <textarea class="form-control" rows="4" readonly id="log-request"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Response</label>
                                <textarea class="form-control" rows="4" readonly id="log-response"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
