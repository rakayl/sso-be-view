@extends('layouts.main')

@section('page-style')
@endsection
    
@section('page-script')
    <script>
        function addReplace(param){
		    var textvalue = $('#package-detail').val();
            var textvaluebaru = textvalue+" "+param;
            $('#package-detail').val(textvaluebaru);
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">GO-SEND Package Detail Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/go-send-package-detail') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            GO-SEND Package Detail Text
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Informasi yang akan dikirimkan ke driver GO-SEND mengenai detail paket" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="GO-SEND Package Detail Text" class="form-control" name="value" id="package-detail" value="@if(isset($result['value'])){{$result['value']}}@endif">
                        <br>
                        You can use this variables to display order ID:
                        <br><br>
                        <div class="row">
                            <div class="col-md-3" style="margin-bottom:5px;">
                                <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '%order_id%' with transaction's order ID" onClick="addReplace('%order_id%');">Order ID</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-10">
                            <button type="submit" class="btn green">
                                <i class="fa fa-check"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
