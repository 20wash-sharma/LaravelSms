@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
   
         @if($errors && count($errors)>0)
    <div class="alert alert-danger">
        
        <ul>
            
       
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
     </ul>
     </div>
    @endif
    @if(Session::has('post_success'))
    <div class='alert alert-success'>{{Session::get('post_success')}}</div>
    @endif
        <div class="panel panel-default widget">
            <div class="panel-heading">
               <i class="fa fa-comment" aria-hidden="true"></i>

                <h3 class="panel-title">
                    Messages</h3>
            
                    
            </div>
            <div class="panel-body">
                <ul class="list-group">
                     @foreach($message as $mymessage)
                   
                     <input type="hidden" value="{{$messageid = $mymessage->id}}"/>
                      <input type="hidden" value="{{$originalsender = $mymessage->sender_id}}"/>
                      <input type="hidden" value="{{$originalreceiver = $mymessage->receiver_id}}"/>
                      
                     
                      
                      
                    <li class="list-group-item ">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="" class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    <a href="#">
                                        {{$mymessage->title}}</a>
                                    <div class="bg-info">
                                        By: <a href="#">{{$sender = $mymessage->name}}</a> {{$mymessage->created_at}}
                                    </div>
                                </div>
                                <div class="comment-text">
                                    {{$mymessage->message}}
                                </div>
                               
                        
                        
                            </div>
                        </div>
                    </li>
                    @endforeach
                
                     @foreach($replies as $reply)
       <li class="list-group-item ">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="" class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    <a href="#">
                                        {{$reply->title}}</a>
                                    <div class="bg-info">
                                        By: <a href="#">{{$reply->name}}</a> {{$reply->created_at}}
                                    </div>
                                </div>
                                <div class="comment-text">
                                    {{$reply->message}}
                                </div>
                               
                        
                        
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                
            </div>
        </div>
    </div>
    <div class="row">
         <form method="POST" action="{{route('message.reply')}}">
             {{csrf_field()}}
             <input type="text" class="form-control" name="title" placeholder="title"/>
             <textarea class="form-control" name="reply" placeholder="reply text"></textarea>
              <input type="hidden" name="message_id"  value="{{$messageid}}"/>
              <input type="hidden" name="receiver_id"  value="{{$originalsender}}"/>
              <input type="hidden" name="sender_id"  value="{{$originalreceiver}}"/>
              <button type="submit" class="btn btn-sm btn-hover btn-primary" ><i class="fa fa-reply" aria-hidden="true"></i>Reply</button>
              
             
         </form>
         
        
    </div>
</div>

@endsection

