<?php
use App\Lib\MyHelper;
$configs    		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .select2-selection__arrow b{
        display:none !important;
    }
    .select2-selection{
        padding-right: 0 !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  /* Firefox */
  input[type=number] {
      -moz-appearance:textfield;
  }
</style>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

<script>
    //render outlet
    stars =['1','2','3','4','5'];
    db = {!!json_encode($options)!!};
    template = '<tr>\
    <td>\
    <div class="form-inline" style="white-space: nowrap;">\
    <select name="rule[::n::][value][]" multiple class="select2a form-control" style="width: 150px" data-placeholder="Star selected" required>\
    ::stars::\
    </select>\
    </div>\
    </td>\
    <td>\
    <div class="form-group">\
    <input type="text" class="form-control" name="rule[::n::][question]" placeholder="Question for user" value="::question::" maxlength="40" required>\
    </div>\
    </td>\
    <td style="width: 200px">\
    ::options::\
    ::addOptionBtn::\
    <td width="1%">\
    <button type="button" data-id="::n::" class="btn red deleteRule"><i class="fa fa-trash-o"></i> Delete Rule</button>\
    </td>\
    </tr>';
    function getSelected() {
        var result = [];
        for(var i=0;i<db.length;i++){
            var vrb = db[i];
            result = result.concat(vrb.value);
        }
        return result;
    }
    function replace(template,replacer,current) {
        var last = current == db.length;
        var htmlStars = '';
        var htmlOptions = '';
        var selected = getSelected();
        for(var i=0;i<stars.length;i++){
            var vrb = stars[i];
            if(replacer.value !== null && replacer.value.includes(vrb)){
                htmlStars+='<option value="'+vrb+'" selected>'+vrb+'</option>';
            }else if(selected.indexOf(vrb)==-1){
                htmlStars+='<option value="'+vrb+'">'+vrb+'</option>';
            }
        }
        replacer.options.forEach(function(vrb,ix){
            htmlOptions+=('<div class="input-group" style="margin-bottom: 5px">\
                <input type="text" class="form-control" placeholder="Option" name="rule[::n::][options]['+ix+']" value="::option::" data-id-option="'+ix+'" maxlength="20" required>\
                <div class="input-group-btn">\
                <button type="button" data-id="'+(current-1)+'" data-id-option="'+ix+'" class="btn red deleteOption"><i class="fa fa-times"></i></button>\
                </div>\
                </div>').replace('::option::',vrb);
        })                        
        return template.replace('::stars::',htmlStars).replace('::question::',replacer.question).replace('::options::',htmlOptions).replace('::addOptionBtn::',replacer.options.length<6?'<button type="button" data-id="::n::" class="btn blue addOption"><i class="fa fa-plus"></i> Add Option</button></td>':'').replace(/::n::/g,current-1);
    }
    function render() {
        console.log('render');
        if(!db.length){
            return addRule();
        }
        stars = ['1','2','3','4','5'];
        var html='';
        current = 0;
        db.forEach(function(vrb){
            current++;
            html+=replace(template,vrb,current);
        });
        $('#questionBody').html(html);
        $('.select2a').select2();
    }
    function addRule() {
        if(!(document.getElementById('questionForm').reportValidity())){
            return false;
        }
        if(getSelected().length >= 5){
            toastr.warning("All star already defined");
            return false;
        }
        db.push({
            'value':[],
            'question':'',
            'options':['']
        });
        if(getSelected().length >= 5){
            $('#btnAddRule').attr('disabled','disabled');
        }else{
            $('#btnAddRule').removeAttr('disabled');
        }
        render();
    }
    function addOption(id) {
        if(db[id].options.length >= 6){
            toastr.warning("Maximum options total already reached(6).");
            return false;
        }
        db[id].options.push('');
        render();
    }

    // render doctor
    starsDc =['1','2','3','4','5'];
    dbDc = {!!json_encode($options_dc)!!};
    templateDc = '<tr>\
    <td>\
    <div class="form-inline" style="white-space: nowrap;">\
    <select name="rule[::n::][value][]" multiple class="select2b form-control" style="width: 150px" data-placeholder="Star selected" required>\
    ::starsDc::\
    </select>\
    </div>\
    </td>\
    <td>\
    <div class="form-group">\
    <input type="text" class="form-control" name="rule[::n::][question]" placeholder="Question for user" value="::question::" maxlength="40" required>\
    </div>\
    </td>\
    <td style="width: 200px">\
    ::options::\
    ::addOptionDcBtn::\
    <td width="1%">\
    <button type="button" data-id="::n::" class="btn red deleteRule"><i class="fa fa-trash-o"></i> Delete Rule</button>\
    </td>\
    </tr>';
    function getSelectedDc() {
        let result = [];
        for(let i=0;i<dbDc.length;i++){
            let vrb = dbDc[i];
            result = result.concat(vrb.value);
        }
        return result;
    }
    function replaceDc(templateDc,replacer,current) {
        let last = current == dbDc.length;
        let htmlStars = '';
        let htmlOptions = '';
        let selected = getSelectedDc();
        for(let i=0;i<starsDc.length;i++){
            let vrb = starsDc[i];
            if(replacer.value !== null && replacer.value.includes(vrb)){
                htmlStars+='<option value="'+vrb+'" selected>'+vrb+'</option>';
            }else if(selected.indexOf(vrb)==-1){
                htmlStars+='<option value="'+vrb+'">'+vrb+'</option>';
            }
        }
        replacer.options.forEach(function(vrb,ix){
            htmlOptions+=('<div class="input-group" style="margin-bottom: 5px">\
                <input type="text" class="form-control" placeholder="Option" name="rule[::n::][options]['+ix+']" value="::option::" data-id-option="'+ix+'" maxlength="20" required>\
                <div class="input-group-btn">\
                <button type="button" data-id="'+(current-1)+'" data-id-option="'+ix+'" class="btn red deleteOption"><i class="fa fa-times"></i></button>\
                </div>\
                </div>').replace('::option::',vrb);
        })
        return templateDc.replace('::starsDc::',htmlStars).replace('::question::',replacer.question).replace('::options::',htmlOptions).replace('::addOptionDcBtn::',replacer.options.length<6?'<button type="button" data-id="::n::" class="btn blue addOptionDc"><i class="fa fa-plus"></i> Add Option</button></td>':'').replace(/::n::/g,current-1);
    }
    function renderDc() {
        if(!dbDc.length){
            return addRuleDc();
        }
        starsDc = ['1','2','3','4','5'];
        let html='';
        current = 0;
        dbDc.forEach(function(vrb){
            current++;
            html+=replaceDc(templateDc,vrb,current);
        });

        $('#questionBodyDc').html(html);
        $('.select2b').select2();
    }
    function addRuleDc() {
        if(!(document.getElementById('questionFormDc').reportValidity())){
            return false;
        }
        if(getSelectedDc().length >= 5){
            toastr.warning("All star already defined");
            return false;
        }
        dbDc.push({
            'value':[],
            'question':'',
            'options':['']
        });
        if(getSelectedDc().length >= 5){
            $('#btnAddRuleDc').attr('disabled','disabled');
        }else{
            $('#btnAddRuleDc').removeAttr('disabled');
        }
        renderDc();
    }
    function addOptionDc(id) {
        if(dbDc[id].options.length >= 6){
            toastr.warning("Maximum options total already reached(6).");
            return false;
        }
        dbDc[id].options.push('');
        renderDc();
    }

    // render product
    starsProduct =['1','2','3','4','5'];
    dbProduct = {!!json_encode($options_product)!!};
    templateProduct = '<tr>\
    <td>\
    <div class="form-inline" style="white-space: nowrap;">\
    <select name="rule[::n::][value][]" multiple class="select2b form-control" style="width: 150px" data-placeholder="Star selected" required>\
    ::starsProduct::\
    </select>\
    </div>\
    </td>\
    <td>\
    <div class="form-group">\
    <input type="text" class="form-control" name="rule[::n::][question]" placeholder="Question for user" value="::question::" maxlength="40" required>\
    </div>\
    </td>\
    <td style="width: 200px">\
    ::options::\
    ::addOptionProductBtn::\
    <td width="1%">\
    <button type="button" data-id="::n::" class="btn red deleteRule"><i class="fa fa-trash-o"></i> Delete Rule</button>\
    </td>\
    </tr>';
    function getSelectedProduct() {
        let result = [];
        for(let i=0;i<dbProduct.length;i++){
            let vrb = dbProduct[i];
            result = result.concat(vrb.value);
        }
        return result;
    }
    function replaceProduct(templateProduct,replacer,current) {
        let last = current == dbProduct.length;
        let htmlStars = '';
        let htmlOptions = '';
        let selected = getSelectedProduct();
        for(let i=0;i<starsProduct.length;i++){
            let vrb = starsProduct[i];
            if(replacer.value !== null && replacer.value.includes(vrb)){
                htmlStars+='<option value="'+vrb+'" selected>'+vrb+'</option>';
            }else if(selected.indexOf(vrb)==-1){
                htmlStars+='<option value="'+vrb+'">'+vrb+'</option>';
            }
        }
        replacer.options.forEach(function(vrb,ix){
            htmlOptions+=('<div class="input-group" style="margin-bottom: 5px">\
                <input type="text" class="form-control" placeholder="Option" name="rule[::n::][options]['+ix+']" value="::option::" data-id-option="'+ix+'" maxlength="20" required>\
                <div class="input-group-btn">\
                <button type="button" data-id="'+(current-1)+'" data-id-option="'+ix+'" class="btn red deleteOption"><i class="fa fa-times"></i></button>\
                </div>\
                </div>').replace('::option::',vrb);
        })
        return templateProduct.replace('::starsProduct::',htmlStars).replace('::question::',replacer.question).replace('::options::',htmlOptions).replace('::addOptionProductBtn::',replacer.options.length<6?'<button type="button" data-id="::n::" class="btn blue addOptionProduct"><i class="fa fa-plus"></i> Add Option</button></td>':'').replace(/::n::/g,current-1);
    }
    function renderProduct() {
        if(!dbProduct.length){
            return addRuleProduct();
        }
        starsProduct = ['1','2','3','4','5'];
        let html='';
        current = 0;
        dbProduct.forEach(function(vrb){
            current++;
            html+=replaceProduct(templateProduct,vrb,current);
        });

        $('#questionBodyProduct').html(html);
        $('.select2b').select2();
    }
    function addRuleProduct() {
        if(!(document.getElementById('questionFormProduct').reportValidity())){
            return false;
        }
        if(getSelectedProduct().length >= 5){
            toastr.warning("All star already defined");
            return false;
        }
        dbProduct.push({
            'value':[],
            'question':'',
            'options':['']
        });
        if(getSelectedProduct().length >= 5){
            $('#btnAddRuleProduct').attr('disabled','disabled');
        }else{
            $('#btnAddRuleProduct').removeAttr('disabled');
        }
        renderProduct();
    }
    function addOptionProduct(id) {
        if(dbProduct[id].options.length >= 6){
            toastr.warning("Maximum options total already reached(6).");
            return false;
        }
        dbProduct[id].options.push('');
        renderProduct();
    }


    $(document).ready(function(){
        $('.select2').select2();
        render();
        $('#btnAddRule').on('click',addRule);
        $('#questionBody').on('click','.deleteRule',function(){
            db.splice($(this).data('id'),1);
            render();
        });
        $('#questionBody').on('click','.addOption',function(){
            addOption($(this).data('id'));
        });
        $('#questionBody').on('click','.deleteOption',function(){
            var oldOption = db[$(this).data('id')].options;
            oldOption.splice($(this).data('id-option'),1);
            db[$(this).data('id')].options = oldOption;
            if(!db[$(this).data('id')].options.length){
                return addOption($(this).data('id'));
            }
            render();
        });
        $('#questionBody').on('change','select,input',function(){
            var cmd = $(this).attr('name').replace('rule','db').replace(/\[([a-z]+)\]/g,"['$1']") + ' = ' + JSON.stringify($(this).val()) + ';';
            if(cmd.includes('[]')){
                cmd = cmd.replace('[]','');
            }
            eval(cmd);
            if(cmd.includes('value')){
                console.log($(this).data('state'))
                if($(this).data('state')!=='unselected'){
                    render();
                }
            }
        });
        $('#questionBody').on("select2:unselecting",'.select2a', function(e) {
            $(this).data('state', 'unselected');
        }).on("select2:opening",'.select2a', function(e) {
            if($(this).data('state')==='unselected'){
                $(this).data('state','');
                render();
                return false;
            }
        });

        // doctor
        renderDc();
        $('#btnAddRuleDc').on('click',addRuleDc);
        $('#questionBodyDc').on('click','.deleteRule',function(){
            dbDc.splice($(this).data('id'),1);
            renderDc();
        });
        $('#questionBodyDc').on('click','.addOptionDc',function(){
            addOptionDc($(this).data('id'));
        });
        $('#questionBodyDc').on('click','.deleteOption',function(){
            var oldOption = dbDc[$(this).data('id')].options;
            oldOption.splice($(this).data('id-option'),1);
            dbDc[$(this).data('id')].options = oldOption;
            if(!dbDc[$(this).data('id')].options.length){
                return addOptionDc($(this).data('id'));
            }
            renderDc();
        });
        $('#questionBodyDc').on('change','select,input',function(){
            var cmd = $(this).attr('name').replace('rule','dbDc').replace(/\[([a-z]+)\]/g,"['$1']") + ' = ' + JSON.stringify($(this).val()) + ';';
            if(cmd.includes('[]')){
                cmd = cmd.replace('[]','');
            }
            eval(cmd);
            if(cmd.includes('value')){
                console.log($(this).data('state'))
                if($(this).data('state')!=='unselected'){
                    renderDc();
                }
            }
        });
        $('#questionBodyDc').on("select2:unselecting",'.select2b', function(e) {
            $(this).data('state', 'unselected');
        }).on("select2:opening",'.select2b', function(e) {
            if($(this).data('state')==='unselected'){
                $(this).data('state','');
                renderDc();
                return false;
            }
        });

        // product
        renderProduct();
        $('#btnAddRuleProduct').on('click',addRuleProduct);
        $('#questionBodyProduct').on('click','.deleteRule',function(){
            dbProduct.splice($(this).data('id'),1);
            renderProduct();
        });
        $('#questionBodyProduct').on('click','.addOptionProduct',function(){
            addOptionProduct($(this).data('id'));
        });
        $('#questionBodyProduct').on('click','.deleteOption',function(){
            var oldOption = dbProduct[$(this).data('id')].options;
            oldOption.splice($(this).data('id-option'),1);
            dbProduct[$(this).data('id')].options = oldOption;
            if(!dbProduct[$(this).data('id')].options.length){
                return addOptionProduct($(this).data('id'));
            }
            renderProduct();
        });
        $('#questionBodyProduct').on('change','select,input',function(){
            var cmd = $(this).attr('name').replace('rule','dbProduct').replace(/\[([a-z]+)\]/g,"['$1']") + ' = ' + JSON.stringify($(this).val()) + ';';
            if(cmd.includes('[]')){
                cmd = cmd.replace('[]','');
            }
            eval(cmd);
            if(cmd.includes('value')){
                if($(this).data('state')!=='unselected'){
                    renderProduct();
                }
            }
        });
        $('#questionBodyProduct').on("select2:unselecting",'.select2b', function(e) {
            $(this).data('state', 'unselected');
        }).on("select2:opening",'.select2b', function(e) {
            if($(this).data('state')==='unselected'){
                $(this).data('state','');
                renderProduct();
                return false;
            }
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
            <span class="caption-subject font-dark sbold uppercase font-blue">User Rating Setting</span>
        </div>
    </div>
    <div class="portlet-body form form-horizontal" id="detailRating">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_setting" data-toggle="tab"> Setting </a>
            </li>
            @if(MyHelper::hasAccess([138], $configs))
            <li>
                <a href="#tab_rating_option" data-toggle="tab"> Rating Option Outlet </a>
            </li>
            @endif
            @if(MyHelper::hasAccess([139], $configs))
            <li>
                <a href="#tab_rating_option_dc" data-toggle="tab"> Rating Option Doctor </a>
            </li>
            @endif
            @if(MyHelper::hasAccess([140], $configs))
                <li>
                    <a href="#tab_rating_option_product" data-toggle="tab"> Rating Option Product </a>
                </li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="tab_rating_option">
                <form id="questionForm" action="{{url('user-rating/option')}}" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 100px">Star <i class="fa fa-question-circle tooltips" data-original-title="Aturan jumlah bintang untuk pertanyaan yang akan disetel. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Question <i class="fa fa-question-circle tooltips" data-original-title="Pertanyaan yang akan ditamplikan setelah bintang yang disetel terpilih. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Options <i class="fa fa-question-circle tooltips" data-original-title="Pilihan yang akan muncul untuk menjawab pertanyaan yang diatur. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="questionBody">
                        </tbody>
                    </table>
                    <div class="text-center">
                    	<input type="hidden" name="rating_target" value="outlet">
                        <button class="btn blue" type="button" id="btnAddRule"><i class="fa fa-plus"></i> Add Rule</button>
                        <button class="btn yellow" type="submit" id="btnSave"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="tab_rating_option_dc">
                <form id="questionFormDc" action="{{url('user-rating/option')}}" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 100px">Star <i class="fa fa-question-circle tooltips" data-original-title="Aturan jumlah bintang untuk pertanyaan yang akan disetel. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Question <i class="fa fa-question-circle tooltips" data-original-title="Pertanyaan yang akan ditamplikan setelah bintang yang disetel terpilih. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Options <i class="fa fa-question-circle tooltips" data-original-title="Pilihan yang akan muncul untuk menjawab pertanyaan yang diatur. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="questionBodyDc">
                        </tbody>
                    </table>
                    <div class="text-center">
                    	<input type="hidden" name="rating_target" value="doctor">
                        <button class="btn blue" type="button" id="btnAddRuleDc"><i class="fa fa-plus"></i> Add Rule</button>
                        <button class="btn yellow" type="submit" id="btnSaveDc"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="tab_rating_option_product">
                <form id="questionFormProduct" action="{{url('user-rating/option')}}" method="POST">
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 100px">Star <i class="fa fa-question-circle tooltips" data-original-title="Aturan jumlah bintang untuk pertanyaan yang akan disetel. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                            <th>Question <i class="fa fa-question-circle tooltips" data-original-title="Pertanyaan yang akan ditamplikan setelah bintang yang disetel terpilih. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                            <th>Options <i class="fa fa-question-circle tooltips" data-original-title="Pilihan yang akan muncul untuk menjawab pertanyaan yang diatur. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo"></i></th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="questionBodyProduct">
                        </tbody>
                    </table>
                    <div class="text-center">
                        <input type="hidden" name="rating_target" value="product">
                        <button class="btn blue" type="button" id="btnAddRuleProduct"><i class="fa fa-plus"></i> Add Rule</button>
                        <button class="btn yellow" type="submit" id="btnSaveProduct"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade in active" id="tab_setting">
                <form action="#" method="POST">
                    @csrf
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Max List Rating <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal rating yang ditampilkan pada halaman home. Urutan berdasarkan waktu terakhir popup ditampilkan dari terlama menuju ke terbaru " data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" name="popup_max_list" class="form-control" required value="{{old('popup_max_list',$setting['popup_max_list']['value']??'')}}" /><br/>
                                    <span class="input-group-addon">
                                        Rating
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Popup Interval Time <i class="fa fa-question-circle tooltips" data-original-title="Rentang waktu minimal ditampilkannya popup rating" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" name="popup_min_interval" class="form-control" required value="{{old('popup_min_interval',$setting['popup_min_interval']['value']??'')}}" /><br/>
                                    <span class="input-group-addon">
                                        Seconds
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Max Refuse Popup <i class="fa fa-question-circle tooltips" data-original-title="Jumlah penolakan maksimal untuk memberikan rating. Setelah jumlah terlampaui, popup tidak akan ditampilkan lagi sampai ada transaksi baru lagi" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control" name="popup_max_refuse" required value="{{old('popup_max_refuse',$setting['popup_max_refuse']['value']??'')}}" /><br/>
                                    <span class="input-group-addon">
                                        Times
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Transaction Date <i class="fa fa-question-circle tooltips" data-original-title="Rentang hari maksimal dari transaksi yang memungkinkan untuk ditampilkan di popup rating mobile apps" data-container="body"></i></label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="0" class="form-control" name="popup_max_days" required value="{{old('popup_max_days',$setting['popup_max_days']['value']??3)}}" /><br/>
                                    <span class="input-group-addon">
                                        days before
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Rating Question Doctor <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di atas pilihan bintang. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo2"></i></label>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="rating_question_text" required  value="{{old('rating_question_text',$setting['rating_question_text']['value_text']??'')}}" maxlength="40" /><br/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-3 control-label text-right">Rating Question Product <i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan ditampilkan di atas pilihan bintang. Klik ikon ini untuk melihat detail." data-container="body" data-toggle="modal" data-target="#modalInfo2"></i></label>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_rating_question_text" required  value="{{old('product_rating_question_text',$setting['product_rating_question_text']['value_text']??'')}}" maxlength="40" /><br/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-3 col-md-5">
                            <div class="form-group">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalInfo2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{env('STORAGE_URL_VIEW')}}img/setting/rating2_preview.png" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modalInfo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{env('STORAGE_URL_VIEW')}}img/setting/rating_preview.png" style="max-height: 75vh">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection