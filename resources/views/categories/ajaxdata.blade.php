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
    <h3 align="center">Category processing</h3>
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add new category</button>
    </div>
    <br />
    <table id="categories_table" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Keyword</th>
                <th>Active</th>
                <th>Action</th>
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
                   <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Enter Title:</label>
                        <input type="text" name="Title" id="Title" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Keyword:</label>
                        <input type="text" name="Keyword" id="Keyword" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Active:</label>
                        <input type="text" name="Active" id="Active" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="category_id" id="category_id" value="" />
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
     $('#categories_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('categoriesajax.getdata') }}",
        "columns":[
            { "data": "Title" },
            { "data": "Keyword" },
            { "data": "Active" },
            { "data": "action", orderable:false, searchable: false},
            { "data": "checkbox", orderable:false, searchable: false}
        ]
     });

    $('#add_data').click(function(){
        $('#categoriesModal').modal('show');
        $('#categories_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('Insert');
        $('#action').val('Add');
        $('.modal-title').text('Add Data');
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
                    $('#action').val('Add');
                    $('.modal-title').text('Add Data');
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
                $('#action').val('Edit');
                $('.modal-title').text('Edit Data');
                $('#button_action').val('Update');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this category?"))
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
        if (confirm("Are you sure about the deletion?")){
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

        }
    }); 

});
</script>
</body>
</html>
