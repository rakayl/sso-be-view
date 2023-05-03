@extends('layouts.main')
    
@section('page-script')
    <script>
        function addReplace(param){
		    var textvalue = $('#package-detail').val();
            var textvaluebaru = textvalue+" "+param;
            $('#package-detail').val(textvaluebaru);
        }

        $('.price').each(function() {
            var input = $(this).val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $(this).val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        });

        $( ".price" ).on( "keyup", numberFormat);
        function numberFormat(event){
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }

            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            var $this = $( this );
            var input = $this.val();
            var input = input.replace(/[\D\s\._\-]+/g, "");
            input = input ? parseInt( input, 10 ) : 0;

            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "id" );
            });
        }

        $( ".price" ).on( "blur", checkFormat);
        function checkFormat(event){
            var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
            if(!$.isNumeric(data)){
                $( this ).val("");
            }
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
                <span class="caption-subject font-green bold uppercase">Package Detail Delivery</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" action="{{ url('transaction/setting/package-detail-delivery') }}" method="post" id="form">
            {{ csrf_field() }}
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Package name
                        <span class="required" aria-required="true"> * </span>  
                            <i class="fa fa-question-circle tooltips" data-original-title="Informasi yang akan dikirimkan ke pihak delivery digunakan untuk GoSend dan wehelpyou" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Package name" class="form-control" name="package_name" id="package-detail" value="@if(isset($result['package_name'])){{$result['package_name']}}@endif">
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
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Package description
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Informasi deskripsi yang akan dikirimkan ke pihak delivery digunakan untuk GoSend dan wehelpyou" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-8">
                        <textarea type="text" placeholder="Package description" class="form-control" name="package_description">{{$result['package_description']??""}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Length/item
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan panjang rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan wehelpyou." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control price" name="length" value="{{ $result['length']??0 }}" placeholder="Length/item" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Width/item
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan lebar rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan wehelpyou." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control price" name="width" value="{{ $result['width']??0 }}" placeholder="Width/item" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Height/item
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan tinggi rata-rata produk, satuan dalam cm. Digunakan untuk kebutuhan wehelpyou." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control price" name="height" value="{{ $result['height']??0 }}" placeholder="Height/item" required>
                            <span class="input-group-addon"> cm </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                            Weight/item
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan bobot rata-rata produk, satuan dalam gram. Digunakan untuk kebutuhan wehelpyou." data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control price" name="weight" value="{{ $result['weight']??0 }}" placeholder="Weight/item" required>
                            <span class="input-group-addon"> gram </span>
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
