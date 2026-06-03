<!DOCTYPE html>
<html lang="en">
<?php echo $this->extend('Common/header_main'); ?>
<?php echo $this->section('content'); ?>
<style type="text/css">
    .bottom-border-only {
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0;
    outline: none;
    box-shadow: none;
    padding-left: 0;
    padding-right: 0;
    background: none;
}
.bottom-border-only:focus {
    background: none;
}
.position-relative {
    position: relative;
}
.table-responsive{
        overflow-x: hidden;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 70%;
    transform: translateY(-50%);
    cursor: pointer;
}
.camera-icon {
    width: 40px;
    height: 40px;
    background-color: orange;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.camera-icon i {
    color: white;
    font-size: 20px;
}
button#save_profile_button {
    background: linear-gradient(to bottom, #fa742c, #fc6515);
    width: 15%;
}
button#save_password_button {
    background: linear-gradient(to bottom, #fa742c, #fc6515);
    width: 15%;
}

.submit-section .submit-btn {
    font-size: 15px;
    font-weight: 600;
    min-width: 130px;
    border-radius: 7px;
    padding: 7px 11px;
}
</style>
   
        <div class="page-wrapper">
            <div class="content container-fluid pb-0">
                <div class="d-flex align-items-center mb-3">
                        <h4 style="font-weight: 600; font-size: 16px;">Clients</h4>
                        <div class="ms-auto d-flex gap-2">
                        <button id="addClientButton" type="button" class="btn btn-xs btn-square btn-outline-primary" style="font-size: smaller;">
                            <i class="fa fa-plus-circle" data-bs-toggle="tooltip" aria-label="fa fa-plus-circle" data-bs-original-title="fa fa-plus-circle"></i> Add
                        </button> 
                        <button id="exportClients" class="btn btn-xs btn-success">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </button>
                        </div>
                </div>
                

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                       <table class="table table-striped custom-table datatable" id="client_list">
                            <thead>
                                <tr style="background-color: orange;color: white;">
                                
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Password</th>
                                    <th>Balance</th>
                                    <th>Campaign Details</th>
                                    <th>Account Details</th>
                                    <th>T&C</th>
                                    <th>Acceptance Letter</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="modal_add_client" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="background: #f6f6f3;">
                    <div class="modal-header">
                        <h5 id="modal_title">Add Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="client_form" enctype="multipart/form-data">

                            <input type="hidden" id="id" name="id">

                            <div class="row">

                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control bottom-border-only" type="text" id="name" name="name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input class="form-control bottom-border-only" type="text" id="mobile" name="mobile">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control bottom-border-only" type="text" id="password" name="password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Balance</label>
                                    <input class="form-control bottom-border-only" type="text" id="balance" name="balance">
                                </div>
                            </div>

                           <div class="col-md-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Campaign Details</label>
                                    <textarea
                                        class="form-control"
                                        id="campaign_details"
                                        name="campaign_details"
                                        rows="5"
                                        placeholder="Enter Campaign Details"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">T&C File</label>
                                    <input class="form-control" type="file" id="tc_file" name="tc_file">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Acceptance Letter</label>
                                    <input class="form-control" type="file" id="acceptance_letter" name="acceptance_letter">
                                </div>
                            </div>

                </div>

                <div class="submit-section mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                </form>
                    </div>
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" />

        <!-- jGrowl JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

        <script type="text/javascript">
             $(document).ready(function() {
                // Add click event listener to the "Add" button
                $('#addClientButton').click(function() {
                    // Open the modal for adding client data
                    $('#modal_add_client').modal('show');
                    document.getElementById("client_form").reset();
                    $('#client_form').validate().resetForm();
                      $("#id").val("");
                 document.getElementById("modal_title").innerText = "Add Client";  
                });
            });
            
            
            $('#exportClients').on('click', function () {
            
                let table = $('#client_list').DataTable();
                let search = table.search();
            
                window.location.href =
                    "<?php echo base_url(route_to('exportClientsExcel')); ?>?search=" + encodeURIComponent(search);
            });

         $(document).ready(function () {

         let table = $('#client_list').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "<?php echo base_url(route_to('getClientsList')); ?>",
                type: "POST"
            },
            columns: [
                { data: 'name' },
                { data: 'mobile' },
                { data: 'password' },
                { data: 'balance' },

                {
                    data: 'campaign_details',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'account_details',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'tc_file',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'acceptance_letter',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [[0, 'desc']],
            language: {
                zeroRecords: "No Data Found"
            }
        });

            // Add button
            $('#addClientButton').click(function () {
                $('#client_form')[0].reset();
                $('#id').val('');
                $('#modal_title').text('Add Client');
                $('#modal_add_client').modal('show');
            });

        });

            // Delete Record

            function delete_client(id) {
                Swal.fire({
                    title: '',
                    text: 'Are you sure you want to delete this user ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF5350',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#loader").show();
                        $.ajax({
                            url: "<?php echo base_url(route_to('delete_client')); ?>",
                            type: "POST",
                            data: { id: id },
                            dataType: "json",
                            success: function(resp) {
                                console.log(resp);
                                $("#loader").hide();
                                if (resp == 1) {
                                    $.jGrowl({
                                        header: "Deleted Successfully.",
                                        theme: 'bg-success'
                                    });
                                    $('#client_list').DataTable().ajax.reload();
                                } else {
                                    $.jGrowl({
                                        header: "<?php echo FAIL_MSG; ?>",
                                        theme: 'bg-danger'
                                    });
                                }
                            }
                        });
                    } else {
                        $('#client_list').DataTable().ajax.reload();
                    }
                });
            }


            function view_client(id) {
                    document.getElementById("category_view_form").reset();
                     $('#category_view_form').validate().resetForm();
                    $(".filename").html("");
                    $("#modal_view_client").modal("show");
                    $.ajax({
                        url: "<?php echo base_url(route_to('fetchClient')); ?>",
                        type: "POST",
                        data: "id=" + id,
                        dataType: "json",
                        success: function(resp) {
                            var res = resp['response'];
                            console.log(res);
                            if (res != "") {
                                $("#name_view").val(res.name);
                                $("#phone_number_view").val(res.phoneNumber);
                                $("#email_view").val(res.email);
                                $("#address_view").val(res.address);

                               var profileImageUrl = res.profile ? "<?php echo USER_IMAGE; ?>" + res.profile : "<?php echo base_url(); ?>public/assets/img/user.jpg";
                                $("#profile_image_view").attr("src", profileImageUrl);

                            }else 
                            {

                                $.jGrowl({
                                    header: "<?php echo FAIL_MSG; ?>",
                                    theme: 'bg-danger'
                                });
                            }
                        }
                    });
                }

            function edit_client(id)
            {
                $.ajax({
                    url: "<?php echo base_url(route_to('fetchClient')); ?>",
                    type: "POST",
                    data: { id: id },
                    dataType: "json",
                    success: function (resp)
                    {
                        let res = resp.response;

                        $('#modal_add_client').modal('show');

                        $('#modal_title').text('Edit Client');

                        $('#id').val(res.id);
                        $('#name').val(res.name);
                        $('#mobile').val(res.mobile);
                        $('#email').val(res.email);

                        // Base64 Decode
                        $('#password').val(atob(res.password));

                        $('#balance').val(res.balance);
                        $('#campaign_details').val(res.campaign_details);
                    }
                });
            }
            
             $.validator.addMethod("validPhoneNumber", function(value, element) {
                // Define your phone number regex here
                // Example: Validate US phone numbers with optional country code and separators
                return this.optional(element) || /^[+]?(\d{1,3})?[-.\s]?(\(?\d{3}\)?[-.\s]?){2}\d{4}$/.test(value);
            }, "Please enter a valid phone number.");

            // Cancel Reason form insert update 
           $("#client_form").submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo base_url(route_to('addClient')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (resp) {

                        if (resp == 1) {
                            $.jGrowl("Saved Successfully", { theme: "bg-success" });

                            $('#modal_add_client').modal('hide');
                            $('#client_list').DataTable().ajax.reload();

                        } else {
                            $.jGrowl("Failed", { theme: "bg-danger" });
                        }
                    }
                });
            });

        </script>

<?php echo $this->endSection(); ?>   
