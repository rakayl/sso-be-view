<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('detail-info')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row">
    <div class="col-md-6">
        <div class="portlet profile-info portlet light bordered">
            <div class="portlet sale-summary">
                <div class="portlet-body">
                    <ul class="list-unstyled">
                        <li>
                            <span class="sale-info"> Status 
                                <i class="fa fa-img-up"></i>
                            </span>
                            @php
                        		$date_start = $subscription['subscription_start'];
                        		$date_end 	= $subscription['subscription_end'];
                        		$now 		= date("Y-m-d H:i:s");
                        	@endphp
                            @if( empty($subscription['subscription_step_complete']) )
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #F4D03F;padding: 5px 12px;color: #fff;">Not Complete</span>
                            @elseif( !empty($date_end) && $date_end < $now )
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;">Ended</span>
                            @elseif( empty($date_start) || $date_start <= $now )
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Started</span>
                            @else
                                <span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Not Started</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-4 name">Charged Central</div>
                    <div class="col-md-8 value">: {{$subscription['charged_central']}} %</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Charged Outlet</div>
                    <div class="col-md-8 value">: {{$subscription['charged_outlet']}} %</div>
                </div>
                @if(isset($subscription['subscription_start']))
                <div class="row static-info">
                    <div class="col-md-4 name">Start</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($subscription['subscription_start']))}}&nbsp;{{date("H:i", strtotime($subscription['subscription_start']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">End</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($subscription['subscription_end']))}}&nbsp;{{date("H:i", strtotime($subscription['subscription_end']))}}</div>
                </div>
                @endif
            	@if(isset($subscription['subscription_publish_start']))
                <div class="row static-info">
                    <div class="col-md-4 name">Publish Start</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($subscription['subscription_publish_start']))}}&nbsp;{{date("H:i", strtotime($subscription['subscription_publish_start']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Publish End</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($subscription['subscription_publish_end']))}}&nbsp;{{date("H:i", strtotime($subscription['subscription_publish_end']))}}</div>
                </div>
            	@endif
                <div class="row static-info">
                    <div class="col-md-4 name">Created</div>
                    <div class="col-md-8 value">: {{date("d M Y", strtotime($subscription['created_at']))}}&nbsp;{{date("H:i", strtotime($subscription['created_at']))}}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Image</div>
                    <div class="col-md-8 value">
                    	<span style="float: left;margin-right: 5px">:</span> 
                    	<div><img src="{{ env('STORAGE_URL_API').$subscription['subscription_image'] }}" style="width: 250px"></div>
                    </div>
                </div>
                
            @if( $subscription['subscription_bought'] == 0 && MyHelper::hasAccess([175], $grantedFeature))
            <div class="row static-info text-center">
                <div class="col-md-11 value">
                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step1/{{$subscription['id_subscription']}}">Edit Detail</a>
                </div>
            </div>
            @endif
            </div>
        </div>
        @if(isset($subscription['is_all_product']) && $subscription['is_all_product'] == '0')
        <div class="profile-info portlet light bordered">
	        <div class="portlet-title"> 
	            <span class="caption font-blue sbold uppercase"> Selected Product </span>
	        </div>
	        <div class="mt-comments">
                @if (!empty($subscription['subscription_products']))
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Variant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscription['subscription_products'] as $res)
                        	@php
                        		$variant = [];
								foreach ($res['product_variant_pivot'] as $val) {
									$variant[] = $val['product_variant']['product_variant_name'];
								}
								$variant = implode(', ',$variant);
                        	@endphp
                                <tr>
                                    <td>{{ $res['brand']['name_brand']??'' }}</td>
                                    <td>{{ $res['product']['product_code']??'' }}</td>
                                    <td>
                                    	<a href="{{ url('product/detail/'.($res['product']['product_code']??'')) }}">{{ $res['product']['product_name']??'' }}</a>	
                                    </td>
                                    <td>{{ $variant }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
	    </div>
        @endif
    </div>
    
    <div class="col-md-6 profile-info">
    	@if (true)
	    	<div class="profile-info portlet light bordered">
	            <div class="portlet-title"> 
	            <span class="caption font-blue sbold uppercase"> Subscription Rules </span>
	            </div>
	            @if ( true || !empty($subscription['deals_promo_id_type']) )
                <div class="row static-info">
                    <div class="col-md-4 name">Subscription Price</div>
                    <div class="col-md-8 value">: 
                    	@if($subscription['subscription_price_type'] == 'free' && $subscription['is_free'] == 1)
                    		{{ $subscription['subscription_price_type'] }}
                    	@elseif(!empty($subscription['subscription_price_point']))
                    		{{ number_format($subscription['subscription_price_point']).' Points' }}
                    	@elseif(!empty($subscription['subscription_price_cash']))
                    		{{ 'IDR '.number_format($subscription['subscription_price_cash']) }}
                    	@endif
                    </div>
                </div>
	            <div class="row static-info">
                    <div class="col-md-4 name">Brand</div>
                    <div class="col-md-8 value">: 
                    	@if (!empty($subscription['id_brand']))
                    		{{ $subscription['brand']['name_brand'] }}
                    	@else
                        	@php
                        		foreach ($subscription['brands'] as $key => $value) {
                            		if ($key == 0) {
                            			$comma = '';
                            		}else{
                            			$comma = ', ';
                            		}
                            		echo $comma.$value['name_brand'];
                        		}
                        	@endphp
                    	@endif
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Brand Rule</div>
                    <div class="col-md-8 value">: 
                        {{ $subscription['brand_rule'] && $subscription['brand_rule'] == 'and' ? 'All selected brands' : 'One of the selected brands' }}
                    </div>
                </div>
                <div class="row static-info">
                	@php
                		$outlet_type = null;
                		if ( !empty($subscription['is_all_outlet']) ) {
                			$outlet_type ='All outlet';
                		} elseif ( !empty($subscription['outlets']) ){
                			$outlet_type = 'Selected outlet';
                		} elseif ( !empty($subscription['outlet_groups']) ){
                			$outlet_type = 'Outlet group filter';
                		}

                	@endphp
                    <div class="col-md-4 name">Outlet</div>
                    <div class="col-md-8 value">: {{ $outlet_type }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Product</div>
                    <div class="col-md-8 value">: @if ( ($subscription['is_all_product']??false) == 1 ) All product @elseif( ($subscription['is_all_product']??false) === 0 ) Selected product @endif </div>
                </div>
                @if (empty($subscription['is_all_product']))
	                <div class="row static-info">
	                    <div class="col-md-4 name">Product Rule</div>
	                    <div class="col-md-8 value">: 
	                        {{ $subscription['product_rule'] && $subscription['product_rule'] == 'and' ? 'All items must be present' : 'One of the items must exist' }}
	                    </div>
	                </div>
                @endif
                @php
					$delivery_list_text = [];
					foreach ($delivery_list ?? [] as $value) {
						$delivery_list_text[$value['code']] = $value['delivery_name'];
					}
				@endphp
                <div class="row static-info">
				    <div class="col-md-4 name">Shipment Method</div>
				    <div class="col-md-1 value">:</div>
				    <div class="col-md-7 value" style="margin-left: -31px">
				    	@if ($subscription['is_all_shipment'] == '1')
				            <div>All Shipment</div>
				        @elseif ($subscription['is_all_shipment'] == '0')
				        	@foreach ($subscription['subscription_shipment_method'] as $val)
				        		<div style="margin-bottom: 10px">{{ '- '.($delivery_list_text[$val['shipment_method']] ?? $val['shipment_method']) }}</div>
				        	@endforeach
				        @else
				            -
				        @endif
				    </div>
				</div>

				@php
					$payment_list_text = [];
					foreach ($payment_list ?? [] as $value) {
						$payment_list_text[$value['payment_method']] = $value['text'];
					}
				@endphp
				<div class="row static-info">
				    <div class="col-md-4 name">Payment Method</div>
				    <div class="col-md-1 value">:</div>
				    <div class="col-md-7 value" style="margin-left: -31px">
				    	@if ($subscription['is_all_payment'] == '1')
				            <div>All Payment Method</div>
				        @elseif ($subscription['is_all_payment'] == '0')
				        	@foreach ($subscription['subscription_payment_method'] as $val)
				        		<div style="margin-bottom: 10px">{{ '- '.($payment_list_text[$val['payment_method']] ?? $val['payment_method']) }}</div>
				        	@endforeach
				        @else
				            -
				        @endif
				    </div>
				</div>
                <div class="row static-info">
                    <div class="col-md-4 name">Subscription Total</div>
                    <div class="col-md-8 value">: {{ !empty($subscription['subscription_total']) ? number_format($subscription['subscription_total']).' Subscriptions' : (($subscription['subscription_total']==0) ? 'unlimited' : '') }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">User Limit</div>
                    <div class="col-md-8 value">: {{ $subscription['user_limit']??false ? number_format($subscription['user_limit']).' Times purchase' : 'Unlimited' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Start Date</div>
                    <div class="col-md-8 value">: @if(!empty($subscription['subscription_voucher_start'])) {{date("d M Y", strtotime($subscription['subscription_voucher_start']))}}&nbsp;{{date("H:i", strtotime($subscription['subscription_voucher_start'])) }} @endif</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Expiry</div>
                    <div class="col-md-8 value">: {{ ($subscription['subscription_voucher_duration']??false) ? 'By Duration ( '.number_format($subscription['subscription_voucher_duration']).' Days )' : (($subscription['subscription_voucher_expired']??false) ? 'By Date ( '.date("d M Y", strtotime($subscription['subscription_voucher_expired'])).' '.date("H:i", strtotime($subscription['subscription_voucher_expired'])).' )' : '-') }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Total</div>
                    <div class="col-md-8 value">: {{ !empty($subscription['subscription_voucher_total']) ? number_format($subscription['subscription_voucher_total']).' Vouchers' : '' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Discount Type</div>
                    <div class="col-md-8 value">: 
                    	@switch($subscription['subscription_discount_type'])
                        @case('discount')
                            Discount
                            @break
                        @case('discount_delivery')
                            Discount Delivery
                            @break
                        @default
                            Payment Method
                    	@endswitch
                	</div>
                </div>
                @if(!empty($subscription['subscription_voucher_nominal']))
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Discount</div>
                    <div class="col-md-8 value">: {{ 'Nominal (IDR '.number_format($subscription['subscription_voucher_nominal']).')' }}</div>
                </div>
                @endif
                @if(!empty($subscription['subscription_voucher_percent']))
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Discount</div>
                    <div class="col-md-8 value">: {{ 'Percent ('.$subscription['subscription_voucher_percent'].' %)' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Voucher Discount Max</div>
                    <div class="col-md-8 value">: {{ !empty($subscription['subscription_voucher_percent_max']) ? 'IDR '.number_format($subscription['subscription_voucher_percent_max']) : '' }}</div>
                </div>
                @endif
                <div class="row static-info">
                    <div class="col-md-4 name">Min Basket Size</div>
                    <div class="col-md-8 value">: {{ !empty($subscription['subscription_minimal_transaction']) ? number_format($subscription['subscription_minimal_transaction']) : '' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">Daily Usage Limit</div>
                    <div class="col-md-8 value">: {{ $subscription['daily_usage_limit']??'' }}</div>
                </div>
                <div class="row static-info">
                    <div class="col-md-4 name">New Purchase Limit</div>
                    <div class="col-md-8 value">: {{ ( ($subscription['new_purchase_after']??false) != 'No Limit' ) ? 'Limit' : 'No Limit' }}</div>
                </div>
                @if($subscription['new_purchase_after'] != 'No Limit')
                <div class="row static-info">
                    <div class="col-md-4 name">New Purchase After</div>
                    <div class="col-md-8 value">: {{ ($subscription['new_purchase_after'] == 'Empty Expired') ? 'Empty/Expired' : $subscription['new_purchase_after']}}</div>
                </div>
                @endif
	            @if( $subscription['subscription_bought'] == 0 && MyHelper::hasAccess([175], $grantedFeature))
	                <div class="row static-info">
	                    <div class="col-md-11 value">
	                        <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$subscription['id_subscription']}}">Edit Rule</a>
	                    </div>
	                </div>
	                @endif
	            @else
	            <span class="sale-num font-red sbold">
	                No subscription Rules
	            </span>
	            @if( $subscription['subscription_bought'] == 0 )
	            <div class="row static-info">
	                <div class="col-md-11 value">
	                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$subscription['id_subscription']}}">Create Rule</a>
	                </div>
	            </div>
	            @endif
	            @endif
	        </div>
    	@endif

    	@if (!empty($subscription['is_online']))
        <div class="profile-info portlet light bordered">
            <div class="portlet-title"> 
            <span class="caption font-blue sbold uppercase">Voucher Online Rules : {{ $subscription['promo_type']??'' }}</span>
            </div>
            @if ( 
            		!empty($subscription['deals_product_discount_rules']) || 
            		!empty($subscription['deals_tier_discount_rules']) || 
            		!empty($subscription['deals_buyxgety_rules']) ||
            		!empty($subscription['deals_promotion_product_discount_rules']) || 
            		!empty($subscription['deals_promotion_tier_discount_rules']) || 
            		!empty($subscription['deals_promotion_buyxgety_rules']) 
            	)
                @if (isset($subscription['deals_product_discount_rules']) && $subscription['deals_product_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ($subscription['deals_product_discount_rules'] != null)
                                @if ($subscription['deals_product_discount_rules']['is_all_product'] == '1')
                                    All Product
                                @elseif ($subscription['deals_product_discount_rules']['is_all_product'] == '0')
                                    Selected Product
                                @else
                                    No Product Requirement
                                @endif
                            @elseif ($subscription['deals_tier_discount_rules'] != null)
                                {{$subscription['deals_tier_discount_product']['product']['product_name']}}
                            @elseif ($subscription['deals_buyxgety_rules'] != null)
                                {{$subscription['deals_buyxgety_product_requirement']['product']['product_name']??''}}
                            @endif
                        </div>
                    </div>
                    @if ($subscription['deals_product_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Discount</div>
                        <div class="col-md-8 value">: 
                            @if ($subscription['deals_product_discount_rules']['discount_type'] == 'Percent')
                                {{$subscription['deals_product_discount_rules']['discount_value']}} % {{ !empty($subscription['deals_product_discount_rules']['max_percent_discount']) ? '(Max : IDR '.number_format($subscription['deals_product_discount_rules']['max_percent_discount']).') ' : '' }}
                            @elseif ($subscription['deals_product_discount_rules']['discount_type'] == 'Nominal')
                                {{ 'IDR '.number_format($subscription['deals_product_discount_rules']['discount_value']) }}
                            @else
                                No discount
                            @endif
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-4 name">Max Product</div>
                        <div class="col-md-8 value">: 
                                {{ ($subscription['deals_product_discount_rules']['max_product'] == 0) ? 'no limit' : number_format($subscription['deals_product_discount_rules']['max_product']).' item' }}
                        </div>
                    </div>
                    @endif
                    <div class="mt-comments">
                        @if ($subscription['deals_product_discount_rules'] != null)
                            @if(isset($subscription['deals_product_discount_rules']['is_all_product']) && $subscription['deals_product_discount_rules']['is_all_product'] == '0')
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_5">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscription['deals_product_discount'] as $res)
                                            <tr>
                                                <td>{{ $res['product']['product_code']??$res['product_group']['product_group_code']??'' }}</td>
                                                <td>
                                                @if (!empty($res['product_group']))
                                                	<a href="{{ url('product-variant/group/'.($res['product_group']['id_product_group']??'')) }}">{{ $res['product_group']['product_group_name']??'' }}</a>
                                                @else
                                                	<a href="{{ url('product/detail/'.($res['product']['product_code']??'')) }}">{{ $res['product']['product_name']??'' }}</a>	
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif
                    </div>
                @elseif (isset($subscription['deals_tier_discount_rules']) && $subscription['deals_tier_discount_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ( isset($subscription['deals_tier_discount_product']) )
                            	@if (!empty($subscription['deals_tier_discount_product']['product_group']))
                                	<a href="{{ url('product-variant/group/'.$subscription['deals_tier_discount_product']['product_group']['id_product_group']??'') }}">{{ ($subscription['deals_tier_discount_product']['product_group']['product_group_code']??'').' - '.($subscription['deals_tier_discount_product']['product_group']['product_group_name']??'') }}</a>
                                @else
                            		<a href="{{ url('product/detail/'.$subscription['deals_tier_discount_product']['product']['product_code']??'') }}">{{ ($subscription['deals_tier_discount_product']['product']['product_code']??'').' - '.($subscription['deals_tier_discount_product']['product']['product_name']??'') }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_6">
                        <thead>
                            <tr>
                                <th>Min Qty</th>
                                <th>Max Qty</th>
                                <th>{{ ($subscription['deals_tier_discount_rules'][0]['discount_type']??'').' Discount' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscription['deals_tier_discount_rules'] as $res)
                                <tr>
                                    <td>{{ number_format($res['min_qty']) }}</td>
                                    <td>{{ number_format($res['max_qty']) }}</td>
                                    <td>{{ ($subscription['deals_tier_discount_rules'][0]['discount_type'] == 'Percent') ? ( $res['discount_value'].' % (Max : IDR '.number_format($res['max_percent_discount']).')' ) : ('IDR '.number_format($res['discount_value'])) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif (isset($subscription['deals_buyxgety_rules']) && $subscription['deals_buyxgety_rules'] != null)
                    <div class="row static-info">
                        <div class="col-md-4 name">Product Requirement</div>
                        <div class="col-md-8 value">: 
                            @if ( isset($subscription['deals_buyxgety_product_requirement']) )
                            	@if (!empty($subscription['deals_buyxgety_product_requirement']['product_group']))
                                	<a href="{{ url('product-variant/group/'.$subscription['deals_buyxgety_product_requirement']['product_group']['id_product_group']??'') }}">{{ ($subscription['deals_buyxgety_product_requirement']['product_group']['product_group_code']??'').' - '.($subscription['deals_buyxgety_product_requirement']['product_group']['product_group_name']??'') }}</a>
                                @else
                            		<a href="{{ url('product/detail/'.$subscription['deals_buyxgety_product_requirement']['product']['product_code']??'') }}">{{ ($subscription['deals_buyxgety_product_requirement']['product']['product_code']??'').' - '.$subscription['deals_buyxgety_product_requirement']['product']['product_name']??'' }}</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_7">
                        <thead>
                            <tr>
                                <th>Min Qty</th>
                                <th>Max Qty</th>
                                <th>Product Benefit</th>
                                <th>Benefit Qty</th>
                                <th>Benefit Discount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscription['deals_buyxgety_rules'] as $res)
                                <tr>
                                    <td>{{ $res['min_qty_requirement'] }}</td>
                                    <td>{{ $res['max_qty_requirement'] }}</td>
                                    <td>
                                    	<a href="{{ url('product/detail/'.$res['product']['product_code']??'') }}">{{ $res['product']['product_code'].' - '.$res['product']['product_name'] }}</a>
                                    <td>{{ $res['benefit_qty'] }}</td>
                                    <td>
                                    @if( ($res['discount_type']??false) == 'nominal' )
                                    	{{'IDR '.number_format($res['discount_value'])}}
                                    @elseif( ($res['discount_type']??false) == 'percent' )
                                    	@if( ($res['discount_value']??false) == 100 )
                                    		Free
                                		@else
                                    		{{ ($res['discount_value']??false).'% (Max : IDR '.number_format($res['max_percent_discount']).')' }}
                                    	@endif
                                    @endif
	                                    </td>
	                                    <td>
	                                    {{ ( ($res['discount_percent']??'') == 100) ? 'Free' : ( ($res['discount_percent']??false) ? $res['discount_percent'].' % (Max : IDR '.number_format($res['max_percent_discount']).')' : (($res['discount_nominal']??false) ? 'IDR '.number_format($res['discount_nominal']) : '' ) ) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @elseif (isset($subscription['deals_discount_global_rule']) && $subscription['deals_discount_global_rule'] != null) 
                                        @if ($subscription['deals_discount_global_rule'] != null)
                                        <div class="row static-info">
                                            <div class="col-md-4 name">Discount</div>
                                            <div class="col-md-8 value">: 
                                                @if ($subscription['deals_discount_global_rule']['discount_type'] == 'Percent')
                                                    {{ $subscription['deals_discount_global_rule']['discount_value'] }} %
                                                @elseif ($subscription['deals_discount_global_rule']['discount_type'] == 'Nominal')
                                                    {{ 'IDR '.number_format($subscription['deals_discount_global_rule']['discount_value']) }}
                                                @else
                                                    No discount
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                    @if( $subscription_type == 'Promotion' || $subscription['deals_total_claimed'] == 0 && MyHelper::hasAccess([175], $grantedFeature))
                                    <div class="row static-info">
                                        <div class="col-md-11 value">
                                            <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$subscription['id_deals']}}">Edit Rule</a>
                                        </div>
                                    </div>
                                    @endif
            @else
            <span class="sale-num font-red sbold">
                No Deals Rules
            </span>
            @if(MyHelper::hasAccess([175], $grantedFeature))
            <div class="row static-info">
                <div class="col-md-11 value">
                    <a class="btn blue" href="{{ url('/'.$rpage)}}/step2/{{$subscription['id_deals']}}">Create Rule</a>
                </div>
            </div>
            @endif
            @endif
        </div>
        @endif
    </div>
    
</div>
@endsection

@section('detail-style')
	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
	</style>
@endsection

@section('detail-script')
	<script>
		$('.sample_5, .sample_6, .sample_7').dataTable({
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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-7 col-sm-12'l><'col-md-5 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

    $('#sample_3').dataTable({
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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });

        $('#sample_4').dataTable({
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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
	</script>
@endsection