@extends('layouts.app') 
@section('content')
<div class="row">
     <div class="col-md-3 col-md-offset-3 ">
    {{$messages->links()}}
     </div>
</div>
<div class="row">
     
     <div class="col-md-9 col-md-offset-2 ">
      <table class="table table-striped table-bordered">
          <thead> <tr><th>title</th><th>Receiver name</th><th>Receiver email</th><th>Message</th><th>Actions</th></tr></thead>
            <tbody>
    @foreach($messages as $message)
       <tr><th>{{$message->title}}</th><th>{{$message->name}}</th><th>{{$message->email}}</th><th>{{$message->message}}</th>
       <th>  <a href="{{route('message.show',['id'=>$message->id])}}"><i class="fa fa-eye" aria-hidden="true"></i>View</a>
       </th>
       <tr>
           
       @endforeach
                
            
           
                 </tbody>
        </table>

</div>

    </div>


 
     <div class="row">
     <div class="col-md-3 col-md-offset-3 ">
    {{$messages->links()}}
     </div>
</div>
@endsection

