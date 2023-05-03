<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>
<a class="btn btn-success" href="{{url('doctor/create?id_outlet='.$id_outlet)}}">Create Doctor <i class="fa fa-plus-circle"></i></a><br><br>
<table class="table table-striped table-bordered table-hover" id="table_product">
    <thead>
    <tr>
        <th> Name </th>
        <th> Phone </th>
        @if(MyHelper::hasAccess([330], $grantedFeature))
            <th> Action </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if (!empty($doctors))
        @foreach($doctors as $key => $value)
            <tr>
                <td>{{ $value['doctor_name'] }}</td>
                <td>{{ $value['doctor_phone'] }}</td>
                @if(MyHelper::hasAccess([330], $grantedFeature))
                    <td style="width: 80px;">
                        <a target="_blank" href="{{url('doctor').'/'.$value['id_doctor'].'/edit'}}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                    </td>
                @endif
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" style="text-align: center">Data Not Available</td>
        </tr>
    @endif
    </tbody>
</table>