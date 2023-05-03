<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
$level    			= session('level');

(session('advert')) ? $advert = session('advert') : $advert = null;

?>

<li class="sidebar-toggler-wrapper hide">
	<div class="sidebar-toggler">
		<span></span>
	</div>
</li>

<li class="nav-item {{($menu_active == 'disburse-dasboard') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/dashboard')}}" class="nav-link nav-toggle">
		<i class="fa fa-th"></i>
		<span class="title">Dashboard</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-all') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/list/all')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List All</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-success') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/list/success')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Success</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-fail') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/list/fail')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Fail</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-trx') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/list/trx')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Transaction Online</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-reset-password') ? 'active' : ''}}">
	<a href="{{url('disburse/user-franchise/reset-password')}}" class="nav-link nav-toggle">
		<i class="fa fa-sliders"></i>
		<span class="title">Reset Password</span>
	</a>
</li>