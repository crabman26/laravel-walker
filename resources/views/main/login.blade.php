@extends('main.master')
@section('content')
<div class="container box">

   @if(isset(Auth::user()->email))
    <script>window.location="/main/successlogin";</script>
   @endif

   @if ($message = Session::get('error'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
   </div>
   @endif

   @if (count($errors) > 0)
    <div class="alert alert-danger">
     <ul>
     @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
     @endforeach
     </ul>
    </div>
   @endif

   <div class="col-md-6">
      <form method="post" action="{{ url('/main/checklogin') }}">
       {{ csrf_field() }}
       <div class="form-group">
        <label>E-mail:</label>
        <input type="email" name="email" class="form-control" />
       </div>
       <div class="form-group">
        <label>Κωδικός:</label>
        <input type="password" name="password" class="form-control" />
       </div>
       <div class="form-group">
        <input type="submit" name="login" class="btn btn-primary" value="Είσοδος" />
        <input type="reset" name="reset" class="btn btn-warning" value="Επαναφορά" />
       </div>
        <a href="{{ url('register') }}">Δημιουργία λογαριασμού</a>
      </form>
   </div>
  </div>
@endsection