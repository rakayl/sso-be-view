<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script>
		function centang(no){
			alert(no);
		}
		var arr = [];

		function checkUsers(){
			var slides = document.getElementsByClassName("md-check");
			for(var i = 0; i < slides.length; i++)
			{
				slides[i].checked = true;
				var currentId = slides[i].id;
				var phone = currentId.replace("check", "");
				arr.push(phone);
			}
			$('[name="users_check"]').val( JSON.stringify( arr ) );
		}

		function uncheckUsers(){
			var slides = document.getElementsByClassName("md-check");
			for(var i = 0; i < slides.length; i++)
			{
				slides[i].checked = false;
			}
			arr = [];
			$('[name="users_check"]').val('');
		}

		function insertUsers(id){
			if($('#check' + id).is(":checked")){
				arr.push(id);
			}else{
				const index = arr.indexOf(id);
				if (index > -1) {
					arr.splice(index, 1);
				}
			}
			$('[name="users_check"]').val( JSON.stringify( arr ) );
		}
	</script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="{{url('/user')}}">User</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<form role="form" action="{{ url('user') }}?filter=1" method="post">
				@if(Session::has('form'))
					<?php

					$search_param = Session::get('form');
					$search_param = array_filter($search_param);
					if(isset($search_param['conditions'])){
						$conditions = $search_param['conditions'];
					} else {
						$conditions = "";
					}
					?>
				@else
					<?php
					$conditions = "";
					?>
				@endif
				{{ csrf_field() }}
				@include('filter')
			</form>
		</div>
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> {{$table_title}} </span>
					</div>
				</div>
				<div class="portlet-body">
					@if(Session::has('form'))
						<?php
						$search_param = Session::get('form');
						$search_param = array_filter($search_param);
						?>
						<div class="alert alert-block alert-info fade in">
							<button type="button" class="close" data-dismiss="alert"></button>
							<h4 class="alert-heading">Displaying search result with parameter(s):</h4>
							@if(isset($search_param['conditions']))
								@foreach($search_param['conditions'] as $key => $cond)
									@foreach($cond as $row)
										@if(isset($row['subject']))
											<p>{{ucwords(str_replace("_"," ",$row['subject']))}}
												@if($row['subject'] == 'trx_product')
													<?php $name = null; ?>
													@foreach($products as $product)
														@if($product['id_product'] == $row['id'])
															<?php $name = $product['product_name']; ?>
														@endif
													@endforeach
													"{{$name}}" with product count {{$row['operatorSpecialCondition']}} {{$row['parameterSpecialCondition']}}
												@elseif($row['subject'] == 'Deals')
													<?php $name = null; ?>
													@foreach($deals as $val)
														@if($val['id_deals'] == $row['operator'])
															<?php $name = $val['deals_title']; ?>
														@endif
													@endforeach
													{{$row['subject']}} = "{{$name}}"
												@elseif($row['subject'] == 'Quest')
													<?php $name = null;
													$dtSelect =[
															'already_claim' => 'Already Claim',
															'not_yet_claim' => 'Not Yet Claim'
													];
													?>
													@foreach($quest as $val)
														@if($val['id_quest'] == $row['operator'])
															<?php $name = $val['name']; ?>
														@endif
													@endforeach
													{{$row['subject']}} = "{{$name}}" ({{$dtSelect[$row['parameter_select']]??''}})
												@elseif($row['subject'] == 'Subscription')
													<?php $name = null; ?>
													@foreach($subscription as $val)
														@if($val['id_subscription'] == $row['operator'])
															<?php $name = $val['subscription_title']; ?>
														@endif
													@endforeach
													{{$row['subject']}} = "{{$name}}"
												@elseif($row['subject'] == 'trx_outlet')
													<?php $name = null; ?>
													@foreach($outlets as $outlet)
														@if($outlet['id_outlet'] == $row['id'])
															<?php $name = $outlet['outlet_name']; ?>
														@endif
													@endforeach
													"{{$name}}" with outlet count {{$row['operatorSpecialCondition']}} {{$row['parameterSpecialCondition']}}
												@elseif($row['subject'] != 'all_user')
													@if(isset($row['operator']) && in_array($row['operator'] ,["=","like","<","<=",">",">="]) )
														{{$row['operator']}} {{$row['parameter']}}
													@else
														=
														@if($row['subject'] == 'trx_outlet_not')
															<?php $name = null; ?>
															@foreach($outlets as $outlet)
																@if($outlet['id_outlet'] == $row['operator'])
																	<?php $name = $outlet['outlet_name']; ?>
																@endif
															@endforeach
															{{$name}}
														@elseif($row['subject'] == 'trx_product_not')
															<?php $name = null; ?>
															@foreach($products as $product)
																@if($product['id_product'] == $row['operator'])
																	<?php $name = $product['product_name']; ?>
																@endif
															@endforeach
															{{$name}}
														@elseif($row['subject'] == 'trx_product_tag' || $row['subject'] == 'trx_product_tag_not')
															<?php $name = null; ?>
															@foreach($tags as $tag)
																@if($tag['id_tag'] == $row['operator'])
																	<?php $name = $tag['tag_name']; ?>
																@endif
															@endforeach
															{{$name}}
														@elseif($row['subject'] == 'membership')
															<?php $name = null; ?>
															@foreach($memberships as $membership)
																@if($membership['id_membership'] == $row['operator'])
																	<?php $name = $membership['membership_name']; ?>
																@endif
															@endforeach
															{{$name}}
														@else
															@if(isset($row['operator']))
																{{$row['operator']}}
															@endif
														@endif
													@endif
												@endif

											</p>
										@endif
									@endforeach

									@if($key < count($conditions)-1)
										<p> {{$cond['rule_next']}}
									@endif
								@endforeach
							@endif

							@if(isset($search_param['take']))<p>Show = {{$search_param['take']}}</p> @endif
							@if(isset($search_param['order_field']))<p>Order By = {{$search_param['order_field']}} @if(isset($search_param['order_method'])) {{$search_param['order_method']}} @endif</p> @endif
							<br>
							<p>
								<a href="{{ url('user/search/reset') }}" class="btn yellow">Reset</a>
							</p>

						</div>
					@endif
					<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-bottom:20px;">
						<div class="col-md-4" style="padding-left:0px;padding-right:0px;">
							<a href="#" class="btn btn md yellow" onClick="checkUsers();">Check All</a>
							<a href="#" class="btn btn md red" onClick="uncheckUsers();">Uncheck All</a>
						</div>
						<form action="{{ url('user') }}" method="post">
							{{ csrf_field() }}
							<div class="col-md-2" style="padding-left:0px;padding-right:0px;">
								<select name="take" class="form-control select2">
									<option value="10" @if($take == 10) selected @endif>Show 10 Data</option>
									<option value="50" @if($take == 50) selected @endif>Show 50 Data</option>
									<option value="100" @if($take == 100) selected @endif>Show 100 Data</option>
									<option value="9999999999" @if($take == 9999999999) selected @endif>Show ALL Data</option>
								</select>
							</div>
							<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
								<select name="order_field" class="form-control select2">
									<option value="id" @if($order_field == 'id') selected @endif>Order by ID</option>
									<option value="name" @if($order_field == 'name') selected @endif>Order by Name</option>
									<option value="phone" @if($order_field == 'phone') selected @endif>Order by Phone</option>
									<option value="email" @if($order_field == 'email') selected @endif>Order by Email</option>
									<option value="address" @if($order_field == 'address') selected @endif>Order by Address</option>
									<option value="gender" @if($order_field == 'gender') selected @endif>Order by Gender</option>
									<option value="birthday" @if($order_field == 'birthday') selected @endif>Order by Birthday</option>
									<option value="city_name" @if($order_field == 'city_name') selected @endif>Order by City Name</option>
									<option value="province_name" @if($order_field == 'province_name') selected @endif>Order by Province Name</option>
								</select>
							</div>
							<div class="col-md-2" style="padding-left:0px;padding-right:0px">
								<select name="order_method" class="form-control select2">
									<option value="desc" @if($order_method == 'desc') selected @endif>Desc</option>
									<option value="asc" @if($order_method == 'asc') selected @endif>Asc</option>
								</select>
							</div>
							<div class="col-md-1" style="padding-left:0px;padding-right:0px;text-align:right">
								<button type="submit" class="btn yellow">Show</button>
							</div>
						</form>
					</div>
					<div class="col-md-12" style="text-align:right;margin-right:0px;padding-right:0px;margin-bottom:20px;">
						<a href="{{ url('user/export') }}" class="btn yellow">Export User Data (.xls)</a>
					</div>
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover nowrap">
							<thead>
							<tr>
								<th scope="col" style="width:450px !important"> No </th>
								<th scope="col"> Actions </th>
								<th scope="col"> Name </th>
								<th scope="col"> Phone </th>
								<th scope="col"> Device </th>
								<th scope="col"> Email </th>
								<th scope="col"> City </th>
								<th scope="col"> Province </th>
								<th scope="col"> Postal Code </th>
								<th scope="col"> Gender </th>
								<th scope="col"> Provider </th>
								<th scope="col"> Birthday </th>
								<th scope="col"> Age </th>
								<th scope="col"> Points </th>
								<th scope="col"> Phone Verified </th>
								<th scope="col"> Email Verified </th>
								<th scope="col"> Register Date </th>

							</tr>
							</thead>
							<tbody>
								@if(!empty($dataUser))
									@foreach($dataUser as $no => $data)

										@if($data['phone_verified'] == 0)
											<tr style="color:red">
										@elseif($data['level'] == "Admin")
											<tr style="color:blue">
										@elseif($data['level'] == "Super Admin")
											<tr style="color:green">
										@else
											<tr>
												@endif
												<td> {{($page-1) * $take + $no + 1}}
													<label class="mt-checkbox"><input type="checkbox" value="1" onclick="insertUsers(`{{$data['phone']}}`)" name="users[{{$data['phone']}}]" id="check{{$data['phone']}}" class="md-check" /> <span></span></label>
												</td>
												<td>
													@if(MyHelper::hasAccess([2], $grantedFeature))
														<a class="btn btn-block yellow btn-xs" href="{{ url('user/detail', $data['phone']) }}"><i class="icon-pencil"></i> Detail </a>
														<a class="btn btn-block blue btn-xs" href="{{ url('user/detail', $data['phone']) }}/favorite"><i class="icon-pencil"></i> Favorite </a>
													@endif

													@if(MyHelper::hasAccess([5], $grantedFeature))
														@if($data['is_deleted'] == 0)
															<a class="btn btn-block red btn-xs" href="{{ url('user/delete', $data['phone']) }}" data-toggle="confirmation" data-placement="top"><i class="icon-close"></i> Delete </a>
														@else
															<a data-toggle="modal" href="#active_{{$data['id']}}" class="btn btn-block green-dark btn-xs"><i class="fa fa-check"></i> Activate</a>
														@endif
													@endif
												</td>
												<td> {!!str_replace(" ","&nbsp;", $data['name'])!!} </td>
												<td> {{$data['phone']}} </td>
												<td>
													@if($data['android_device'] == "" && $data['ios_device'] == "") None @endif
													@if($data['android_device'] != "" && $data['ios_device'] == "") Android @endif
													@if($data['android_device'] == "" && $data['ios_device'] != "") IOS @endif
													@if($data['android_device'] != "" && $data['ios_device'] != "") Both @endif
												</td>
												<td> {{$data['email']}} </td>
												<td> {!!str_replace(" ","&nbsp;", $data['city_name'])!!} </td>
												<td> {!!str_replace(" ","&nbsp;", $data['province_name'])!!} </td>
												<td> {{$data['address_postal_code']}} </td>
												<td> {{$data['gender']}} </td>
												<td> {{$data['provider']}} </td>
												<td> @if($data['birthday'] != ""){!!str_replace(" ","&nbsp;", date('d F Y', strtotime($data['birthday'])))!!}@else - @endif </td>
												<td> {!!str_replace(" ","&nbsp;", $data['age'])!!} </td>
												<td> {{$data['balance']}} </td>
												<td> @if($data['phone_verified'] == 0) Not Verified @else Verified @endif </td>
												<td> @if($data['email_verified'] == 0) Not Verified @else Verified @endif </td>
												<td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($data['created_at'])))!!} </td>
												<div class="modal fade" id="active_{{$data['id']}}" tabindex="-1" role="basic" aria-hidden="true">
						                                        <div class="modal-dialog">
						                                            <div class="modal-content">
						                                                <div class="modal-header">
						                                                    <h4 class="modal-title">Activate User <b>{{$data['name']}}</b></h4>
						                                                </div>
						                                                <div class="modal-body">
						                                                	<form class="form-horizontal" role="form" action="{{url('user/activate')}}" method="post">
						                                                    @if($data['have_another_account'])
							                                                    <div class="alert alert-warning">
							                                                    	<p>Phone dan Email sudah terpakai untuk user lain, untuk mengaktifkan user kembali Anda wajib memperbaharui data phone dan email dibawah ini.</p>
							                                                    </div>
							                                                    <br>
							                                                    @endif
						                                                        <div class="form-group">
						                                                            <label class="col-md-3 control-label" style="text-align: left">
						                                                                Phone <span class="required" aria-required="true">*</span>
						                                                            </label>
						                                                            <div class="col-md-8">
						                                                                <input class="form-control" maxlength="30" name="active_phone" value="{{$data['phone']}}" @if($data['have_another_account']) required @else readonly @endif>
						                                                            </div>
						                                                        </div>
						                                                        <br>
						                                                        <br>
						                                                        <div class="form-group">
						                                                            <label class="col-md-3 control-label" style="text-align: left">
						                                                                Email <span class="required" aria-required="true">*</span>
						                                                            </label>
						                                                            <div class="col-md-8">
						                                                                <input class="form-control" maxlength="30" name="active_email" value="{{$data['email']}}" @if($data['have_another_account']) required @else readonly @endif>
						                                                            </div>
						                                                        </div>
						                                                        <br>
						                                                        <br>
						                                                        <div class="form-group">
						                                                            <label class="col-md-3 control-label" style="text-align: left">
						                                                                Current Password <span class="required" aria-required="true">*</span>
						                                                            </label>
						                                                            <div class="col-md-8">
						                                                                <input class="form-control" type="password" maxlength="50" name="active_current_pin" required>
						                                                            </div>
						                                                        </div>
						                                                        <br>
						                                                        <br>
						                                                    <input type="hidden" name="id_user" value="{{$data['id']}}">
						                                                    <div class="modal-footer" style="text-align: center">
						                                                        {{ csrf_field() }}
						                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
						                                                        <button type="submit" class="btn green-dark">Activate</button>
						                                                    </div>
						                                                </form>
						                                                </div>
						                                            </div>
						                                        </div>
						                                    </div>
											</tr>
							@endforeach
							@endif

							</tbody>
						</table>
					</div>
					<div style="padding-right: 0px;">
						@if ($dataUserPaginator)
							{{ $dataUserPaginator->links() }}
						@endif
					</div>
				</div>
				<form action="{{ url('user/action/bulk') }}" method="post">
					{{ csrf_field() }}
					<div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:20px">
						<div class="col-md-5" style="padding-left:0px;padding-right:0px;">
							<select name="action" class="form-control select2" required>
								<option value="">Select...</option>
								<option value="phone verified">Set Phone Verified</option>
								<option value="phone not verified">Set Phone Not Verified</option>
								<option value="email verified">Set Email Verified</option>
								<option value="email not verified">Set Email Not Verified</option>
							</select>
						</div>
						<input type="hidden" name="users_check">
						<div class="col-md-3" style="padding-left:0px;padding-right:0px;">
							<button type="submit" class="btn yellow" data-toggle="confirmation" data-placement="top">Apply Bulk Action</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection