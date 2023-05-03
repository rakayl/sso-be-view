<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>

	<script>
	$(document).ready(function() {
		$('.summernote').summernote({
			placeholder: 'Content',
			tabsize: 2,
			toolbar: [
				['style', ['style']],
				['style', ['bold', 'italic', 'underline', 'clear']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['table']],
				['insert', ['link', 'picture', 'video']],
				['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
			],
			height: 120
		});

		var clicktoInbox = "@if(isset($inbox['inbox_global_clickto'])){{$inbox['inbox_global_clickto']}}@endif";
		var toInbox = "@if(isset($inbox['inbox_global_id_reference'])){{$inbox['inbox_global_id_reference']}}@endif";

		if(clicktoInbox != null && toInbox != null) fetchDetail(clicktoInbox, 'inbox', toInbox);
	});

	$('#checkBtn').click(function() {
		checked = $("input[type=checkbox]:checked").length;

		if(!checked) {
			alert("You must check at least one Campaign Media.");
			return false;
		}

    });

	function addInboxSubject(param){
		var textvalue = $('#inbox_global_subject').val();
		var textvaluebaru = textvalue+" "+param;
		$('#inbox_global_subject').val(textvaluebaru);
    }

	function addInboxContent(param){
		var textvalue = $('#inbox_global_content').val();

		var textvaluebaru = textvalue+" "+param;
		$('#inbox_global_content').val(textvaluebaru);
		$('#inbox_global_content').summernote('editor.saveRange');
		$('#inbox_global_content').summernote('editor.restoreRange');
		$('#inbox_global_content').summernote('editor.focus');
		$('#inbox_global_content').summernote('editor.insertText', param);
    }

	function fetchDetail(det, type, idref=null){
		let token  = "{{ csrf_token() }}";
		if(det == 'Product'){
			$.ajax({
				type : "GET",
				url : "{{ url('product/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_product']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['product_name'], result[x]['id_product']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Outlet'){
			$.ajax({
				type : "GET",
				url : "{{ url('outlet/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_outlet']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['outlet_name'], result[x]['id_outlet']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'News'){
			$.ajax({
				type : "GET",
				url : "{{ url('news/ajax') }}",
				data : "_token="+token,
				success : function(result) {
					document.getElementById('atd_'+type).style.display = 'block';
					var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
					for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
					operator_value.options[operator_value.options.length] = new Option("", "");
					for(x=0;x < result.length; x++){
						if(idref == result[x]['id_news']){
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news'], false, true);
						}else{
							operator_value.options[operator_value.options.length] = new Option(result[x]['news_title'], result[x]['id_news']);
						}
					}
				}
			});
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
			document.getElementById('inbox_global_id_reference').required = true;
		}else{
			document.getElementById('inbox_global_id_reference').required = false;
		}

		if(det == 'Home'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Inbox'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Voucher'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Contact Us'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Link'){
			console.log(idref)
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'block';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
			document.getElementById('inbox_global_link').required = true;
		}else{
			document.getElementById('inbox_global_link').required = false;
		}

		if(det == 'Logout'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'none';
		}

		if(det == 'Content'){
			document.getElementById('atd_'+type).style.display = 'none';
			var operator_value = document.getElementsByName('inbox_global_id_reference')[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			document.getElementById('link_'+type).style.display = 'none';
			if(type=="inbox") document.getElementById('div_inbox_content').style.display = 'block';
		}

	}
	</script>

@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<span>{{ $title }}</span>
			@if (!empty($sub_title))
				<i class="fa fa-circle"></i>
			@endif
		</li>
		@if (!empty($sub_title))
		<li>
			<span>{{ $sub_title }}</span>
		</li>
		@endif
	</ul>
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<form role="form" action="" method="POST" class="form-horizontal">
		<div class="col-md-12">
			{{ csrf_field() }}
			@if(isset($inbox['inbox_global_rule_parents']))
				<?php
					$search_param = $inbox['inbox_global_rule_parents'];
					$search_param = array_filter($search_param);
					$conditions = $search_param;
				?>
			@else
				@if(Session::has('form'))
				<?php
					$search_param = Session::get('form');
					$search_param = array_filter($search_param);
					if(isset($search_param['conditions'])){
						$conditions = $search_param['conditions'];
					} else {
						$conditions = "";
					}
				?>
				@else
				<?php
				//@if(isset($inbox['rules']))
				// @else
					$conditions = "";
				?>
				@endif
			@endif
			<?php $tombolsubmit = 'hidden'; ?>
			@include('filter')
		</div>
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption font-blue ">
						<i class="icon-settings font-blue "></i>
						<span class="caption-subject bold uppercase">Inbox Global Content</span>
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-body">
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-2 control-label">
									Subject
									<i class="fa fa-question-circle tooltips" data-original-title="Subjek / judul pesan inbox, tambahkan text replacer bila perlu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<input type="text" placeholder="Inbox Subject" maxlength="125" class="form-control" name="inbox_global_subject" id="inbox_global_subject" @if(isset($inbox['inbox_global_subject'])) value="{{$inbox['inbox_global_subject']}}" @endif required>
								<br>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxSubject('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="form-group" id="div_inbox_clickto">
							<div class="input-icon right">
								<label for="inbox_global_clickto" class="control-label col-md-2">
									Click Action
									<i class="fa fa-question-circle tooltips" data-original-title="action / menu yang terbuka saat user membuka push notification" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<select name="inbox_global_clickto" id="inbox_global_clickto" class="form-control select2" onChange="fetchDetail(this.value, 'inbox')" required>
									<option value="" selected></option>
									<option value="Home" @if(old('inbox_global_clickto') == 'Home') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Home") selected @endif @endif>Home</option>
									{{-- <option value="Content" @if(old('inbox_global_clickto') == 'Content') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "News") selected @endif @endif>Content</option> --}}
									<option value="News" @if(old('inbox_global_clickto') == 'News') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "News") selected @endif @endif>News</option>
									<!-- <option value="Product" @if(old('inbox_global_clickto') == 'Product') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Product") selected @endif @endif>Product</option> -->
									<option value="Outlet" @if(old('inbox_global_clickto') == 'Outlet') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Outlet") selected @endif @endif>Outlet</option>
									<!-- <option value="Inbox" @if(old('inbox_global_clickto') == 'Inbox') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Inbox") selected @endif @endif>Inbox</option> -->
									<option value="Voucher" @if(old('inbox_global_clickto') == 'Voucher') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Voucher") selected @endif @endif>Voucher</option>
									<option value="Contact Us" @if(old('inbox_global_clickto') == 'Contact Us') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Contact Us") selected @endif @endif>Contact Us</option>
									<option value="Link" @if(old('inbox_global_clickto') == 'Link') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Link") selected @endif @endif>Link</option>
									<option value="Logout" @if(old('inbox_global_clickto') == 'Logout') selected @else @if(isset($inbox['inbox_global_clickto']) && $inbox['inbox_global_clickto'] == "Logout") selected @endif @endif>Logout</option>
								</select>
							</div>
						</div>
						<div class="form-group" id="atd_inbox" style="display:none;">
							<div class="input-icon right">
								<label for="inbox_global_clickto" class="control-label col-md-2" style="padding-right:0">
									Action to Detail
									<i class="fa fa-question-circle tooltips" data-original-title="detail action / menu yang akan terbuka saat user membuka inbox" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<select name="inbox_global_id_reference" id="inbox_global_id_reference" class="form-control select2">
								</select>
							</div>
						</div>
						<div class="form-group" id="link_inbox" style="display:none;">
							<div class="input-icon right">
								<label for="inbox_global_clickto" class="control-label col-md-2">
									Link
									<i class="fa fa-question-circle tooltips" data-original-title="jika action berupa link, masukkan alamat link nya disini" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<input type="text" placeholder="https://" class="form-control" id="inbox_global_link" name="inbox_global_link" value="@if(isset($inbox['inbox_global_link'])){{$inbox['inbox_global_link']}}@endif">
							</div>
						</div>
						<div class="form-group" id="div_inbox_content" style="display:none">
							<div class="input-icon right">
								<label for="multiple" class="control-label col-md-2">
									Content
									<i class="fa fa-question-circle tooltips" data-original-title="konten pesan, tambahkan text replacer bila perlu" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-10">
								<textarea name="inbox_global_content" id="inbox_global_content" class="form-control summernote">@if(old('inbox_global_content')) <?php echo old('inbox_global_content'); ?> @else @if(isset($inbox['inbox_global_content']) && $inbox['inbox_global_content'] != '') <?php echo $inbox['inbox_global_content'];?> @endif @endif</textarea>
								You can use this variables to display user personalized information:
								<br><br>
								<div class="row">
									@foreach($textreplaces as $key=>$row)
										<div class="col-md-3" style="margin-bottom:5px;">
											<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="addInboxContent('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon right">
								<label class="col-md-2 control-label" >
									Published
									<i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai inbox ditampilkan ke user" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-4">
								<div class="input-group date form_datetime form_datetime bs-datetime">
									<input type="text" size="16" class="form-control" name="inbox_global_start" placeholder="Date to Start Displaying" @if(isset($inbox['inbox_global_start']) && $inbox['inbox_global_start'] != "") value="{{date('d F Y - H:i', strtotime($inbox['inbox_global_start']))}}" @endif required>
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>

							<div class="input-icon right">
								<label class="col-md-2 control-label" >
									Expired
									<i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhirnya inbox ditampilkan ke user" data-container="body"></i>
								</label>
							</div>
							<div class="col-md-4">
								<div class="input-group date form_datetime form_datetime bs-datetime">
									<input type="text" size="16" class="form-control" name="inbox_global_end" placeholder="Date to Stop Displaying" @if(isset($inbox['inbox_global_end']) && $inbox['inbox_global_end'] != "") value="{{date('d F Y - H:i', strtotime($inbox['inbox_global_end']))}}" @endif required>
									<span class="input-group-addon">
										<button class="btn default date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-actions">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								@if(MyHelper::hasAccess([117], $grantedFeature))
									<button type="submit" class="btn yellow" id="checkBtn">Submit</button>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection