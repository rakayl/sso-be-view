<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
        
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Treatment</label>
            <div class="col-md-9">
                <select class="form-control select2-multiple" name="id_treatment" data-placeholder="Select Treatment" required="required">
                    <option></option>
                    @if (!empty($treatment))
                        @foreach($treatment as $suw)
                            <option value="{{ $suw['id_treatment'] }}">{{ $suw['treatment_name'] }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Time</label>
            <div class="row">
                <div class="col-md-4">
                    <input type="time" data-placeholder="select time start" class="form-control mt-repeater-input-inline" name="treatment_schedule_start" value="{{ old('day', date('H:i')) }}" required>
                </div>
                <div class="col-md-4">
                    <input type="time" data-placeholder="select time end" class="form-control mt-repeater-input-inline" name="treatment_schedule_end" value="{{ old('day', date('H:i')) }}" required>
                </div>  
            </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Day</label>
          <div class="col-md-9">
              <div class="checkbox-list">
                    <label>
                      <input type="checkbox" name="treatment_schedule_day[]" value="Monday"> Monday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Tuesday"> Tuesday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Wednesday"> Wednesday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Thursday"> Thursday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Friday"> Friday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Saturday"> Saturday 
                    </label>
                    <label>
                        <input type="checkbox" name="treatment_schedule_day[]" value="Sunday"> Sunday 
                    </label>
              </div>
          </div>
        </div>
     
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_outlet" value="{{ $outlet[0]['id_outlet'] }}">
            <button type="submit" class="btn green">Submit</button>
          </div>
      </div>
  </div>
</form>

<hr>

<div class="portlet-body form">
    @if (!empty($outlet[0]['schedule']))
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Schedule</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Treatment </th>
                        <th> Day </th>
                        <th> Time Start </th>
                        <th> Time End </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($outlet[0]['schedule'] as $value)
                    <tr>
                        <td> {{ $value['treatment']['treatment_code'] }} - {{ $value['treatment']['treatment_name'] }}  </td>
                        <td> {{ $value['treatment_schedule_day'] }} </td>
                        <td> {{ date('H:i', strtotime($value['treatment_schedule_start'])) }} </td>
                        <td> {{ date('H:i', strtotime($value['treatment_schedule_end'])) }} </td>
                        <td> <a data-toggle="confirmation" data-popout="true" class="btn red delete-disc" data-id="{{ $value['id_treatment_schedules'] }}"><i class="fa fa-trash-o"></i></a> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>