<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
<div class="row">
    <div class="col-md-6">
		<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
	    	<div class="portlet light bordered">
			    <div class="form-body text-center">
			    	<div class="form-group">
			        	<span class="caption font-blue sbold uppercase"> Update PIN </span>
			        	<i class="fa fa-question-circle tooltips" data-original-title="Pin outlet berupa 6 digit angka. Pin yang baru akan dikirimkan ke email outlet jika email sudah terisi dan autoresponse sent pin diaktifkan" data-container="body"></i>
			        </div>
			    </div>
			    <div class="form-body">
			        <div class="form-group">
			            <div class="input-icon right">
			                <label class="col-md-3 control-label">
			                New PIN
			                <i class="fa fa-question-circle tooltips" data-original-title="Pin outlet berupa 6 digit angka" data-container="body"></i>
			                </label>
			            </div>
			            <div class="col-md-9">
			                <input type="password" class="form-control" name="outlet_pin" required placeholder="New Outlet PIN" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">
			            </div>
			        </div>

			        <div class="form-group">
			            <div class="input-icon right">
			                <label class="col-md-3 control-label">
			                Re-type New PIN
			                <span class="required" aria-required="true"> * </span>  
			                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan pin yang baru dibuat" data-container="body"></i>
			                </label>
			            </div>
			            <div class="col-md-9">
			                <input type="password" class="form-control" name="outlet_pin_confirmation" required placeholder="Re-type New PIN" maxLength="6" minLength="6" onkeypress="return isNumberKey(event)">
			            </div>
			        </div>
			    </div>
			    <div class="form-actions text-center">
			        {{ csrf_field() }}
			        <div class="row">
			            <div class="">
			                @if(MyHelper::hasAccess([27], $grantedFeature))
			                    <button type="submit" class="btn green">Update</button>
			                @endif
			                <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
			            </div>
			        </div>
			    </div>
	    	</div>
		</form>
	</div>
	<div class="col-md-6">
		<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			<div class="portlet light bordered">
			    <div class="form-body text-center">
			    	<div class="form-group">
			        	<span class="caption font-blue sbold uppercase"> Generate PIN </span>
			        	<i class="fa fa-question-circle tooltips" data-original-title="Pin outlet berupa 6 digit angka akan dibuatkan otomatis oleh sistem. Pin yang baru akan dikirimkan ke email outlet jika email sudah terisi dan autoresponse sent pin diaktifkan" data-container="body"></i>
			        </div>
			    </div>
			    <div class="form-actions text-center">
			        {{ csrf_field() }}
			        <div class="row">
			            <div class="">
			                @if(MyHelper::hasAccess([27], $grantedFeature))
			                    <button type="submit" class="btn green">Generate</button>
			                @endif
			                <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
			                <input type="hidden" name="generate_pin_outlet" value="1">
			            </div>
			        </div>
			    </div>
			</div>
		</form>
	</div>
</div>