<?= $this->extend('Common/header'); ?>
<?= $this->section('content'); ?>

<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><i class="icon-home2 position-left"></i>Home
                <li class="active"><?= $data['title'] ?></li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

 <style>
 .show-password-icon {
    position: absolute;
    top: 55%;
    right: 70px;
    transform: translateY(-50%);
    cursor: pointer;
}

.show-password-icon i {
    cursor: pointer;
}

.form-group {
    position: relative;
}
</style>

    <!-- Content area -->
    <div class="content">

        <div class="col-md-6">
            <form id="change_password_form" method="POST">
                <div class="row">
                    <div class="col-md-12 col-md-offset-5">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title"><?= $data['title'] ?></h5>
                                <a class="heading-elements-toggle"><i class="icon-more"></i></a>
                            </div>

                            <div class="panel-body">
                            	<div class="row"> 
	                            	<div class="col-md-11">
	                                    <label>Enter your Current Password: </label>  
	                                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password">
	                            	</div>
	                            	<div class="col-md-1" style="margin-top: 42px;">
	                                    <div class="show-password-icon">
	                                        <i class="icon-eye" id="toggleCurrent_password"></i>
	                                    </div>
	                            	</div>

                                </div><br>

                                <div class="row"> 
                                	<div class="col-md-11">
	                                    <label>Enter your New Password:</label>
	                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
	                                </div>   
	                                <div class="col-md-1" style="margin-top: 42px;">
	                                    <div class="show-password-icon">
	                                        <i class="icon-eye" id="toggleNew_password"></i>
	                                    </div>
	                            	</div> 

                                </div><br>

                                <div class="row">
                                	<div class="col-md-11">
	                                    <label>Enter your New Confirm Password:</label>
	                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="New Confirm Password">
	                                </div>   
	                                <div class="col-md-1" style="margin-top: 42px;">
	                                	<div class="show-password-icon">
	                                        <i class="icon-eye" id="toggleConfirm_password"></i>
	                                    </div>
	                            	</div> 
	                                    
                                </div> <br>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-customize">Submit <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /content area -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.7/jquery.jgrowl.min.js"></script>
<script>
    var jq = jQuery.noConflict();

    jq(document).ready(function($) {
        // Toggle password visibility
        jq('#toggleCurrent_password').click(function() {
            var passwordInput = jq('#current_password');
            var type = passwordInput.attr('type');
            if (type === 'password') {
                passwordInput.attr('type', 'text');
                jq(this).removeClass('icon-eye').addClass('icon-eye-blocked');
            } else {
                passwordInput.attr('type', 'password');
                jq(this).removeClass('icon-eye-blocked').addClass('icon-eye');
            }
        });
        jq('#toggleNew_password').click(function() {
            var passwordInput = jq('#new_password');
            var type = passwordInput.attr('type');
            if (type === 'password') {
                passwordInput.attr('type', 'text');
                jq(this).removeClass('icon-eye').addClass('icon-eye-blocked');
            } else {
                passwordInput.attr('type', 'password');
                jq(this).removeClass('icon-eye-blocked').addClass('icon-eye');
            }
        });
        jq('#toggleConfirm_password').click(function() {
            var passwordInput = jq('#confirm_password');
            var type = passwordInput.attr('type');
            if (type === 'password') {
                passwordInput.attr('type', 'text');
                jq(this).removeClass('icon-eye').addClass('icon-eye-blocked');
            } else {
                passwordInput.attr('type', 'password');
                jq(this).removeClass('icon-eye-blocked').addClass('icon-eye');
            }
        });

        // Form validation using jQuery Validate plugin
        jq("#change_password_form").validate({
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter your current password",
                    minlength: "Password must be at least 6 characters long"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "Password must be at least 6 characters long"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    equalTo: "Passwords do not match"
                }
            },
            errorPlacement: function(error, element) {
                error.css("color", "red");
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                var fd = new FormData(jq('#change_password_form')[0]);
                jq("#loader").show();
                jq.ajax({
                    url: "<?php echo base_url('setting_change_password') ?>",
                    type: "POST",
                    data: fd,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        jq("#loader").hide();
                        if (resp == "<?= SUCCESS_CODE; ?>") {
                            jq.jGrowl({
                                header: "Your Password change successfully.",
                                theme: 'bg-success',
                                timer: 1000,
                            });
                            setTimeout(function() {
                                window.location = "<?= base_url() ?>";
                            }, 1000);
                        } else if (resp == "<?= UNAUTH_CODE; ?>") {
                            jq.jGrowl({
                                header: "Your Current Password is wrong. Please enter a valid current password.",
                                theme: 'bg-danger'
                            });
                        } else {
                            jq.jGrowl({
                                header: "<?= FAIL_MSG ?>",
                                theme: 'bg-danger'
                            });
                        }
                    }
                });
            }
        });
    });
</script>

    <?= $this->endSection(); ?>