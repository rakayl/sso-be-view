<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    $grantedFeature     = session('granted_features');
    date_default_timezone_set('Asia/Jakarta');
 ?>
                     <div class="row">
                        <div class="col-md-5">
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title" style="display: flex;"> 
                                    <img src="{{$data['quest']['image']}}" style="width: 40px;height: 40px;" class="img-responsive" alt="">
                                    <span class="caption font-blue sbold uppercase">
                                        &nbsp;&nbsp;{{$data['quest']['name']}}
                                    </span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span class="sale-info"> Status 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <?php
                                                    if ($data['quest']['stop_at']) {
                                                        echo '<span class="sale-num sbold badge badge-pill badge bg-red" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Stop</span>';
                                                    } else if (!$data['quest']['is_complete']) {
                                                        echo '<span class="sale-num sbold badge badge-pill badge badge-secondary" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Pending</span>';
                                                    } else if ($data['quest']['date_start'] > date('Y-m-d H:i:s')) {
                                                        echo '<span class="sale-num sbold badge badge-pill badge bg-yellow" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Not Started</span>';
                                                    } else if ($data['quest']['publish_end'] >= date('Y-m-d H:i:s')) {
                                                        echo '<span class="sale-num sbold badge badge-pill badge bg-green-jungle" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">On Going</span>';
                                                    } else if ($data['quest']['publish_end'] < date('Y-m-d H:i:s')) {
                                                        echo '<span class="sale-num sbold badge badge-pill badge bg-red" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">End</span>';
                                                    }
                                                ?>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Autoclaim 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                @if ($data['quest']['autoclaim_quest'])
                                                    <span class="sale-num sbold badge" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On</span>
                                                @else
                                                    <span class="sale-num sbold badge secondary" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Off</span>
                                                @endif
                                            </li>
                                            <li>
                                                <span class="sale-info"> User Rule Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    @if(is_null($data['quest']['user_rule_subject']))
                                                        All User
                                                    @else
                                                        With Rule
                                                    @endif
                                                </span>
                                            </li>
                                            @if(!is_null($data['quest']['user_rule_subject']))
                                                <li>
                                                <span class="sale-info"> User Rule
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                    <span class="sale-num font-black">
                                                    <?php
                                                        $userRuleSubject = [
                                                            'r_quartile' => ' R',
                                                            'f_quartile' => 'F',
                                                            'm_quartile' => 'M',
                                                            'RFMScore' => 'RFM'
                                                        ];
                                                    ?>
                                                    {{$userRuleSubject[$data['quest']['user_rule_subject']]??''}} {{$data['quest']['user_rule_operator']}} {{$data['quest']['user_rule_parameter']}}
                                                    </span>
                                                </li>
                                            @endif
                                            <li>
                                                <span class="sale-info"> Published at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['publish_start']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Publish end at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['publish_end'] ? date('d F Y H:i', strtotime($data['quest']['publish_end'])) : '-'}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Start at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['date_start']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Max Complete
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    @if($data['quest']['date_end'])
                                                    {{date('d F Y H:i', strtotime($data['quest']['date_end']))}}
                                                    @else
                                                    {{number_format($data['quest']['max_complete_day'], 0, ',', '.')}} day
                                                    @endif
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Quest Limit
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['quest_limit'] ? number_format($data['quest']['quest_limit'], 0, ',', '.') : 'Unlimited'}} claim
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Created at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['created_at']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Short Description
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="{{$data['quest']['short_description'] ? '' : 'text-muted'}}">{{$data['quest']['short_description_formatted'] ?: 'No short description'}}</span>
                                            </li>
                                            @if ($data['quest']['stop_at'])
                                            <li>
                                                <span class="sale-info"> Stop at
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{date('d F Y H:i', strtotime($data['quest']['stop_at']))}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Stop Reason
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="{{$data['quest']['short_description'] ? '' : 'text-muted'}}">{{$data['quest']['stop_reason']}}</span>
                                            </li>
                                            @endif
                                        </ul>
                                        @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                        <div class="text-center">
                                            <a data-toggle="modal" href="#modalEditQuest" class="btn btn-primary blue"><i class="fa fa-pencil"></i> Edit Quest</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="portlet profile-info portlet light bordered">
                                <div class="portlet-title" style="display: flex;"> 
                                    <span class="caption font-blue sbold uppercase">
                                        Quest Benefit
                                    </span>
                                </div>
                                <div class="portlet sale-summary">
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            @if($data['quest']['quest_benefit']['benefit_type'] == 'voucher')
                                            <li>
                                                <span class="sale-info"> Benefit Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    Voucher
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Voucher Qty
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{number_format($data['quest']['quest_benefit']['value'], 0, '.', ',')}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Deals
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{$data['quest']['quest_benefit']['deals']['deals_title']}} ({{$data['quest']['quest_benefit']['deals']['deals_voucher_expired'] ? date('d F Y H:i', strtotime($data['quest']['quest_benefit']['deals']['deals_voucher_expired'])) : ($data['quest']['quest_benefit']['deals']['deals_voucher_duration'] ?? null) . ' days'}})
                                                </span>
                                            </li>
                                            @else
                                            <li>
                                                <span class="sale-info"> Benefit Type
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{env('POINT_NAME', 'Point')}}
                                                </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> Point Nominal
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                <span class="sale-num font-black">
                                                    {{\App\Lib\MyHelper::thousandNumberFormat($data['quest']['quest_benefit']['value'], '_CURRENCY')}}
                                                </span>
                                            </li>
                                            @endif
                                            <li>
                                                <span class="sale-info"> Autoclaim 
                                                    <i class="fa fa-img-up"></i>
                                                </span>
                                                @if ($data['quest']['quest_benefit']['autoclaim_benefit'])
                                                    <span class="sale-num sbold badge" style="font-size: 20px!important;height: 30px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">On</span>
                                                @else
                                                    <span class="sale-num sbold badge secondary" style="font-size: 20px!important;height: 30px!important;padding: 5px 12px;color: #fff;">Off</span>
                                                @endif
                                            </li>
                                        </ul>
                                        @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                        <div class="text-center">
                                            <a data-toggle="modal" href="#modalEditBenefit" class="btn btn-primary blue"><i class="fa fa-pencil"></i> Edit Benefit</a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 profile-info">
                            <div class="profile-info portlet light bordered">
                                <div class="portlet-title"> 
                                    <span class="caption font-blue sbold uppercase">{{$data['quest']['name']}} Rule </span>
                                    @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                    <a class="btn blue" style="float: right;" data-toggle="modal" href="#addBadge">Add Rule</a>
                                    @endif
                                </div>
                                <div class="portlet-body row">
                                    @foreach ($data['quest']['quest_detail'] as $item)
                                    <div class="col-md-12 profile-info">
                                        <div class="profile-info portlet light bordered">
                                            <div class="portlet-title"> 
                                                <div class="col-md-6" style="display: flex;padding-left: 0px;">
                                                    <span class="caption font-blue sbold uppercase" style="padding: 8px 0px;font-size: 16px;">
                                                        {{$item['name']}}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    @if(MyHelper::hasAccess([230], $grantedFeature) && $data['quest']['is_complete'] != 1)
                                                    <div class="btn-group btn-group-solid pull-right">
                                                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <div id="loadingBtn" hidden>
                                                                <i class="fa fa-spinner fa-spin"></i> Loading
                                                            </div>
                                                            <div id="moreBtn">
                                                                <i class="fa fa-ellipsis-horizontal"></i> More
                                                                <i class="fa fa-angle-down"></i>
                                                            </div>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li style="margin: 0px;">
                                                                <a href="#editBadge" data-toggle="modal" onclick="editBadge({{json_encode($item)}})"> Edit </a>
                                                            </li>
                                                            <li style="margin: 0px;">
                                                                <a href="javascript:;" onclick="removeBadge(this, {{$item['id_quest_detail']}})"> Remove </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row" style="padding: 5px;position: relative;">
                                                    <div class="col-md-12">
                                                        <p>{{$item['short_description']}}</p>
                                                        <hr>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 value">Quest Rule</div>
                                                        </div>
                                                        <div class="row static-info">
                                                            @php
                                                            if (!$item['quest_rule']) {
                                                                if ($item['different_outlet']) {
                                                                    $item['quest_rule'] = 'total_outlet';
                                                                } elseif ($item['different_province']) {
                                                                    $item['quest_rule'] = 'total_province';
                                                                } elseif ($item['trx_total']) {
                                                                    $item['quest_rule'] = 'total_transaction';
                                                                } elseif ($item['id_product'] && $item['product_total']) {
                                                                    $item['quest_rule'] = 'total_product';
                                                                } else {
                                                                    $item['quest_rule'] = 'nominal_transaction';
                                                                }
                                                            }
                                                            @endphp
                                                            @switch($item['quest_rule'])
                                                            @case('nominal_transaction')
                                                                <div class="col-md-5 name">Transaction Nominal</div>
                                                                <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                                                @break
                                                            @case('total_transaction')
                                                                <div class="col-md-5 name">Transaction Total</div>
                                                                <div class="col-md-7 value">: {{$item['trx_total']}}</div>
                                                                @break
                                                            @case('total_product')
                                                                <div class="col-md-5 name">Product Total</div>
                                                                <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                                                @break
                                                            @case('total_outlet')
                                                                <div class="col-md-5 name">Outlet Different</div>
                                                                <div class="col-md-7 value">: {{$item['different_outlet']}}</div>
                                                                @break
                                                            @case('total_province')
                                                                <div class="col-md-5 name">Province Different</div>
                                                                <div class="col-md-7 value">: {{$item['different_province']}}</div>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                        <hr/>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 value">Additional Rule</div>
                                                        </div>
                                                        @if (!is_null($item['id_product_category']) || !is_null($item['different_category_product']))
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_product_category']))
                                                                    <div class="col-md-5 name">Product Category</div>
                                                                    <div class="col-md-7 value">: {{$item['product_category']['product_category_name']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_product']) || !is_null($item['product_total']))
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_product']))
                                                                    <div class="col-md-5 name">Product</div>
                                                                    <div class="col-md-7 value">: {{$item['product']['product_name']}}</div>
                                                                @endif
                                                                @if (!is_null($item['product_total']) && $item['quest_rule'] != 'total_product')
                                                                    <div class="col-md-5 name">Product Total</div>
                                                                    <div class="col-md-7 value">: {{$item['product_total']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_outlet']) || !is_null($item['different_outlet']))
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_outlet']))
                                                                    <div class="col-md-5 name">Outlet</div>
                                                                    <div class="col-md-7 value">: {{$item['outlet']['outlet_name']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_outlet_group']))
                                                            <div class="row static-info">
                                                                <div class="col-md-5 name">Outlet Group Filter</div>
                                                                <div class="col-md-7 value">: <a target="_blank" href="{{url('outlet-group-filter/detail/'.$item['outlet_group']['id_outlet_group'])}}">{{$item['outlet_group']['outlet_group_name']}}</a></div>
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['id_province']) || !is_null($item['different_province']))
                                                            <div class="row static-info">
                                                                @if (!is_null($item['id_province']))
                                                                    <div class="col-md-5 name">Province</div>
                                                                    <div class="col-md-7 value">: {{$item['province']['province_name']}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if (!is_null($item['trx_nominal']) || !is_null($item['trx_total']))
                                                            <div class="row static-info">
                                                                @if (!is_null($item['trx_nominal']) && $item['quest_rule'] != 'nominal_transaction')
                                                                    <div class="col-md-5 name">Transaction Nominal</div>
                                                                    <div class="col-md-7 value">: Minimum {{number_format($item['trx_nominal'])}}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>