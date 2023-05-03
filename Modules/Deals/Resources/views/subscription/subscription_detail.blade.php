@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .repeater-btn-remove{
            position: absolute;
            top: 0px;
            left: 21%;
        }
        .dealsPromoTypeShow .form-control,
        .dealsPromoTypeShow .select2-container{
            display: none;
        }
        .dealsPromoTypeShow .select2-selection{
            position: relative;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>

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
        todayBtn: true
    });

    </script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                "searching": false,
                "paging": false,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_1').on('click', '.delete-disc', function() {
            let token  = "{{ csrf_token() }}";
            let column = $(this).parents('tr');
            let id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('deals/voucher/delete') }}",
                data : "_token="+token+"&id_deals_voucher="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Voucher has been deleted.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete voucher.");
                    }
                },
                error : function(result) {
                    toastr.warning("Something went wrong. Failed to delete voucher.");
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('#sample_2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [2, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                "searching": false,
                "paging": false,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            token = '<?php echo csrf_token();?>';

            /* TYPE VOUCHER */
            $('.voucherType').click(function() {
                var nilai = $(this).val();
                // alert(nilai);

                if (nilai == "List Vouchers") {
                    $('#listVoucher').show();
                    $('.listVoucher').prop('required', true);

                    $('#generateVoucher').hide();
                    $('.generateVoucher').removeAttr('required');
                    $('.generateVoucher').val('');
                }
                else {
                    $('#generateVoucher').show();
                    $('.generateVoucher').prop('required', true);

                    $('#listVoucher').hide();
                    $('.listVoucher').removeAttr('required');
                    $('.listVoucher').val('');
                }
            });

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

            // upload & delete image on summernote
            $('.summernote').summernote({
                placeholder: 'Deals Content Long',
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
                    onImageUpload: function(files){
                        sendFile(files[0]);
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "{{ csrf_token() }}";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/deals')}}",
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
                    url : "{{url('summernote/picture/upload/deals')}}",
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
                    if (this.naturalHeight === 300 && this.naturalWidth === 300) {
                    } else {
                        mentah.attr('src', "")
                        $('#file').val("");
                        toastr.warning("Please check dimension of your photo.");
                    }
                };
            })


        });

        //  form repeater
        var radio_id = {{ $subscriptions_count * 3 + 7 }};
        // *3 : because there are 3 radio in each line (old deals subscriptions)
        // +7 : because 1-6 is reserved for another radio
        // console.log('radio_id', radio_id);
        $('.mt-repeater').repeater({
            show: function () {
                $(this).slideDown();
                // init select2
                var last_item = $('.mt-repeater-item').last();
                last_item.find('.tooltips').tooltip();
                last_item.find('.select2').select2({ width: '100%' });
                // give id and for attribute to metronic radio
                last_item.find('.md-radio').each(function() {
                    $(this).find('input').attr('id','radio'+radio_id);
                    $(this).find('label').attr('for','radio'+radio_id);
                    radio_id++;
                });

                // hide form control
                last_item.find('.dealsPromoTypeShow .form-control').hide();
                last_item.find('.select2-container').hide();
                // console.log('radio_id', radio_id);
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });

        $( ".mt-repeater" ).on( "keyup", ".price", numberFormat);

        // show or hide deals promo type input
        $(document).on('click', '.dealsPromoType', function() {
            var nilai = $(this).val();
            var parent = $(this).parents('.promo-type');

            parent.find('.dealsPromoTypeShow').show();

            if (nilai == "promoid") {
                parent.find('.dealsPromoTypeValuePromo').show();
                parent.find('.dealsPromoTypeValuePromo').prop('required', true);

                parent.find('.dealsPromoTypeValuePrice').val('');
                parent.find('.dealsPromoTypeValuePrice').hide();
                parent.find('.dealsPromoTypeValuePrice').removeAttr('required', true);
                parent.find('.dealsPromoTypeValueItem').val('');
                parent.find('.dealsPromoTypeValueItem').hide();
                parent.find('.dealsPromoTypeValueItem').removeAttr('required', true);
                parent.find('.select2-container').hide();
            }
            else if (nilai == "nominal") {
                parent.find('.dealsPromoTypeValuePrice').show();
                parent.find('.dealsPromoTypeValuePrice').prop('required', true);

                parent.find('.dealsPromoTypeValuePromo').val('');
                parent.find('.dealsPromoTypeValuePromo').hide();
                parent.find('.dealsPromoTypeValuePromo').removeAttr('required', true);
                parent.find('.dealsPromoTypeValueItem').val('');
                parent.find('.dealsPromoTypeValueItem').hide();
                parent.find('.dealsPromoTypeValueItem').removeAttr('required', true);
                parent.find('.select2-container').hide();
            }
            else {
                parent.find('.dealsPromoTypeValueItem').show();
                parent.find('.dealsPromoTypeValueItem').prop('required', true);
                parent.find('.select2-container').show();

                parent.find('.dealsPromoTypeValuePrice').val('');
                parent.find('.dealsPromoTypeValuePrice').hide();
                parent.find('.dealsPromoTypeValuePrice').removeAttr('required', true);
                parent.find('.dealsPromoTypeValuePromo').val('');
                parent.find('.dealsPromoTypeValuePromo').hide();
                parent.find('.dealsPromoTypeValuePromo').removeAttr('required', true);
            }
        });

        // show bootstrap select if promo type = free item
        $(document).ready(function() {
            $('.promo-type').each(function() {
                var promo_type = $(this).find('.dealsPromoType:checked').val();
                if (promo_type == "free item") {
                    $(this).find('.select2-container').show();
                }
            });
        });

        // check total_voucher_subscription
        $(document).on('keyup change', '.total_voucher', function() {
            var total_voucher_subs = $('.total_voucher_subscription').val();
            var total_voucher = 0;
            $('.total_voucher').each(function() {
                var total_temp = $(this).val();
                total_voucher += parseInt(total_temp);
            });

            if (total_voucher > total_voucher_subs) {
                alert("Total Voucher Qty should not greater than Total Voucher");
                $('.total_voucher').last().val('');
                $('.total_voucher').last().focus();
            }
        });

        // check voucher_start and voucher_end
        $(document).on('change', '.voucher_start, .voucher_end', function() {
            var parent = $(this).parents('.mt-repeater-item');
            var voucher_start = parent.find('.voucher_start').val();
            var voucher_end = parent.find('.voucher_end').val();
            console.log('voucher_start', voucher_start);
            console.log('voucher_end', voucher_end);

            if (voucher_start!='' && voucher_end!='' && voucher_start>voucher_end) {
                alert("Voucher Start should not be greater than Voucher End");
                $('html, body').animate({
                    scrollTop: ($(this).offset().top - 140)
                }, 300);
                $(this).focus();
            }
        });

        // check total voucher and voucher qty
        $('.form-info').on('submit', function(e) {
            var total_voucher_subs = $('.total_voucher_subscription').val();
            var total_voucher = 0;
            $('.total_voucher').each(function() {
                var total_temp = $(this).val();
                total_voucher += parseInt(total_temp);
            });

            if (total_voucher != total_voucher_subs) {
                e.preventDefault();
                alert('Total Voucher is should be equal with total Voucher Qty');
                $('html, body').animate({
                    scrollTop: ($('.total_voucher_subscription').offset().top - 70)
                }, 300);
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

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals[0]['deals_total_voucher'] }}">{{ $deals[0]['deals_total_voucher'] }}</span>
                    </div>
                    <div class="desc"> Total Voucher </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals[0]['deals_total_claimed'] }}">{{ $deals[0]['deals_total_claimed'] }}</span>
                    </div>
                    <div class="desc"> Total Claimed </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals[0]['deals_total_redeemed'] }}">{{ $deals[0]['deals_total_redeemed'] }}</span>
                    </div>
                    <div class="desc"> Total Redeem </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $deals[0]['deals_total_used'] }}">{{ $deals[0]['deals_total_used'] }}</span>
                    </div>
                    <div class="desc"> Total Used </div>
                </div>
            </a>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $deals[0]['deals_title'] }}</span>
            </div>
            <ul class="nav nav-tabs">

                <li class="active" id="infoOutlet">
                    <a href="#info" data-toggle="tab" > Info </a>
                </li>
                <li>
                    <a href="#voucher" data-toggle="tab"> Voucher </a>
                </li>
                <li>
                    <a href="#participate" data-toggle="tab"> Participate </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @include('deals::subscription.subscription_info')
                </div>
                <div class="tab-pane" id="voucher">
                    @include('deals::deals.voucher')
                </div>
                <div class="tab-pane" id="participate">
                    @include('deals::deals.participate')
                </div>
            </div>

        </div>
    </div>


@endsection