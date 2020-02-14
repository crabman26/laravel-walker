<!DOCTYPE html>
<html>
	<head>
		<title>Region Processing</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>       
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style>
		    nav ul li{
		        display: inline-block;
		    }
		</style>
	</head>
	<body>
	<div class="container">
		<nav>
		    <ul>
		        <li><a href="{{route('adsajax')}}">Ads</a></li>
		        <li><a href="{{route('categoriesajax')}}">Categories</a></li>
		        <li><a href="{{route('regionajax')}}">Regions</a></li>
		    </ul>
		</nav>
		<br />
		<h3 align="center">Region Processing</h3>
		<br />
		<div align="right">
			<button type="button" name="add" id="add_region" class="btn btn-success btn-sm">Add Region</button>
		</div>
		<table id="regions_table" class="table table-bordered">
			<thead>
				<tr>
				<th>Name</th>
				<th>Action</th>
				<th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></th>	
				</tr>
			</thead>
		</table>
	</div>	
		<div id="regionModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" id="region_form">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add Region</h4>
						</div>
						<div class="modal-body">
							{{csrf_field()}}
							<span id="form-output"></span>
							<div class="form-group">
								<label>Enter Name:</label>
								<input type="text" name="Name" id="Name" class="form-control"/>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="button_action" id="button_action" value="insert" />
								<input type="hidden" id="region_id" name="region_id"/>
								<input type="submit" name="submit" id="action" class="btn btn-info" value="Add"/>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<script>
		$(document).ready(function(){
			$('#regions_table').DataTable({
				"processing" : true,
				"serverside" : true,
				"ajax": "{{ route('regionajax.getdata') }}",
				"columns" : [
					{"data" : "Name"},
					{"data" : "action", orderable:false, searchable: false},
					{"data" : "checkbox", orderable:false, searchable: false},
				]
			})
		});

		$('#add_region').on('click',function(){
			$('#regionModal').modal('show');
			$('#region_form')[0].reset();
			$('#form-output').html('');
			$('#action').val('Add');
			$('#button_action').val('Insert');
			$('.modal-title').text('Add new Region');
		});

		$('#region_form').on('submit',function(event){
			event.preventDefault();
			var form_data = $(this).serialize();
			$.ajax({
				url: "{{ route('regionajax.postdata') }}",
				method: "POST",
				data : form_data,
				dataType: "json",
				success: function(data){
					if (data.error.length > 0){
						var error_html = '';
						for (var count = 0; count < data.error.length; count ++) {
							error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
						}
						$('#form_output').html(error_html);
					} else {
						$('#form_output').html(data.sucess);
						$('#region_form')[0].reset();
						$('#action').val('Add');
						$('#button_action').val('Insert');
						$('.modal-title').text('Add new Region');
						$('#regions_table').DataTable().ajax.reload();
					}
				}

			})
		});

		$(document).on('click', '.edit', function(){
		    var id = $(this).attr("id");
		    $('#form_output').html('');
		    $.ajax({
		        url:"{{ route('regionajax.fetchdata') }}",
		        method:'get',
		        data:{id:id},
		        dataType:'json',
		        success:function(data)
		        {
		            $('#Name').val(data[0].Name);
		            $('#region_id').val(id);
		            $('#regionModal').modal('show');
		            $('#action').val('Edit');
		            $('.modal-title').text('Edit Region');
		            $('#button_action').val('Update');
		        }
		    })
		});

		$(document).on('click', '.delete', function(){
			var id = $(this).attr("id");
			if (confirm("Are you sure you want to delete this region?")){
				$.ajax({
					url: "{{ route('regionajax.removedata') }}",
					method: 'get',
					data:{id:id},
					success:function(data){
						alert(data);
						$('#regions_table').DataTable().ajax.reload();
					}
				});
			} else{	
				return false;
			}
		});

		$(document).on('click', '#bulk_delete', function(){
			var id = [];
			if (confirm("Are you sure about the deletion?")){
				$('.region_checkbox:checked').each(function(){
					id.push($(this).val());
				});
				if (id.length > 0) {
					$.ajax({
						url: "{{ route('regionajax.massremove') }}",
						method: 'get',
						data: {id:id},
						success: function(data){
							alert(data);
							$('#regions_table').DataTable().ajax.reload();
						}
					});

				}
			} else {
				alert('Please choose at least one checkbox');
			}
		});
	</script>
	</body>
</html>