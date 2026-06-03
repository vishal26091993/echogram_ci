<?= $this->extend('Common/header'); ?>
<?= $this->section('content'); ?>

<div class="content-wrapper">

    <div class="page-header page-header-default">

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><i class="icon-home2 position-left"></i>Home
                <li class="active"><?= $data['title'] ?></li>
            </ul>
        </div>
    </div>

    <div class="content">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"><?= $data['title'] ?></h5>
           
            </div>
            <div class="panel-body table-responsive">
                <table class="table datatable-selection-single" id="category_list"  style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>   
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Of Birth</th>
                            <th>Is Email Verified</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


        <?= $this->include('Common/footer') ?>
    </div>

    <script>

        $(".product_category").addClass("active");

        function file_show(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_show').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

         function file_show_icon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_show_icon').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#btn_product_size").on('click', function() {
            document.getElementById('category_form').reset();
            $("#modal_product_category").modal("show");
            $("#image_show").attr("src", "assets/images/placeholder.jpg");
            $(".filename").html("");
        })


        // Business Category list table view
        loadData();
        function loadData() {
            $('#category_list').DataTable({
                'processing': false,
                'serverSide': true,
                "oLanguage": {
                    "sZeroRecords": "No Data Found"
                },
                'serverMethod': 'post',
                'ajax': {
                    'url': '<?= base_url(route_to('getUsersList')) ?>'
                },
                "order": [
                    ['0', 'desc']
                ],
                'columns': [
                    {
                        data: 'id',
                        visible: false
                    },
                    {
                        data: 'profile',
                        orderable: false,
                        searchable: false,
                        width: '100px'
                    },
                    {
                        data: 'name', 
                        width: '300px'
                    },
                    {
                        data: 'email',
                        width: '300px'
                    },
                    {
                        data: 'date_of_birth',
                        width: '200px'
                    },
                    {
                        data: 'is_verified',
                        width: '100px'
                    },
                    {
                        data: 'is_active',
                        width: '100px'
                    },
                    {
                        data: 'action',
                        orderable: false,
                         width: '200px',
                        searchable: false,
                        className: "text-center"
                    }
                ],
                initComplete: function () {
                    $('.dataTables_length select').select2({
                            minimumResultsForSearch: Infinity
                    });
                    $('.dataTables_length .select2').addClass('w-auto');
                }
            });
        }



        // Delete Record
        function block_user(id) {
            swal({
                    title: "",
                    text: "Are you sure you want to change this user status?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#EF5350",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $("#loader").show();
                        $.ajax({
                            url: "<?php echo base_url(route_to('deactivate_user')) ?>",
                            type: "POST",
                            data: "id=" + id,
                            dataType: "json",
                            success: function(resp) {
                                console.log(resp);
                                $("#loader").hide();
                                swal.close();
                                if (resp == 1) {
                                    $.jGrowl({
                                        header: "Update Successfully.",
                                        theme: 'bg-success'
                                    });
                                    $('#category_list').DataTable().ajax.reload();
                                } else {
                                    $.jGrowl({
                                        header: "<?= FAIL_MSG ?>",
                                        theme: 'bg-danger'
                                    });
                                }
                            }
                        });
                    } else {
                        swal.close();
                        $('#category_list').DataTable().ajax.reload();
                    }
                });
        }

    </script>

    <?= $this->endSection(); ?>