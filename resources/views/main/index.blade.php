@extends('main.master')
@section('content')
<h2 align="center">Κατηγορίες Αγγελιών</h2>
	<ul class="list-group">
		@foreach($categories as $category)
			<li class="list-group-item"><a href="{{route('ads',['title' => $category->Title])}}">{{$category->Title}}</a></li>
		@endforeach
	</ul>
@endsection