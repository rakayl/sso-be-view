@extends('layouts.main')

@section('page-style')
@endsection
    
@section('page-script')
<script src="{{ url('js/prices.js')}}"></script>
<script>
    $(document).ready(function() {
        @if(isset($result['free_delivery_requirement_type']))
            @if($result['free_delivery_requirement_type'] == 'total item')
                $('.div-item').show();
                $('.item').prop('required', true);
                $('.div-subtotal').hide();
                $('.subtotal').prop('required', false);
            @else
                $('.div-item').hide();
                $('.item').prop('required', false);
                $('.div-subtotal').show();
                $('.subtotal').prop('required', true);
            @endif
        @endif

        @if(isset($result['free_delivery_type']))
            @if($result['free_delivery_type'] == 'free')
                $('.div-nominal').hide();
                $('.nominal').prop('required', false);
            @else
                $('.div-nominal').show();
                $('.nominal').prop('required', true);
            @endif
        @endif
    })

    $('.type').click(function() {
        var nilai = $(this).val();
        if (nilai == "nominal") {
            $('.div-nominal').show();
            $('.nominal').prop('required', true);
        }else{
            $('.div-nominal').hide();
            $('.nominal').prop('required', false);
        }
    });
    $('.req-type').click(function() {
        var nilai = $(this).val();
        if (nilai == "total item") {
            $('.div-item').show();
            $('.item').prop('required', true);
            $('.div-subtotal').hide();
            $('.subtotal').prop('required', false);
        }else{
            $('.div-item').hide();
            $('.item').prop('required', false);
            $('.div-subtotal').show();
            $('.subtotal').prop('required', true);
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

    <div class="portlet light form-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">Free Delivery Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/free-delivery') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Requirement Type
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Tipe syarat minimum untuk mendapatkan free delivery dapat berupa total item atau subtotal transaksi" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-icon right">
                            <div class="col-md-4">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio1" name="free_delivery_requirement_type" class="md-radiobtn req-type" value="total item" required @if(isset($result['free_delivery_requirement_type']) && $result['free_delivery_requirement_type'] == 'total item') checked @endif>
                                        <label for="radio1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Total Item Transaction</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio2" name="free_delivery_requirement_type" class="md-radiobtn req-type" value="subtotal" required @if(isset($result['free_delivery_requirement_type']) && $result['free_delivery_requirement_type'] == 'subtotal') checked @endif>
                                        <label for="radio2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Subtotal Transaction </label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>

                <div class="form-group div-item" style="display:none">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Minimum Total Item
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah total item minimal untuk mendapatkan free delivery" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-3">
                        <div class="input-icon right">
                            <div class="input-group">
                                <input type="text" class="form-control price item" min="0" name="free_delivery_min_item" value="@if(isset($result['free_delivery_min_item'])) {{$result['free_delivery_min_item']}} @endif">
                                <span class="input-group-addon">
                                    Item
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group div-subtotal" style="display:none">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Minimum Subtotal Transaction
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Jumlah subtotal transaksi minimal untuk mendapatkan free delivery" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" min="0" class="form-control price subtotal" name="free_delivery_min_subtotal" value="@if(isset($result['free_delivery_min_subtotal'])) {{$result['free_delivery_min_subtotal']}} @endif"> 
                    </div>
                </div>


                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Free Delivery Type
                        <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Tipe Free delivery berupa potongan harga atau free" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-icon right">
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio14" name="free_delivery_type" class="md-radiobtn type" value="free" required @if(isset($result['free_delivery_type']) && $result['free_delivery_type'] == 'free') checked @endif>
                                        <label for="radio14">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Free </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio16" name="free_delivery_type" class="md-radiobtn type" value="nominal" required @if(isset($result['free_delivery_type']) && $result['free_delivery_type'] == 'nominal') checked @endif>
                                        <label for="radio16">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Nominal </label>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>

                <div class="form-group div-nominal" style="display:none">
                    <label class="col-md-3 control-label"> Nominal <span class="required" aria-required="true"> * </span> </label>
                    <div class="col-md-4">
                        <input type="text" min="0" class="form-control nominal price" name="free_delivery_nominal" value="@if(isset($result['free_delivery_nominal'])) {{$result['free_delivery_nominal']}} @endif"> 
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
