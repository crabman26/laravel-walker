@extends('master')

@section('content')

<div class="row">
	<div class="col-md-12">
		<br />
		<h3>Edit Record</h3>
		<br />
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form method="post" action="{{action('AdsController@update', $id)}}">
			{{csrf_field()}}
			<input type="hidden" name="_method" value="PATCH"/>
			<div class="form-group">
				<input type="text" name="Name" class="form-control" value="{{$ads->Name}}" placeholder="Enter Name" />
			</div>
			<div class="form-group">
				<input type="text" name="Surname" class="form-control" value="{{$ads->Surname}}" placeholder="Enter Surname" />
			</div>
			<div class="form-group">
				<input type="text" name="Town" class="form-control" value="{{$ads->Town}}" placeholder="Enter Town" />
			</div>
			<div class="form-group">
				<input type="text" name="Region" class="form-control" value="{{$ads->Region}}" placeholder="Enter Region" />
			</div>
			<div class="form-group">
				<input type="e-mail" name="E-mail" class="form-control" value="{{$ads->Email}}" placeholder="Enter E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
			</div>
			<div class="form-group">
				<input type="text" name="Description" class="form-control" value="{{$ads->Description}}" placeholder="Enter Description" />
			</div>
			<div class="form-group">
				<input type="text" name="State" class="form-control" value="{{$ads->State}}" placeholder="Enter State" />
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Edit" />
			</div>
		</form>
	</div>
</div>
@endsection