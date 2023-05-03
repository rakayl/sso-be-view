@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
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
    @if(!empty($user))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase ">User Detail</span>
                </div>
            </div>
            <div class="portlet-body form">
                <table>
                    <tr>
                        <td width="60%">Register Date</td>
                        <td>: {{ date('d M Y H:i', strtotime($user['created_at'])) }}</td>
                    </tr>
                    <tr>
                        <td width="60%">User Name</td>
                        <td>: {{ $user['name'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">User Phone</td>
                        <td>: {{ $user['phone'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">User Email</td>
                        <td>: {{ $user['email'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">Gender</td>
                        <td>: {{ $user['gender'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">Membership</td>
                        <td>: {{ $user['membership_name'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">City</td>
                        <td>: {{ $user['city_name'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">Job</td>
                        <td>: {{ $user['job'] }}</td>
                    </tr>
                    <tr>
                        <td width="60%">Total Point Active</td>
                        <td>: {{number_format($user['balance'])}}</td>
                    </tr>
                    <tr>
                        <td width="60%">Total Accumulation Point</td>
                        <td>: {{number_format((int)$user['accumulation_point'])}}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Achievement List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" id="tableReport">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Last Badge</th>
                    <th>Date of First Badge</th>
                    <th>Achievement Start</th>
                    <th>Achievement End</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @foreach($data as $val)
                        <tr>
                            <td>{{$val['category_name']}}</td>
                            <td>{{$val['name']}}</td>
                            <td>{{$val['last_badged']}}</td>
                            <td>{{date('d F Y H:i:s', strtotime($val['date_first_badge']))}}</td>
                            <td>
                                @if(!is_null($val['date_start']))
                                    {{date('d F Y', strtotime($val['date_start']))}}
                                @else
                                    Not Set
                                @endif
                            </td>
                            <td>
                                @if(!is_null($val['date_end']))
                                    {{date('d F Y', strtotime($val['date_end']))}}
                                @else
                                    Not Set
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-xs blue dropdown-toggle" target="_blank" href="{{url('achievement/report/user-achievement/detail-badge/'.$val['id_achievement_group'].'/'.$phone)}}"> Detail </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
            <br>
            @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
                Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
            @endif
            @if ($dataPaginator)
                {{ $dataPaginator->links() }}
            @endif
        </div>
    </div>



@endsection
