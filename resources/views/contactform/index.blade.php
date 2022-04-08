@extends('master')
@section('content')
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Όνομα</th>
			<th>Επώνυμο</th>
			<th>E-mail</th>
			<th>Τηλέφωνο</th>
			<th>Μήνυμα</th>
			<th>Απάντηση</th>
			<th>Ενέργειες</th>
		</tr>
		@foreach($contacts as $contact)
			<tr>
				<td class="cid">{{$contact['id']}}</td>
				<td>{{$contact['Name']}}</td>
				<td>{{$contact['Surname']}}</td>
				<td>{{$contact['E-mail']}}</td>
				<td>{{$contact['Phone']}}</td>
				<td>{{$contact['Message']}}</td>
				<td>{{$contact['Answer']}}</td>
				<td><button type="button" class="btn btn-primary">Απάντηση</button></td>
			</tr>
		@endforeach
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
                    <input type="hidden" name="button_action" id="button_action" value="answer" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
	$('button').click(function(){
		$('#answerModal').modal('show');
        $('#answer_form')[0].reset();
        $('#contact_id').val()
        $('#form_output').html('');
        $('#button_action').val('Answer');
        $('#action').val('Απάντηση');
        $('.modal-title').text('Απάντηση επικοινωνίας');
	});
	$('#answer_form').on('submit',function(e){
		e.preventDefault();
		var answer_data = $(this).serialize();
		$.ajax({
			url: "{{ route('contact.answer') }}",
			method: "POST",
			data: answer_data,
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