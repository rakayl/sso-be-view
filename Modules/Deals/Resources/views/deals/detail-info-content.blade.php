<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@section('detail-info-content')
@php
    $datenow = date("Y-m-d H:i:s");
@endphp
<div class="row">
	<div class="col-md-6">
		<div class="profile-info portlet light bordered">
		    <div class="row static-info">
	            <div class="col-md-6 name"> Description :</div>
	            <div class="col-md-6"></div>
	        </div>
	        <div class="row static-info">
	            <div class="col-md-12 value">{!! $deals['deals_description'] !!}</div>
				@if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0)
					@if((MyHelper::hasAccess([75], $grantedFeature) && $deals_type == 'Deals') ||
						(MyHelper::hasAccess([190], $grantedFeature) && $deals_type == 'WelcomeVoucher') ||
						(MyHelper::hasAccess([80], $grantedFeature) && $deals_type == 'Hidden'))
						<div class="col-md-12">
							<a class="btn blue" href="{{ url('/'.$rpage)}}/step3/{{$deals['id_deals']??$deals['id_deals_promotion_template']}}">Edit Description & Content</a>
						</div>
					@endif
			    @endif
	        </div>
	    </div>
	</div>
	<div class="col-md-6">
		<div class="profile-info portlet light bordered">
		    <div class="row static-info">
	            <div class="col-md-6 name"> Custom Outlet Available Text :</div>
	            <div class="col-md-6"></div>
	        </div>
	        <div class="row static-info">
	            <div class="col-md-12 value">{!! $deals['custom_outlet_text']??null !!}</div>
				@if( $deals_type == 'Promotion' || $deals['deals_total_claimed'] == 0)
					@if((MyHelper::hasAccess([112], $grantedFeature) && $deals_type == 'Promotion') ||
					(MyHelper::hasAccess([75], $grantedFeature) && $deals_type == 'Deals') ||
               (MyHelper::hasAccess([190], $grantedFeature) && $deals_type == 'WelcomeVoucher') ||
               (MyHelper::hasAccess([80], $grantedFeature) && $deals_type == 'Hidden'))
		        <div class="col-md-12">
		            <a class="btn blue" href="{{ url('/'.$rpage)}}/step1/{{$deals['id_deals']??$deals['id_deals_promotion_template']}}">Edit Text</a>
		        </div>
					@endif
			    @endif
	        </div>
	    </div>
	</div>
	<div class="col-md-12">

		<div class="profile-info portlet light bordered">
	        <div class="row static-info">
	            <div class="col-md-4 name"> Content :</div>
	            <div class="col-md-8 value"></div>
	        </div>
			@php 
				$i = 1; 
				$count_content = count($deals['deals_content']??$deals['deals_promotion_content']); 
			@endphp
			@foreach (($deals['deals_content']??$deals['deals_promotion_content']) as $content)
				@if ($i == 1 || $i%3 == 1)
					<div class="row">
				@endif
				    <div class="col-md-4">
				        <div class="portlet portlet light bordered">
				        	<div class="portlet-title"> 
					        <span class="caption font-blue sbold uppercase">{{$content['title']}}</span>
					        @if ($content['is_active'] == 1)
					        	<span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;float: right;">Visible</span>
					        @else
					        	<span class="sale-num sbold badge badge-pill" style="font-size: 20px!important;height: 30px!important;background-color: #ACB5C3;padding: 5px 12px;color: #fff;float: right;">Hidden</span>
					        @endif
					        </div>
				            <div class="portlet-body">
				            	@foreach (($content['deals_content_details']??$content['deals_promotion_content_details']) as $content_detail)
					                <div class="row static-info">
					                    <div class="col-md-2 name">{{$content_detail['order']}}</div>
					                    <div class="col-md-10 value">{{$content_detail['content']}}</div>
					                </div>
				            	@endforeach
				            </div>
				        </div>
				    </div>
				@if ($i%3 == 0 || $count_content == $i)
					</div>
				@endif
				@php $i++ @endphp
			@endforeach
		</div>
	</div>
</div>
@endsection