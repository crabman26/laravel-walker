@extends('master')
@section('content')
    <br />
    <h3 align="center">Επεξεργασία αγγελιών</h3>
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Προσθήκη αγγελίας</button>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <h3 align="center">Κατηγορία:</h3>
            <select class="form-control input-lg dynamic" id="Categories" name="Categories">
                <option> </option>
            </select>
            <h3 align="center">Κατάσταση:</h3>
            <input type="checkbox" name="Status" id="Active" value="Ενεργή" class="form-check-input"/>
            <label class="form-check-label" for="Active">Ενεργή</label>
            <input type="checkbox" name="Status" id="Inactive" value="Ανενεργή" class="form-check-input" style="margin-left:10px;"/>
            <label class="form-check-label" for="Inactive">Ανενεργή</label>
        </div>
        <div class="col-md-6">
            <h3 align="center">Περιφέρεια:</h3>
            <select class="form-control input-lg dynamic" id="Regions" name="Regions">
                <option> </option>
            </select>
            <h3 align="center">Δήμος:</h3>
            <select class="form-control input-lg dynamic" id="Municipalities" name="Municipalities">
            </select>
        </div>
    </div>
    <br />
    <table id="ads_table" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Τίτλος</th>
                <th>Όνομα</th>
                <th>Επώνυμο</th>
                <th>Πόλη</th>
                <th>E-mail</th>
                <th>Περιγραφή</th>
                <th>Ενέργειες</th>
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
                   <h4 class="modal-title">Εισαγωγή δεδομένων</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Τίτλος:</label>
                        <input type="text" name="Title" id="Title" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Όνομα:</label>
                        <input type="text" name="Name" id="Name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Επώνυμο:</label>
                        <input type="text" name="Surname" id="Surname" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Κατηγορία:</label>
                        <select name="Category" id="Category" class="form-control input-lg dynamic" data-dependent="category">
                            <option> </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Περιφέρεια:</label>
                        <select name="Region" id="Region" class="form-control input-lg dynamic" data-dependent="region">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Δήμος:</label>
                        <select name="Municipality" id="Municipality" class="form-control input-lg dynamic" data-dependent="municipality"></select>
                    </div>
                    <div class="form-group">
                        <label>Πόλη:</label>
                        <input type="text" name="Town" id="Town" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input type="e-mail" name="E-mail" id="E-mail" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
                    </div>
                    <div class="form-group">
                        <label>Περιγραφή:</label>
                        <textarea rows = "3" cols="3" name="Description" id="Description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Κατάσταση:</label>
                        <select name="State" id="State" class="form-control input-lg dynamic">
                            <option>Ενεργή</option>
                            <option>Ανενεργή</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                     <input type="hidden" name="ads_id" id="ads_id" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Κλείσιμο</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    getCategories();
    getRegions();
    fetch_ads();
    function fetch_ads(category = '',region = '',municipality = '',state = ''){
        $('#ads_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('adsajax.getdata') }}",
                data: {
                    category:category,
                    region:region,
                    municipality:municipality,
                    state:state,
                }
            },
            "columns":[
                { "data": "Header" },
                { "data": "Name" },
                { "data": "Surname" },
                { "data": "Town" },
                { "data": "Email" },
                { "data": "Description" },
                { "data": "action", orderable:false, searchable: false},
                { "data": "checkbox", orderable:false, searchable: false}
            ]
         });

    }

    $('#add_data').click(function(){
        $('#adsModal').modal('show');
        $('#ads_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('Insert');
        $('#action').val('Εισαγωγή');
        $('.modal-title').text('Προσθήκη αγγελίας');
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
                    $('#action').val('Εισαγωγή');
                    $('.modal-title').text('Προσθήκη αγγελίας');
                    $('#button_action').val('Insert');
                    $('#ads_table').DataTable().ajax.reload();
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        getRegions();
        getCategories();
        getMunicipalities();
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"{{ route('adsajax.fetchdata') }}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#Title').val(data.Title);
                $('#Name').val(data.Name);
                $('#Surname').val(data.Surname);
                $('#Category').val(data.Category);
                $('#Town').val(data.Town);
                $('#Municipality').val(data.Municipality);
                $('#Region').val(data.Region);
                $('#E-mail').val(data.Email);
                $('#Description').val(data.Description);
                $('#State').val(data.State);
                $('#ads_id').val(id);
                $('#adsModal').modal('show');
                $('#action').val('Επεξεργασία');
                $('.modal-title').text('Επεξεργασία αγγελίας');
                $('#button_action').val('Update');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("Είσαι σίγουρος για την διαγραφή της αγγελίας?"))
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
        if (confirm("Είσαι σίγουρος για την διαγραφη?")){
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
            alert("Παρακαλούμε επιλέξτε τουλάχιστον μια αγγελία.");
        }
    });

    $('#Region, #Regions').on('change',function(){
        var region = $(this).children("option:selected").val();
        $.ajax({
            url : "{{ route('municipalityajax.getregionmunicipality') }}",
            method: "get",
            data: {region},
            dataType: "json",
            success:function(data){
                $('#Municipality').empty();
                $('#Municipalities').empty();
                for (i=0;i<data.length;i++){
                    $('#Municipality').append($("<option></option>").text(data[i]['Name']));
                    $('#Municipalities').append($("<option></option>").text(data[i]['Name']));
                }
            }
        })
    });

    $('#Categories').on('change',function(){
        var category = $(this).children("option:selected").val();
        $('#ads_table').DataTable().destroy();
        fetch_ads(category,'','','');
    });

    $('#Regions').on('change',function(){
        var region = $(this).children("option:selected").val();
        $('#ads_table').DataTable().destroy();
        fetch_ads('',region,'','');
    });

    $('#Municipalities').on('change',function(){
        var municipality = $(this).children("option:selected").val();
        $('#ads_table').DataTable().destroy();
        fetch_ads('','',municipality,'');
    });

    $('#Active, #Inactive').on('click',function(){
        var category = $('#Categories').children("option:selected").val();
        var state = $(this).val();
        if ($(this).is(":checked")){
            if (category != ''){
                $("#ads_table").DataTable().destroy();
                fetch_ads(category,'','',state);
            } else {
                $("#ads_table").DataTable().destroy();
                fetch_ads('','','',state);
            }
        }
    });

    $('input[type="checkbox"]').on('change', function() {
       $('input[type="checkbox"]').not(this).prop('checked', false);
    });

    function getRegions(){
        $.ajax({
            url: "{{ route('regionajax.getregionlist') }}",
            method: "get",
            dataType: "json",
            success:function(data){
                for (i=0;i<data.length;i++){
                    $('#Region').append($("<option></option").text(data[i]['Title']));
                    $('#Regions').append($("<option></option").text(data[i]['Title']));
                }
            }
        });
    }

    function getCategories(){
        $.ajax({
            url: "{{ route('categoriesajax.getcategories') }}",
            method: "get",
            dataType: "json",
            success:function(data){
                for (i=0;i<data.length;i++){
                    $('#Category').append($("<option></option>").text(data[i]['Title']));
                    $('#Categories').append($("<option></option>").text(data[i]['Title']));
                }
            }
        });
    }

    function getMunicipalities(){
        $.ajax({
            url: "{{ route('municipalityajax.getmunicipalities') }}",
            method: 'get',
            dataType: "json",
            success:function(data){
                for (i=0;i<data.length;i++){
                    $('#Municipality').append($("<option></option").text(data[i]['Name']));
                }
            }
        });
    }

});
</script>
@endsection
