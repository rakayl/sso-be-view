@section('deals-info')
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">Information</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="row">
				<div class="col-md-6">
					<div class="row static-info">
		                <div class="col-md-4 name">Brand</div>
		                <div class="col-md-8 value">: 
		                	@php
		                		foreach ($result['brands'] as $key => $value) {
		                    		if ($key == 0) {
		                    			$comma = '';
		                    		}else{
		                    			$comma = ', ';
		                    		}
		                    		echo $comma.$value['name_brand'];
		                		}
		                	@endphp</div>
		            </div>
		            <div class="row static-info">
		                <div class="col-md-4 name">Brand Rule</div>
		                <div class="col-md-8 value">: 
		                    {{ $result['brand_rule'] && $result['brand_rule'] == 'and' ? 'All selected brands' : 'One of the selected brands' }}
		                </div>
		            </div>						
					<div class="row static-info">
						<div class="col-md-4 name">Product Type</div>
						<div class="col-md-8 value">: 
							@php
								$product_type = $result['product_type'] ?? 'single';
								$echo = "";
								switch ($product_type) {
									case 'single + variant':
										$echo = 'Product + Product variant';
										break;

									case 'variant':
										$echo = 'Product variant only';
										break;
									
									default:
										$echo = 'Product only';
										break;
								}

								echo $echo;
							@endphp
						</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Deals Title</div>
						<div class="col-md-8 value">: {{ isset($result['deals_title']) ? $result['deals_title'] : '' }}</div>
					</div>
					@if($deals_type != 'Promotion')
		                @if(isset($result['deals_start']))
		                <div class="row static-info">
		                    <div class="col-md-4 name">Start</div>
		                    <div class="col-md-8 value">: {{date("d M Y", strtotime($result['deals_start']))}}&nbsp;{{date("H:i", strtotime($result['deals_start']))}}</div>
		                </div>
		                <div class="row static-info">
		                    <div class="col-md-4 name">End</div>
		                    <div class="col-md-8 value">: {{date("d M Y", strtotime($result['deals_end']))}}&nbsp;{{date("H:i", strtotime($result['deals_end']))}}</div>
		                </div>
		                @endif
		            @endif
					@if($deals_type != 'WelcomeVoucher' && $deals_type != 'Promotion')
		                @if($deals_type != 'Hidden')
			                @if(isset($result['deals_end']))
			                <div class="row static-info">
			                    <div class="col-md-4 name">Publish Start</div>
			                    <div class="col-md-8 value">: {{date("d M Y", strtotime($result['deals_publish_start']))}}&nbsp;{{date("H:i", strtotime($result['deals_publish_start']))}}</div>
			                </div>
			                <div class="row static-info">
			                    <div class="col-md-4 name">Publish End</div>
			                    <div class="col-md-8 value">: {{date("d M Y", strtotime($result['deals_publish_end']))}}&nbsp;{{date("H:i", strtotime($result['deals_publish_end']))}}</div>
			                </div>
			                @endif
		                @endif
		            @endif
					<div class="row static-info">
						<div class="col-md-4 name">Charged Central</div>
						<div class="col-md-8 value">: {{$result['charged_central']}} %</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Charged Outlet</div>
						<div class="col-md-8 value">: {{$result['charged_outlet']}} %</div>
					</div>
				</div>
				<div class="col-md-6">
					@if($deals_type != 'Promotion')
						<div class="row static-info">
		                    <div class="col-md-4 name">Total Voucher</div>
		                    <div class="col-md-8 value">: {{ !empty($result['deals_total_voucher']) ? number_format($result['deals_total_voucher']).' Vouchers' : (isset($result['deals_total_voucher']) ? 'unlimited' : '') }}</div>
		                </div>
		                <div class="row static-info">
		                    <div class="col-md-4 name">Used Voucher</div>
		                    <div class="col-md-8 value">: {{ number_format($result['deals_total_used']??0).' Vouchers' }}</div>
		                </div>
		            @endif
	                <div class="row static-info">
	                    <div class="col-md-4 name">User Limit</div>
	                    <div class="col-md-8 value">: {{ $result['user_limit']??false ? number_format($result['user_limit']).' Times usage' : 'Unlimited' }}</div>
	                </div>
	                @if($deals_type != 'Promotion')
		                <div class="row static-info">
		                    <div class="col-md-4 name">Voucher Expiry</div>
		                    <div class="col-md-8 value">: {{ ($result['deals_voucher_duration']??false) ? 'By Duration ( '.number_format($result['deals_voucher_duration']).' Days )' : (($result['deals_voucher_expired']??false) ? 'By Date ( '.date("d M Y", strtotime($result['deals_voucher_expired'])).' '.date("H:i", strtotime($result['deals_voucher_expired'])).' )' : '-') }}</div>
		                </div>
		                <div class="row static-info">
		                    <div class="col-md-4 name">Voucher Start</div>
		                    <div class="col-md-8 value">: {{ $result['deals_voucher_start']??false ? date("d M Y", strtotime($result['deals_voucher_start'])) : '-' }}</div>
		                </div>
		            @endif
	                <div class="row static-info">
	                    <div class="col-md-4 name">Image</div>
	                    <div class="col-md-8 value">
	                    	<span style="float: left;margin-right: 5px">:</span> 
	                    	<div><img src="{{ $result['url_deals_image']??'' }}" style="width: 100px"></div>
	                    </div>
	                </div>
					<div class="row static-info">
						<div class="col-md-4 name">Creator</div>
						<div class="col-md-8 value">: {{ isset($result['created_by_user']['name']) ? $result['created_by_user']['name'] : '' }}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Level</div>
						<div class="col-md-8 value">: {{ isset($result['created_by_user']['level']) ? $result['created_by_user']['level'] : ''}}</div>
					</div>
					<div class="row static-info">
						<div class="col-md-4 name">Created</div>
						<div class="col-md-8 value">: @if(isset($result['created_at'])) {{date("d F Y", strtotime($result['created_at']))}}&nbsp;{{date("H:i", strtotime($result['created_at']))}} @endif</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection