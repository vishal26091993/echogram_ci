<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CLE - <?= $data['title'] ?></title>
	<base href="/">
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?= ASSET_URL."assets/css/icons/icomoon/styles.css" ?>" rel="stylesheet" type="text/css">
	<link href="<?= ASSET_URL."assets/css/bootstrap.css" ?>" rel="stylesheet" type="text/css">
	<link href="<?= ASSET_URL."assets/css/core.css" ?>" rel="stylesheet" type="text/css">
	<link href="<?= ASSET_URL."assets/css/components.css" ?>" rel="stylesheet" type="text/css">
	<link href="<?= ASSET_URL."assets/css/colors.css" ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/plugins/loaders/pace.min.js" ?>"></script>
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/core/libraries/jquery.min.js" ?>"></script>
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/core/libraries/bootstrap.min.js" ?>"></script>
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/plugins/loaders/blockui.min.js" ?>"></script>
	<!-- /core JS files -->
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/plugins/notifications/jgrowl.min.js" ?>"></script>
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/plugins/forms/selects/select2.min.js" ?>"></script>

	<script type="text/javascript" src="<?= ASSET_URL."assets/js/pages/form_layouts.js" ?>"></script>

	<script type="text/javascript" src="<?= ASSET_URL."assets/js/plugins/forms/styling/uniform.min.js" ?>"></script>
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?= ASSET_URL."assets/js/core/app.js" ?>"></script>
	<!-- /theme JS files -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy6kSyxrjrrrGcjiJH7wk59QaaVqHZ-3w
&callback=initMap&libraries=places&v=weekly" defer></script>
</head>
<style>
	.form-group {
		margin-bottom: 10px;
	}
</style>

<body class="login-container">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Ezcart</a>
			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content" style="background-image:'assets/images/logo_light.png'">
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Content area -->
				<div class="content">
					<div class="col-md-5">
						<form id="register_form" method="POST">
							<div class="panel panel-body login-form" style="width:auto;">
								<div class="text-center">
									<h5 class="content-group">Create account <small class="display-block">All fields are required</small></h5>
								</div>

								<div class="content-divider text-muted form-group"><span>Your credentials</span></div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group has-feedback has-feedback-left">
											<div class="form-control-feedback">
												<i class="icon-user-check text-muted"></i>
											</div>
											<input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" onkeypress="return accept_onlyalpha(event)">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group has-feedback has-feedback-left">
											<div class="form-control-feedback">
												<i class="icon-mention text-muted"></i>
											</div>
											<input type="text" class="form-control" id="email_id" name="email_id" placeholder="Your email">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group has-feedback has-feedback-left">
											<div class="form-control-feedback">
												<i class="icon-user-lock text-muted"></i>
											</div>
											<input type="password" class="form-control" id="password" name="password" placeholder="Create password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact No" onkeypress="return accept_number(event)">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" id="business_id" name="business_id" placeholder="Your Business ID" maxlength="15" placeholder="e.g: 12345EMV234" data-toggle="tooltip" title="e.g: 12345EMV234">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" id="business_name" name="business_name" placeholder="Your Business Name" onkeypress="return accept_alphanumeric(event)">
										</div>
									</div>
								</div>
								<!-- <div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="location" name="location" placeholder="Your Business Location">
										</div>
									</div>
								</div> -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<select type="text" class="select" id="country" name="country" onchange="get_state(this.value)" data-placeholder="Select Country"></select>
											<span id="country_err"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<select type="text" class="select" id="state" name="state" onchange="get_city(this.value)" data-placeholder="Select State"></select>
											<span id="state_err"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<select type="text" class="select" id="city" name="city" data-placeholder="Select City" required="required"></select>
											<span id="city_err"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" id="radio">
											<label class="display-block text-semibold">Business Type</label>
											<label class="radio-inline">
												<input type="radio" name="business_type" id="restaurant" value="1">
												Restaurant
											</label>
											<label class="radio-inline">
												<input type="radio" name="business_type" id="warehouse" value="2">
												Warehouse
											</label>
											<br>
											<span id="typeError"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<input id="location" name="location" class="form-control" type="text" onclick="myFunction()" placeholder="Search Address" value="" />
									<br>
									<div id="map" style="height:200px; width: 100%"></div>
									<!-- <div class="col-md-6"> -->
									<div class="form-group">
										<input type="hidden" class="form-control" id="latitude" name="latitude" placeholder="Latitude" required="required" onkeypress="return accept_decimal(event)">
									</div>
									<!-- </div>
									<div class="col-md-6"> -->
									<div class="form-group">
										<input type="hidden" class="form-control" id="longitude" name="longitude" placeholder="Longitude" required="required" onkeypress="return accept_decimal(event)">
									</div>
									<!-- </div> -->
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<select name="category_name" id="category_name" data-placeholder="Select Business Category" class="select select2-hidden-accessible">
											</select>
											<span id="category_name_err"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Business Profile Image</label>
											<div class="media no-margin-top">
												<div class="media-left">
													<img src="assets/images/placeholder.jpg" id="show_business_profile_img" name="show_business_profile_img" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
												</div>
												<div class="media-body">
													<input type="file" class="file-styled" name="business_image" id="business_image" onchange="file_show(this)" accept="image/png, image/jpg, image/jpeg">
													<span id="business_image_err"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Business Logo Image</label>
											<div class="media no-margin-top">
												<div class="media-left">
													<img src="assets/images/placeholder.jpg" id="show_business_logo_img" name="show_business_logo_img" style="width: 58px; height: 58px; border-radius: 2px;" alt="">
												</div>
												<div class="media-body">
													<input type="file" class="file-styled" name="business_logo" id="business_logo" onchange="file_show1(this)" accept="image/png, image/jpg, image/jpeg">
													<span id="business_logo_err"></span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<button type="submit" class="btn  btn-customize btn-block btn-lg">Register <i class="icon-circle-right2 position-right"></i></button>
							</div>
						</form>
					</div>
					<div class="col-md-7 text-center"><img width="85%" src="assets/images/delivery.png"></div>
				</div>
				<!-- /content area -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->
