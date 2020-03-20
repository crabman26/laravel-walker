@extends('master')
@section('content')
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Όνομα</th>
			<th>Επώνυμο</th>
			<th>E-mail</th>
			<th>Τηλέφωνο</th>
			<th>Μήνυμα</th>
			<th>Ενέργειες</th>
		</tr>
		@foreach($contacts as $contact)
			<tr>
				<td>{{$contact->Name}}</td>
				<td>{{$contact->Surname}}</td>
				<td>{{$contact->E-mail}}</td>
				<td>{{$contact->Phone}}</td>
				<td>{{$contact->Message}}</td>
				<td>Απάντηση</td>
			</tr>
		@endforeach
	</thead>
</table>
@endsection