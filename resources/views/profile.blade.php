@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="jumbotron">
                 @if($errors && count($errors)>0)
    <div class="alert alert-danger">
        
        <ul>
            
       
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
     </ul>
     </div>
    @endif
    @if(Session::has('success-message'))
    <div class='alert alert-success'>{{Session::get('success-message')}}</div>
    @endif
                @foreach($user as $singleuser)
                <form action="{{route('updateprofile')}}" method="POST">
                    {{csrf_field()}}
                     <div class="form-group">
           <label for="inputEmail" class="sr-only">Name</label>
        <input class="form-control" type="text" name="name" placeholder="Name" value="{{$singleuser->name}}">
     
             </div>
                     <div class="form-group">
           <label for="inputEmail" class="sr-only">Old Password</label>
        <input class="form-control" type="password" name="oldpassword" placeholder="Old Password" value="">
     
             </div>
                    <div class="form-group">
           <label for="inputEmail" class="sr-only">New Password</label>
        <input class="form-control" type="password" name="newpassword" placeholder="New Password" value="">
     
             </div>
                     <div class="form-group">
           <label for="inputEmail" class="sr-only">Confirm New Password</label>
        <input class="form-control" type="password" name="newpassword_confirmation" placeholder="Confirm New Password" value="">
     
             </div>
                    
                  <input class="form-control" type="submit"   value="Update">
        
                    
                </form>
                 @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
