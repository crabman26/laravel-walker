@extends('main.master')
@section('content')
	<table class="table table-bordered">
		<tr>
			<th>Τίτλος</th>
			<th>Πόλη</th>
			<th>Περιγραφή</th>
		</tr>
			
		@foreach($ads as $ad)
			<tr>
				<td>{{$ad->Header}}</td>
				<td>{{$ad->Town}}</td>
				<td>{{$ad->Description}}</td>
			</tr>
			@endforeach	
			
	</table>
@endsection