<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
  <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">Type</label>
        <div class="col-md-9">
            <label class="radio-inline">
            <input type="radio" name="type_disc" class="disc" required data-type="percentage"> Percentage </label>
            <label class="radio-inline">
            <input type="radio" name="type_disc" class="disc" required data-type="nominal"> Nominal </label>
        </div>
        </div>
        <div class="form-group percentage-div" style="display: none;">
            <label class="col-md-3 control-label">Percentage</label>
            <div class="col-md-9">
                <input type="number" min="1" max="100" class="form-control percentage" name="discount_percentage" value="{{ old('discount_percentage') }}">
            </div>
        </div>
        <div class="form-group nominal-div" style="display: none;">
            <label class="col-md-3 control-label">Nominal</label>
            <div class="col-md-9">
                <input type="text" class="form-control nominal" name="discount_nominal" value="{{ old('discount_nominal') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">Date</label>
            <div class="row">
                <div class="col-md-4">
                    <input type="date" data-placeholder="select date start" class="form-control mt-repeater-input-inline" name="discount_start" value="{{ old('day', date('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <input type="date" data-placeholder="select date end" class="form-control mt-repeater-input-inline" name="discount_end" value="{{ old('day', date('Y-m-d')) }}">
                </div>  
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Time</label>
            <div class="row">
                <div class="col-md-4">
                    <input type="time" data-placeholder="select time start" class="form-control mt-repeater-input-inline" name="discount_time_start" value="{{ old('day', date('H:i')) }}">
                </div>
                <div class="col-md-4">
                    <input type="time" data-placeholder="select time end" class="form-control mt-repeater-input-inline" name="discount_time_end" value="{{ old('day', date('H:i')) }}">
                </div>  
            </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Day</label>
          <div class="col-md-9">
              <div class="checkbox-list">
                    <label>
                      <input type="checkbox" name="discount_days[]" value="Monday"> Monday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Tuesday"> Tuesday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Wednesday"> Wednesday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Thursday"> Thursday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Friday"> Friday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Saturday"> Saturday 
                    </label>
                    <label>
                        <input type="checkbox" name="discount_days[]" value="Sunday"> Sunday 
                    </label>
              </div>
          </div>
        </div>
     
  </div>
  <div class="form-actions">
      {{ csrf_field() }}
      <div class="row">
          <div class="col-md-offset-3 col-md-9">
            <input type="hidden" name="id_product" value="{{ $product[0]['id_product'] }}">
            <button type="submit" class="btn green">Submit</button>
          </div>
      </div>
  </div>
</form>

<hr>

<div class="portlet-body form">
    @if (!empty($product))
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">List Discount</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> Discount </th>
                        <th> Value </th>
                        <th> Date Start </th>
                        <th> Date End </th>
                        <th> Time Start </th>
                        <th> Time End </th>
                        <th> Day </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($product as $value)
                    @if (!empty($value['discount']))
                        @foreach ($value['discount'] as $key=> $you)
                            <tr>
                                @if (empty($you['discount_percentage']))
                                <td> Rp </td>
                                <td> {{ $you['discount_nominal'] }} </td>
                                @else
                                <td> % </td>
                                <td> {{ $you['discount_percentage'] }} </td>
                                @endif
                                <td> {{ date('Y-m-d', strtotime($you['discount_start'])) }} </td>
                                <td> {{ date('Y-m-d', strtotime($you['discount_end'])) }} </td>
                                <td> {{ date('H:i', strtotime($you['discount_time_start'])) }} </td>
                                <td> {{ date('H:i', strtotime($you['discount_time_end'])) }} </td>
                                <td> {{ $you['discount_days'] }} </td>
                                <td> <a data-toggle="confirmation" data-popout="true" class="btn red delete-disc" data-id="{{ $you['id_product_discount'] }}"><i class="fa fa-trash-o"></i></a> </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>