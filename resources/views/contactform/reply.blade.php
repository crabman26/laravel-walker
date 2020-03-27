@extends('master')
@section('content')
@foreach ($mail as $usermail)
	<form action="{{ url('contact/replymail',['Mail' => $usermail->Mail]) }}" method="post">
		{{ csrf_field() }}
		<div class="form-group">
				<label for="E-mail">E-mail:</label>
				<input type="text" name="email" class="form-control" value="{{ $usermail->Mail }}" readonly/>
		</div>
		<div class="form-group">
			<label for="Message">Μήνυμα:</label>
			<textarea class="form-control" name="Reply" cols="30">
			</textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Αποστολή</button>
			<button type="reset" class="btn btn-warning">Καθαρισμός</button>
		</div>
	</form>
@endforeach
@endsection