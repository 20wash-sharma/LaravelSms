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
          <thead> <tr><th>title</th><th>Sender name</th><th>Sender email</th><th>Message</th><th>Importance</th><th>Actions</th></tr></thead>
            <tbody>
    @foreach($messages as $message)
       <tr>
           <th>{{$message->title}}</th><th>{{$message->name}}</th><th>{{$message->email}}</th><th>{{str_limit($message->message, $limit = 50, $end = '...')}}</th>
        @if($message->importance==0)
        <th>unimportant</th>
        <?php $mark = 'Mark Important'; $class='fa fa-check'; $valuetobeupdated=1; ?>
        @else
        <th>important</th>
         <?php $mark = 'Mark UnImportant';$class='fa fa-times';$valuetobeupdated=0; ?>
       
        @endif
         <th>  
              <form method="POST" action="{{route('message.update',['id'=>$message->id])}}">
             {{csrf_field()}}
            
             <input type="hidden" name="updatevalue" value="{{$valuetobeupdated}}"/>
           
             <input type="hidden" name="_method" value="PUT"/>
              <a href="javascript:void(0)" class="login-button"><i class="{{$class}}"></i>{{$mark}}</a>
              
   
</button>
              
         </form>  
             <a href="{{route('message.show',['id'=>$message->id])}}"><i class="fa fa-eye" aria-hidden="true"></i>View</a>
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

