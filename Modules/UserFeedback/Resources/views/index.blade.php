@extends('layouts.main')
@include('list_filter')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@yield('filter_script')
<script>    
    rules={
        all_trx:{
            display:'All Transaction',
            operator:[],
            opsi:[]
        },
        review_date:{
            display:'Review Date',
            operator:[
                ['=','='],
                ['>','>'],
                ['>=','>='],
                ['<','<'],
                ['<=','<='],
            ],
            opsi:[],
            type:'date'
        },
        transaction_date:{
            display:'Transaction Date',
            operator:[
                ['=','='],
                ['>','>'],
                ['>=','>='],
                ['<','<'],
                ['<=','<='],
            ],
            opsi:[],
            type:'date'
        },
        transaction_type:{
            display:'Transaction Type',
            operator:[],
            opsi:[
                ['Offline','Offline'],
                ['Pickup Order','Pickup Order']
            ]
        },
        transaction_receipt_number:{
            display:'Receipt Number',
            operator:[
                ['=','='],
                ['like','like']
            ],
            opsi:[]
        },
        user_name:{
            display:'User Name',
            operator:[
                ['=','='],
                ['like','like']
            ],
            opsi:[]
        },
        user_phone:{
            display:'User Phone',
            operator:[
                ['=','='],
                ['like','like']
            ],
            opsi:[]
        },
        user_email:{
            display:'User Email',
            operator:[
                ['=','='],
                ['like','like']
            ],
            opsi:[],
            type:'email'
        },
        rating_value:{
            display:'Rating Value',
            operator:[],
            opsi:[
                ['1',"{{$rating_items['1']??'Good'}}"],
                ['0',"{{$rating_items['0']??'Netral'}}"],
                ['-1',"{{$rating_items['-1']??'Bad'}}"],
            ]
        },
        photos_only:{
            display:'Photo',
            operator:[],
            opsi:[
                ['1',"With Photos Only"],
                ['0',"Show All"],
                ['-1',"Without Photos Only"]
            ]
        },
        notes_only:{
            display:'Notes',
            operator:[],
            opsi:[
                ['1',"With Notes Only"],
                ['0',"Show All"],
                ['-1',"Without Notes Only"]
            ]
        },
        outlet:{
            display:'Outlet',
            operator:[],
            opsi:{!!json_encode($outlets)!!}
        },
    };

	$(document).ready(function(){
 		$('#outlet_selector').on('change',function(){
			var value = $(this).val();
            if(value == '0'){
                value = '';
            }
			window.location.href = "{{url('user-feedback')}}/"+value;
		});
	});
</script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
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
    </div><br>

    @include('layouts.notifications')
    @yield('filter_view')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-blue">List Feedback</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="feedback_table">
                <thead>
                    <tr>
                        <th> Create Feedback Date </th>
                        <th> Receipt Number </th>
                        <th> User </th>
                        <th> Grand Total </th>
                        <th> Vote </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                	@if($feedbackData['data'])
                	@foreach($feedbackData['data'] as $feedback)
                	<tr>
                		<td>{{date('d M Y',strtotime($feedback['created_at']))}}</td>
                		<td><a href="{{url('transaction/detail'.'/'.$feedback['transaction']['id_transaction'].'/'.strtolower($feedback['transaction']['trasaction_type']))}}">{{$feedback['transaction']['transaction_receipt_number']}}</a></td>
                		<td><a href="{{url('user/detail'.'/'.$feedback['user']['phone'])}}">{{$feedback['user']['name']}}</a></td>
                		<td>Rp {{number_format($feedback['transaction']['transaction_grandtotal'],0,',','.')}}</td>
                		<td>{{$rating_items[$feedback['rating_value']]??$feedback['rating_item_text']}}</td>
                		<td><a href="{{url('user-feedback/detail/'.base64_encode($feedback['id_user_feedback'].'#'.$feedback['transaction']['id_transaction']))}}" class="btn blue">Detail</a></td>
                	</tr>
                	@endforeach
                	@else
                	<tr>
                		<td colspan="6" class="text-center"><em class="text-muted">No Feedback Found</em></td>
                	</tr>
                	@endif
                </tbody>
            </table>
            <div class="col-md-offset-8 col-md-4 text-right">
                <div class="pagination">
                    <ul class="pagination">
                         <li class="page-first{{$prev_page?'':' disabled'}}"><a href="{{$prev_page?:'javascript:void(0)'}}">«</a></li>
                        
                         <li class="page-last{{$next_page?'':' disabled'}}"><a href="{{$next_page?:'javascript:void(0)'}}">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection