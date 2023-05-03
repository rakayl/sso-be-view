<form class="form-horizontal form-row-separated" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
    <div class="form-body">
        <div class="form-group">
            <label for="multiple" class="control-label col-md-3">Top Text <span class="required" aria-required="true"> * </span> </label>
            <div class="col-md-9">
                <textarea name="value" class="form-control summernote" id="text">@if (isset($advert['text_top'][0])){{ $advert['text_top'][0]['value'] }}@endif</textarea>
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
                                <option value="{{ $newsItem['id_news'] }}" @if(isset($advert['text_bottom'][0]['news']['id_news']) && $advert['text_bottom'][0]['news']['id_news'] == $newsItem['id_news']) selected @endif>{{ $newsItem['news_title'] }}</option>
                            @endforeach
                        @endif
                    </optgroup>
                </select>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <div class="col-md-3"></div>
        <div class="col-md-5">
            <input type="hidden" name="page" value="{{ $page }}">
            <input type="hidden" name="type" value="text_top">
            <input type="hidden" name="current" value="textontop">
            <button type="submit" class="btn green">Submit</button>
          {{ csrf_field() }}
        </div>
    </div>
</form>