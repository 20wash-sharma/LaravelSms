@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    
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
<form method="POST" action="{{route('message.store')}}">
    <!input type="hidden" name="_token" value="abc"/>
    {{csrf_field()}}
    <div class="form-group">
    <label> Email</label>
    <select name="email" class="form-control">
          @foreach($users->all() as $user)
    <option value="{{$user->id}}">{{$user->email}}:{{$user->name}}</option>
    @endforeach
    </select>
    </div>
    <div class="form-group">
        <label> Title</label>
         <input type="text" name ="title" class="form-control"/> <br/>
    </div>
    <div class="form-group">
   <label> Message</label>
     
     <textarea rows="10" cols="100" name ="message" class="form-control"></textarea> 
      <input type="submit"  class="form-control" value="Send Message"/> <br/>
</form>
    </div>
@endsection
