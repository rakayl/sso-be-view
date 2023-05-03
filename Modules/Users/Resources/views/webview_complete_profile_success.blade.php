<?php
    use App\Lib\MyHelper;
    $title = "User Profile";
?>
@extends('webview.main')

@section('page-style-plugin')
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
@stop

@section('content')
    <div class="col-md-offset-4 col-md-4">
        <div class="text-center" style="margin-top: 20px;">
            {!! $content !!}
        </div>
    </div>
@stop