@extends('master')
@section('content')
<br />
<h3 align="center">Επεξεργασία περιφερειών</h3>
<br />
<div align="right">
	<button type="button" name="add" id="add_region" class="btn btn-success btn-sm">Προσθήκη περιφέρειας</button>
</div>
<table id="regions_table" class="table table-bordered">
	<thead>
		<tr>
			<th>Όνομα</th>
			<th>Ενέργειες</th>
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
					<h4 class="modal-title">Προσθήκη περιφέρειας</h4>
				</div>
				<div class="modal-body">
					{{csrf_field()}}
					<span id="form-output"></span>
					<div class="form-group">
						<label>Όνομα:</label>
						<input type="text" name="Name" id="Name" class="form-control"/>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="button_action" id="button_action" value="insert" />
						<input type="hidden" id="region_id" name="region_id"/>
						<input type="submit" name="submit" id="action" class="btn btn-info" value="Εισαγωγή"/>
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
			{"data" : "Title"},
			{"data" : "action", orderable:false, searchable: false},
			{"data" : "checkbox", orderable:false, searchable: false},
		]
	})
});

$('#add_region').on('click',function(){
	$('#regionModal').modal('show');
	$('#region_form')[0].reset();
	$('#form-output').html('');
	$('#action').val('Προσθήκη');
	$('#button_action').val('Insert');
	$('.modal-title').text('Προσθήκη περιφέρειας');
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
				$('#action').val('Προσθήκη');
				$('#button_action').val('Insert');
				$('.modal-title').text('Προσθήκη περιφέρειας');
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
		    success:function(data){
		        $('#Name').val(data.Name);
		        $('#region_id').val(id);
		        $('#regionModal').modal('show');
		        $('#action').val('Επεξεργασία');
		        $('.modal-title').text('Επεξεργασία περιφέρειας');
		        $('#button_action').val('Update');
		    }
		})
});

$(document).on('click', '.delete', function(){
	var id = $(this).attr("id");
		if (confirm("Είσαι σίγουρος για την διαγραφή της περιφέρειας?")){
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
	if (confirm("Είσαι σίγουρος για την διαγραφή?")){
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
			alert('Επιλέξτε τουλάχιστον μια περιφέρεια.');
		}
	});
</script>
@endsection
	