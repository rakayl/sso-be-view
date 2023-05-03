@if($errors->any())
  <div class="alert alert-danger" role="alert" style="margin-top:20px">
   <strong>Error!</strong> <br/>
   @foreach($errors->all() as $e)
    - {{$e}} <br/>
   @endforeach
 </div>

@endif

@if(Session::has('success'))
  <div class="alert alert-success" role="alert" style="margin-top:20px">
   <strong>Success!</strong><br/>

   @foreach(Session::get('success') as $s)
     - {{$s}} <br/>
   @endforeach
 </div>
 <?php Session::forget('success'); ?>
@endif

@if(Session::has('warning'))
  <div class="alert alert-warning" role="alert" style="margin-top:20px">
    <strong>Warning!</strong> <br/>
    @foreach(Session::get('warning') as $w)
        - {{$w}} <br/>
    @endforeach

 </div>
 <?php Session::forget('warning'); ?>
@endif
