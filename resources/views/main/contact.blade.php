@extends('main.master')
@section('content')
<form method="post" action="{{url('contacts')}}" id="contact-form">
	{{ csrf_field() }}
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
		<label for="Name">Όνομα:</label>
		<input type="text" id="Name" name="Name" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="Surname">Επώνυμο:</label>
		<input type="text" id="Surname" name="Surname" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="E-mail">E-mail:</label>
		<input type="e-mail" id="E-mail" E-mail="E-mail" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="Phone">Τηλέφωνο:</label>
		<input type="text" id="Phone" name="Phone" class="form-control"/>
	</div>
	<div class="form-group">
		<label for="Message">Μήνυμα:</label>
		<textarea  cols="30" id="Message" name="Message" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Αποστολή"/>
		<input type="reset" class="btn btn-warning" value="Καθαρισμός"/>
	</div>
</form>
@endsection