<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-sidebar-closed page-boxed">
	<div class="page-wrapper">
		<!-- BEGIN HEADER -->
        @include('layouts.header-closed')
		<!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
            <div class="container">
				<div class="page-container">
					<!-- BEGIN SIDEBAR -->
					<div class="page-sidebar-wrapper">
						<div class="page-sidebar navbar-collapse collapse">
							@include('layouts.sidebar-closed')
							@include('layouts.sidebar')
							</ul>
						</div>
					</div>
					<!-- END SIDEBAR -->
					<!-- BEGIN CONTENT -->
					<div class="page-content-wrapper">
						<!-- BEGIN CONTENT BODY -->
						<div class="page-content">
							@yield('content')
						</div>
						<!-- END CONTENT BODY -->
					</div>
					<!-- END CONTENT -->
					<!-- BEGIN QUICK SIDEBAR -->
					<a href="javascript:;" class="page-quick-sidebar-toggler">
						<i class="icon-login"></i>
					</a>
					<!-- END QUICK SIDEBAR -->
				</div>
			</div>
        <!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="container">
			<div class="page-footer">
				@include('layouts.footer')
			</div>
		</div>
		<!-- END FOOTER -->
	</div>
	@include('layouts.script')
</body>