@extends('main.master')
@section('content')
<div class="col-md-5" id="searchbar">
    <input class="form-control" type="text" placeholder="Αναζήτηση κατηγορίας" id="search">
    <div id="categorylist"></div>
    {{ csrf_field() }}
</div>
<h2 align="center">Κατηγορίες Αγγελιών</h2>
	<div id="categories">
		<ul class="list-group">
			@foreach($categories as $category)
				<li class="list-group-item"><a href="{{route('ads',['title' => $category->Title])}}">{{$category->Title}}</a></li>
			@endforeach
		</ul>
		{{ $categories->links() }}
	</div>
	<div id="result">
		<ul class="list-group">
			<li class="list-group-item"><a href="" id="search-result"></a></li>
		</ul>
	</div>
<script>
	$('#search').keyup(function(){
		var query = $(this).val();
		var _token = $('input[name="_token"]').val();
		$.ajax({
			url:"{{ route('categoriesajax.fetchresult') }}",
			method: "POST",
			data:{query:query, _token:_token},
			success:function(data){
				$('#categorylist').fadeIn();  
            	$('#categorylist').html(data);
			}
		});	
	});


	$(document).on('click', '.search-result', function(){  
        	var category = $(this).text();
        	$('#categorylist').fadeOut();
        	$('#categories').css("display","none");
        	$('#result').css("display","block");
        	$('#search-result').html(category);
        	$('#search-result').attr("href","{{route('ads',['title' => ""])}}"+'/'+category);
    });  

</script>
@endsection
