<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
		<title>EchoGram</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<!-- Fonts-->
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/fonts/fontawesome/font-awesome.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/fonts/pe-icon/pe-icon.css'; ?>">
		<!-- Vendors-->
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/vendors/bootstrap/grid.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/vendors/magnific-popup/magnific-popup.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/vendors/swiper/swiper.css'; ?>">
		<!-- App & fonts-->
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald:400,600|Playfair+Display:400i">
		<link rel="stylesheet" type="text/css" href="<?php echo ASSET_URL.'assets/front/css/main.css'; ?>">
		<link rel="icon" type="image/png" href="<?php echo ASSET_URL.'assets/images/circle_logo.png'; ?>" />

	</head>
	<style>
	    body {
    margin: 0;
    padding: 0;
    line-height: 1.6;
    font-size: 14px;
    font-weight: 400;
    font-family: "Open Sans", sans-serif;
    color: #575757;
    background-color: #eee;
}
.services__desc {
     height: 90px;   
}

/* Force equal boxes for all grid items */
.grid-css .grid-item,
.grid-css .grid-item .grid-item__inner,
.grid-css .grid-item .grid-item__content-wrapper,
.grid-css .gallery__image {
  height: 250px !important;          /* choose height you want */
  min-height: 250px !important;
  max-height: 250px !important;
  min-width: 250px !important;
  max-width: 250px !important;
  box-sizing: border-box;
}

/* Make background image fill and hide overflow so cropping is clean */
.grid-css .gallery__image {
  display: block;
  width: 100% !important;
  overflow: hidden !important;
  position: relative !important;
  background-size: cover !important;
  background-position: center center !important;
  background-repeat: no-repeat !important;
  border-radius: 6px !important;
}

/* Ensure the <img> inside doesn't break layout and covers fully */
.grid-css .gallery__image img {
  position: absolute !important;
  top: 0; left: 0;
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  display: block !important;
  pointer-events: none;   /* optional: prevents clicks to the img so overlay works */
  opacity: 0;             /* hide the <img> visual because background-image already used */
}



/* If you prefer the <img> visible instead of background-image, set opacity:1 and remove background-image styles */



	</style>
	<body>
				
				<!-- preload -->
				<div class="preload" id="preload">
					<div class="cssload-spin-box"></div>
				</div><!-- End / preload -->
				
		<div class="page-wrap">
			
			<!-- header -->
			<header class="header header-fixheight header--fixed">
				<div class="container">
					<div class="header__inner">
						<div class="header-logo" style="width:40%"><a href="#"><img src="<?php echo ASSET_URL.'assets/images/circle_logo.png'; ?>" style="width:26%;" alt=""/></a></div>
						
						<!-- raising-nav -->
						<nav class="raising-nav">
							
							<!-- raising-menu -->
							<ul class="raising-menu">
								<li class="current"><a href="#id1">Home</a>
								</li>
								<!--<li><a href="#id2">About</a>
								</li>
								<li><a href="#id3">service</a>
								</li>
								<li><a href="#id4">gallery</a>
								</li>
								<li><a href="#id5">testimonial</a>
								</li>
								<li><a href="#id6">team</a>
								</li>
								<li><a href="#id7">contact us</a>
								</li> -->
							</ul><!-- raising-menu -->
							
							<div class="navbar-toggle"><i class="fa fa-bars"></i></div>
						</nav><!-- End / raising-nav -->
						
						<div class="searchbar">
							<div class="searchbar__group"><span class="searchbar__addon"><i class="fa fa-search"></i></span>
								<input class="searchbar__input" type="text" name="search" value="" placeholder="Search"/><span class="searchbar__close"></span>
							</div>
						</div>
					</div>
				</div>
			</header><!-- End / header -->
			
			<!-- Content-->
			<div class="md-content">
				
		
				<hero class="hero" id="id1">
					

					<div class="container mt-5">
    <div class="row">

        <!-- Section 1 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>Bulk Voice Campaigns</h4>
                    <p>
                        EchoGram helps businesses reach thousands of customers instantly
                        through automated voice broadcasting campaigns. Schedule calls,
                        track delivery reports, and monitor campaign performance from a
                        single dashboard.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>Interactive IVR Solutions</h4>
                    <p>
                        Create professional IVR systems with customizable menus,
                        call routing, and automated responses. Improve customer
                        engagement while reducing manual support efforts.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>SMS Marketing</h4>
                    <p>
                        Send promotional messages, OTPs, notifications, and alerts
                        directly to customers. EchoGram provides fast delivery,
                        real-time tracking, and detailed campaign analytics.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>WhatsApp Integration</h4>
                    <p>
                        Connect with customers using WhatsApp messaging solutions.
                        Automate conversations, send updates, and provide instant
                        support through a familiar communication channel.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>Real-Time Analytics</h4>
                    <p>
                        Monitor campaign performance with comprehensive reports,
                        delivery statistics, call logs, and engagement metrics.
                        Make informed decisions using actionable insights.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 6 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h4>Customer Engagement Platform</h4>
                    <p>
                        Centralize communication through voice, SMS, and digital
                        channels. EchoGram empowers organizations to build stronger
                        customer relationships and improve service efficiency.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
				</hero> <!-- End / hero -->
				
		
			
			<!-- footer-01 -->
			<footer class="footer-01 md-skin-dark">

				<!-- copyright-01 -->
				<div class="copyright-01 md-text-center">
					<div class="container">
						<p class="copyright-01__copy">2025 &copy; Copyright EchoGram. All rights Reserved.</p>
					</div>
				</div><!-- End / copyright-01 -->
				
			</footer><!-- End / footer-01 -->
			
		</div>
		<!-- Vendors-->
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/jquery/jquery.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/imagesloaded/imagesloaded.pkgd.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/isotope-layout/isotope.pkgd.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/jquery.matchHeight/jquery.matchHeight.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/magnific-popup/jquery.magnific-popup.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/masonry-layout/masonry.pkgd.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/swiper/swiper.jquery.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/jquery-one-page/jquery.nav.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/menu/menu.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/vendors/jquery.waypoints/jquery.waypoints.min.js'; ?>"></script>
		<!-- App-->
		<script type="text/javascript" src="<?php echo ASSET_URL.'assets/front/js/main.js'; ?>"></script>
		<script>
document.addEventListener('DOMContentLoaded', function() {
  const targetHeight = 250; // same value as CSS
  document.querySelectorAll('.grid-css .grid-item').forEach(function(item){
    item.style.height = targetHeight + 'px';
    const inner = item.querySelector('.grid-item__inner');
    if(inner) inner.style.height = targetHeight + 'px';
    const wrapper = item.querySelector('.grid-item__content-wrapper');
    if(wrapper) wrapper.style.height = targetHeight + 'px';
    const g = item.querySelector('.gallery__image');
    if(g){
      g.style.height = targetHeight + 'px';
      g.style.minHeight = targetHeight + 'px';
      g.style.maxHeight = targetHeight + 'px';
      g.style.backgroundSize = 'cover';
      g.style.backgroundPosition = 'center';
      g.style.overflow = 'hidden';
    }
    const img = item.querySelector('.gallery__image img');
    if(img){
      img.style.position = 'absolute';
      img.style.top = '0';
      img.style.left = '0';
      img.style.width = '100%';
      img.style.height = '100%';
      img.style.objectFit = 'cover';
      img.style.opacity = '0';
    }
  });
});
</script>

	</body>
</html>