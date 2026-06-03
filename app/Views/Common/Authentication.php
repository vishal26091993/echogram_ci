<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Shree-Construction">
<meta name="keywords" content="Shree-Construction">
<meta name="author" content="Shree-Construction">
<title><?= 'Shree-Construction - ' . $data['title']; ?></title>

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
                    <img src="<?php echo base_url(); ?>public/assets/images/loginimage.png" alt="Shree-Construction">
                </div>
                <div class="col-md-6">
        
                    <div class="account-box">
                        <center><div class="orange-border-bar"></div> </center>
                        <div class="account-wrapper">
                            <div class="row">
                              <div class="account-logo">
                            <a href="#"><img src="<?php echo base_url(); ?>public/assets/images/circle_logo.png" alt="Shree-Construction" style="float: none;width: 175px;"></a>
                        </div></div>
                            <h3 class="account-title">Login</h3>

                             <form id="login_form" method="POST">
                                <div class="input-block mb-4">
                                    <label class="col-form-label">Email Id</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email Id">
                                    </div>
                                </div>

                                <div class="input-block mb-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label class="col-form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-lock"></i>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                                    </div>
                                </div>

                               <!--<div class="row align-items-center mb-4">-->
                               <!--     <div class="col">-->
                               <!--         <div class="row">-->
                
                               <!--             <div class="col-auto ml-auto" style="margin-left: 65px;">-->
                               <!--                 <a class="text-muted" style="color: #000 !important;font-size: 13px;" href="<?= base_url(route_to("recover_password")) ?>">Forgot password?</a>-->
                               <!--             </div>-->
                               <!--         </div>-->
                               <!--     </div>-->
                               <!-- </div>-->

                                <div class="input-block mb-4 text-center">
                                    <button class="btn btn-primary btn-xs account-btn" type="submit">Login</button>
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
<!-- jGrowl CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" />

<!-- jGrowl JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

<script>
        $(document).ready(function() {
            $("#login_form").submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                var formData = new FormData($(this)[0]);
                formData.append('time_zone', timezone);

                formData.append('remember_me', $('#remember_me').is(':checked') ? '1' : '0');

                $.ajax({
                    url: "<?php echo base_url('user_login') ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        
                         var resp = response;
                          console.log(response);
                        if (resp == "<?= SUCCESS_CODE; ?>") 
                        {
                            window.location = "<?= base_url(route_to('admin_dashboard')) ?>";
                           
                        } else if (resp == "<?= FAILD_CODE; ?>") {
                            $.jGrowl({
                                header: "Please enter valid username and password",
                                theme: 'bg-danger'
                            });
                        } else if (resp == "<?= EXIST_CODE; ?>") {
                            $.jGrowl({
                                header: "Please enter valid username and password",
                                theme: 'bg-danger'
                            });
                        } else if (resp == "<?= PENDING_VERIFY; ?>") {
                            $.jGrowl({
                                header: "Business Account verification in progress. Please try logging after some time.",
                                theme: 'bg-danger'
                            });
                        } else if (resp == "<?= REJECT_VERIFY; ?>") {
                            $.jGrowl({
                                header: "Your account has been rejected. Please check your email for more information.",
                                theme: 'bg-danger'
                            });
                        } else if (resp == "<?= UNAUTH_CODE; ?>") {
                            $.jGrowl({
                                header: "Your account has been deactivated. Please contact admin or check your email for more information.",
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