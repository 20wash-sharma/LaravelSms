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
    <form method="POST" action="{{route('message.importexcel')}}" enctype="multipart/form-data">
   
    {{csrf_field()}}
    <div class="form-group">
    <label> Import</label>
    <input type="file" name="excelfile" class="form-control" id="fileToUpload">
    <input type="submit" value="Upload Image" class="form-control" name="submit">
    </div>
    
    </form>
    <form method="get" action="{{route('message.exportexcel')}}">
        <div class="form-group">
    <label> Export</label>
    
    <input type="submit" value="Export" class="form-control" name="submit">
    </div>
    </form>
@endsection
