<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
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
    </div>

    <h1 class="page-title"> Setting Bank Account </h1>

    @include('layouts.notifications')

    <div class="tab-pane" id="profileupdate">
        <div class="row profile-account">
            <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <li class="active">
                        <a data-toggle="tab" href="#add"><i class="fa fa-database"></i> Add </a>
                        <span class="after"> </span>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#export-import"><i class="fa fa-database"></i> Export Import</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div id="add" class="tab-pane active">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-blue sbold uppercase ">Add Bank Account Outlet</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="m-heading-1 border-green m-bordered">
                                    <p>Tipe "All Oultet" akan menambahkan data bank account pada outlet yang data bank accountnya masih kosong</p>
                                </div>
                                <form class="form-horizontal" role="form" action="{{ url('disburse/setting/bank-account') }}" method="post">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Bank Name
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Nama Bank yang dituju" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <select class="form-control select2" data-placeholder="Bank" name="id_bank_name" data-value="{{old('id_bank_name')}}">
                                                        <option></option>
                                                        @if(!empty($bank))
                                                            @foreach($bank as $val)
                                                                <option value="{{$val['id_bank_name']}}">{{$val['bank_name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Beneficiary Name
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="nama penerima" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Beneficiary Name" class="form-control" name="beneficiary_name" value="{{ old('beneficiary_name') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Beneficiary Alias
                                                <i class="fa fa-question-circle tooltips" data-original-title="nama alias penerima" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Beneficiary Alias" class="form-control" name="beneficiary_alias" value="{{ old('beneficiary_alias') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Beneficiary Account
                                                <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="nomor rekening penerima" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="111116xxxxxx" class="form-control" name="beneficiary_account" value="{{ old('beneficiary_account') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Beneficiary Email
                                                <i class="fa fa-question-circle tooltips" data-original-title="email penerima" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="email@example.com" class="form-control" name="beneficiary_email" value="{{ old('beneficiary_email') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Outlets
                                                <i class="fa fa-question-circle tooltips" data-original-title="pilih outlet yang memiliki bank account yang sudah dimasukkan" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <select class="form-control select2-multiple" data-placeholder="Outlets" id="outlet" name="id_outlet[]" multiple data-value="{{json_encode(old('id_outlet',[]))}}" required>
                                                    <option></option>
                                                    @foreach($outlets as $o)
                                                        <option value="{{$o['id_outlet']}}">{{$o['outlet_code']}} - {{$o['outlet_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions" style="text-align: center">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn green">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="export-import" class="tab-pane">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-blue sbold uppercase">Import Bank Account Outlet</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="m-heading-1 border-green m-bordered">
                                    <p>Anda bisa menambahkan dan mengubah data bank account dengan menggunakan hasil  export.</p><br>
                                    <p style="color: red">Note:</p>
                                    <p style="color: red">1. Silahkan memasukan alamat email yang valid. Alamat email boleh kosong.</p>
                                    <p style="color: red">2. Penulisan "Beneficiary Name" tidak boleh menggunakan latin letter dan latin numeric</p>
                                    <p style="color: red">3. Untuk nama bank silahkan menggunakan kode bank(bank_code) yang ada di "List Bank Name" dibawah ini, jika memasukkan kode bank yang tidak ada pada list maka data bank account outlet tersebut akan gagal disimpan.</p>
                                </div>
                                <form class="form-horizontal" role="form" action="{{url('disburse/setting/import-bank-account-outlet')}}" method="post" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">List Bank Name
                                                <i class="fa fa-question-circle tooltips" data-original-title="List Nama Bank" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <a href= "{{url('disburse/setting/export-list-bank')}}"> <i class="fa fa-file-excel-o"></i> Bank Name </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Export Data
                                                <i class="fa fa-question-circle tooltips" data-original-title="Export data bank account outlet" data-container="body"></i>
                                            </label>
                                            <div class="col-md-9">
                                                <a href= "{{url('disburse/setting/export-bank-account-outlet')}}"> <i class="fa fa-file-excel-o"></i> Export Data Outlet </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">File Import <span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="File import untuk menambah atau memperbaharui data bank account outlet" data-container="body"></i></label>
                                            <div class="col-md-9">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="input-group input-large">
                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                            <span class="fileinput-filename"> </span>
                                                        </div>
                                                        <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> Select file </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required> </span>
                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green">Import</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection