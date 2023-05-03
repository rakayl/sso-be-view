<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
    <div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="form">
            <div class="form-body">
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Name  
                        <span class="required" aria-required="true"> * </span> 
                        <i class="fa fa-question-circle tooltips" data-original-title="Nama reward" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-icon right">
                            <input type="text" class="form-control" name="reward_name" value="{{ $reward[0]['reward_name'] }}" placeholder="Name" required maxlength="50">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Description
                        <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi tentang reward yang dibuat" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-icon right">
                            <textarea name="reward_description" class="form-control">{{ $reward[0]['reward_description'] }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Point Price Coupon 
                        <span class="required" aria-required="true"> * </span> 
                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah point yang dibutuhkan untuk mendapatkan 1 kupon" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control price" name="reward_coupon_point" value="{{ $reward[0]['reward_coupon_point'] }}" placeholder="point" required>
                            <span class="input-group-addon">
                                point for 1 coupon
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Reward Periode <span class="required" aria-required="true"> * </span> </label>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" name="reward_start" value="{{ date('d-M-Y', strtotime($reward[0]['reward_start'])) }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn default" type="button">
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode reward" data-container="body"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" name="reward_end" value="{{ date('d-M-Y', strtotime($reward[0]['reward_end'])) }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn default" type="button">
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal selesai periode reward" data-container="body"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Publish Periode <span class="required" aria-required="true"> * </span> </label>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" name="reward_publish_start" value="{{ date('d-M-Y', strtotime($reward[0]['reward_publish_start'])) }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn default" type="button">
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode reward" data-container="body"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <div class="input-group">
                                <input type="text" class="datepicker form-control" name="reward_publish_end" value="{{ date('d-M-Y', strtotime($reward[0]['reward_publish_end'])) }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button class="btn default" type="button">
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal selesai periode reward" data-container="body"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Image
                        <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Gambar reward" data-container="body"></i>
                        <br>
                        <span class="required" aria-required="true"> (300*300) </span>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-icon right">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <img src="{{ $reward[0]['url_reward_image'] }}" alt="Image Reward">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imagereward" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" accept="image/*" name="reward_image" class="file" id="fieldphoto">
                                    </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Number of Winners
                        <span class="required" aria-required="true"> * </span>  
                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah user yang akan mendapatkan reward" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-2">
                        <div class="input-icon right">
                            <input type="number" name="count_winner" class="form-control" id="countWin" value="{{$reward[0]['count_winner']}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <label class="col-md-3 control-label">
                        Get Winner by  
                        <span class="required" aria-required="true"> * </span> 
                        <i class="fa fa-question-circle tooltips" data-original-title="Nama reward" data-container="body"></i>
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio2" name="winner_type" class="md-radiobtn" value="Highest Coupon" @if($reward[0]['winner_type'] == 'Highest Coupon') checked @endif>
                                <label for="radio2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Highest Coupon </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="radio3" name="winner_type" class="md-radiobtn" value="Choosen" @if($reward[0]['winner_type'] == 'Choosen') checked @endif>
                                <label for="radio3">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Choose User </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" id="radio1" name="winner_type" class="md-radiobtn" value="Random" @if($reward[0]['winner_type'] == 'Random') checked @endif>
                                <label for="radio1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Random </label>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="form-actions">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input hidden name="id_reward" value="{{ $reward[0]['id_reward'] }}">

                        @if(MyHelper::hasAccess([133], $grantedFeature)) 
                            <button type="submit" class="btn green">Update</button>
                        @endif
                        <!-- <button type="button" class="btn default">Cancel</button> -->
                    </div>
                </div>
            </div>
        </form>
    </div>