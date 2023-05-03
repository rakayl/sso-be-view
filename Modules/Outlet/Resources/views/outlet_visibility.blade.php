<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
    <div class="form-body" style="height:100vh">
        <div class="form-group">
            <div class="col-md-2" id="div-left"></div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <input type="text" id="search-product" class="form-control" name="search" placeholder="Search Product">
            </div>
            <button type="button" class="btn default col-md-2" id="btn-reset" style="display:none">Reset</button>
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
