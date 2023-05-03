<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>

        function showModal(id_mdr){
            $('#detail_payment_name').val(document.getElementById ( id_mdr+'_payment_name' ).innerText);
            $('#detail_mdr').val(document.getElementById ( id_mdr+'_mdr' ).innerText);
            $('#detail_mdr_central').val(document.getElementById ( id_mdr+'_mdr_central' ).innerText);
            $('#detail_percent_type').val(document.getElementById ( id_mdr+'_percent_type' ).innerText).trigger("change");
            $('#detail_id_mdr').val(id_mdr);
            $('#mdrModal').modal('show');
        }
    </script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main' : 'disburse::layouts.main'))

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <div class="alert alert-warning">
        <strong>Note</strong> : Dana akan akan dikirimkan ke outlet <strong>berdasarkan hari yang telah dipilih</strong>. Jika tidak ada hari yang dipilih maka dana dengan payment channel tersebut akan dikirimkan setiap hari.
    </div>
    <br>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">List Payment Chanel</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover" id="tableReport">
                <thead>
                <tr>
                    <th scope="col" width="10%"> Action </th>
                    <th scope="col" width="30%"> Payment Channel Name </th>
                    <th scope="col" width="10%"> MDR Central</th>
                    <th scope="col" width="10%"> MDR Outlet </th>
                    <th scope="col" width="10%"> MDR Type </th>
                    <th scope="col" width="25%"> Updated At </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($mdr))
                    @foreach($mdr as $data)
                        <tr>
                            <td>
                                <a class="btn btn-xs green" onClick="showModal('{{$data['id_mdr']}}')"><i class="fa fa-edit"></i> Edit</a>
                            </td>
                            <td id="{{$data['id_mdr']}}_payment_name">{{$data['payment_name']}}</td>
                            <td id="{{$data['id_mdr']}}_mdr_central">{{$data['mdr_central']}}</td>
                            <td id="{{$data['id_mdr']}}_mdr">{{$data['mdr']}}</td>
                            <td id="{{$data['id_mdr']}}_percent_type">{{$data['percent_type']}}</td>
                            <td>{{ date('d M Y H:i', strtotime($data['updated_at'])) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="8" style="text-align: center">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade bs-modal-sm" id="mdrModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Edit Detail</h4>
                </div>
                <form role="form" role="form" action="{{ url('disburse/setting/mdr') }}" method="post">
                    <div class="modal-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label>Payment Name
                                    <i class="fa fa-question-circle tooltips" title="nama payment method" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <input type="text" class="form-control" disabled id="detail_payment_name">
                            </div>
                            <div class="form-group">
                                <label>MDR Type
                                    <i class="fa fa-question-circle tooltips" title="tipe mdr berupa persen atau nominal" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <select class="form-control select2-multiple" data-placeholder="MDR Type" id="detail_percent_type" name="percent_type">
                                    <option></option>
                                    <option value="Percent">Percent (%)</option>
                                    <option value="Nominal">Nominal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>MDR Central
                                    <i class="fa fa-question-circle tooltips" title="jumlah yang akan di bebankan ke pihak pusat" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <br><div style="font-size: 11px;color: red">(Please use '.' if you want to use commas. <br>Example : 0.2)</div>
                                <input type="text" class="form-control" name="mdr_central" id="detail_mdr_central">
                            </div>
                            <div class="form-group">
                                <label>MDR Outlet
                                    <i class="fa fa-question-circle tooltips" title="jumlah yang akan di bebankan ke pihak outlet" data-toggle="tooltip" data-placement="top"></i>
                                </label>
                                <br><div style="font-size: 11px;color: red">(Please use '.' if you want to use commas. <br>Example : 0.2)</div>
                                <input type="text" class="form-control" name="mdr" id="detail_mdr">
                            </div>
                            <input type="hidden" id="detail_id_mdr" name="id_mdr">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ csrf_field() }}
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection