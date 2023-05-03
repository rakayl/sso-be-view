<?php
use App\Lib\MyHelper;
$configs = session('configs');
$show=$show??false;
?>
<script type="text/javascript">
document.getElementById('upload-csv-btn').classList.remove('hidden')
window.addEventListener('DOMContentLoaded', function() {
	$('input[name="csv_content"]').on('change', function(){
		var url_sample = '{{url('campaign-assets/sample_data.csv')}}';
		if($('input[name="csv_content"]:checked').val() !== 'phone'){
			url_sample = '{{url('campaign-assets/sample_data.csv')}}';
		} else {
			url_sample = '{{url('campaign-assets/sample_data_phone.csv')}}';
		}
		$('#sample-file-link').attr('href', url_sample);
	});
});
</script>
<div id="csvFilter" class="collapse @if($show) show @endif">
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Upload CSV</span>
		</div>
		@if(!is_array($conditions) || count($conditions) <= 0)
		<div class="actions">
			<div class="btn-group">
				<button class="btn btn-sm green collapser" type="button"> Manual Filter
				</button>
			</div>
		</div>
		@endif
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="form-group row">
				<label class="col-md-3 control-label text-right">Sample File</label>
				<div class="col-md-9">
					<a href="{{url('campaign-assets/sample_data.csv')}}" id="sample-file-link"> <i class="fa fa-file-o"></i> Sample CSV file </a> 
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 control-label text-right">Data Content @if(!$show) <span class="required" aria-required="true"> * </span> @endif</label>
				<div class="col-md-9">
					<div class="input-icon right">
						<div class="col-md-4">
							<div class="md-radio-inline">
								<div class="md-radio">
									<input type="radio" name="csv_content" id="input-user-id" class="md-radiobtn req-type" value="id" @if(empty(old('csv_content'))||old('csv_content')=='id') checked @endif @if(!$show) required="" disabled="disabled" @endif>
									<label for="input-user-id">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> User Id 
									</label>
								</div>
							</div>
						</div>    
						<div class="col-md-4">
							<div class="md-radio-inline">
								<div class="md-radio">
									<input type="radio" name="csv_content" id="input-phone-number" class="md-radiobtn req-type" value="phone"  @if(old('csv_content')=='phone') checked @endif @if(!$show) required="" disabled="disabled" @endif>
									<label for="input-phone-number">
										<span></span>
										<span class="check"></span>
										<span class="box"></span> Phone Number
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 control-label text-right">CSV File @if(!$show) <span class="required" aria-required="true"> * </span> @endif</label>
				<div class="col-md-9">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="input-group input-large">
							<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
								<i class="fa fa-file fileinput-exists"></i>&nbsp;
								<span class="fileinput-filename"> </span>
							</div>
							<span class="input-group-addon btn default btn-file">
								<span class="fileinput-new"> Select file </span>
								<span class="fileinput-exists"> Change </span>
								<input type="file" name="import_file" accept=".csv" id="campaign-csv-file" @if(!$show) required="" disabled="disabled" @endif> </span>
								<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 control-label text-right">Description</label>
				<div class="col-md-6">
					<textarea class="form-control" name="campaign_description">{{isset($result['campaign_description'])?$result['campaign_description']:''}}</textarea>
				</div>
			</div>
		</div>
	</div>
</div>
