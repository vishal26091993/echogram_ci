<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Trade Logic">
<meta name="keywords" content="Trade Logic">
<meta name="author" content="Trade Logic">
<title><?= 'Trade Logic - ' . $data['title']; ?></title>

<link rel="icon" type="image/png" href="<?php echo base_url(); ?>public/assets/images/circle_logo.png">

<link rel="stylesheet" href="<?= ASSET_URL."assets/css/bootstrap.min.css"?>">

<link rel="stylesheet" href="<?= ASSET_URL."assets/plugins/fontawesome/css/fontawesome.min.css"?>">
<link rel="stylesheet" href="<?= ASSET_URL."assets/plugins/fontawesome/css/all.min.css"?>">

<link rel="stylesheet" href="<?= ASSET_URL."assets/css/line-awesome.min.css"?>">
<link rel="stylesheet" href="<?= ASSET_URL."assets/css/material.css"?>">

<link rel="stylesheet" href="<?= ASSET_URL."assets/css/line-awesome.min.css"?>">

<link rel="stylesheet" href="<?= ASSET_URL."assets/css/style.css"?>">
<script src="<?= ASSET_URL."assets/js/bootstrap.bundle.min.js" ?>" type="86920c3c0e7f629de492d26d-text/javascript"></script>

<script src="<?= ASSET_URL."assets/js/app.js" ?>" type="86920c3c0e7f629de492d26d-text/javascript"></script>
<script src="<?= ASSET_URL."assets/rocket-loader.min.js "?>" data-cf-settings="86920c3c0e7f629de492d26d-|49" defer></script>

</head>
<style>
.position-relative {
    position: relative;
}

.fa-solid {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

#email_id {
    padding-right: 30px; /* Adjust spacing for icon */
    padding-left: 30px; 
}

#password {
    padding-right: 30px; /* Adjust spacing for icon */
    padding-left: 30px; /* Add some padding for text */
}

#toggle-password {
    right: 10px; /* Adjust position to the right */
}

.account-btn {
    width: auto; /* Allow button to adjust its width */
    margin: 0 auto; /* Center button horizontally */
}

.account-box {
    border-bottom: 1px solid #000; /* Bottom border */
}

.form-control {
    border-top: none;
    border-left: none;
    border-right: none;
    border-radius: 0; /* Optional: Remove border radius */
}

#email_id,
#password {
    border-bottom: 1px solid #cecece; /* Add bottom border */
    /* Optional: Adjust padding for icon */
    padding-right: 30px; /* for email */
    padding-right: 45px; /* for password */
}

.orange-border-bar {
    height: 5px;
    background-color: #f7681c;
    width: 43%;
    margin-bottom: 5px;
    border-radius: 50px;
}
.fa-solid {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: #f7681c;
}

</style>
<body class="account-page" style="background: #fefef9;">
<div class="main-wrapper">
    <div class="account-content">
        <div class="container">

      
                
            <div class="row"> 
    
                <div class="col-md-6">
                    <div class="account-box">
                        <center><div class="orange-border-bar"></div> </center>
                        <div class="account-wrapper">
                                  <div class="row"> 
                                    <div class="account-logo">
                                        <a href="#"><img src="<?php echo base_url(); ?>public/assets/images/circle_logo.png" alt="Shree-construction" style="float:none;width:175px;"></a>
                                    </div>
                                </div>
                           <center> <h3 class="account-title">Password recovery </h3>
                             <h6>We'll send you instructions in email</h6> </center>

                             <form id="recovery_form" method="POST" style="margin-top:25px;">
                                <div class="input-block mb-4">
                                    <label class="col-form-label">Email Id</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-envelope"></i>
                                       <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Your email" required>
                                       <div class="form-control-feedback">
											<i class="icon-mail5 text-muted"></i>
										</div>
                                    </div>
                                </div>

                                <div class="input-block mb-4 text-center">
                                    <button class="btn btn-primary btn-xs account-btn" type="submit">Reset password</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?= ASSET_URL."assets/js/jquery-3.7.1.min.js" ?>" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" />

<!-- jGrowl JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>
<script>
        $(document).ready(function() {
            $("#recovery_form").submit(function(event) {
                event.preventDefault(); // Prevent default form submission
  
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "<?php echo base_url('password_recovery') ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                    	if (resp == "400") {
                            $.jGrowl({
                                header: "Please enter correct email id. Admin email id not mathced.",
                                theme: 'bg-danger'
                            });
                            document.getElementById("recovery_form").reset();
                        }
                        else if (resp == "<?= SUCCESS_CODE; ?>") {
                            $.jGrowl({
                                header: "Please check your e-mail, we have sent a password reset link to your registered email.",
                                theme: 'bg-warning'
                            });
                            document.getElementById("recovery_form").reset();
                        } else {
                            $.jGrowl({
                                header: "<?= FAIL_MSG ?>",
                                theme: 'bg-danger'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                    }
                });
            });
        });
    </script>
</body>
</html>