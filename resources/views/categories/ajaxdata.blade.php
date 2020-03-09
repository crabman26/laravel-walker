<!DOCTYPE html>
<html>
<head>
    <title>Σελίδα επεξεργασίας κατηγοριών</title>
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
            <li><a href="{{route('adsajax')}}">Αγγελίες</a></li>
            <li><a href="{{route('categoriesajax')}}">Κατηγορίες</a></li>
            <li><a href="{{route('regionajax')}}">Περιφέρειες</a></li>
            <li><a href="{{route('municipalityajax')}}">Δήμοι</a></li>
        </ul>
    </nav>
    <br />
    <h3 align="center">Επεξεργασία κατηγοριών</h3>
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Προσθήκη κατηγορίας</button>
    </div>
    <div class="col-md-4">
        <h3 align="center">Ενεργή</h3>
        <input type="checkbox" name="Status" id="Active" class="form-check-input" value="Ναι"/>
        <label for="Active" class="form-check-label">Ναι</label>
        <input type="checkbox" name="Status" id="Inactive" class="form-check-input" style="margin-left:10px;" value="Όχι"/>
        <label for="Inactive" class="form-check-label">Όχι</label>
    </div>
    <br />
    <table id="categories_table" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Τίτλος</th>
                <th>Keyword</th>
                <th>Ενέργειες</th>
                <th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></th>
            </tr>
        </thead>
    </table>
</div>

<div id="categoriesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="categories_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Προσθήκη δεδομένων</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Τίτλος:</label>
                        <input type="text" name="Title" id="Title" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Keyword:</label>
                        <input type="text" name="Keyword" id="Keyword" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Ενεργή:</label>
                        <select name="Active" id="Active" class="form-control input-lg dynamic">
                            <option>Ναι</option>
                            <option>Όχι</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" id="category_id" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    fetch_categories();
    function fetch_categories(active = ''){

     $('#categories_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "{{ route('categoriesajax.getdata') }}",
            data: {
                active:active
            }
        },
        "columns":[
            { "data": "Title" },
            { "data": "Keyword" },
            { "data": "action", orderable:false, searchable: false},
            { "data": "checkbox", orderable:false, searchable: false}
        ]
     });
    }

    $('#add_data').click(function(){
        $('#categoriesModal').modal('show');
        $('#categories_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('Insert');
        $('#action').val('Προσθήκη');
        $('.modal-title').text('Προσθήκη κατηγορίας');
    });

    $('#categories_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('categoriesajax.postdata') }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
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
                    $('#categories_form')[0].reset();
                    $('#action').val('Εισαγωγή');
                    $('.modal-title').text('Προσθήκη κατηγορίας');
                    $('#button_action').val('Insert');
                    $('#categories_table').DataTable().ajax.reload();
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"{{ route('categoriesajax.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#Title').val(data.Title);
                $('#Keyword').val(data.Keyword);
                $('#Active').val(data.Active);
                $('#category_id').val(id);
                $('#categoriesModal').modal('show');
                $('#action').val('Επεξεργασία');
                $('.modal-title').text('Επεξεργασία κατηγορίας');
                $('#button_action').val('Update');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Είσαι σίγουρος για την διαγραφή της κατηγορίας?"))
        {
            $.ajax({
                url:"{{ route('categoriesajax.removedata') }}",
                method:"get",
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#categories_table').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });

    $(document).on('click','#bulk_delete',function(){
        var id = [];
        if (confirm("Είσαι σίγουρος για την διαγραφή?")){
            $('.category_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            $.ajax({
                url: "{{ route('categoriesajax.massremove') }}",
                method:"get",
                data:{id:id},
                success:function(data){
                    alert(data);
                    $('#categories_table').DataTable().ajax.reload();
                }
            });
        }else {
            alert('Επιλέξτε τουλάχιστον μια κατηγορία.');
        }
    });

    $('#Active, #Inactive').on('click',function(){
        if ($(this).is(':checked')){
            var active = $(this).val();
            $("#categories_table").DataTable().destroy();
            fetch_categories(active);
        }
    });

    $('input[type="checkbox"]').on('change', function() {
       $('input[type="checkbox"]').not(this).prop('checked', false);
    }); 

});
</script>
</body>
</html>
