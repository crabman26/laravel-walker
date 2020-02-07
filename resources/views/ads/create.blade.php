@extends('master')

@section('content')
<div class="row">
 <div class="col-md-12">
  <br />
  <h3 aling="center">Insert ad's data</h3>
  <br />
  @if(count($errors) > 0)
  <div class="alert alert-danger">
   <ul>
   @foreach($errors->all() as $error)
    <li>{{$error}}</li>
   @endforeach
   </ul>
  </div>
  @endif
  @if(\Session::has('success'))
  <div class="alert alert-success">
   <p>{{ \Session::get('success') }}</p>
  </div>
  @endif

  <form method="post" action="{{url('ads')}}">
   {{csrf_field()}}
   <div class="form-group">
    <input type="text" name="Name" class="form-control" placeholder="Enter First Name" />
   </div>
   <div class="form-group">
    <input type="text" name="Surname" class="form-control" placeholder="Enter Last Name" />
   </div>
   <div class="form-group">
    <input type="text" name="Town" class="form-control" placeholder="Enter Town" />
   </div>
   <div class="form-group">
    <input type="text" name="Region" class="form-control" placeholder="Enter Region" />
   </div>
   <div class="form-group">
    <input type="e-mail" name="E-mail" class="form-control" placeholder="Enter E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
   </div>
   <div class="form-group">
    <input type="text" name="Description" class="form-control" placeholder="Enter Description" />
   </div>
   <div class="form-group">
    <input type="text" name="State" class="form-control" placeholder="Enter State" />
   </div>
   <div class="form-group">
    <input type="submit" class="btn btn-primary" />
   </div>
  </form>
 </div>
</div>
@endsection