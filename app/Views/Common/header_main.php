<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EchoGram">
    <meta name="keywords" content="EchoGram">
    <meta name="author" content="EchoGram">
    <title>Dashboard - EchoGram</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/plugins/fontawesome/css/fontawesome.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/plugins/fontawesome/css/all.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/plugins/icons/feather/feather.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/line-awesome.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/material.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/owl.carousel.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/select2.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/style.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSET_URL.'assets/css/dataTables.bootstrap4.min.css'; ?>">

    <!-- JavaScript -->
    <script src="<?php echo ASSET_URL.'assets/js/jquery-3.7.1.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/select2.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/bootstrap.bundle.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/jquery.slimscroll.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/feather.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/plugins/apexchart/apexcharts.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/plugins/apexchart/chart-data.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/owl.carousel.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/layout.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/theme-settings.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/greedynav.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/app.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/jquery.dataTables.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/js/dataTables.bootstrap4.min.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo ASSET_URL.'assets/rocket-loader.min.js'; ?>" data-cf-settings="86920c3c0e7f629de492d26d-|49" defer></script>
</head>

   <!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

	<style type="text/css">
	.sidebar .sidebar-menu ul li.active a, .two-col-bar .sidebar-menu ul li.active a {
    color: #fff;
    background: linear-gradient(to bottom, #f97a36, #fe5c05);
}

.sidebar .sidebar-menu ul li.active a, .two-col-bar .sidebar-menu ul li.active a
Specificity: (0,3,3)
 {
    color: #100e0e !important;
    background: linear-gradient(to bottom, #ffffff, #ffffff) !important;
}

.sidebar .sidebar-menu ul ul li a.active {
    text-decoration: none;
    background: #245009;
    padding-left: 25px;
}

		.header .page-title-box {
		    float: left;
		    height: 60px;
		    margin-bottom: 0;
		    padding: 10px 16px;
		    border-radius: 0;
		}
		.sidebar .sidebar-menu ul li a {
		    background: none;
		    margin-left: 10px;
		    width: 90%;
		    border-radius: 10px;
		    padding: 7px;
		    margin: 10px;
		    color: #000;
		    font-size: 14px;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #373b3e;
    font-size: 13px;
    font-weight: 400;
    line-height: 44px;
}
.select2-results__option {
    padding: 6px 15px;
    font-size: 13px;
}

		.sidebar .sidebar-menu ul li a.active {

		    background: linear-gradient(to bottom, #f97a36, #fe5c05);
		    margin-left: 10px;
		    width: 90%;
		    border-radius: 10px;
		    padding: 7px;
		    margin: 10px;
		    color: white;
		    font-size: 14px;
		}
		.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link{
		    color: #000;
		     background: none;
		    border-top: none;
		    border-right: none;
		    border-left: none;
		}
		.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		     color: #000;
		     background: none;
		    border-top: none;
		    border-right: none;
		    border-left: none;
		}

		/* Active tab */
		#active-tab.active {
		    border-bottom: 2px solid #fc6718 !important;
		}

		/* Completed tab */
		#completed-tab.active {
		    border-bottom: 2px solid #37c585 !important;
		}

		/* Remove borders for inactive tabs */
		.nav-tabs .nav-item .nav-link {
		    border-bottom: none !important;
		}

		/* Style active and hovered tabs */
		.nav-tabs .nav-item .nav-link.active,
		.nav-tabs .nav-item .nav-link:hover {
		    color: #000;
		    background: none;
		    border-top: none;
		    border-right: none;
		    border-left: none;
		}
.col-form-label,
.form-upload-profile h6 {
  color: #8f8f8f;
  font-weight: 400;
}

.form-control:disabled, .form-control[readonly] {
    background: none;
    opacity: 1;
}
th.sorting_disabled {
    background: linear-gradient(to bottom, #f97a36, #fe5c05);
    color: white;
}
.text-left {
    text-align: left !important;
}

.text-end {
    text-align: end !important;
}
.table th {
	font-size: 13px !important;
	}
	.table td {
		font-size: 13px !important;
	}

	div#client_list_length {
    display: none !important;
}
div#client_list_filter {
    display: none !important;
}

