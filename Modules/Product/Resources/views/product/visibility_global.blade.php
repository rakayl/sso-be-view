<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" id="formWithPrice" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" style="height:190vh">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-2" id="div-left"></div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <input type="text" id="search-outlet" class="form-control" name="search" placeholder="Search Outlet">
            </div>
            <button type="button" class="btn default col-md-2" id="btn-reset" style="display:none">Reset</button>
        </div>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3><center><b>Default Visibility ({{$product[0]["product_visibility"]}})</b></center></h3>
            <select multiple="" id="visibleglobal-default" class="form-control" style="height:70vh">
            </select>
        </div>
        <div class="col-md-12" style="margin: 20px 0">
        <div class="col-md-2"></div>
            <button type="button" id="default-to-visible" class="btn blue col-md-2"><i class="fa fa-arrow-down"></i> Make Visible</button>
            <div class="col-md-1"></div>
            <button type="button" id="move-default" class="btn blue col-md-2"><i class="fa fa-arrow-up"></i> Use Default</button>
            <div class="col-md-1"></div>
            <button type="button" id="default-to-hidden" class="btn blue col-md-2"><i class="fa fa-arrow-down"></i> Make Hidden</button>
        </div>
        <div class="col-md-5">
            <h3><center><b>Visible</b></center></h3>
            <select multiple="" id="visibleglobal-visible" class="form-control" style="height:70vh">
        </select>
        </div>
        <div class="col-md-2" style="height:70vh">
            <button type="button" id="move-hiden" class="btn blue" style="margin:35vh 20% 0; width:60%"><i class="fa fa-arrow-right"></i></button>
            <button type="button" id="move-visible" class="btn blue" style="margin:10px 20%; width:60%"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="col-md-5">
            <h3><center><b>Hidden</b></center></h3>
            <select multiple="" id="visibleglobal-hidden" class="form-control" style="height:70vh">
            </select>
        </div>
    </div>

</form>