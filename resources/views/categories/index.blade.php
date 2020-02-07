@extends('master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<br />
		<h3 align="center">Categories Data</h3>
		<br />
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{$message}}</p>
			</div>
		@endif
		<div align="right">
			<a href="{{route('categories.create')}}" class="btn btn-primary">Add new category</a>
			<br />
			<br />
		</div>
		<table class="table table-bordered tabled-striped">
			<tr>
				<th>Title</th>
				<th>Keyword</th>
				<th>Active</th>
			</tr>
			@foreach ($categories as $row)
					<tr>
						<td>{{$row['Title']}}</td>
						<td>{{$row['Keyword']}}</td>
						<td>{{$row['Active']}}</td>
						<td><a href="{{action('CategoriesController@edit', $row['id'])}}" class="btn btn-warning">Edit</a></td>
						<td>
							<form method="post" action="{{action('CategoriesController@destroy', $row['id'])}}" class="form_delete">
								{{csrf_field()}}
								<input type="hidden" name="_method" value="DELETE"/>
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>
						</td>
					</tr>
				@endforeach
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.form_delete').on('submit',function(){
			if (confirm('Are you sure you want to delete the category?')){
				return true;
			} else {
				return false;
			}
		});
	});
</script>
@endsection
