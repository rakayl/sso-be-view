<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption ">
            <span class="caption-subject sbold uppercase font-blue">Voucher Redemption</span>
        </div>
        <div class="filter-loader" id="voucher-loader">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="voucher_id_outlet" name="voucher_id_outlet">
                        <option value="0">All Outlets</option>
                        @foreach($outlets as $outlet)
                        <option value="{{ $outlet['id_outlet'] }}" {{ ($outlet['id_outlet']==$filter['voucher_id_outlet'] ? 'selected' : '') }}>{{ $outlet['outlet_code'] ." - ". $outlet['outlet_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control select2" id="id_deals" name="id_deals">
                        <option value="0">All Deals</option>
                        @foreach($deals as $item)
                            <option value="{{ $item['id_deals'] }}" {{ ($item['id_deals']==$filter['id_deals'] ? 'selected' : '') }}>{{ $item['deals_title'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px;">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_voucher_1" id="tab-menu-voucher-1" data-toggle="tab">Voucher Redemption</a>
                        </li>
                        <li>
                            <a href="#tab_voucher_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_voucher_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_voucher_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_voucher_5" data-toggle="tab">Provider</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_voucher_1">
                            <div id="voucher_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_voucher_2">
                            <div id="voucher_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_voucher_3">
                            <div id="voucher_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_voucher_4">
                            <div id="voucher_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_voucher_5">
                            <div id="voucher_provider_chart" style="height:300px;"></div>
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
                            <td id="voucher_outlet_name">{{ isset($filter['voucher_outlet_name']) ? $filter['voucher_outlet_name'] : 'All Outlets' }}</td>
                        </tr>
                        <tr>
                            <td><b>Deals</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="deals_title">{{ isset($filter['deals_title']) ? $filter['deals_title'] : 'All Deals' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-line-chart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_voucher_1">{{ $report['vouchers']['voucher_total_male'] }}</span> </div>
                                <div class="desc"> 
                                Total
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
                                <span data-counter="counterup" data-value="0" id="card_voucher_2">{{ $report['vouchers']['voucher_total_male'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0" id="card_voucher_3">{{ $report['vouchers']['voucher_total_female'] }}</span> </div>
                                <div class="desc"> 
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-android"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_voucher_3">{{ $report['vouchers']['voucher_total_android'] }}</span> </div>
                                <div class="desc"> 
                                Total Android
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-apple"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_voucher_4">{{ $report['vouchers']['voucher_total_ios'] }}</span> </div>
                                <div class="desc"> 
                                Total iOS
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            {{-- Table --}}
            <div id="table-voucher" class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th data-data='number'> No </th>
                            <th data-data='date' class="col-date"> Date </th>
                            <th data-data='voucher_count'> Total </th>
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
                        @foreach($report['vouchers']['data'] as $key => $voucher)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td class="col-date">{{ $voucher['date'] }}</td>
                            <td>{{ $voucher['voucher_count'] }}</td>
                            <td>{{ $voucher['cust_male'] }}</td>
                            <td>{{ $voucher['cust_female'] }}</td>
                            <td>{{ $voucher['cust_android'] }}</td>
                            <td>{{ $voucher['cust_ios'] }}</td>
                            <td>{{ $voucher['cust_telkomsel'] }}</td>
                            <td>{{ $voucher['cust_xl'] }}</td>
                            <td>{{ $voucher['cust_indosat'] }}</td>
                            <td>{{ $voucher['cust_tri'] }}</td>
                            <td>{{ $voucher['cust_axis'] }}</td>
                            <td>{{ $voucher['cust_smart'] }}</td>
                            <td>{{ $voucher['cust_teens'] }}</td>
                            <td>{{ $voucher['cust_young_adult'] }}</td>
                            <td>{{ $voucher['cust_adult'] }}</td>
                            <td>{{ $voucher['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>