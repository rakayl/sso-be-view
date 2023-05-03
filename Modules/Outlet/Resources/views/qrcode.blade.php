<html>
<head>
        <meta charset="utf-8">
        <title>Behave | Print QRCode Outlet</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="Technopartner Indonesia - BEHAVE Loyalty Platform" name="description">
        <meta content="" name="author">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
        <link href="{{ url('/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/invoice-2.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css">
        <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css">

        <style>
        .page-break {
            page-break-after: always;
        }
        </style>
        <script type="text/javascript">
                setTimeout(function () { window.print(); }, 200);
                window.onfocus = function () { setTimeout(function () { window.close(); }, 200); }
        </script>
</head>
<body>
    @foreach ($outlet as $item)
        <div class="page-break">
            <div class="invoice-content-2 bordered">
                <div class="row invoice-head">
                    <div class="col-xs-12">
                        <center>
                            <h3><b>{{$item['outlet_name']}}</b></h3>
                            <!-- <h3><b>{{$item['outlet_code']}}</b></h3> -->
                            <br>
                            <img src="{{$item['qrcode']}}" class="img-responsive" style="width:300px">
                        </center>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>