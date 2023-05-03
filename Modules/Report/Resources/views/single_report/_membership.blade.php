<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject sbold uppercase font-blue">Customer Membership</span>
        </div>
        <div class="filter-loader" id="mem-loader">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body">
            <div class="bg-grey-steel clearfix" style="padding-top: 15px; padding-bottom: 15px;">
                <div class="col-md-6">
                    <select class="form-control select2" id="id_membership" name="id_membership">
                        @foreach($memberships as $membership)
                            <option value="{{ $membership['id_membership'] }}" {{ ($membership['id_membership']==$filter['id_membership'] ? 'selected' : '') }}>{{ $membership['membership_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        	{{-- Chart --}}
            <div style="margin-top: 30px;">
                <div class="tabbable tabbable-tabdrop">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_mem_1" id="tab-menu-mem-1" data-toggle="tab">Membership</a>
                        </li>
                        {{-- <li>
                            <a href="#tab_mem_2" data-toggle="tab">Gender</a>
                        </li>
                        <li>
                            <a href="#tab_mem_3" data-toggle="tab">Age</a>
                        </li>
                        <li>
                            <a href="#tab_mem_4" data-toggle="tab">Device</a>
                        </li>
                        <li>
                            <a href="#tab_mem_5" data-toggle="tab">Provider</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_mem_1">
                            <div id="mem_chart" style="height:300px;"></div>
                        </div>
                        {{-- <div class="tab-pane" id="tab_mem_2">
                            <div id="mem_gender_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_3">
                            <div id="mem_age_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_4">
                            <div id="mem_device_chart" style="height:300px;"></div>
                        </div>
                        <div class="tab-pane" id="tab_mem_5">
                            <div id="mem_provider_chart" style="height:300px;"></div>
                        </div> --}}
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
                            <td><b>Membership</b></td>
                            <td class="semicolon text-center">:</td>
                            <td id="membership_name">{{ $filter['membership_name'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Card --}}
            <div class="row cards" style="margin-top: 30px">
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-male"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_mem_1">{{ $report['memberships']['mem_total_male'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0" id="card_mem_2">{{ $report['memberships']['mem_total_female'] }}</span> </div>
                                <div class="desc"> 
                                Total Female Customer
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat grey-steel" style="padding-top: 5px; padding-bottom: 5px;">
                        <div class="visual">
                            <i class="fa fa-android"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="0" id="card_mem_3">{{ $report['memberships']['mem_total_android'] }}</span> </div>
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
                                <span data-counter="counterup" data-value="0" id="card_mem_4">{{ $report['memberships']['mem_total_ios'] }}</span> </div>
                                <div class="desc"> 
                                Total iOS
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div id="table-mem" class="table-wrapper" style="margin-top: 30px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th data-data='number'> No </th>
                            <th data-data='date' class="col-date"> Date </th>
                            <th data-data='cust_total'> Total </th>
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
                        @foreach($report['memberships']['data'] as $key => $mem)
                        <tr class="odd gradeX">
                            <td>{{ $key+1 }}</td>
                            <td class="col-date">{{ $mem['date'] }}</td>
                            <td>{{ $mem['cust_total'] }}</td>
                            <td>{{ $mem['cust_male'] }}</td>
                            <td>{{ $mem['cust_female'] }}</td>
                            <td>{{ $mem['cust_android'] }}</td>
                            <td>{{ $mem['cust_ios'] }}</td>
                            <td>{{ $mem['cust_telkomsel'] }}</td>
                            <td>{{ $mem['cust_xl'] }}</td>
                            <td>{{ $mem['cust_indosat'] }}</td>
                            <td>{{ $mem['cust_tri'] }}</td>
                            <td>{{ $mem['cust_axis'] }}</td>
                            <td>{{ $mem['cust_smart'] }}</td>
                            <td>{{ $mem['cust_teens'] }}</td>
                            <td>{{ $mem['cust_young_adult'] }}</td>
                            <td>{{ $mem['cust_adult'] }}</td>
                            <td>{{ $mem['cust_old'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>