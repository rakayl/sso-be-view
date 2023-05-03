<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

 ?>
 @extends('layouts.main')
@include('list_filter')
@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


    @endsection

    @section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    @yield('filter_script')
    <script type="text/javascript">
        rules = {
            all_product_modifier :{
                display:'All Product Variant NON PRICE (NO SKU)',
                operator:[],
                opsi:[]
            },
            text :{
                display:'Name',
                operator:[
                    ['=','='],
                    ['like','like']
                ],
                opsi:[]
            }
        };
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
    @yield('filter_view')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product Variant NON PRICE (NO SKU)</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover table-responsive" width="100%">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Child </th>
                        <th> Assign Product </th>
                        <th> Assign Product Variant </th>
                        @if(MyHelper::hasAccess([287,285,286], $grantedFeature))
                            <th> Action </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($modifierGroup))
                        @foreach($modifierGroup as $mg)
                            <tr>
                                <td>{{$mg['product_modifier_group_name']}}</td>
                                <td>
                                    <ul>
                                        @foreach($mg['product_modifier'] as $pm)
                                            <li>{{$pm['text']}} ({{$pm['code']}})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($mg['product_modifier_group_pivots'] as $pmgp)
                                            @if(!empty($pmgp['id_product']))
                                            <li>{{$pmgp['product_code']}} - {{$pmgp['product_name']}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($mg['product_modifier_group_pivots'] as $pmgp)
                                            @if(!empty($pmgp['product_variant_name']))
                                                <li>{{$pmgp['product_variant_name']}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                @if(MyHelper::hasAccess([287,285,286], $grantedFeature))
                                    <td>
                                        <form action="{{url('product/modifier-group/delete/'.$mg['id_product_modifier_group'])}}" method="POST" class="form-inline">
                                            {{csrf_field()}}
                                            <button class="btn btn-sm red btnDelete" type="submit" data-toggle="confirmation"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="{{url('product/modifier-group/edit/'.$mg['id_product_modifier_group'])}}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center"><em class="text-muted">No toppings group found</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-offset-8 col-md-4 text-right">
                <div class="pagination">
                    <ul class="pagination">
                        <br>
                        @if ($modifierGroupPaginator)
                            {{ $modifierGroupPaginator->links() }}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>



@endsection