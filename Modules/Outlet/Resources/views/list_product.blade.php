<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
?>

<table class="table table-striped table-bordered table-hover" id="table_product">
    <thead>
    <tr>
        <th> No </th>
        <th> Code </th>
        <th> Category </th>
        <th> Name </th>
        @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
            <th> Action </th>
        @endif
    </tr>
    </thead>
    <tbody>
    @if (!empty($products))
        @foreach($products as $key => $value)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value['product_code'] }}</td>
                @if (empty($value['category']))
                    <td>Uncategorize</td>
                @else
                    <td>{{ $value['category'][0]['product_category_name']??'Uncategories' }}</td>
                @endif
                <td>{{ $value['product_name'] }}</td>
                @if(MyHelper::hasAccess([49,51,52], $grantedFeature))
                    <td style="width: 80px;">
                        @if(MyHelper::hasAccess([49,51], $grantedFeature))
                            <a target="_blank" href="{{ url('product/detail') }}/{{ $value['product_code'] }}" class="btn btn-sm blue"><i class="fa fa-edit"></i></a>
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
    @endif
    </tbody>
</table>