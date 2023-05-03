<form method="post" action="{{url('quest/detail/'.$data['quest']['id_quest'].'/update/content')}}">
    @csrf
    <div class="row form-group">
        <div class="col-md-12">
            <div id="quest-content-container" class="sortable">
                @foreach($data['quest']['quest_contents'] as $index => $quest_content)
                <div id="accordion{{$index}}" class="accordion-item">
                    <div class="row">
                        <div class="col-md-6 content-title">
                            <div class="input-group">
                                <span class="input-group-addon sortable-handle"><a><i class="fa fa-arrows-v"></i></a></span>
                                <input type="text" class="form-control" name="content[{{$index}}][title]"  placeholder="Content Title" required maxlength="20" value="{{$quest_content['title']}}">
                                <input type="hidden" name="content[{{$index}}][id_quest_content]" value="{{ $quest_content['id_quest_content'] }}" >
                                <input type="hidden" name="content_order[]" value="{{$index}}">
                                <span class="input-group-addon">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$index}}" aria-expanded="true" href="#collapse_{{$index}}">
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" class="make-switch visibility-switch" {{ $quest_content['is_active'] ? 'checked' : '' }} data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="content[{{$index}}][is_active]">
                        </div>
                        <div class="col-md-3 text-right">
                            <button class="btn btn-danger delete-btn" type="button"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="col-md-12 accordion-body collapse {{ $quest_content['is_active'] ? 'in' : '' }}" style="margin-top: 10px; margin-bottom: 0" id="collapse_{{$index}}">
                            <textarea name="content[{{$index}}][content]" class="form-control summernote" placeholder="Content" id="summernote{{$index}}">{{$quest_content['content']}}</textarea>
                            <div class="portlet-body" style="margin-bottom: 15px">
                                <span style="margin-bottom: 5px">You can use this variables to display dynamic information:</span>
                                <div>
                                    @if($data['quest']['quest_benefit']['benefit_type'] == 'voucher')
                                        <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote{{$index}}', '%deals_title%')">%deals_title%</button>
                                        <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote{{$index}}', '%voucher_qty%')">%voucher_qty%</button>
                                    @else
                                        <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote{{$index}}', '%point_received%')">%point_received%</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #F0F5F7; margin: 10px 0"/>
                </div>
                @endforeach
            </div>
        </div>
{{--         <div class="col-md-3" style="right: 0;top: 70px; position: sticky">
            <div style="position: sticky;top: 0;">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-text"></i>Text Replace</div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <p>You can use this variables to display dynamic information:</p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="col-md-offset-2 col-md-10 text-center">
        <button class="btn btn-info green" onclick="addCustomContent()" type="button">Add Content</button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr style="border-bottom: 1px solid #F0F5F7"/>
        </div>
        <div class="col-md-offset-2 col-md-3">
            <button class="btn btn-primary">Save Quest Content</button>
        </div>
    </div>
</form>