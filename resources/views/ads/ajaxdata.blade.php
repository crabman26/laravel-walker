<!DOCTYPE html>
<html>
<head>
    <title>Datatables Server Side Processing in Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<br />
		<h3 align="center">Datatables server processing with Laravel</h3>
		<br />
		<table id="adstable" class="table table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Surname</th>
					<th>Town</th>
					<th>Region</th>
					<th>Email</th>
					<th>Description</th>
					<th>State</th>
				</tr>
			</thead>
		</table>
	</div>
	<script>
		$(document).ready(function(){
			$("#adstable").DataTable({
				"processing" : true,
				"serverSide" : true,
				"ajax": "{{route('adsajax.getdata')}}",
				"columns" : [
					{"data" : "Name"},
					{"data" : "Surname"},
					{"data" : "Town"},
					{"data" : "Region"},
					{"data" : "Email"},
					{"data" : "Description"},
					{"data" : "State"}
				]
			});
		});
	</script>
</body>
</html>