<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    database={!!json_encode($brands)!!};
    valuex={single:[],combo:[]};
    @if($old=old('brands'))
    valuex["{{old('outlet_type','single')}}"]={!!json_encode($old)!!};
    @endif
    template={
        single:'\
            <div class="row"><div class="col-md-5 form-group">\
            %select%\
            </div><div class="col-md-1"><button data-id="%id%" class="btn btn-danger remover_btn" type="button"><i class="fa fa-times"></i></button></div></div>',
        combo:'\
            <div class="row">\
                <div class="col-md-5 form-group">%select0%\
                </div>\
                <div class="col-md-1 text-center control-label">AND</div>\
                <div class="col-md-5 form-group">%select1%\
                </div><div class="col-md-1"><button data-id="%id%" class="btn btn-danger remover_btn" type="button"><i class="fa fa-times"></i></button></div>\
            </div>'
    };
    function selectBrand(value){
        if(value=='all'){
            $('#select_brand_container').hide();
        }else{
            $('#select_brand_container').show();
        }
        var type=$('input[name="outlet_type"]:checked').val();
        renderer(type);
    }
    function add(type="single"){
        valuex[type].push({});
        renderer(type);
    }
    function remove(id,type="single"){
        valuex[type].splice(id,1);
        renderer(type);
    }
    function selectBuilder(name,value){
        var templatex='<select name="'+name+'" class="select2 form-control brand_selector" data-placeholder="Select Brand" required><option></option>%option%</select>';
        var option='';
        for(var i=0;i<database.length;i++){
            brand=database[i];
            if(value==brand.id_brand){var more="selected";}else{var more="";}
            option+='<option value="'+brand.id_brand+'" '+more+'>'+brand.name_brand+'</option>';
        }
        templatex=templatex.replace('%option%',option);
        return templatex;
    }
    function renderer(type="single"){
        var db=valuex[type];
        if(db&&db.length<=0&&type!="all"){
            return add(type);
        }
        var tpl=template[type];
        var html='';
        if(type=="single"){
            for(i=0;i<db.length;i++){
                var name='brands['+i+'][0]';
                var value='';
                if(db[i][0]){
                    value=db[i][0];
                }
                var select=selectBuilder(name,value);
                html+=tpl.replace('%select%',select).replace('%id%',i);
            }
        }else if(type=="combo"){
            for(i=0;i<db.length;i++){
                for(j=0;j<2;j++){
                    var name='brands['+i+']['+j+']';
                    var value='';
                    if(db[i][j]){
                        value=db[i][j];
                    }
                    if(j==0){
                        var select0=selectBuilder(name,value);
                    }else{
                        var select1=selectBuilder(name,value);
                    }
                }
                html+=tpl.replace('%select0%',select0).replace('%select1%',select1).replace('%id%',i);
            }
        }
        $('#brand_inner_container').html(html);
        $('.select2').select2({
            placeholder:$(this).data('placeholder')
        });
    }
    $(document).ready(function(){
        $('.select2').select2({
            'placeholder':$(this).data('placeholder')
        });
        $('input[name="outlet_type"]').on('click',function(){
            var value=$('input[name="outlet_type"]:checked').val();
            selectBrand(value);
        });
        selectBrand($('input[name="outlet_type"]:checked').val());
        $('#add_btn').on('click',function(){
            var type=$('input[name="outlet_type"]:checked').val();
            if(type){
                add(type);
            }
        });
        $('#select_brand_container').on('click','.remover_btn',function(){
            var id=$(this).data('id');
            var type=$('input[name="outlet_type"]:checked').val();
            remove(id,type);
        });
        $('#select_brand_container').on('change','.brand_selector',function(){
            var name=$(this).prop('name');
            var type=$('input[name="outlet_type"]:checked').val();
            var value=$(this).val();
            name=name.replace('brands','valuex["'+type+'"]');
            eval(name+'="'+value+'";');
        });
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
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-yellow sbold uppercase">Export Outlet</span>
            </div>
        </div>
        <div class="portlet-body form">
            @if(MyHelper::hasAccess([24,25], $grantedFeature))
                @if(MyHelper::hasAccess([24,25], $grantedFeature))
                    <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Outlet Type <span class="required" aria-required="true"> * </span></label>
                            <div class="col-md-9">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio_all" name="outlet_type" class="md-radiobtn" value="all" required checked>
                                        <label for="radio_all">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> All </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio_single" name="outlet_type" class="md-radiobtn" value="single" required @if(old('outlet_type')=='single') checked @endif>
                                        <label for="radio_single">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Single </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio_multiple" name="outlet_type" class="md-radiobtn" value="combo" required  @if(old('outlet_type')=='combo') checked @endif>
                                        <label for="radio_multiple">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Combo </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="select_brand_container">
                            <label class="col-md-3 control-label">Brand<span class="required" aria-required="true"> * </span></label>
                            <div class="col-md-9" id="brand_inner_container"></div>
                            <div class="col-md-offset-3 col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" id="add_btn" class="btn blue">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <div class="form-group">
                                        <button type="submit" id="export_btn" class="btn green">Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </div>
@endsection