<head>
        <meta charset="utf-8" />
        <title>{{env('TITLE', 'CRM System')}} | {{$title}}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Technopartner Indonesia - BEHAVE Loyalty Platform" name="description" />
        <meta content="" name="author" />
		<!-- BEGIN PAGE FIRST SCRIPTS -->
        <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE FIRST SCRIPTS -->
        <!-- BEGIN PAGE TOP STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/pace/themes/pace-theme-flash.css?') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE TOP STYLES -->
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page-style')
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/layouts/layout/css/themes/light.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->

        <link rel="shortcut icon" href="{{env('STORAGE_URL_VIEW') }}{{ ('images/icon.png')}}" />
</head>