</body>

</html>

<script>
	$.validator.addMethod("pwcheck", function(value) {
		return /^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value) // consists of only these
			
	});

	function accept_decimal(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 &&
			(charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function accept_number(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode < 48 || charCode > 57)
			return false;

		return true;
	}

	function accept_alphanumeric(evt) {
		var k;
		document.all ? k = evt.keycode : k = evt.which;
		return ((k > 47 && k < 58) || (k > 64 && k < 91) || (k > 96 && k < 123) || k == 32 || k == 0);
	}

	function accept_onlyalpha(evt) {
		var k;
		document.all ? k = evt.keycode : k = evt.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 32);
	}

	// register  
	if ($("#register_form").length > 0) {
		$("#register_form").validate({
			rules: {
				user_name: {
					required: true,
				},
				email_id: {
					required: true,
				},
				password: {
					required: true,
					pwcheck: true,
					minlength: 8
				},
				contact_no: {
					required: true,
				},
				business_id: {
					required: true,
				},
				business_name: {
					required: true,
				},
				location: {
					required: true,
				},
				business_type: {
					required: true,
				},
				category_name: {
					required: true,
				},
				business_image: {
					required: true,
				},
				business_logo: {
					required: true,
				},
				latitude: {
					required: true,
				},
				longitude: {
					required: true,
				},
				country: {
					required: true,
				},
				state: {
					required: true,
				},
				city: {
					required: true,
				},
			},
			messages: {
				user_name: {
					required: "Please enter username",
				},
				email_id: {
					required: "Please enter email",
				},
				password: {
					required: "Please enter password",
					pwcheck: "Password must be contain of atleast 8 characters and should contain atleast 1 character, 1 special character and 1 numeric value."
				},
				contact_no: {
					required: "Please enter contact no",
					min: 10,
				},
				business_id: {
					required: "Please enter your business ID",
				},
				business_name: {
					required: "Please enter business name",
				},
				location: {
					required: "Please enter business location",
				},
				business_type: {
					required: "Please select business type",
				},
				category_name: {
					required: "Please select business category",
				},
				business_image: {
					required: "Please upload business image",
				},
				business_logo: {
					required: "Please upload business logo",
				},
				latitude: {
					required: "Please enter latitude",
				},
				longitude: {
					required: "Please enter longitude",
				},
				country: {
					required: "Please select business country",
				},
				city: {
					required: "Please select business city",
				},
				state: {
					required: "Please select business state",
				},

			},
			errorPlacement: function(label, element) {
				label.css("color", "red");

				if (element.attr("name") == "business_type")
					label.insertAfter('#typeError');
				else if (element.attr("name") == "business_image")
					label.insertAfter('#business_image_err');
				else if (element.attr("name") == "country")
					label.insertAfter('#country_err');
				else if (element.attr("name") == "state")
					label.insertAfter('#state_err');
				else if (element.attr("name") == "city")
					label.insertAfter('#city_err');
				else if (element.attr("name") == "category_name")
					label.insertAfter('#category_name_err');
				else if (element.attr("name") == "business_logo")
					label.insertAfter('#business_logo_err');
				else
					label.insertAfter(element);

			},
			submitHandler: function(form) {
				var fd = new FormData($('#register_form')[0]);
				$.ajax({
					url: "<?php echo base_url('user_register') ?>",
					type: "POST",
					data: fd,
					dataType: "json",
					contentType: false,
					processData: false,
					success: function(resp) {
						if (resp == "<?= SUCCESS_CODE; ?>") {
							$.jGrowl({
								header: "Thank you for registration. You would receive an email about status of your account in 1-2 working days.",
								theme: 'bg-info'
							});

							document.getElementById("register_form").reset();
							setTimeout(function() {
								window.location = "<?= base_url() ?>";
							}, 1000);

						} else if (resp == "<?= EXIST_CODE; ?>") {
							$.jGrowl({
								header: "Business already registered.",
								theme: 'bg-warning'
							});
						} else {
							$.jGrowl({
								header: "<?= FAIL_MSG ?>",
								theme: 'bg-danger'
							});
						}
					}
				});
			}
		})
	}

	getCategoryList();

	function getCategoryList() {
		$.ajax({
			url: "<?php echo base_url('getCategorydropdownList') ?>",
			type: "POST",
			dataType: "json",
			success: function(resp) {
				if (resp.length > 0) {
					$("#category_name").html("<option value=''>Select Business Category</option>");
					for (var i = 0; i < resp.length; i++) {
						$("#category_name").append("<option value='" + resp[i]['id'] + "'>" + resp[i]['category_name'] + "</option>");
					}
				} else {
					$("#category_name").html("<option value=''>Category Not Found.</option>");
				}
			}
		});
	}

	function file_show(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#show_business_profile_img').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function file_show1(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#show_business_logo_img').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	country()

	function country() {
		$.ajax({
			url: "<?php echo base_url('getCountry') ?>",
			type: "POST",
			dataType: "json",
			success: function(resp) {
				if (resp.length > 0) {
					$("#country").html("<option value=''>Select Business Country</option>");
					for (var i = 0; i < resp.length; i++) {
						$("#country").append("<option value='" + resp[i]['id'] + "'>" + resp[i]['name'] + "</option>");
					}
				} else {
					$("#country").html("<option value=''>Not Found</option>");
				}
			}
		});
	}

	function get_state(country_id) {

		$.ajax({
			url: "<?php echo base_url('getState') ?>",
			type: "POST",
			data: "country_id=" + country_id,
			dataType: "json",
			success: function(resp) {
				if (resp.length > 0) {
					$('#state').val(null).trigger("change");
					$('#city').val(null).trigger("change");
					$("#state").html("<option value=''>Select Business State</option>");
					for (var i = 0; i < resp.length; i++) {
						$("#state").append("<option value='" + resp[i]['id'] + "'>" + resp[i]['name'] + "</option>");
					}
				} else {
					$("#state").html("<option value=''>Not Found</option>");
				}
			}
		});
	}

	function get_city(state_id) {
		$.ajax({
			url: "<?php echo base_url('getCity') ?>",
			type: "POST",
			data: "state_id=" + state_id,
			dataType: "json",
			success: function(resp) {
				if (resp.length > 0) {
					$('#city').val(null).trigger("change");
					$("#city").html("<option value=''>Select Business City</option>");
					for (var i = 0; i < resp.length; i++) {
						$("#city").append("<option value='" + resp[i]['id'] + "'>" + resp[i]['name'] + "</option>");
					}
				} else {
					$("#city").html("<option value=''>Not Found</option>");
				}
			}
		});
	}

	function myFunction() {

		const map = new google.maps.Map(document.getElementById("map"), {
			center: {
				lat: 21.1956285, //latitude,
				lng: 72.7917057 //longitude
			},
			zoom: 13,
			mapTypeControl: false,
		});
		const card = document.getElementById("pac-card");
		const input = document.getElementById("location");

		const options = {
			fields: ["formatted_address", "geometry", "name"],
			strictBounds: false,
			types: ["establishment"],
		};

		map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

		const autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.bindTo("bounds", map);
		const marker = new google.maps.Marker({
			position: {
				lat: 21.1956285,
				lng: 72.7917057
			},
			map,
			anchorPoint: new google.maps.Point(0, -29),
		});
		const infowindow = new google.maps.InfoWindow();
		const infowindowContent = document.getElementById("infowindow-content");

		infowindow.setContent(infowindowContent);
		autocomplete.addListener("place_changed", () => {
			infowindow.close();
			marker.setVisible(false);

			const place = autocomplete.getPlace();

			if (!place.geometry || !place.geometry.location) {
				window.alert("No details available for input: '" + place.name + "'");
				return;
			}

			// If the place has a geometry, then present it on a map.
			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}
			console.log(place.geometry.location);
			marker.setPosition(place.geometry.location);
			var latitude = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			console.log("add>" + latitude);
			console.log("add>" + longitude);
			document.getElementById('latitude').value = latitude;
			document.getElementById('longitude').value = longitude;
			console.log(latitude);
			console.log(longitude);
			marker.setVisible(true);
			console.log("PLCE=>" + place.name);
			console.log("PLCE formatted_address=>" + place.formatted_address);
			console.log("infowindowContent=>" + infowindowContent);
			marker.setVisible(true);
			console.log(infowindow);
			if (infowindowContent == null) {
				infowindow.setContent(place.name + ',<br>' + place.formatted_address);

				// document.getElementById("infowindow-content").value=place.formatted_address;
			} else {
				infowindowContent.children["place-name"].textContent = place.name;
				infowindowContent.children["place-address"].textContent =
					place.formatted_address;
			}
			infowindow.open(map, marker);
		});
	}

	function initMap() {

		const map = new google.maps.Map(document.getElementById("map"), {
			center: {
				lat: 21.1956285, //latitude,
				lng: 72.7917057 //longitude
			},
			zoom: 13,
			mapTypeControl: false,
		});
		const card = document.getElementById("pac-card");
		const input = document.getElementById("location");

		const options = {
			fields: ["formatted_address", "geometry", "name"],
			strictBounds: false,
			types: ["establishment"],
		};

		map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

		const autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.bindTo("bounds", map);

		const marker = new google.maps.Marker({
			position: {
				lat: 21.1956285,
				lng: 72.7917057
			},
			map,
			anchorPoint: new google.maps.Point(0, -29),
		});

		const infowindow = new google.maps.InfoWindow();
		const infowindowContent = document.getElementById("infowindow-content");

		infowindow.setContent(infowindowContent);

		autocomplete.addListener("place_changed", () => {
			infowindow.close();
			marker.setVisible(false);

			const place = autocomplete.getPlace();

			if (!place.geometry || !place.geometry.location) {
				window.alert("No details available for input: '" + place.name + "'");
				return;
			}

			// If the place has a geometry, then present it on a map.
			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}
			console.log(place.geometry.location);
			marker.setPosition(place.geometry.location);
			var latitude = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			console.log("add>" + latitude);
			console.log("add>" + longitude);
			document.getElementById('latitude').value = latitude;
			document.getElementById('longitude').value = longitude;
			console.log(latitude);
			console.log(longitude);
			marker.setVisible(true);
			infowindowContent.children["place-name"].textContent = place.name;
			infowindowContent.children["place-address"].textContent =
				place.formatted_address;
			infowindow.open(map, marker);
		});

	}
	window.initMap = initMap;
</script>