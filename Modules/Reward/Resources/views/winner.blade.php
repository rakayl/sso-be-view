<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@if(date('Y-m-d', strtotime($reward[0]['reward_end'])) > date('Y-m-d'))
  <p class="text-primary" style="text-align:center">The winner will be selected when the reward period has expired</p>
@endif

@if($reward[0]['winner_type'] == 'Choosen')
    <div class="portlet-body form">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-yellow sbold uppercase">Setting Winner</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="{{ url('reward/winner') }}" method="post" enctype="multipart/form-data" id="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Choose User</label>
                            <div class="col-md-9">
                                <select id="select2User" name="id_user[]" class="form-control  select2-multiple" multiple 
                                    @if(date('Y-m-d', strtotime($reward[0]['reward_end'])) > date('Y-m-d')) disabled @endif
                                    @if($reward[0]['count_winner'] <= $reward[0]['reward_total_winner']) disabled @endif
                                >
                                    @foreach($reward[0]['reward_user'] as $value)
                                        @if($value['is_winner'] == '0')
                                            <option value="{{$value['user']['id']}}">{{ $value['user']['name'] }} - {{ $value['total_coupon'] }} coupon</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input hidden name="id_reward" value="{{ $reward[0]['id_reward'] }}">
                                
                                @if(MyHelper::hasAccess([133], $grantedFeature)) 
                                    <button type="submit" class="btn blue" 
                                        @if(date('Y-m-d', strtotime($reward[0]['reward_end'])) > date('Y-m-d')) disabled @endif
                                        @if($reward[0]['count_winner'] <= $reward[0]['reward_total_winner']) disabled @endif
                                    >Set Winner</button>
                                @endif
                                <!-- <button type="button" class="btn default">Cancel</button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<div class="portlet-body form">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-yellow sbold uppercase">Winner</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Phone </th>
                        <th> Total Coupon </th>
                    </tr>
                </thead>
                <tbody>
                @if(date('Y-m-d', strtotime($reward[0]['reward_end'])) <= date('Y-m-d'))
                    @if (!empty($reward[0]['reward_user']))
                        @foreach($reward[0]['reward_user'] as $value)
                            @if($value['is_winner'] == '1')
                                <tr>
                                    <td> {{ $value['user']['name'] }} </td>
                                    <td> {{ $value['user']['phone'] }}  </td>
                                    <td> {{ number_format($value['total_coupon']) }}  </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
