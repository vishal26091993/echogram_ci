<?= $this->extend('Common/header_main'); ?>

<?= $this->section('content'); ?>

<style type="text/css">
    .bottom-border-only {
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0;
    outline: none;
    box-shadow: none;
    padding-left: 0;
    padding-right: 0;
    background: #fcf9f2;
}
.bottom-border-only:focus {
    background: none;
}
.position-relative {
    position: relative;
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

</style>


    
<div class="page-wrapper">

    <div class="content container-fluid pb-0">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Account Information</h4>
                    <!-- <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul> -->
                </div>
            </div>
        </div>


        <div class="card mb-0">
    <div class="card-body" style="background: #fff;">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                       <!-- Profile Information Row -->
                    <form id="update_profile" method="post" enctype="multipart/form-data">
                    <!-- Profile Image Row -->
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <div class="profile-img-wrap edit-img" style="margin: 0;">
                                <img id="profile_image" class="inline-block" src="assets/img/profiles/avatar-02.jpg" alt="User Image">
                                <div class="fileupload btn">
                                    <div class="camera-icon">
                                        <i class="fas fa-camera"></i>
                                       <input class="upload" type="file" name="business_image" id="business_image" onchange="file_show(this)">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 

                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Name</label>
                                    <input type="text" class="form-control bottom-border-only" name="user_name" id="user_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Email ID</label>
                                    <input type="text" class="form-control bottom-border-only" name="email_id" id="email_id" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Phone Number</label>
                                    <input type="text" class="form-control bottom-border-only" name="phone_number" id="phone_number">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 22px;">
                            <div class="col-md-12 text-center">
                                <div class="input-block mb-4">
                                    <button class="btn btn-light btn-xs account-btn" type="button" id="save_cancel_button">Cancel</button>
                                    <button class="btn btn-primary btn-xs account-btn" type="button" id="save_profile_button">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-0">
    <div class="card-body" style="background: #fff;">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <!-- Change Password Row -->
                    <form id="change_password_form" method="post">
                        <div class="row" style="margin-top:10px;">
                            <h4 class="page-title" style="font-size:16px;">Change Password</h4>
                            <div class="col-md-4">
                                <div class="input-block mb-3 position-relative">
                                    <label class="col-form-label">Current Password</label>
                                    <input type="password" class="form-control bottom-border-only" name="current_password" id="current_password">
                                    <span class="fa-solid fa-eye-slash toggle-password" id="toggle-current_password" data-toggle="#current_password"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block mb-3 position-relative">
                                    <label class="col-form-label">New Password</label>
                                    <input type="password" class="form-control bottom-border-only" name="new_password" id="new_password">
                                    <span class="fa-solid fa-eye-slash toggle-password" id="toggle-new_password" data-toggle="#new_password"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-block mb-3 position-relative">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input type="password" class="form-control bottom-border-only" name="confirm_password" id="confirm_password">
                                    <span class="fa-solid fa-eye-slash toggle-password" id="toggle-confirm_password" data-toggle="#confirm_password"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 22px;">
                            <div class="col-md-12 text-center">
                                <div class="input-block mb-4">
                                    <button class="btn btn-light btn-xs account-btn" type="button" id="cancel_button">Cancel</button>
                                    <button class="btn btn-primary btn-xs account-btn" type="button" id="save_password_button">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" />

<!-- jGrowl JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script type="text/javascript">
    document.querySelectorAll('.toggle-password').forEach(item => {
    item.addEventListener('click', function () {
        let input = document.querySelector(this.getAttribute('data-toggle'));
        if (input.getAttribute('type') === 'password') {
            input.setAttribute('type', 'text');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            input.setAttribute('type', 'password');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});
</script>

     <script>
          function file_show(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profile_image').attr('src', e.target.result); // ✅ correct ID
        }
        reader.readAsDataURL(input.files[0]);
    }
}

            // fetch Data
            getData();

            function getData() {
                $.ajax({
                    url: "<?= base_url(route_to('getProfileList')) ?>",
                    type: "POST",
                    dataType: "json",
                    success: function(resp) {
                        if (resp != "") {
                            document.getElementById("user_name").value = resp.username;
                            document.getElementById("email_id").value = resp.email;
                            document.getElementById("phone_number").value = resp.phoneNumber;
                             var profileImageUrl = "<?= USER_IMAGE ?>" + resp.profileImage;
                              $("#profile_image").attr("src", profileImageUrl);
                        } else {

                        }
                    }
                });
            }

        </script>
  <script type="text/javascript">
    $(document).ready(function() {
    // Function to validate and submit the update_profile form
    function submitUpdateProfileForm() {
        var isValid = $("#update_profile").valid();
        if (isValid) {
            var fd = new FormData($('#update_profile')[0]);
            return $.ajax({
                url: "<?= base_url(route_to('update_profile')) ?>",
                type: "POST",
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false
            });
        } else {
            return $.Deferred().reject();
        }
    }

    // Function to validate and submit the change_password_form form
    function submitChangePasswordForm() {
        var isValid = $("#change_password_form").valid();
        if (isValid) {
            var fd = new FormData($('#change_password_form')[0]);
            return $.ajax({
                url: "<?= base_url('setting_change_password') ?>",
                type: "POST",
                data: fd,
                dataType: "json",
                contentType: false,
                processData: false
            });
        } else {
            return $.Deferred().reject();
        }
    }

    // Validate the update_profile form
    $("#update_profile").validate({
        rules: {
            user_name: {
                required: true,
            },
            email_id: {
                required: true,
                email: true
            },
            phone_number: {
                required: true,
                digits: true
            }
        },
        messages: {
            user_name: {
                required: "Please enter your username",
            },
            email_id: {
                required: "Please enter your email",
                email: "Please enter a valid email address"
            },
            phone_number: {
                required: "Please enter your phone number",
                digits: "Please enter only digits"
            }
        },
        errorPlacement: function(error, element) {
            error.css("color", "red");
            error.insertAfter(element);
        }
    });

    // Validate the change_password_form form
    $("#change_password_form").validate({
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
                required: "Please enter your current password"
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
        }
    });

    // Handle the click event of the save_profile_button
    $("#save_profile_button").click(function() {
        submitUpdateProfileForm().then(function(updateResp) {
            if (updateResp == "<?= SUCCESS_CODE; ?>") {
                $.jGrowl("Profile Updated Successfully.", {theme: 'bg-success'});
                setTimeout(() => { window.location.reload(); }, 1000);
            } else {
                $.jGrowl("Something went wrong with profile update!", {theme: 'bg-danger'});
            }
        }).fail(function() {
            // Handle validation failure or other failures
        });
    });

    // Handle the click event of the save_password_button
    $("#save_password_button").click(function() {
        submitChangePasswordForm().then(function(changePassResp) {
            if (changePassResp == "<?= SUCCESS_CODE; ?>") {
                $.jGrowl("Password Updated Successfully.", {theme: 'bg-success'});
                setTimeout(() => { window.location.reload(); }, 1000);
            } else if (changePassResp == "<?= UNAUTH_CODE; ?>") {
                $.jGrowl("Your Current Password is wrong.", {theme: 'bg-danger'});
            } else {
                $.jGrowl("Something went wrong with password update!", {theme: 'bg-danger'});
            }
        }).fail(function() {
            // Handle validation failure or other failures
        });
    });
});

  </script>      
<?= $this->endSection(); ?>           