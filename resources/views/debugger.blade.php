@extends('layouts.main')

@section('page-style')
@endsection

@section('page-script')
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{url('/')}}">Home</a>
			</li>
			<li>
				<a href="{{url('/')}}">Debugger</a>
			</li>
		</ul>
	</div>
	<h1 class="page-title">
		<i class="fa fa-code font-blue"></i>
		<span class="caption-subject font-blue-sharp sbold">{{$title}}</span>
	</h1>
	<div class="portlet light">
		<div class="portlet-body">
			@include('layouts.notifications')
			<form action="/debugger" method="post" style="padding-bottom: 20px;">
				<div class="form-group">
					<textarea class="form-control" name="script">{{$script}}</textarea>
				</div>
				@csrf
				<button class="btn btn-sm btn-success">Run</button>
				<label>
					<input type="checkbox" name="pre" value="1" {{$pre ? 'checked' : ''}}> use pre
				</label>
			</form>
			@if($script)
			<b>Result</b>
			<{!!$pre ? 'pre' : 'div style="border:1px solid grey; padding: 20px;"'!!}>
				@php eval($script) @endphp
			</{{$pre ? 'pre' : 'div'}}>
			@endif
		</div>
	</div>
@endsection
