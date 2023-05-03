@include('subscription::step1-form')
<?php
use App\Lib\MyHelper;
$configs = session('configs');
if ($subscription_type == 'welcome') {
	$redirect = 'welcome-subscription';
}
else{
	$redirect = 'subscription';
}
?>
@extends('layouts.main')

@section('page-style')

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .content-title {
            padding-bottom: 15px;
        }
        .content-detail {
            padding-bottom: 10px;
            padding-left: 40px;
        }
        .p-l-40px {
            padding-left: 40px;
        }
        .p-l-30px {
            padding-left: 30px;
        }
        a[aria-expanded=false] .fa-chevron-down {
            display: none;
        }
        a[aria-expanded=true] .fa-chevron-right {
            display: none;
        }
        .bottom-border {
            border-bottom: 1px solid #c2cad8;
        }
        .btn-grey {
            color: #337ab7;
            background-color: #eee;
            border-color: #ccc;
        }
        .text-decoration-none {
            text-decoration: none!important;
        }
    </style>
@endsection

@section('page-script')

    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/subscription.js') }}" type="text/javascript"></script>

    <script>
    $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
    $('.timepicker').timepicker();

    $(".form_datetime").datetimepicker({
        format: "d-M-yyyy hh:ii",
        autoclose: true,
        todayBtn: true,
        minuteStep:1
    });

    </script>

    <script type="text/javascript">        
        var oldOutlet=[];
        function redrawOutlets(list,selected,convertAll){
            var html="";
            if(list.length){
                html+="<option value=\"all\">All Outlets</option>";
            }
            list.forEach(function(outlet){
                html+="<option value=\""+outlet.id_outlet+"\">"+outlet.outlet_code+" - "+outlet.outlet_name+"</option>";
            });
            $('select[name="id_outlet[]"]').html(html);
            $('select[name="id_outlet[]"]').val(selected);
            if(convertAll&&$('select[name="id_outlet[]"]').val().length==list.length){
                $('select[name="id_outlet[]"]').val(['all']);
            }
            oldOutlet=list;
        }
        $(document).ready(function() {

            var _URL = window.URL || window.webkitURL;

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });
            token = '<?php echo csrf_token();?>';

            /* PRICES */
            $('.prices').click(function() {
                var nilai = $(this).val();

                if (nilai != "free") {
                    $('#prices').show();

                    $('.payment').hide();

                    $('#'+nilai).show();
                    $('.'+nilai).prop('required', true);
                    $('.'+nilai+'Opp').removeAttr('required');
                    $('.'+nilai+'Opp').val('');
                }
                else {
                    $('#prices').hide();
                    $('.freeOpp').removeAttr('required');
                    $('.freeOpp').val('');
                }
            });

            /* VOUCHER TYPE */
            $("input[name='voucher_type']").click(function() {
                var nilai = $(this).val();

                $('#voucher-value').show();
                $('#discount-max-form, #discount-max-value').hide();
                $("input[name='percent_max']").prop('checked', false);
                $("input[name='subscription_voucher_percent_max']").prop('required', false);

                if (nilai == "percent") {

                    $('#voucher-percent, #discount-max').show();
                    $('#voucher-cash').hide();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', true);
                    $("input[name='subscription_voucher_nominal']").prop('required', false);
                }
                else {
                    $('#voucher-percent, #discount-max').hide();
                    $('#voucher-cash').show();
                    $("input[name='subscription_voucher_percent'], input[name='percent_max']").prop('required', false);
                    $("input[name='subscription_voucher_nominal']").prop('required', true);

                }
            });

            /* DISCOUNT MAX */
            $("input[name='percent_max']").click(function() {
                var nilai = $(this).val();

                $('#voucher-percent').show();

                if (nilai == "true") {

                    $('#discount-max-form, #discount-max-value').show();
                    $("input[name='subscription_voucher_percent_max']").prop('required', true);
                }
                else {

                    $('#discount-max-form, #discount-max-value').hide();
                    $("input[name='subscription_voucher_percent_max']").prop('required', false);
                }
            });

            /* SUBSCRIPTION TOTAL */
            $("input[name='subscription_total_type']").click(function() {
                var nilai = $(this).val();

                if (nilai == "limited") {

                    $('#subscription-total-form, #subscription-total-value').show();
                    $("input[name='subscription_total']").prop('required', true);
                }
                else {
                    $('#subscription-total-form, #subscription-total-value').hide();
                    $("input[name='subscription_total']").prop('required', false);
                }
            });

            /* EXPIRY */
            $('.expiry').click(function() {
                var nilai = $(this).val();

                $('#times').show();

                $('.voucherTime').hide();

                $('#'+nilai).show();
                $('.'+nilai).prop('required', true);
                $('.'+nilai+'Opp').removeAttr('required');
                $('.'+nilai+'Opp').val('');
            });

            $('.subscriptionPromoType').click(function() {
                $('.subscriptionPromoTypeShow').show();
                var nilai = $(this).val();

                if (nilai == "promoid") {
                    $('.subscriptionPromoTypeValuePromo').show();
                    $('.subscriptionPromoTypeValuePromo').prop('required', true);

                    $('.subscriptionPromoTypeValuePrice').val('');
                    $('.subscriptionPromoTypeValuePrice').hide();
                    $('.subscriptionPromoTypeValuePrice').removeAttr('required', true);
                }
                else {
                    $('.subscriptionPromoTypeValuePrice').show();
                    $('.subscriptionPromoTypeValuePrice').prop('required', true);

                    $('.subscriptionPromoTypeValuePromo').val('');
                    $('.subscriptionPromoTypeValuePromo').hide();
                    $('.subscriptionPromoTypeValuePromo').removeAttr('required', true);
                }
            });

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: true,
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
                callbacks: {
                    onInit: function(e) {
                      this.placeholder
                        ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                        : e.editingArea.remove(".note-placeholder");
                    },
                    onImageUpload: function(files){
                        sendFile(files[0]);
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "{{ csrf_token() }}";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/subscription')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });

            function sendFile(file){
                token = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/subscription')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            $('#field_content_long').summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            $('.fileinput-preview').bind('DOMSubtreeModified', function() {
                var mentah    = $(this).find('img')
                // set image
                var cariImage = mentah.attr('src')
                var ko        = new Image()
                ko.src        = cariImage
                // load image
                ko.onload     = function(){
                    if (this.naturalHeight === 250 && this.naturalWidth === 600) {
                    } else {
                        mentah.attr('src', "https://www.placehold.it/600x250/EFEFEF/AAAAAA&text=no+image")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            });
            window.onload = function() {
                $("body").on('click', ".removeRepeater", function() {
                    var mbok = $(this).parent().parent().parent();
                    mbok.remove();
                });
            }
            $('.collapse').collapse({
              toggle: true
            })
            $('.sortable').sortable({
                handle: ".sortable-handle",
                connectWith: ".sortable",
                axis: 'y',
            });
            $('.sortable-detail-0').sortable({
                handle: '.sortable-detail-handle-0',
                connectWith: '.sortable-detail-0',
                axis: 'y'
            });
            $('.sortable-detail-1').sortable({
                handle: '.sortable-detail-handle-1',
                connectWith: '.sortable-detail-1',
                axis: 'y'
            });
        });

        $('input[name=charged_central]').keyup(function () {
            var outlet = $('input[name=charged_outlet]').val();
            var central = $('input[name=charged_central]').val();

            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'block';
                document.getElementById('label_outlet').style.display = 'none';
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
            }
        });

        $('input[name=charged_outlet]').keyup(function (e) {
            var outlet = $('input[name=charged_outlet]').val();
            var central = $('input[name=charged_central]').val();

            var check = Number(outlet) + Number(central);
            if(check !== 100){
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'block';
            }else{
                document.getElementById('label_central').style.display = 'none';
                document.getElementById('label_outlet').style.display = 'none';
            }
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
        <div class="col-md-12">
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="col-md-4 mt-step-col first active">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step1/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Info</div>
                            <div class="mt-step-content font-grey-cascade">Title, Image, & Periode</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col ">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step2/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Rule</div>
                            <div class="mt-step-content font-grey-cascade">Discount, Limit, & Expired</div>
                        </a>
                    </div>
                    <div class="col-md-4 mt-step-col last">
                        <a href="{{ ($subscription['id_subscription']??0) ? url($redirect.'/step3/'.$subscription['id_subscription']) : '' }}" class="text-decoration-none">
                            <div class="mt-step-number bg-white">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">Content</div>
                            <div class="mt-step-content font-grey-cascade">Detail Content Subscription</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase ">{{ $subscription['subscription_title'] ?? "Step 1 ".$title }}</span>
            </div>
        </div>
        <div class="portlet-body form">

            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
                <div class="form-body">
                    @yield('step1')
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-5 col-md-7">
                            <input type="hidden" name="id_subscription" value="{{ $subscription['id_subscription']??'' }}">
                            <input type="hidden" name="subscription_type" value="{{ $subscription_type??'' }}">
                            <button type="submit" class="btn green">Next Step</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection