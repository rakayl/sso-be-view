<?php
    use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
	$configs    		= session('configs');
 ?>
<div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Admin Outlet</span>
            </div>
            @if(MyHelper::hasAccess([40], $grantedFeature))
                <a href="{{url('outlet/detail/'.$outlet[0]['outlet_code'].'/admin/create')}}" class="btn green" style="float:right">
                    New Admin Outlet
                </a>
            @endif
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Action </th>
                        <th> Name </th>
                        <th> Phone </th>
                        <th> Email </th>
                        {{-- cek config enquiry dulu baru cek admin enquiry --}}
                        @if(MyHelper::hasAccess([56], $configs))
                            @if(MyHelper::hasAccess([9], $configs))
                                <th>Enquiry</th>
                            @endif
                        @endif
                        {{-- cek config pickup order dulu baru cek admin pickup--}}
                        @if(MyHelper::hasAccess([12], $configs))
                            @if(MyHelper::hasAccess([6], $configs))
                                <th style="white-space: inherit;">Pickup Order</th>
                            @endif
                        @endif
                        {{-- cek config delivery order dulu baru cek admin delivery --}}
                        @if(MyHelper::hasAccess([13,15], $configs))
                            @if(MyHelper::hasAccess([7], $configs))
                                <th>Delivery</th>
                            @endif
                        @endif
                        {{-- cek config manual payment dulu baru cek admin finance --}}
                        @if(MyHelper::hasAccess([17], $configs))
                            @if(MyHelper::hasAccess([8], $configs))
                                <th>Payment</th>
                            @endif
                        @endif

                        @if(MyHelper::hasAccess([101], $configs))
                            <th>Outlet Apps</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($outlet[0]['user_outlets']))
                        @foreach($outlet[0]['user_outlets'] as $value)
                            <tr>
                                <td> 
                                    @if(MyHelper::hasAccess([42], $grantedFeature))
                                        <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $value['id_user_outlet'] }}" style="margin:0"><i class="fa fa-trash-o" style="width:10px"></i></a> 
                                    @endif
                                    @if(MyHelper::hasAccess([39], $grantedFeature))
                                        <a href="{{ url('outlet/detail/'.$outlet[0]['outlet_code'].'/admin/edit/'.$value['id_user_outlet']) }}" class="btn btn-sm blue" style="margin:0"><i class="fa fa-search" style="width:10px"></i></a> 
                                     @endif 
                                </td>
                                <td>{{ $value['name'] }}</td>
                                <td>{{ $value['phone'] }}</td>
                                <td>{{ $value['email'] }}</td>
                                {{-- cek config enquiry dulu baru cek admin enquiry --}}
                                @if(MyHelper::hasAccess([56], $configs))
                                    @if(MyHelper::hasAccess([9], $configs))
                                    <td style="text-align: center;">@if($value['enquiry'] == 1) <i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i> @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                    @endif
                                @endif
                                {{-- cek config pickup order dulu baru cek admin pickup--}}
                                @if(MyHelper::hasAccess([12], $configs))
                                    @if(MyHelper::hasAccess([6], $configs))
                                        <td style="text-align: center;">@if($value['pickup_order'] == 1)<i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i>  @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                    @endif
                                @endif
                                {{-- cek config delivery order dulu baru cek admin delivery --}}
                                @if(MyHelper::hasAccess([13,15], $configs))
                                    @if(MyHelper::hasAccess([7], $configs))
                                        <td style="text-align: center;">@if($value['delivery'] == 1)<i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i>  @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                    @endif
                                @endif
                                {{-- cek config manual payment dulu baru cek admin finance --}}
                                @if(MyHelper::hasAccess([17], $configs))
                                    @if(MyHelper::hasAccess([8], $configs))
                                        <td style="text-align: center;">@if($value['payment'] == 1)<i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i>  @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                    @endif
                                @endif

                                @if(MyHelper::hasAccess([101], $configs))
                                    <td style="text-align: center;">@if($value['outlet_apps'] == 1)<i class="fa fa-check" style="color:green; font-size: x-large;padding-top: 8px;"></i>  @else <i class="fa fa-times" style="color:#e7505a; font-size: x-large;padding-top: 8px;"></i> @endif</td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>