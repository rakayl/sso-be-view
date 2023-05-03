@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Auto Response',
                tabsize: 2,
                height: 120,
                callbacks: {
                    onImageUpload: function(files){
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/autoresponse')}}",
                            success: function(data){
                            }
                        });
                    }
                }
            });
            $('.price').inputmask("numeric", {
                removeMaskOnSubmit: true, 
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                oncleared: function () { self.Value(''); }
            });
        });

        function visibleDiv(apa,nilai){
            if(apa == 'email'){
                if(nilai === '1'){
                    document.getElementById('autoresponse-wrapper').style.display = 'none';
                } else {
                    document.getElementById('autoresponse-wrapper').style.display = 'block';
                }
            }
        }

        function addForwardSubject(param){
            var textvalue = $('#autocrm_forward_email_subject').val();
            var textvaluebaru = textvalue+" "+param;
            $('#autocrm_forward_email_subject').val(textvaluebaru);
        }

        function addForwardContent(param){
            var textvalue = $('#autocrm_forward_email_content').val();

            var textvaluebaru = textvalue+" "+param;
            $('#autocrm_forward_email_content').val(textvaluebaru);
            $('#autocrm_forward_email_content').summernote('editor.saveRange');
            $('#autocrm_forward_email_content').summernote('editor.restoreRange');
            $('#autocrm_forward_email_content').summernote('editor.focus');
            $('#autocrm_forward_email_content').summernote('editor.insertText', param);
        }

    </script>
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Order</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Delivery Settings</span>
            <i class="fa fa-circle"></i>
        </li>
        @if (!empty($sub_title))
        <li>
            <span>[Forward] WeHelpYou Low Balance</span>
        </li>
        @endif
    </ul>
</div><br>

@include('layouts.notifications')

<form class="form-horizontal" action="#" method="post" id="form">
<div class="portlet light form-fit bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">[Forward] WeHelpYou Low Balance</span>
        </div>
    </div>
    <div class="portlet-body form">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="form-group">
                <div class="input-icon right">
                    <label class="col-md-3 control-label">
                        Limit Balance
                    <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Apabila balance kurang dari nilai yang di set, maka akan mengirimkan forward email ke admin" data-container="body"></i>
                    </label>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">Rp</div>
                        <input type="text" name="wehelpyou_limit_balance" class="form-control price" value="{{$wehelpyou_limit_balance}}">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_autocrm" value="{{$result['id_autocrm']}}"/>
            <div id="autoresponse-wrapper">
                <div class="form-group" id="div_email_recipient_transaction_in_day">
                    <div class="input-icon right">
                        <label for="multiple" class="control-label col-md-3">
                            Email Recipient
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="diisi dengan alamat email admin yang akan menerima laporan fraud detection, jika lebih dari 1 pisahkan dengan tanda koma (,)" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <textarea name="autocrm_forward_email" id="autocrm_forward_email" class="form-control field_email" placeholder="Email address recipient">@if(isset($result['autocrm_forward_email'])){{ $result['autocrm_forward_email'] }}@endif</textarea>
                        <p class="help-block">Comma ( , ) separated for multiple emails</p>
                    </div>
                </div>

                <div class="form-group" id="div_email_subject">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Subject
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan subjek email, tambahkan text replacer bila perlu" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Email Subject" class="form-control" name="autocrm_forward_email_subject" id="autocrm_forward_email_subject" value="{{$result['autocrm_forward_email_subject']}}">
                        <br>
                        You can use this variables to display user personalized information:
                        <br><br>
                        <div class="row">
                            @foreach($textreplaces as $key=>$row)
                                @php if(!$row) continue; @endphp
                                <div class="col-md-3" style="margin-bottom:5px;">
                                    <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                </div>
                            @endforeach
                            @if (isset($custom))
                                @foreach($custom as $key=>$row)
                                    @php if(!$row) continue; @endphp
                                    <div class="col-md-3" style="margin-bottom:5px;">
                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}'" onClick="addForwardSubject('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group" id="div_email_content">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Content
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Diisi dengan konten email, tambahkan text replacer bila perlu" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <textarea name="autocrm_forward_email_content" id="autocrm_forward_email_content" class="form-control summernote"><?php echo $result['autocrm_forward_email_content'];?></textarea>
                        You can use this variables to display user personalized information:
                        <br><br>
                        <div class="row" >
                            @foreach($textreplaces as $key=>$row)
                                @php if(!$row) continue; @endphp
                                <div class="col-md-3" style="margin-bottom:5px;">
                                    <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addForwardContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                </div>
                            @endforeach
                            @if (isset($custom))
                                @foreach($custom as $key=>$row)
                                @php if(!$row) continue; @endphp
                                    <div class="col-md-3" style="margin-bottom:5px;">
                                        <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $custom[$key] }}'" onClick="addForwardContent('{{ $custom[$key] }}');">{{ str_replace('_',' ',$custom[$key]) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
    <button class="btn green" type="submit">
        <i class="fa fa-check"></i> Save
    </button>    
</div>
</form>
@endsection
