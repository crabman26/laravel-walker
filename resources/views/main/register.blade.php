@extends('main.master')
@section('content')
<br />
  <div class="container box">
   <h3 align="center">Δημιουργία λογαριασμού</h3><br />
   
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
   <div class="form-group">
    <label>Enter Your Email</label>
    <input type="text" name="email" id="email" class="form-control input-lg" />
    <span id="error_email"></span>
   </div>
   <div class="form-group">
    <label>Enter Your Name</label>
    <input type="text" name="name" id="name" class="form-control input-lg" />
    <span id="error_email"></span>
   </div>
   <div class="form-group">
    <label>Enter Your Password</label>
    <input type="password" name="password" id="password" class="form-control input-lg" />
   </div>
   <div class="form-group" align="center">
    <button type="button" name="register" id="register" class="btn btn-info">Εγγραφή</button>
    <button type="button" name="reset" id="reset" class="btn btn-warning">Επαναφορά</button>
   </div>
   {{ csrf_field() }}
   
   <br />
   <br />
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 $('#email').blur(function(){
  var error_email = '';
  var email = $('#email').val();
  var _token = $('input[name="_token"]').val();
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!filter.test(email))
  {    
   $('#error_email').html('<label class="text-danger">Εισάγετε σωστά το e-mail σας.</label>');
   $('#email').addClass('has-error');
   $('#register').attr('disabled', 'disabled');
  }
  else
  {
   $.ajax({
    url:"{{ route('register.check') }}",
    method:"POST",
    data:{email:email, _token:_token},
    success:function(result)
    {
     if(result == 'unique')
     {
      $('#error_email').html('<label class="text-success">Το e-mail μπορεί να χρησιμοποιηθεί για δημιουργία λογαριασμού.</label>');
      $('#email').removeClass('has-error');
      $('#register').attr('disabled', false);
     }
     else
     {
      $('#error_email').html('<label class="text-danger">Υπάρχει ενεργός χρήστης με αυτό το e-mail.</label>');
      $('#email').addClass('has-error');
      $('#register').attr('disabled', 'disabled');
     }
    }
   })
  }
 });
 
});
</script>
@endsection