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
    <h3 align="center">Ads processing</h3>
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add new ad</button>
    </div>
    <br />
    <table id="ads_table" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Town</th>
                <th>Region</th>
                <th>E-mail</th>
                <th>Description</th>
                <th>State</th>
                <th>Action</th>
                <th><button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button></th>
            </tr>
        </thead>
    </table>
</div>

<div id="adsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="ads_form">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Enter Name:</label>
                        <input type="text" name="Name" id="Name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Surname:</label>
                        <input type="text" name="Surname" id="Surname" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Town:</label>
                        <input type="text" name="Town" id="Town" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Region:</label>
                        <select name="region" id="region" class="form-control input-lg dynamic" data-dependent="city">
                             <option value="">Select Region</option>
                        </select>
                        <!-- <input type="text" name="Region" id="Region" class="form-control" /> -->
                    </div>
                    <div class="form-group">
                        <label>Enter E-mail:</label>
                        <input type="e-mail" name="E-mail" id="E-mail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
                    </div>
                    <div class="form-group">
                        <label>Enter Description:</label>
                        <input type="text" name="Description" id="Description" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter State:</label>
                        <input type="text" name="State" id="State" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                     <input type="hidden" name="ads_id" id="ads_id" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
     $('#ads_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('adsajax.getdata') }}",
        "columns":[
            { "data": "Name" },
            { "data": "Surname" },
            { "data": "Town" },
            { "data": "Region" },
            { "data": "Email" },
            { "data": "Description" },
            { "data": "State" },
            { "data": "action", orderable:false, searchable: false},
            { "data": "checkbox", orderable:false, searchable: false}
        ]
     });

    $('#add_data').click(function(){
        $('#adsModal').modal('show');
        $('#ads_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('Insert');
        $('#action').val('Add');
        $('.modal-title').text('Add new ad');
    });

    $('#ads_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('adsajax.postdata') }}",
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
                    $('#ads_form')[0].reset();
                    $('#action').val('Add');
                    $('.modal-title').text('Add new add');
                    $('#button_action').val('Insert');
                    $('#ads_table').DataTable().ajax.reload();
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"{{ route('adsajax.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#Name').val(data.Name);
                $('#Surname').val(data.Surname);
                $('#Town').val(data.Town);
                $('#Region').val(data.Region);
                $('#E-mail').val(data.Email);
                $('#Description').val(data.Description);
                $('#State').val(data.State);
                $('#ads_id').val(id);
                $('#adsModal').modal('show');
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
                $('#button_action').val('Update');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this ad?"))
        {
            $.ajax({
                url:"{{ route('adsajax.removedata') }}",
                method:"get",
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#ads_table').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });

    $(document).on('click', '#bulk_delete', function(){
        var id = [];
        if (confirm("Are you sure about the deletion?")){
            $('.ad_checkbox:checked').each(function(){
                id.push($(this).val());
            });
            if(id.length > 0){
                $.ajax({
                    url:"{{ route('adsajax.massremove') }}",
                    method:"get",
                    data:{id:id},
                    success:function(data){
                        alert(data);
                        $("#ads_table").DataTable().ajax.reload();
                    }
                });
            }
        } else {
            alert("Please select at least one checkbox");
        }
    }); 

});
</script>
</body>
</html>
