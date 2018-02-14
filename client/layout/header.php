<?php 

require('../admin/include/connection.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Eventoz : Home</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="assets/images/favicon.ico"/>
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Slick slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">

    <!-- Main Style -->
    <link href="style.css" rel="stylesheet">

    <!-- Fonts -->

    <!-- Open Sans for body font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800" rel="stylesheet">
	<!-- Montserrat for title -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
 
 
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  	<?php

					$select_banner_query = "SELECT * FROM `company_banner`";

					$result_banner_query = mysqli_query($_connection,$select_banner_query);
						$rows_banner_query = mysqli_fetch_assoc($result_banner_query);
						?>
  	
  	<!-- Start Header -->
	<header id="mu-hero" style='background-image: url("http://<?php echo $_SERVER['HTTP_HOST']; ?>/php/Task/Priya-02-06/banner/<?php echo $rows_banner_query['banner_image'];  ?>");' class="" role="banner">
		<!-- Start menu  -->
		<nav class="navbar navbar-fixed-top navbar-default mu-navbar">
		  	<div class="container">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>

			      <!-- Logo -->
			      <a class="navbar-brand" href="index.php">Eventoz</a>

			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      	<ul class="nav navbar-nav mu-menu navbar-right">
			      		<li><a href="#mu-hero">Home</a></li>
				        <li><a href="#mu-about">About Us</a></li>
				        <li><a href="#mu-schedule">Schedule</a></li>
			            <li><a href="#mu-speakers">Speakers</a></li>
			            <li><a href="#mu-pricing">Price</a></li>
			            <li><a href="#mu-register">Register</a></li>
			            <li><a href="#mu-sponsors">Sponsors</a></li>
			            <li><a href="#mu-contact">Contact</a></li>
			      	</ul>
			    </div><!-- /.navbar-collapse -->
		  	</div><!-- /.container-fluid -->
		</nav>
		<!-- End menu -->

		<div class="mu-hero-overlay">
			<div class="container">
				<div class="mu-hero-area">

					


							<!-- Start hero featured area -->
					<div class="mu-hero-featured-area">
						<!-- Start center Logo -->
						<div class="mu-logo-area">
							<!-- text based logo -->
							<a class="mu-logo" href="#"><?php echo $rows_banner_query['banner_companyname']; ?> </a>
							<!-- image based logo -->
							<!-- <a class="mu-logo" href="#"><img src="assets/images/logo.jpg" alt="logo img"></a> -->
						</div>
						<!-- End center Logo -->

						<div class="mu-hero-featured-content">

							<h1> <?php echo $rows_banner_query['banner_welcome']; ?></h1>
							<h2><?php echo $rows_banner_query['banner_slogan']; ?></h2>

	
									
								</div>
							</div>
	
				

						</div>
					</div>
					<!-- End hero featured area -->

				</div>
			</div>
		</div>
	</header>
	<!-- End Header -->