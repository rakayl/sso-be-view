<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner container">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.html" style="height:85%">
				<img src="{{ env('STORAGE_URL_VIEW') }}{{ ('images/logo_mono.png') }}" alt="logo" class="logo-default"  style="margin: 0; height:100%"/> </a>
			<div class="menu-toggler sidebar-toggler">
				<span></span>
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
			<span></span>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">

				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
				<!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
				<!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username" style="font-weight: 600;"> {{Session::get('name')}} </span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="{{url('profile')}}">
								<i class="icon-user"></i> My Profile </a>
						</li>
						<li>
							<a href="{{url('logout')}}">
								<i class="icon-key"></i> Log Out </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	@if(config('app.env') != 'production')
	<div style="position: fixed; top: 28px; background-color: {{config('app.env') == 'local' ? 'red' : 'gold'}}; right: -48px; width: 200px; height: 50px; transform: rotate(45deg); text-align: center; padding: 10px; color: white; font-size: 20px; font-weight: bold; opacity: .9">{{strtoupper(config('app.env'))}}</div>
	@endif
	<!-- END HEADER INNER -->
</div>