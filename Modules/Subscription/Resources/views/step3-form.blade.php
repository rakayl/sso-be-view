<?php
use App\Lib\MyHelper;
$configs = session('configs');
?>

@section('step3')
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Description
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang subscription yang dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-icon right">
                                <textarea name="subscription_description" id="field_content_long" class="form-control summernote" placeholder="Subscription Description">{{ old('subscription_description')??$subscription['subscription_description']??'' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Content
                            <i class="fa fa-question-circle tooltips" data-original-title="Konten yang akan ditampilkan pada halaman detail subscription" data-container="body"></i>
                            </label>
                        </div>
                        <div class="input-icon right">
                            <div class="col-md-9">
                                <div id="contentTarget" class="sortable">
                                	{{-- default 1 --}}
                                    <div class="form-group content-count bottom-border unsortable">
                                        <div id="accordion1">
                                            <div class="col-md-6 content-title">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="content_title[]"  placeholder="Content Title" required maxlength="20" value="{{ $subscription['subscription_content'][0]['title']??'Ketentuan' }}">
                                                    <input type="hidden" name="id_subscription_content[]" value="0" >
                                                    <input type="hidden" name="content_order[]" value="0">
                                                    <a class="accordion-toggle input-group-addon" data-toggle="collapse" data-parent="#accordion1" aria-expanded="true" href="#collapse_1">
                                                        <i class="fa fa-chevron-down custom-addon-icon"></i>
                                                        <i class="fa fa-chevron-right custom-addon-icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <input type="checkbox" class="make-switch visibility-switch" {{ isset($subscription['subscription_content'][0]['is_active']) ? 'checked' : '' }} data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="visible[1][]">
                                            </div>
                                            <div class="col-md-12 accordion-body collapse {{ empty($subscription['subscription_content'][0]['subscription_content_details']) ? 'in' : '' }}" id="collapse_1">
                                                <div class="form-group mt-repeater">
                                                    <div>
                                                        <div id="contentDetail1" class="sortable-detail-1">
                                                            @if( !empty($subscription['subscription_content'][0]['subscription_content_details']) )
                                                            @foreach( $subscription['subscription_content'][0]['subscription_content_details'] as $key => $value )
                                                            <div class="detail{{$key+1}}1">
                                                                <div data-repeater-item class="mt-overflow content-detail">
                                                                    <div class="mt-repeater-cell">
                                                                        <div class="col-md-1 sortable-detail-handle-1">
                                                                            <a href="javascript:;" class="btn btn-grey "><i class="fa fa-arrows-v"></i></a>
                                                                        </div>
                                                                        <div class="col-md-9 p-l-30px">
                                                                            <textarea type="text" placeholder="Content Detail" class="form-control focused-input" name="content_detail[1][]" required style="resize:vertical;"  />{{$value['content']}}</textarea>
                                                                            <input type="hidden" name="content_detail_order[1][]" value="0">
                                                                            <input type="hidden" name="id_content_detail[1][]" value="0">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDetail(<?php echo $key+1 ?>1)">
                                                                                <i class="fa fa-close"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-repeater">
                                                    <div class="p-l-40px">
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addDetail('1')"><i class="fa fa-plus"></i> Add new detail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- default 2 --}}
                                    <div class="form-group content-count bottom-border unsortable">
                                        <div id="accordion2">
                                            <div class="col-md-6 content-title">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="content_title[]"  placeholder="Content Title" required maxlength="20" value="{{ $subscription['subscription_content'][1]['title']??'Cara Penggunaan' }}">
                                                    <input type="hidden" name="id_subscription_content[]" value="0">
                                                    <input type="hidden" name="content_order[]" value="0">
                                                    <a class="accordion-toggle input-group-addon" data-toggle="collapse" data-parent="#accordion2" aria-expanded="true" href="#collapse_2">
                                                        <i class="fa fa-chevron-down custom-addon-icon"></i>
                                                        <i class="fa fa-chevron-right custom-addon-icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                    <input type="checkbox" class="make-switch visibility-switch" {{ isset($subscription['subscription_content'][1]['is_active']) ? 'checked' : '' }} data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="visible[2][]">
                                            </div>
                                            <div class="col-md-12 accordion-body collapse {{ empty($subscription['subscription_content'][1]['subscription_content_details']) ? 'in' : '' }}" id="collapse_2">
                                                <div class="form-group mt-repeater">
                                                    <div>
                                                        <div id="contentDetail2" class="sortable-detail-2">
                                                            @if( !empty($subscription['subscription_content'][1]['subscription_content_details']) )
                                                            @foreach( $subscription['subscription_content'][1]['subscription_content_details'] as $key => $value )
                                                            <div class="detail{{$key+1}}2">
                                                                <div data-repeater-item class="mt-overflow content-detail">
                                                                    <div class="mt-repeater-cell">
                                                                        <div class="col-md-1 sortable-detail-handle-2">
                                                                            <a href="javascript:;" class="btn btn-grey "><i class="fa fa-arrows-v"></i></a>
                                                                        </div>
                                                                        <div class="col-md-9 p-l-30px">
                                                                            <textarea type="text" placeholder="Content Detail" class="form-control focused-input" name="content_detail[2][]" required style="resize:vertical;" />{{$value['content']}}</textarea>
                                                                            <input type="hidden" name="content_detail_order[2][]" value="0">
                                                                            <input type="hidden" name="id_content_detail[2][]" value="0">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDetail(<?php echo $key+1 ?>2)">
                                                                                <i class="fa fa-close"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-repeater">
                                                    <div class="p-l-40px">
                                                        <a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addDetail('2')"><i class="fa fa-plus"></i> Add new detail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- other content --}}
                                    @if( isset($subscription['subscription_content']) )
                                        @foreach($subscription['subscription_content'] as $key => $val)
                                            @if($key > 1)
                                                @php $key++ @endphp
                                                <div class="form-group content-count bottom-border">
                                                    <div id="accordion{{$key}}">
                                                        <div class="col-md-6 content-title">
                                                            <div class="input-group">
                                                                <span class="input-group-addon sortable-handle">
                                                                    <a>
                                                                        <i class="fa fa-arrows-v"></i>
                                                                    </a>
                                                                </span>
                                                                <input type="text" class="form-control" name="content_title[]"  placeholder="Content Title" required maxlength="20" value="{{ $val['title']??'' }}">
                                                                <input type="hidden" name="id_subscription_content[]" value="0">
                                                                <input type="hidden" name="content_order[]" value="0">
                                                                <a class="accordion-toggle input-group-addon" data-toggle="collapse" data-parent="#accordion{{$key}}" aria-expanded="true" href="#collapse_{{$key}}">
                                                                    <i class="fa fa-chevron-down custom-addon-icon"></i>
                                                                    <i class="fa fa-chevron-right custom-addon-icon"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                                <input type="checkbox" class="make-switch visibility-switch" {{ isset($val['is_active']) ? 'checked' : '' }} data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="visible[{{$key}}][]">
                                                        </div>
                                                        <div class="col-md-1 p-l-30px">
                                                            <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline removeRepeater"><i class="fa fa-close"></i></a>
                                                        </div>
                                                        <div class="col-md-12 accordion-body collapse {{ empty($val['subscription_content_details']) ? 'in' : '' }}" id="collapse_{{$key}}">
                                                            <div class="form-group mt-repeater">
                                                                <div>
                                                                    <div id="contentDetail{{$key}}" class="sortable-detail-{{$key}}">
                                                                        @if( !empty($val['subscription_content_details']) )
                                                                        @foreach( $val['subscription_content_details'] as $key2 => $value2 )
                                                                        <div class="detail{{$key2+1}}{{$key}}">
                                                                            <div data-repeater-item class="mt-overflow content-detail">
                                                                                <div class="mt-repeater-cell">
                                                                                    <div class="col-md-1 sortable-detail-handle-{{$key}}">
                                                                                        <a href="javascript:;" class="btn btn-grey "><i class="fa fa-arrows-v"></i></a>
                                                                                    </div>
                                                                                    <div class="col-md-9 p-l-30px">
                                                                                        <textarea type="text" placeholder="Content Detail" class="form-control focused-input" name="content_detail[{{$key}}][]" required style="resize:vertical;" />{{$value2['content']}}</textarea>
                                                                                        <input type="hidden" name="content_detail_order[{{$key}}][]" value="0">
                                                                                        <input type="hidden" name="id_content_detail[{{$key}}][]" value="0">
                                                                                    </div>
                                                                                    <div class="col-md-1">
                                                                                        <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteDetail(<?php echo $key2+1;echo $key ?>)">
                                                                                            <i class="fa fa-close"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-repeater">
                                                                <div class="p-l-40px">
                                                                    <a href="javascript:;" data-repeater-create class="btn btn-success" onclick="addDetail('{{$key}}')"><i class="fa fa-plus"></i> Add new detail</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><a href="javascript:;" class="btn btn-info content"><i class="fa fa-plus"></i> Add Content </a></label>
                                </div>
                                @if (!empty($text_replaces))
	                                <br>
									
									You can use this variables to display subscription information to the content detail:
									<br><br>
									<div class="row">
										@foreach($text_replaces as $key=>$row)
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="Text will be replace '{{ $row['keyword'] }}' with user's {{ $row['reference'] }}" onClick="textReplace('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
											</div>
										@endforeach
									</div>
									<br><br>
                                @endif
                            </div>
                        </div>
                    </div>
@endsection