.fa-solid {
    position: sticky;
    top: 50%;
    transform: translateY(-50%);
    color: #f7681c;
}
.fa-regular, .far {
    font-weight: 400;
    color: #f7681c;
}
.sidebar .sidebar-menu ul ul {
    background: #ffffff;
    max-width: 194px;
    margin: 0 auto;
    border-radius: 5px;
    padding: 10px 0;
}
.sidebar .sidebar-menu ul ul li a {
    color: #000000;
    position: relative;
    padding: 5px 10px 5px 25px;
}
	</style>
	</head>
	 <?php

        if (null === session()->get('user_role')) {
            header('Location: '.base_url(route_to('logout')));
            exit;
        }

    ?>
	<body>

		<div class="main-wrapper">

			<div id="loader-wrapper">
				<div id="loader">
					<div class="loader-ellips">
						<span class="loader-ellips__dot"></span>
						<span class="loader-ellips__dot"></span>
						<span class="loader-ellips__dot"></span>
						<span class="loader-ellips__dot"></span>
					</div>
				</div>
			</div>


			<div class="header">

				<div class="header-left">
					<a href="javascript:void(0);" class="logo">
						<img src="<?php echo base_url(); ?>public/assets/images/circle_logo.png" alt="Shree Construction" style='width:33%;' >
					</a>
					<a href="javascript:void(0);" class="logo collapse-logo">
						<img src="<?php echo base_url(); ?>public/assets/images/circle_logo.png" alt="Shree Construction" style='width:33%;' >
					</a>
					<a href="javascript:void(0);" class="logo2">
						<img src="<?php echo base_url(); ?>public/assets/images/circle_logo.png" alt="Shree Construction" style='width:33%;' >
					</a>
				</div>


				<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>

					<ul class="nav user-menu">


						<li class="nav-item dropdown has-arrow main-drop">
							<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img" style="border-radius: 32px; border: 1px #fa7026 solid;"><?php if (session()->get('profile_picture')) { ?>
                            <img src="<?php echo USER_IMAGE.session()->get('profile_picture'); ?> " alt="" >
			                        <?php } else { ?>
			                            <img src="<?php echo base_url(); ?>public/assets/images/user_placeholder.png" alt="" style="width: 35px;height: 35px;border-radius: 50%;">
			                        <?php } ?>
								<span class="status online"></span></span>
								  <span style="color:black;font-weight: 500;"><?php echo session()->get('user_name'); ?></span>
							</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="<?php echo base_url(route_to('admin_profile')); ?>">Account Info</a>
								<a class="dropdown-item" href="<?php echo base_url(route_to('logout')); ?>" id="confirmLogout">Logout</a>

							</div>
						</li>
					</ul>


					<div class="dropdown mobile-user-menu">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="<?php echo base_url(route_to('admin_profile')); ?>">Account Info</a>
							<a class="dropdown-item" href="<?php echo base_url(route_to('logout')); ?>" id="confirmLogout">Logout</a>


						</div>
					</div>

			</div>


			<div class="sidebar" id="sidebar">
			    <div class="sidebar-inner slimscroll">
			        <div id="sidebar-menu" class="sidebar-menu">
			            <ul class="sidebar-vertical">
			            	<?php $request = Config\Services::request();
    $uri = $request->uri;
    $segments = $uri->getSegment(2);
    ?>
			                <li>
			                    <a href="<?php echo base_url(); ?>admin/dashboard" class="<?php echo $segments == 'dashboard' ? 'active' : ''; ?>"><i class="la la-dashboard"></i> <span>Dashboard</span></a>

			                </li>

			                <li>
			                    <a href="<?php echo base_url(); ?>admin/clients" class="<?php echo $segments == 'clients' ? 'active' : ''; ?>"><i class="la la-users"></i> <span>Clients</span></a>
			                </li>
	                        
	                    <!--    <li class="submenu <?php echo ($segments == 'material_master' || $segments == 'material_master_category') ? 'active' : ''; ?>">
                                
                                <a href="#">
                                    <i class="fe fe-file-text"></i>
                                    <span>Materials Master</span>
                                    <span class="menu-arrow"></span>
                                </a>
                            
                                <ul style="display: <?php echo ($segments == 'material_master' || $segments == 'material_master_category') ? 'block' : 'none'; ?>">
                                    
                                    <li>
                                        <a href="<?php echo base_url('admin/material_master'); ?>"
                                           class="<?php echo $segments == 'material_master' ? 'active' : ''; ?>">
                                            Material Management
                                        </a>
                                    </li>
                            
                                    <li>
                                        <a href="<?php echo base_url('admin/material_master_category'); ?>"
                                           class="<?php echo $segments == 'material_master_category' ? 'active' : ''; ?>">
                                            Material Category
                                        </a>
                                    </li>
                            
                                </ul>
                            </li>  -->
	                        
			            </ul>
			        </div>
			    </div>
			</div>
		
	<?php echo $this->renderSection('content'); ?>
