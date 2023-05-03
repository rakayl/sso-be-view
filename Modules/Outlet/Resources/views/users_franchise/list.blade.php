<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
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
    <script>
        function showModalSettingPasswordDeafult(phone) {
            $('#input_password_phone').val(phone);
            $('#setPasswordModal').modal('show');
        }

        $('input[name=re_type_password]').keyup(function (e) {
            var password = $('input[name=password]').val();
            var re_password = $('input[name=re_type_password]').val();

            if(password !== re_password){
                document.getElementById('wording-re-type-password').style.display = 'block';
            }else{
                document.getElementById('wording-re-type-password').style.display = 'none';
            }
        });
        
        function submitPasswordDefault() {
            var msg = "";
            var password = $('input[name=password]').val();
            var re_password = $('input[name=re_type_password]').val();

            if(password !== re_password){
                msg += "Password does not match \n";
            }

            if(msg !== ""){
                confirm(msg);
            }else{
                $( "#form-set-default-password" ).submit();
            }
        }

        function displayPassword(phone, type) {
            if(type === 'hide'){
                document.getElementById('plain-'+phone).style.display = 'none';
                document.getElementById('button-password-show-'+phone).style.display = 'block';
                document.getElementById('button-password-hide-'+phone).style.display = 'none';
            }else{
                document.getElementById('plain-'+phone).style.display = 'block';
                document.getElementById('button-password-show-'+phone).style.display = 'none';
                document.getElementById('button-password-hide-'+phone).style.display = 'block';
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

    <?php
    if(Session::has('filter-list-user-franchise')){
        $search_param = Session::get('filter-list-user-franchise');
        if(isset($search_param['rule'])){
            $rule = $search_param['rule'];
        }

        if(isset($search_param['conditions'])){
            $conditions = $search_param['conditions'];
        }
    }
    ?>

    <form role="form" class="form-horizontal" action="{{url()->current()}}?filter=1" method="POST">
        {{ csrf_field() }}
        @include('outlet::users_franchise.filter_list_user_franchise')
    </form>
    <br>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List User Franchise</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Action </th>
                        <th> Password Default </th>
                        <th> User Status </th>
                        <th> Phone </th>
                        <th> Email </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($list))
                        @foreach($list as $value)
                            <tr>
                                <td>
                                    @if(MyHelper::hasAccess([248], $grantedFeature))
                                        <a href="{{ url('outlet/detail/user-franchise') }}/{{ $value['phone'] }}" target="_blank" class="btn btn-sm blue">Detail</a>
                                        @if(is_null($value['password']))
                                        <button onclick="showModalSettingPasswordDeafult('{{ $value['phone'] }}')" class="btn btn-sm yellow">Setting Password</button>
                                        @endif
                                    @else
                                        Not Available
                                    @endif
                                </td>
                                <td>
                                    @if(is_null($value['password']) && is_null($value['password_default_plain_text']))
                                        Not already set up
                                    @elseif(!is_null($value['password_default_plain_text']))
                                        <span style="display: none" id="plain-{{$value['phone']}}">Password : <b>{{$value['password_default_decrypt']}}</b></span>
                                        <button onclick="displayPassword('{{ $value['phone'] }}', 'show')" class="btn btn-sm purple" id="button-password-show-{{$value['phone']}}">Show Password</button>
                                        <button style="display: none" onclick="displayPassword('{{ $value['phone'] }}', 'hide')" class="btn btn-sm purple" id="button-password-hide-{{$value['phone']}}">Hide Password</button>
                                    @else
                                        Already reset password
                                    @endif
                                </td>
                                <td>
                                    @if($value['user_franchise_type'] == 'Franchise')
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Mitra</span>
                                    @else
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Pusat</span>
                                    @endif
                                </td>
                                <td>{{$value['phone']}}</td>
                                <td>{{$value['email']}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if (isset($paginator) && !empty($paginator))
                {{ $paginator->links() }}
            @endif
        </div>
    </div>

    <div class="modal fade bs-modal-sm" id="setPasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Input Password</h4>
                </div>
                <form id="form-set-default-password" role="form" action="{{ url('outlet/user-franchise/set-password-default') }}" method="post">
                    <div class="modal-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Password</label><br>
                                <span style="font-size: 11px;color: red">(Maximum 6 characters)</span>
                                <input type="password" maxlength="6" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Re-type Password</label><br>
                                <span style="font-size: 11px;color: red">(Maximum 6 characters)</span>
                                <input type="password" maxlength="6" class="form-control" name="re_type_password" required>
                                <span style="font-size: 13px;color: red;display: none" id="wording-re-type-password">Password does not match</span>
                            </div>
                            <input type="hidden" id="input_password_phone" name="phone">
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
                <div class="modal-footer">
                    <button onclick="submitPasswordDefault()" class="btn green">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection