<?php
    $title = "News Custom Form Submit";
?>
@extends('webview.main')

@section('content')
    <!-- BEGIN CONTAINER -->
    <div class="page-container open-sans">
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="col-md-offset-3 col-md-6">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-body form">
                        <div class="text-center" style="min-height: 75vh; margin-top: 30px; font-size: 16px;">
                        @foreach($messages as $message)
                            <div style="margin-bottom: 10px;">{{ $message }}</div>
                        @endforeach
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
@stop