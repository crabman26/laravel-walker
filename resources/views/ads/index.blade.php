@extends('master')

@section('content')

<div class="row">
	<div class="col-md-12">
		<br />
		<h3 align="center">Ads Data</h3>
		<br />
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{$message}}</p>
			</div>
		@endif
		<div align="right">
			<a href="{{route('ads.create')}}" class="btn btn-primary">Add new ad</a>
			<br />
			<br />
		</div>
		<table class="table table-bordered tabled-striped">
			<tr>
				<th>Name</th>
				<th>Surname</th>
				<th>Town</th>
				<th>Region</th>
				<th>E-mail</th>
				<th>Description</th>
				<th>State</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<tr>
				@foreach($ads as $row)
					<tr>
						<td>{{$row['Name']}}</td>
						<td>{{$row['Surname']}}</td>
						<td>{{$row['Town']}}</td>
						<td>{{$row['Region']}}</td>
						<td>{{$row['Email']}}</td>
						<td>{{$row['Description']}}</td>
						<td>{{$row['State']}}</td>
						<td><a href="{{action('AdsController@edit', $row['id'])}}" class="btn btn-warning">Edit</a></td>
						<td>
							<form method="post" action="{{action('AdsController@destroy', $row['id'])}}" class="delete_form">
								{{csrf_field()}}
								<input type="hidden" name="_method" value="DELETE"/>
								<button type="submit" class="btn btn-danger">Delete</button>								
							</form>
						</td>
					</tr>
				@endforeach
			</tr>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_form').on('submit',function(){
			if (confirm("Are you sure you want to delete the ad?")){
				return true;
			} else {
				return false;
			}
		});
	});
</script>
@endsection