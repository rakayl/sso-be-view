<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $idUserFrenchisee = session('id_user_franchise');
 ?>
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>

    <script>
        $(document).ready(function () {
            outlets();
        });

        $('input[name=central]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('input[name=outlet]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('input[name=fee]').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('#input-fee-disburse').keypress(function (e) {
            var regex = new RegExp("^[0-9]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('input[name=central]').keyup(function () {
            var outlet = $('input[name=outlet]').val();
            var central = $('input[name=central]').val();

            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'block';
                document.getElementById('label_outlet').style.display = 'none';
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
            }
        });

        $('input[name=outlet]').keyup(function (e) {
            var outlet = $('#outlet').val();
            var central = $('#central').val();

            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'block';
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
            }
        });


        function outlets() {
            $("#tableListOutletBody").empty();
            var data_display = 10;
            var token  = "{{ csrf_token() }}";
            var url = "{{url('disburse/setting/fee-outlet-special/outlets')}}";
            var tab = $.fn.dataTable.isDataTable( '#tableListOutlet' );
            if(tab){
                $('#tableListOutlet').DataTable().destroy();
            }

            var data = {
                _token : token
            };

            $('#tableListOutlet').DataTable( {
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "bInfo": true,
                "iDisplayLength": data_display,
                "bProcessing": true,
                "serverSide": true,
                "searching": true,
                "ajax": {
                    url : url,
                    dataType: "json",
                    type: "POST",
                    data: data,
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        render: function ( data, type, row, meta ) {
                            var html = '<label class="mt-checkbox"><input value="'+data+'" onchange="checkboxEvent(this)" type="checkbox" id="check'+data+'" class="md-check checkbox-fee-special-outlet" /> <span></span></label>';
                            return html;
                        }
                    },
                    {
                        targets: 2,
                        render: function ( data, type, row, meta ) {
                            if(data == 1){
                                var html = "<span class=\"sbold badge badge-pill\" style=\"font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;\">Mitra</span>";
                            }else{
                                var html = "<span class=\"sbold badge badge-pill\" style=\"font-size: 14px!important;height: 25px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;\">Pusat</span>";
                            }
                            return html;
                        }
                    }
                ]
            });
        }

        var arrOutlet = [];
        function checkboxEvent(checkboxElem) {
            var value = checkboxElem.value;

            if(value == 'all'){
                if (checkboxElem.checked) {
                    arrOutlet.push('all');
                    $(".checkbox-fee-special-outlet").prop("checked", true);
                }else{
                    $(".checkbox-fee-special-outlet").prop("checked", false);
                }
            }else{
                if (checkboxElem.checked) {
                    arrOutlet.push(Number(checkboxElem.value));
                } else {
                    var index = arrOutlet.indexOf(Number(checkboxElem.value));
                    if (index > -1) {
                        arrOutlet.splice(index, 1);
                    }
                }
            }
        }
        
        function submitFeeSpecialOutlet() {
            var msg = "";
            var percentFee = $('input[name=outlet_special_fee]').val();

            if(document.getElementById("checkall").checked === false){
                if(arrOutlet.length <= 0){
                    msg += "-Please select one or more outlet to setting \n";
                }
            }
            if(percentFee === ""){
                msg += "-Please input Percent Fee \n";
            }

            if(msg !== ""){
                confirm(msg);
            }else{
                $('input[name=id_outlet]').val(arrOutlet);
                $( "#form_fee_outlet_special" ).submit();
            }
        }

        $('#move-special').click(function() {
            var id =[];
            $('#not-special-outlet option:selected').each(function () {
                var $this = $(this);
                id.push($this.attr('data-id'))
            })
            let token  = "{{ csrf_token() }}";

            if(id.length <= 0){
                toastr.warning("Please select one or more from not special outlet");
            }else{
                $.ajax({
                    type : "POST",
                    url : "{{ url('disburse/setting/outlet-special') }}",
                    data : "_token="+token+"&id_outlet="+id+"&status=1",
                    success : function(result) {
                        if (result.status == "success") {
                            outlets();
                            arrOutlet = [];
                            toastr.info("Special Outlet has been updated.");
                            $('#not-special-outlet option:selected').each(function () {
                                var $this = $(this);
                                $('#special-outlet-select').append('<option data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>');
                                $(this).remove();
                            })

                        }
                        else {
                            toastr.warning("Something went wrong. Failed to update special outlet.");
                        }
                    },
                    error: function (jqXHR, exception) {
                        toastr.warning('Something went wrong. Failed to update special outlet');
                    }
                });
            }
        });

        $('#move-not-special').click(function() {
            var id =[];
            $('#special-outlet-select option:selected').each(function () {
                var $this = $(this);
                id.push($this.attr('data-id'))
            })
            let token  = "{{ csrf_token() }}";

            if(id.length <= 0){
                toastr.warning("Please select one or more from special outlet");
            }else{
                $.ajax({
                    type : "POST",
                    url : "{{ url('disburse/setting/outlet-special') }}",
                    data : "_token="+token+"&id_outlet="+id+"&status=0",
                    success : function(result) {
                        if (result.status == "success") {
                            outlets();
                            arrOutlet = [];
                            toastr.info("Special Outlet has been updated.");
                            $('#special-outlet-select option:selected').each(function () {
                                var $this = $(this);
                                $('#not-special-outlet').append('<option data-id='+$this.attr('data-id')+'>'+$this.text()+'</option>');
                                $(this).remove();
                            })

                        }
                        else {
                            toastr.warning("Something went wrong. Failed to update special outlet.");
                        }
                    },
                    error: function (jqXHR, exception) {
                        toastr.warning('Something went wrong. Failed to update special outlet');
                    }
                });
            }
        });

        $('#search-outlet').on("keyup", function(){
            var search = $('#search-outlet').val();
            $(".option-special").each(function(){
                if(!$(this).text().toLowerCase().includes(search.toLowerCase())){
                    $(this).hide()
                }else{
                    $(this).show()
                }
            });
            $('#btn-reset').show()
            $('#div-left').hide()
        })

        $('#btn-reset').click(function(){
            $('#search-outlet').val("")
            $(".option-special").each(function(){
                $(this).show()
            })
            $('#btn-reset').hide()
            $('#div-left').show()
        })
    </script>
