@section('code-info')
{{-- this data is for show only, this data will not be saved --}}
<div class="col-md-5 disable-form">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">Generate Code</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="alert alert-warning">
		        Cannot update code because promo already used.
		    </div>
			<div class="form-group" style="height: 90px;">
				<label class="control-label">Code Type</label>
				<span class="required" aria-required="true"> * </span>
				<i class="fa fa-question-circle tooltips" data-original-title="Tipe kode promo yang dibuat" data-container="body"></i>
				<div class="mt-radio-list">
					<label class="mt-radio mt-radio-outline"> Single
						<input disabled type="radio" value="Single"  @if(isset($result['code_type']) && $result['code_type'] == "Single") checked @elseif(old('code_type') == "Single") checked @endif required/>
						<span></span>
					</label>
					<label class="mt-radio mt-radio-outline"> Multiple
						<input disabled type="radio" value="Multiple"  @if(isset($result['code_type']) && $result['code_type'] == "Multiple") checked  @elseif(old('code_type') == "Multiple") checked @endif required/>
						<span></span>
					</label>
				</div>
			</div>

			@if ($result['code_type'] == 'Single')
				<div>
					<div class="form-group">
						<label class="control-label">Promo Code</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Kode promo yang dibuat" data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled maxlength="30" type="text" class="form-control" value="{{ $result['promo_campaign_promo_codes'][0]['promo_code']??null }}" autocomplete="off">
							<p id="alertSinglePromoCode" style="display: none;" class="help-block">Kode sudah pernah dibuat!</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Limit Usage (Penggunaan Per User)</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Limit penggunaan kode promo untuk tiap user. Tulis 0 jika tidak ada limit." data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled required type="text" class="form-control digit_mask" placeholder="Limit Usage" value="{{ old('limitation_usage') ?? $result['limitation_usage'] ?? null }}" autocomplete="off">
						</div>
					</div>
				</div>
			@else
				<div>
					<div class="form-group" id="alertMultipleCode">
						<label class="control-label">Prefix Code</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Kode prefix untuk judul kode. Maksimal 9 karakter. Prefix Code + Digit Random tidak boleh lebih dari 30 karakter" data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled maxlength="9" type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789]/g,'');" placeholder="Prefix Code" value="{{ $result['prefix_code']??null }}" autocomplete="off">
							<p id="alertMultiplePromoCode" style="display: none;" class="help-block">Kode prefix sudah pernah dibuat, lebih disarankan untuk membuat kode baru!</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Digit Random</label>
						<span class="required" aria-required="true"> * </span>
						<i class="fa fa-question-circle tooltips" data-original-title="Jumlah digit yang digenerate secara otomatis untuk akhiran kode. Prefix Code + Digit Random tidak boleh lebih dari 30 karakter" data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled type="number" class="form-control" placeholder="Total Digit Random Last Code" value="{{ $result['number_last_code']??null }}" autocomplete="off" oninput="validity.valid||(value='');" min="6" max="30">
						</div>
						{{-- <span class="help-block" id="subscription-false"> Min : <span id="digit-random-min" class="font-weight-bold" style="padding-right: 12px">6</span> Max : <span id="digit-random-max" class="font-weight-bold">30</span></span> --}}
					</div>
					{{-- 
					<div class="form-group">
						<label class="control-label">Example Code 
						<i class="fa fa-question-circle tooltips" data-original-title="Contoh Kode yang digenerate secara otomatis" data-container="body"></i></label>
						<div class="input-group col-md-12">
							<span id="exampleCode"></span>
						</div>
						<div class="input-group col-md-12">
							<span id="exampleCode1"></span>
						</div>
						<div class="input-group col-md-12">
							<span id="exampleCode2"></span>
						</div>
					</div>
					 --}}
					<div class="form-group">
						<label class="control-label">User Limit (Penggunaan Per User)</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Limit berapa kali satu user dapat menggunakan kode promo yang berbeda. Tulis 0 jika tidak ada limit." data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled type="text" class="form-control digit_mask" placeholder="User Limit" value="{{ old('user_limit') ?? $result['user_limit'] ?? null }}" autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Code Limit (Penggunaan Per Code)</label>
						<i class="fa fa-question-circle tooltips" data-original-title="Limit berapa kali satu kode promo dapat digunakan. Tulis 0 jika tidak ada limit." data-container="body"></i>
						<div class="input-group col-md-12">
							<input disabled type="text" class="form-control digit_mask" placeholder="Code Limit" value="{{ old('code_limit') ?? $result['code_limit'] ?? null }}" autocomplete="off">
						</div>
					</div>
				</div>
			@endif

			<div class="form-group">
				<label class="control-label">Total Coupon (Jumlah Total Voucher)</label>
				<span class="required" aria-required="true"> * </span>
				<i class="fa fa-question-circle tooltips" data-original-title="Total kode kupon yang dibuat" data-container="body"></i>
				<div class="input-group col-md-12">
					<input disabled required type="text" class="form-control digit_mask" placeholder="Total Coupon" value="{{ $result['total_coupon']??null }}" autocomplete="off">
					<p id="alertTotalCoupon" style="display: none;" class="help-block">Generate Random Total Coupon sangat tidak memungkinkan!</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection