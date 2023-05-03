<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject sbold uppercase font-blue">Product</span>
        </div>
        <div class="filter-loader" id="product-loader">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">

            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="product_id_outlet" name="product_id_outlet">
                        <option value="0">All Outlets</option>
                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet['id_outlet'] }}" {{ ($outlet['id_outlet']==$filter['product_id_outlet'] ? 'selected' : '') }}>{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control select2" id="id_product" name="id_product">
                        <option>Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product['id_product'] }}" {{ ($product['id_product']==$filter['id_product'] ? 'selected' : '') }} >{{ $product['product_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_product_1" id="tab-menu-product-1" data-toggle="tab">Product</a>
                        </li>
                        <li>
                            <a href="#tab_product_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_product_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_product_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_product_5" data-toggle="tab">Provider</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_product_1">
                            <div id="product_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_2">
                            <div id="product_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_3">
                            <div id="product_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_4">
                            <div id="product_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_product_5">
                            <div id="product_provider_chart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px">
                <table>
                    <tbody>
                        <tr>
                            <td><b>Date Range</b></td>
                            <td class="semicolon text-center">:</td>
                            <td class="date-range">{{ $date_range }}</td>
                        </tr>
                        <tr>
                            <td><b>Outlet</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="product_outlet_name">{{ isset($filter['product_outlet_name']) ? $filter['product_outlet_name'] : 'All Outlets' }}</td>
                        </tr>
                        <tr>
                            <td><b>Product</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="product_name">{{ $filter['product_name'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_product_1">{{ $report['products']['product_total_nominal'] }}</span> </div>
                                <div class="desc"> 
                                Total Nominal (IDR)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-line-chart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_product_2">{{ $report['products']['product_total_qty'] }}</span> </div>
                                <div class="desc"> 
                                Total Quantity
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-male"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_product_3">{{ $report['products']['product_total_male'] }}</span> </div>
                                <div class="desc"> 
                                Total Male Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-female"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_product_4">{{ $report['products']['product_total_female'] }}</span> </div>
                                <div class="desc"> 
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div id="table-product" class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th data-data='number'> No </th>
                            <th data-data='date' class="col-date"> Date </th>
                            <th data-data='product.product_name'> Product </th>
                            <th data-data='total_rec'> Total Recurring </th>
                            <th data-data='total_qty'> Total (Qty) </th>
                            <th data-data='total_nominal'> Total Nominal (IDR) </th>
                            <th data-data='cust_male'> Male Customer </th>
                            <th data-data='cust_female'> Female Customer </th>
                            <th data-data='cust_android'> Android </th>
                            <th data-data='cust_ios'> iOS </th>
                            <th data-data='cust_telkomsel'> Telkomsel </th>
                            <th data-data='cust_xl'> XL </th>
                            <th data-data='cust_indosat'> Indosat </th>
                            <th data-data='cust_tri'> Tri </th>
                            <th data-data='cust_axis'> Axis </th>
                            <th data-data='cust_smart'> Smart </th>
                            <th data-data='cust_teens'> Teens </th>
                            <th data-data='cust_young_adult'> Young Adult </th>
                            <th data-data='cust_adult'> Adult </th>
                            <th data-data='cust_old'> Old </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report['products']['data'] as $key => $product)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td class="col-date">{{ $product['date'] }}</td>
                            <td>{{ $product['product']['product_name'] }}</td>
                            <td>{{ $product['total_rec'] }}</td>
                            <td>{{ $product['total_qty'] }}</td>
                            <td>{{ $product['total_nominal'] }}</td>
                            <td>{{ $product['cust_male'] }}</td>
                            <td>{{ $product['cust_female'] }}</td>
                            <td>{{ $product['cust_android'] }}</td>
                            <td>{{ $product['cust_ios'] }}</td>
                            <td>{{ $product['cust_telkomsel'] }}</td>
                            <td>{{ $product['cust_xl'] }}</td>
                            <td>{{ $product['cust_indosat'] }}</td>
                            <td>{{ $product['cust_tri'] }}</td>
                            <td>{{ $product['cust_axis'] }}</td>
                            <td>{{ $product['cust_smart'] }}</td>
                            <td>{{ $product['cust_teens'] }}</td>
                            <td>{{ $product['cust_young_adult'] }}</td>
                            <td>{{ $product['cust_adult'] }}</td>
                            <td>{{ $product['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>