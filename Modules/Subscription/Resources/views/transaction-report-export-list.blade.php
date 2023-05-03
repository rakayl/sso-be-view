@extends('layouts.main')

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

    <h1 class="page-title" style="margin-top: 0px;">
        {{$sub_title}}
    </h1>
    @include('layouts.notifications')

    <div class="m-heading-1 border-green m-bordered">
        <p>Halaman ini adalah daftar antrian export yang sudah dicreate. Anda bisa mendownload dan menghapus file jika file sudah selesai digenerate oleh sistem.</p>
    </div>

    <table class="table table-striped table-bordered table-hover" id="tableReport">
        <thead>
        <tr>
            <th scope="col" width="30%"> Date </th>
            <th scope="col" width="25%"> Filter </th>
            <th scope="col" width="10%"> Action </th>
        </tr>
        </thead>
        <tbody>
        	@php
        		/*foreach ($data as $key => $value) {
        			$data[$key]['filter'] = (array)json_decode($value['filter']);
        		}
        		dd($data);*/
        	@endphp
        @if(!empty($data))
            @foreach($data as $val)
                <tr>
                    <td>{{date('d M Y H:i', strtotime($val['created_at']))}}</td>
                    <td>
                        <?php
                        $filter = (array)json_decode($val['filter']);

                        $html = '';

                        if(isset($filter['date_start']) && isset($filter['date_end'])){
                            $html .= 'Date Start : '. $filter['date_start'].'<br>';
                            $html .= 'Date End : '. $filter['date_end'].'<br>';
                        }

                        if(isset($filter['type'])){
                            $html .= 'Export Report Type: '.$filter['type'].'<br>';
                        }

                        if($val['report_type'] == 'Transaction' && isset($filter['detail'])){
                            $html .= 'Export : Transaction Detail <br>';
                        }

                        if(isset($filter['operator'])){
                        	if(is_object($filter['operator'])){
			                    $filter['operator'] = (array) $filter['operator'];
			                }
                            	//dd($filter['operator']);
                            $html .= 'Parent operator : '. $filter['operator'].'<br>';
                        }

                        if(isset($filter['rule'])){
                            foreach ($filter['rule'] as $v){
                                $v = (array)$v;
	                            if(is_array($v['parameter']))
	                            {
	                            	$v['parameter'] = implode( ", ", $v['parameter'] );
	                            }
                                if(isset($v['subject'])){
                                    $html .= 'Subject : '. $v['subject'].'| Operator : '.($v['operator']??'or').'| Parameter : '.($v['parameter'] == null ? '-' :$v['parameter']);
                                }
                            }
                        }else{
                            $html .= 'No Filter';
                        }

                        echo $html;
                        ?>
                    </td>
                    <td class="text-center">
                        @if($val['status_export'] == 'Deleted')
                            <span style="color: red">File has been deleted</span>
                        @elseif($val['status_export'] == 'Running')
                            File not ready
                            <a class="btn btn-sm grey" href="{{ url()->current() }}"><i class="fa fa-refresh"></i></a>
                        @else
                            @if($val['report_type'] == 'Subscription')
                                <a class="btn btn-sm red" href="{{ url('subscription/export-action/deleted', $val['id_export_queue']) }}"><i class="fa fa-trash-o"></i></a>
                                <a class="btn btn-sm blue" href="{{ url('subscription/export-action/download', $val['id_export_queue']) }}"><i class="fa fa-download"></i></a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="11" style="text-align: center">Data Not Available</td></tr>
        @endif
        </tbody>
    </table>
    <br>
    @if(isset($dataPerPage) && isset($dataUpTo) && isset($dataTotal))
        Showing {{$dataPerPage}} to {{$dataUpTo}} of {{ $dataTotal }} entries<br>
    @endif
    @if ($dataPaginator)
        {{ $dataPaginator->links() }}
    @endif
@endsection