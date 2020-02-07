@extends('master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<br />
			<h3>Edit Category</h3>
			<br />
			@if (count($errors)>0)
				<div class="alert alert-danger">
					@foreach($errors as $error)
						<li>{{$error}}</li>
					@endforeach
				</div>
			@endif
			<form method="post" action="{{action('CategoriesController@update', $id)}}">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="PATCH" />
				<div class="form-group">
					<input type="text" name="Title" class="form-control" value = "{{$categories->Title}}" placeholder="Enter category title" />
				</div>
				<div class="form-group">
					<input type="text" name="Keyword" class="form-control" value="{{$categories->Keyword}}" placeholder="Enter category keyword">
				</div>
				<div class="form-group">
					<input type="text" name="Active" class="form-control" value="{{$categories->Active}}" placeholder="Enter category status">
				</div>
				<div clas="form-group">
					<input type="submit" class="btn btn-primary" value="Edit"/>
				</div>
			</form>
		</div>
	</div>
@endsection