<style>
button#login_button {
    background: linear-gradient(to bottom, #f97a36, #fe5c05);
    width: 15%;
}
button#cancel_button {
    background: linear-gradient(to bottom, #e2e1e0, #dadada);
    width: 15%;
    color: #585555;
}
button#save_cancel_button {
    background: linear-gradient(to bottom, #e2e1e0, #dadada);
    width: 15%;
    color: #585555;
}

  div:where(.swal2-container) div:where(.swal2-popup) {
    display: none;
    position: relative;
    box-sizing: border-box;
    grid-template-columns: minmax(0, 100%);
    width: auto;
    height: auto;
    max-width: 100%;
    padding: 0 0 1.25em;
    border: none;
    border-radius: 5px;
    background: #fff;
    color: #545454;
    font-family: inherit;
    font-size: 0.8rem;
    border-radius: 10px;
}
i#icon_new
 { 
        position: relative;
        display: inline-block;
        width: 60px; /* adjust size as needed */
        height: 60px; /* adjust size as needed */
        background: #f58412; /* light orange background color */
        border-radius: 50%; /* make it a circle */
        text-align: center;
        line-height: 60px;
        color: #fff;
}
span.dash-widget-icon {
    background-color: rgb(218 214 214 / 24%);
    /* color: #eeeeee; */
    margin-bottom: 10px;
    font-size: 23px;
    height: 40px;
    line-height: 48px;
    margin-right: 10px;
    text-align: center;
    width: 40px;
    border-radius: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    align-items: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    justify-content: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
}

</style>
  <style type="text/css">
     table.dataTable>thead>tr>th:not(.sorting_disabled), table.dataTable>thead>tr>td:not(.sorting_disabled) {
    padding-right: 1px;
    background: linear-gradient(to bottom, #f97a36, #fe5c05);
        color: white;
}
table.dataTable>thead .sorting:after, table.dataTable>thead .sorting_asc:after, table.dataTable>thead .sorting_desc:after, table.dataTable>thead .sorting_asc_disabled:after, table.dataTable>thead .sorting_desc_disabled:after {
    right: .5em;
    content: "↓";
    display: none;
}
table.dataTable>thead .sorting:before, table.dataTable>thead .sorting_asc:before, table.dataTable>thead .sorting_desc:before, table.dataTable>thead .sorting_asc_disabled:before, table.dataTable>thead .sorting_desc_disabled:before {
    right: 1em;
    content: "↑";
    display: none;
}
  </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#confirmLogout").click(function(event) {
            event.preventDefault();
            Swal.fire({
                title: '<span class="custom-title"><i class="fas fa-sign-out-alt" id="icon_new"></i><br>Are you sure want to logout?</span>',
                // html: '<span class="custom-message">This is a warning message.</span>',
                showCancelButton: true,
                confirmButtonColor: "#EF5350",
                confirmButtonText: "<u>Logout</u>",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'custom-confirm-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").show();
                    window.location.href = "<?php echo base_url(route_to('logout')); ?>"; // Redirect to the logout URL
                }
            });
        });
    });
</script>

    </div>
</body>

</html>