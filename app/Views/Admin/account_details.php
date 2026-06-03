<?php echo $this->extend('Common/header_main'); ?>
<?php echo $this->section('content'); ?>

<style>
    .col-md-3 {
        margin-bottom: 10px;
}
</style>
<div class="page-wrapper">

    <div class="content container-fluid">

        <div class="card">

            <div class="card-header">

                <h4>
                    Account Details  :  
                </h4>
                <h4>
                       Campaign Details  : <?php echo esc($client['campaign_details']); ?>
</h4>

            </div>
<div class="card-body">

    <div class="row">

        <div class="col-md-3">
            <div class="border rounded p-3 bg-light h-100">
                <div class="text-muted small mb-1">
                    Mobile Number
                </div>

                <div class="fw-bold fs-6">
                    <?php echo esc($client['mobile']); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="border rounded p-3 bg-light h-100">
                <div class="text-muted small mb-1">
                    Password
                </div>

                <div class="fw-bold fs-6">
                    <?php echo esc($client['password']); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="border rounded p-3 bg-light h-100">
                <div class="text-muted small mb-1">
                    Balance
                </div>

                <div class="fw-bold fs-6 text-success">
                    ₹ <?php echo number_format($client['balance'], 2); ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="border rounded p-3 bg-light h-100">
                <div class="text-muted small mb-1">
                    Client ID
                </div>

                <div class="fw-bold fs-6">
                    #<?php echo $client['id']; ?>
                </div>
            </div>
        </div>

    </div>

