<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');

 ?>
<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" style="height:190vh">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-2" id="div-left"></div>
            <div class="col-md-5"></div>
            <div class="col-md-5">
                <input type="text" id="search-outlet" class="form-control" name="search" placeholder="Search Outlet">
            </div>
            <button type="button" class="btn default col-md-2" id="btn-reset" style="display:none">Reset</button>
        </div>

        <div class="col-md-5">
            <h3><center><b>Not Special Outlet</b></center></h3>
            <select multiple="" id="not-special-outlet" class="form-control" style="height:70vh">
                @foreach($outlets as $outlet)
                    @if($outlet['outlet_special_status'] != 1)
                        <option class="option-special" data-id="{{$outlet["id_outlet"]}}">{{$outlet["outlet_code"]}} - {{$outlet["outlet_name"]}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2" style="height:70vh">
            <button type="button" id="move-special" class="btn blue" style="margin:35vh 20% 0; width:60%"><i class="fa fa-arrow-right"></i></button>
            <button type="button" id="move-not-special" class="btn blue" style="margin:10px 20%; width:60%"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="col-md-5">
            <h3><center><b>Special Outlet</b></center></h3>
            <select multiple="" id="special-outlet-select" class="form-control" style="height:70vh">
                @foreach($outlets as $outlet)
                    @if($outlet['outlet_special_status'] == 1)
                        <option class="option-special" data-id="{{$outlet["id_outlet"]}}">{{$outlet["outlet_code"]}} - {{$outlet["outlet_name"]}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

</form>