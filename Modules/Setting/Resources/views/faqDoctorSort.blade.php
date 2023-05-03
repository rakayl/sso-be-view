<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .well{
            height: 130px;
        }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-blockui.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#sortable').sortable({
                update: function (event, ui) {
                    $(document).ajaxStart($.blockUI({ css: {border: 'none', backgroundColor: '#000', opacity: .3, color: '#fff'} })).ajaxStop($.unblockUI);
                    $.post("{{url('setting/faq-doctor/sort/update')}}", $('#formFaqSort').serialize(), function(result){
                        if(result['status'] == 0 ){
                            location.reload();
                        }
                    });
                }
            });
            $( "#sortable" ).disableSelection();
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
    <?php
    //========= start setting column and row =========//
    $total = count($result);
    $total_column = 3;
    $totalRow = $total / $total_column;
    $index = 0;

    if(is_float($totalRow) === true){
        $totalRow = (int)$totalRow + 1;
    }
    //========= end setting =========//
    ?>

    <div class="col-md-12">
        <div class="m-heading-1 border-green m-bordered">
            <p>Anda dapat mengatur urutan List FAQ dengan cara "Drag and Drop" pada setiap box dibawah ini.
                Setiap action "Drop" akan langsung tersimpan secara otomatis. Urutan dimulai dari kiri kekanan.
            </p>
        </div>
        <form class="form-horizontal form-bordered" id="formFaqSort" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="clearfix" id="sortable">
                @for($i=0;$i<=$total_column;$i++)
                    @for($j=0;$j<=$totalRow;$j++)
                        @if($index != $total)
                            @if(strlen($result[$index]['question']) > 85)
                                <div class="col-md-3" style="cursor: all-scroll;">
                                    <input type="hidden" name="id_faq_doctor[]" value="{{ $result[$index]['id_faq_doctor'] }}">
                                    <div class="well">{{substr($result[$index]['question'],0,85)}} ...</div>
                                </div>
                            @else
                                <div class="col-md-3" style="cursor: all-scroll;">
                                    <input type="hidden" name="id_faq_doctor[]" value="{{ $result[$index]['id_faq_doctor'] }}">
                                    <div class="well">{{$result[$index]['question']}}</div>
                                </div>
                            @endif

                            <?php
                            $index++;
                            ?>
                        @endif
                    @endfor
                @endfor
            </div>
        </form>
    </div>
@endsection