</div>

            <div class="card mt-3">

    <div class="card-header d-flex justify-content-between">

        <h4>Contact Lists</h4>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#listModal">

            Create New List

        </button>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>List Name</th>
                    <th>Total Numbers</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($lists as $row) { ?>

                <tr>

                    <td>
                        <?php echo esc($row['list_name']); ?>
                    </td>

                    <td>
                        <?php echo $row['total_numbers']; ?>
                    </td>

                  <td>

                        <button
                            class="btn btn-info btn-sm"
                            onclick="viewNumbers(<?php echo $row['id']; ?>)">
                            View
                        </button>

                        <!-- <button
                            class="btn btn-primary btn-sm"
                            onclick="editList(<?php echo $row['id']; ?>)">
                            Edit
                        </button> -->

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="deleteList(<?php echo $row['id']; ?>)">
                            Delete
                        </button>

                        </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

        </div>

    </div>

</div>
<div class="modal fade" id="listModal">

<div class="modal-dialog">

<div class="modal-content">

<form
id="listForm"
enctype="multipart/form-data">

<div class="modal-header">

<h5>Create New List</h5>

</div>

<div class="modal-body">

    <input type="hidden"
           name="client_id"
           value="<?php echo $client['id']; ?>">

    <div class="mb-3">
        <label>List Name</label>
        <input type="text"
               name="list_name"
               class="form-control"
               required>
    </div>

    <div class="mb-3">

        <label class="fw-bold">
            Import Method
        </label>

        <div class="form-check">
            <input class="form-check-input"
                   type="radio"
                   name="import_type"
                   value="manual"
                   checked>

            <label class="form-check-label">
                Comma Separated Numbers
            </label>
        </div>

        <div class="form-check">
            <input class="form-check-input"
                   type="radio"
                   name="import_type"
                   value="excel">

            <label class="form-check-label">
                Excel / CSV Upload
            </label>
        </div>

    </div>

    <div id="manual_block">

        <label>Mobile Numbers</label>

        <textarea name="mobile_numbers" class="form-control" rows="8" placeholder="9876543210,9988776655,8877665544">
        </textarea>

    </div>

    <div id="excel_block" style="display:none">

        <label>Select Excel/CSV</label>

        <input type="file"
               name="file"
               class="form-control"
               accept=".csv,.xls,.xlsx">

    </div>

</div>

<div class="modal-footer">

<button
type="submit"
class="btn btn-primary">

Save

</button>

</div>

</form>

</div>

</div>

</div>

<!-- ------------------- -->
<div class="modal fade"
     id="numbersModal"
     tabindex="-1">

     <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Contact Numbers
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <button
                        class="btn btn-danger"
                        onclick="deleteSelectedNumbers()">

                        Delete Selected

                    </button>

                    <button
                        class="btn btn-success"
                        onclick="showAddNumbersModal()">

                        Add Numbers

                    </button>

                </div>

              <div
                id="numbersTableArea"
                style="max-height:500px; overflow-y:auto;">
            </div>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="addNumbersModal">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <form id="addNumbersForm">

                <div class="modal-header">
                    <h5>Add Numbers</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                           id="selected_list_id"
                           name="list_id">

                    <label>
                        Mobile Numbers
                    </label>

                  <textarea
                    class="form-control"
                    rows="15"
                    name="numbers"
                    placeholder="9876543210,9988776655">
                </textarea>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-success">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script>

    $('#listForm').submit(function(e) {

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '<?php echo base_url('admin/create-contact-list'); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                console.log(res);
                if (res.status == 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    location.reload();

                } else {
                      console.log(res);
                    Swal.fire({
                    icon: 'danger',
                    title: 'Error',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                }

            }
        });

    });

    function deleteList(id) {

        if (confirm('Are you sure you want to delete this list?')) {

            $.ajax({
                url: '<?php echo base_url('admin/delete-contact-list'); ?>',
                type: 'POST',
                data: { id: id },
                success: function(res) {

                    if (res.status == 'success') {
  console.log(res);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();

                    } else {
                        console.log(res);
                        Swal.fire({
                            icon: 'danger',
                            title: 'Error',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }

                }
            });

        }

    }
    $('input[name="import_type"]').change(function(){

    if($(this).val() == 'manual')
    {
        $('#manual_block').show();
        $('#excel_block').hide();
    }
    else
    {
        $('#manual_block').hide();
        $('#excel_block').show();
    }

});

let currentListId = 0;

function viewNumbers(listId)
{
    currentListId = listId;

    $.ajax({

        url:"<?php echo base_url('admin/get-contact-list-numbers'); ?>",

        type:"POST",

        data:{
            list_id:listId
        },

        success:function(html)
        {
            $('#numbersTableArea').html(html);

            $('#numbersModal').modal('show');
        }

    });
}

$(document).on(
'change',
'#select_all',
function(){

    $('.number_checkbox')
        .prop(
            'checked',
            $(this).prop('checked')
        );

});

function deleteSelectedNumbers()
{
    let ids = [];

    $('.number_checkbox:checked')
        .each(function(){

            ids.push($(this).val());

        });

    if(ids.length == 0)
    {
       // alert('Select numbers');
        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Select numbers',
                            timer: 1500,
                            showConfirmButton: false
                        });

        return;
    }

    $.ajax({

        url:"<?php echo base_url('admin/delete-selected-numbers'); ?>",

        type:"POST",

        data:{
            ids:ids
        },

        success:function()
        {
            viewNumbers(currentListId);
        }

    });
}
function showAddNumbersModal()
{
    $('#selected_list_id').val(currentListId);

    $('#addNumbersModal').modal('show');
}
$('#addNumbersForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url:"<?php echo base_url('admin/add-contact-numbers'); ?>",

        type:"POST",

        data:$(this).serialize(),

        dataType:"json",

        success:function(res)
        {
            $('#addNumbersModal').modal('hide');

            Swal.fire({
                icon:'success',
                title:'Success',
                text:res.message,
                timer:1500,
                showConfirmButton:false
            });

            viewNumbers(currentListId);
        }

    });

});

function deleteNumber(id)
{
    Swal.fire({
        title: 'Delete Number?',
        text: 'This number will be removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
    }).then((result) => {

        if (!result.isConfirmed)
        {
            return;
        }

        $.ajax({

            url: "<?php echo base_url('admin/delete-contact-number'); ?>",

            type: "POST",

            data: {
                id: id
            },

            dataType: "json",

            success: function(res)
            {
                if(res.status == 'success')
                {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    viewNumbers(currentListId);
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message
                    });
                }
            }

        });

    });
}
    </script>
<?php echo $this->endSection(); ?>