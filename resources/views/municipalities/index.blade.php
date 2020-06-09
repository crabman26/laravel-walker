@extends('master')
@section('content')
    <br />   
    <h3 align="center">Επεξεργασία Δήμων</h3>
     <br />
     <div align="right">
         <button type="button" class="btn btn-success btn-sm" id="add_data" name="add">Προσθήκη δήμου</button>
     </div>
     <br/>
     <table id="municipalitiestable" class="table table-bordered">
        <thead>
            <tr>
                <th>Όνομα</th>
                <th>
                    <select class="form-control" id="Regions" name="Regions">
                        <option>
                            Επιλέξτε Περιφέρεια
                        </option>
                    </select>
                </th>
                <th>Ενέργειες</th>
                <th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></th>
            </tr>
        </thead>
         
     </table>
     <div id="municipalitiesmodal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="municipalities_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Εισαγωγή δεδομένων</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label>Όνομα</label>
                            <input type="text" name="Name" id="Name" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Περιφέρεια</label>
                            <select name="Region" id="Region" class="form-control input-lg dynamic" data-dependent="region">
                        </div>
                        <div class="modal-footer">
                             <input type="hidden" name="municipality_id" id="municipality_id" value="" />
                            <input type="hidden" name="button_action" id="button_action" value="insert" />
                            <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
         
     </div>
    </div>
<script>
    $(document).ready(function(){
        getRegions();
        fetch_region();
        function fetch_region(region = ''){
            $('#municipalitiestable').DataTable({
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: "{{ route('municipalityajax.getdata') }}",
                    data : {region:region}
                },
                "columns":[
                   {"data": "Name"},
                   {"data": "Title", orderable:false,searchable:false},
                   { "data": "action", orderable:false, searchable: false},
                   { "data": "checkbox", orderable:false, searchable: false}
                ]
            });

        }

        $('#add_data').click(function(){
            $('#municipalitiesmodal').modal('show');
            $('#municipalities_form')[0].reset();
            $('#form_output').html('');
            $('#action').val('Προσθήκη');
            $('#button_action').val('Insert');
            $('.modal-title').text('Προσθήκη δήμου');
        });

        $('#municipalities_form').on('submit',function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "{{ route('municipalityajax.postdata') }}",
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
                        $('#municipalities_form')[0].reset();
                        $('#action').val('Προσθήκη');
                        $('#button_action').val('Insert');
                        $('.modal-title').text('Προσθήκη δήμου');
                        $('#municipalitiestable').DataTable().ajax.reload();
                    }
                }

            })
        });

        $(document).on('click','.edit',function(){
            var id = $(this).attr('id');
            getRegions();
            $('#form_output').html('');
            $.ajax({
                url: "{{ route('municipalityajax.fetchdata') }}",
                method: 'get',
                data: {id:id},
                dataType: 'json',
                success:function(data){
                    $("#Name").val(data.Name);
                    $("#Region").val(data.Region);
                    $('#municipality_id').val(id);    
                    $('#municipalitiesmodal').modal('show');
                    $('#action').val('Επεξεργασία');
                    $('.modal-title').html('Επεξεργασία στοιχείων δήμου');
                    $('#button_action').val('Update');
                }
            });
        });

        $(document).on('click','.delete',function(){
            var id = $(this).attr('id');
            $('#form_output').html('');
            if (confirm('Είσαι σίγουρος για την διαγραφή του δήμου?')){
                $.ajax({
                    url: "{{ route('municipalityajax.removedata') }}",
                    method:'get',
                    data:{id:id},
                    success:function(data){
                        alert(data);
                        $('#municipalitiestable').DataTable().ajax.reload();
                    }
                });
            }else {
                return false;
            }
        });

        $(document).on('click','#bulk_delete',function(){
            var id = [];
            if (confirm("Είστε σίγουρος για την διαγραφή των δήμων????")){
                $('.municipality_checkbox:checked').each(function(){
                    id.push($(this).val());
                });
                if (id.length > 0){
                    $.ajax({
                        url: "{{ route('municipalityajax.massremove') }}",
                        method: 'get',
                        data: {id:id},
                        success:function(data){
                            alert(data);
                            $('#municipalitiestable').DataTable().ajax.reload();
                        }
                    });                    
                }
            }else {
                alert("Επιλέξτε τουλάχιστον ένα δήμο.")
            }
        });

        $('#Regions').on('change',function(){
            var region = $(this).children("option:selected").val();
            $('#municipalitiestable').DataTable().destroy();
            fetch_region(region);
        });

        function getRegions(){
            $.ajax({
                url: "{{ route('regionajax.getregionlist') }}",
                method:"get",
                dataType: "json",
                success:function(data){
                    for (i=0;i<data.length;i++){
                        $('#Region').append($("<option></option").text(data[i]['Title']));
                        $('#Regions').append($("<option></option").text(data[i]['Title']));
                    }
                }
            });
        }
    });
</script>
@endsection