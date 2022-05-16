@extends('master')
@section('content')
<table class="table table-bordered" id="contacts_table">
	<thead>
		<tr>
			<th>Όνομα</th>
			<th>Επώνυμο</th>
			<th>E-mail</th>
			<th>Τηλέφωνο</th>
			<th>Μήνυμα</th>
			<th>Απάντηση</th>
			<th>Ενέργειες</th>
		</tr>
		
	</thead>
</table>
<div id="answerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="answer_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Απάντηση φόρμας επικοινωνίας</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Κείμενο:</label>
                        <textarea id="text" name="text" rows="4" cols="50" class="form-control">
							
						</textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
   					<input type="hidden" name="contact_id" id="contact_id" value="" />
                    <input type="submit" name="submit" id="action" value="Αποστολή" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		fetch_contacts();

		function fetch_contacts(){
			$("#contacts_table").DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": {
					url: "{{ route('contact.getdata')}}",

				},
				"columns":[
					{"data": "Name"},
					{"data": "Surname"},
					{"data": "E-mail"},
					{"data": "Phone"},
					{"data": "Message"},
					{"data": "Answer"},
					{ "data": "action", orderable:false, searchable: false},

				]
			})
		}
	});
	$(document).on('click','.edit',function(){
		var id = $(this).attr("id");
		$('#answerModal').modal('show');
        $('#answer_form')[0].reset();
        $('#form_output').html('');
        $('#contact_id').val(id);
        $('.modal-title').text('Απάντηση επικοινωνίας');
	});
	$('#answer_form').on('submit',function(e){
		e.preventDefault();
		var answer_data = $(this).serialize();
		console.log(answer_data);
		var id = $('#contact_id').val();
		var _token = $('input[name="_token"]').val();
		$.ajax({
			url: "{{ route('contact.answer') }}",
			method: "POST",
			data: {
				answer_data: answer_data,
				id : id,
				_token: _token,
			},
			dataType: "json",
			success:function(data){
				if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                }
                else
                {
                    $('#form_output').html(data.success);
                   
                }
			}
		})

	})
</script>
@endsection