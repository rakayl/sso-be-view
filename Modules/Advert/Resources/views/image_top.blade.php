<form class="form-horizontal form-row-separated" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Top Image <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-9">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 300px; height: 100px;">
                      <img src="https://www.placehold.it/300x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <br>
                        <span class="required" aria-required="true"> width (1080) x height (360) </span>
                    <br>
                    <div>
                        <span class="btn default btn-file">
                            <span class="fileinput-new"> Select image </span>
                            <span class="fileinput-exists"> Change </span>
                            {{ csrf_field() }}

                            <input type="hidden" name="page" value="{{ $page }}">
                            <input type="hidden" name="add" value="1">
                            <input type="hidden" name="type" value="img_top">
                            <input type="hidden" name="current" value="pictontop">
                            <input type="file" class accept="image/*" name="img_top">
                        </span>
                      <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                    </div>
              </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">News</label>
            <div class="col-md-9">
                <select id="outlet"  id="field_outlet_select" class="form-control select2" data-placeholder="Select news" name="id_news">
                    <optgroup label="News List">
                        @if (!empty($news))
                        <option value="">-</option>
                            @foreach($news as $newsItem)
                                <option value="{{ $newsItem['id_news'] }}">{{ $newsItem['news_title'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-actions" style="margin-bottom:20px">
            <div class="row">
                <div class="col-md-offset-3 col-md-4">
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@if (!empty($advert['img_top']))
    <div class="portlet-title m-heading-1 border-green m-bordered">
        <div class="caption">
            Sort
        </div>
    </div>
    <div class="portlet-body">
        <form action="{{ url()->current() }}" method="POST">
            <div class="form-body">
                <div class="col-md-12 sortable form-group">
                   @foreach($advert['img_top'] as $knc=>$nilai)
                     <div class="portlet portlet-sortable light bordered col-md-4">
                        <div class="portlet-title">
                            <span class="caption-subject bold" style="font-size: 12px !important;">{{ $knc + 1 }}</span>
                            <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete pull-right" data-id="{{ $nilai['id_advert'] }}"><i class="fa fa-trash-o"></i></a>
                        </div>
                        <div class="portlet-body">
                            <input type="hidden" name="id_advert[]" value="{{ $nilai['id_advert'] }}">
                            <center>
                                <img src="{{ $nilai['value'] }}" alt="{{ $knc + 1 }}" width="150">
                                <br>
                                <br>
                                @if($nilai['news']['news_title'])
                                    Link news to : {{ $nilai['news']['news_title'] }}
                                @endif
                            </center>
                        </div>
                    </div>
                   @endforeach
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-5"></div>
                <div class="col-md-7">
                    <input type="hidden" name="rearange" value="yes">
                    <input type="hidden" name="current" value="pictontop">
                    <button type="submit" class="btn green">Submit</button>
                  {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
@endif