@endsection

@extends(($idUserFrenchisee == NULL ? 'layouts.main-closed' : 'disburse::layouts.main-closed'))

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

    <div class="tabbable-line">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#fee">Fee Global </a>
            </li>
            <li>
                <a data-toggle="tab" href="#fee-product-plastic">Fee Plastic </a>
            </li>
            <li>
                <a data-toggle="tab" href="#special-outlet">Special Outlet</a>
            </li>
            <li>
                <a data-toggle="tab" href="#fee-special-outlet">Fee Special Outlet</a>
            </li>
            <li>
                <a data-toggle="tab" href="#approver">Approver Payouts</a>
            </li>
            <li>
                <a data-toggle="tab" href="#time-to-sent">Time To Sent Disburse</a>
            </li>
            <li>
                <a data-toggle="tab" href="#fee-disburse">Fee Disburse</a>
            </li>
            <li>
                <a data-toggle="tab" href="#send-email-to">Send Email To</a>
            </li>
        </ul>
    </div>
    <br>
    <div class="tab-content">
        <div id="fee" class="tab-pane active">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur fee untuk outlet pusat dan outlet mitra.</p>
                <br><p style="color: red">*(Silahkan gunakan '.' jika Anda ingin menggunakan koma. Example : 0.2)</p>
            </div>
            <br>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-yellow sbold uppercase">Setting Fee</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form class="form-horizontal" role="form" action="{{url('disburse/setting/fee-global')}}" method="post">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Percent Fee Outlet Central<span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="jumlah  fee yang akan di bebankan ke outlet milik pusat" data-container="body"></i></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fee_central" required value="{{$fee['fee_central']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Percent Fee Outlet Mitra<span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="jumlah  fee yang akan di bebankan ke outlet milik mitra" data-container="body"></i></label></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fee_outlet" required value="{{$fee['fee_outlet']}}"><span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions" style="text-align: center">
                                {{ csrf_field() }}
                                <button type="submit" id="export_btn" class="btn green">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="fee-product-plastic" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur perhitungan fee pada product plastic. Jika active maka product plastic akan dikenakan fee.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_fee_product_plastic')
        </div>

        <div id="special-outlet" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur outlet mana saja yang termasuk sebagai special fee.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_special_outlet')
        </div>

        <div id="approver" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur proses appove payouts. Approver bisa dilakukan oleh sistem(auto approve) atau oleh admin.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_auto_approve')
        </div>

        <div id="fee-special-outlet" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur fee untuk outlet special fee.</p>
                <br><p style="color: red">*(Silahkan gunakan '.' jika Anda ingin menggunakan koma. Example : 0.2)</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_fee_special_outlet')
        </div>
        <div id="time-to-sent" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur waktu pengiriman disburse dari tanggal transaksi. Value dalam bentuk hari.</p>
                <br><p><b>Contoh: <br>Waktu diset = 3</b> <br>maka disburse akan dikirim ke tiap outlet h+ 3 hari dari tanggal transaksi.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_time_to_sent')
        </div>
        <div id="fee-disburse" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur biaya disburse untuk tiap pengiriman dana.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_disburse_fee_transafer')
        </div>
        <div id="send-email-to" class="tab-pane">
            <div class="m-heading-1 border-green m-bordered">
                <p>Setting ini digunakan untuk mengatur hasil laporan income outlet akan di kirim ke email bank atau email outlet.</p>
            </div>
            <br>
            @include('disburse::setting_global.setting_disburse_send_email_to')
        </div>
    </div>
@endsection