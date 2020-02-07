@extends ('master')

@section ('content')
<div class="row">
	<div class="col-md-12">
		<br />
		<h3 align="center">Inser category's data</h3>
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
		@if(\Session::has('success'))
			<div class="alert alert-success">
				<p>{{ \Session::get('success')}}</p>
			</div>
		@endif
		<form method="post" action="{{url('categories')}}">
			{{csrf_field()}}
			<div class="form-group">
				<input type="text" name="Title" class="form-control" placeholder="Enter category title" />
			</div>
			<div class="form-group">
				<input type="text" name="Keyword" class="form-control" placeholder="Enter category keyword" maxlength="60" />
			</div>
			<div class="form-group">
				<input type="text" name="Active" class="form-control" placeholder="Enter category status" />
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary"/>
			</div>
		</form>
	</div>
</div>
@endsection