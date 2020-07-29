@extends('main.master')
@section('content')
  <div class="col-md-12">
  	<h3 align="center">Φίλτρα Αναζήτησης</h3>
  	<div class="col-md-5">
	  <div class="form-group">
	        <input type="text" name="keyword_name" id="keyword_name" class="form-control" placeholder="Εισάγετε την λέξη κλειδί της κατηγορίας" />
	            <div id="KeywordList">
	        </div>
	   </div>
	   {{ csrf_field() }}
  	</div>
  	<div class="col-md-5">
	   <div class="form-group">
	        <input type="text" name="area_name" id="area_name" class="form-control" placeholder="Εισάγετε τον δήμο της αγγελίας" />
	            <div id="AreaList">
	        </div>
	   </div>
	   {{ csrf_field() }}
  	</div>
  </div>
<h2 align="center">Κατηγορίες Αγγελιών</h2>
	<ul class="list-group">
		@foreach($categories as $category)
			<li class="list-group-item"><a href="{{route('ads',['title' => $category->Title])}}">{{$category->Title}}</a></li>
		@endforeach
	</ul>
@endsection
