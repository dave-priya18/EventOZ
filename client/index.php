<?php 

require('../admin/include/connection.php');

?>


<?php
    $user_profile_fname_error= $user_profile_lname_error = $user_profile_email_error = 
    $user_profile_username_error= $user_profile_address_error =  $user_profile_country_error 
    = $user_profile_city_error  = $user_profile_postalcode_error = 
    $user_profile_aboutme_error ="";
       
    $count =0;
    $error=0;
    $var_vp_fname = $var_vp_lname =  $var_vp_email = $var_up_username =  $var_vp_address = 
    $var_vp_city = $var_vp_country = $var_vp_postalcode = $var_vp_aboutme ="";

    if(isset($_POST['submit_user'])){

        
//Username Validation
            
        if(!($_POST['user_profile_username'])==""){
            if (!(strlen($_POST['user_profile_username']) >5 && strlen($_POST['user_profile_username']) < 11)) {
                $count++;
                $user_profile_username_error = "Username Must be between 6 to 10  characters";
            }
            else{
                if(!(preg_match("/^[_A-Za-z0-9]*$/", $_POST['user_profile_username']))){
                    $count++;
                    $user_profile_username_error = "Format Problem";
                }
                else{
                    //echo "UserName: ".$_POST['user_profile_username']."<br>";
                    $var_up_username = $_POST['user_profile_username'];
                }
            }
        }
        else{
            $count++;
            $user_profile_username_error = "Username is required";
        }    


//Email-id Validation
  
        if(!($_POST['user_profile_email'])== ""){
            // if (!(filter_var($_POST['user_profile_email'], FILTER_VALIDATE_EMAIL))) {
            //  $user_profile_email_error = "Wrong Email Format";
            //  $count++;
            //}
            if (!(preg_match("/^([-a-zA-Z0-9_.]+)@([-a-zA-Z0-9_.]+)\.([a-zA-Z])*$/",$_POST['user_profile_email']))) {
                $count++;
                $user_profile_email_error = "Wrong Email Format";
            }
            else{
                //echo "Email Id(regex): ".$_POST['user_profile_email']."<br>";
                $var_vp_email = $_POST['user_profile_email'];
            }           
        }
        else{
            $count++;
            $user_profile_email_error = "Email is Required";    
        }
            
           
//First Name Validation
        if(!($_POST['user_profile_fname']) == ""){
            if(!(strlen($_POST['user_profile_fname']) <= 50)){
                $count++;
                $user_profile_username_error ="First name should be less than 50 characters";
            }
            else{
                //echo "First Name: ". $_POST['user_profile_fname'] . "<br>";
                $var_vp_fname = $_POST['user_profile_fname'];
            }
        }
        else{
            $count++;
            $user_profile_fname_error = "First Name Required";
        }

//Last Name Validation
            
        if(!($_POST['user_profile_lname']) == ""){
            if(!(strlen($_POST['user_profile_lname']) <= 50)){
                $count++;
                $user_profile_lname_error = "Last name should be less than 50 characters";
            }
        else{
                //echo "Last Name: ".$_POST['user_profile_lname'] ."<br>";
                $var_vp_lname = $_POST['user_profile_lname'];
            }
        }
        else{
            $count++;
            $user_profile_lname_error = "Last Name Required";
        }





//Address Validation


        if(!($_POST['user_profile_address']== "")){
            if(!(strlen($_POST['user_profile_address']) < 201 )) {
                $count++;
                $user_profile_address_error = "Length problem";
            }
            else{
                //echo "Address: ".$_POST['user_profile_address']."<br>";
                $var_vp_address = $_POST['user_profile_address'];
            }
        }
        else{
            $count++;
            $user_profile_address_error = "Address is required";
        }
        
            

        
//City Validation

        if(!($_POST['user_profile_city'])== ""){
            if(!(strlen($_POST['user_profile_city']) < 101)){
                $count++;
                $user_profile_city_error = "Too Long City Name";
            }
            else{
                //echo "City: ".$_POST['user_profile_city']."<br>";
                $var_vp_city = $_POST['user_profile_city'];
            }
              
        }
        else{   
            $count++;
            $user_profile_city_error = "City is Required";  
        }
        


//Country Validation
        if(!($_POST['user_profile_country'])==""){
            //echo "Country: ".$_POST['user_profile_country']."<br>";
            $var_vp_country = $_POST['user_profile_country'];
        }   
        else{
            $count++;
            $user_profile_country_error = "Country is Required";       
        }

//Postal Code Validation

        if(!(($_POST['user_profile_postalcode']) == "")){
            if(!(strlen($_POST['user_profile_postalcode']) == 6 )) {
                $count++;
                $user_profile_postalcode_error = "Must be 6 digits";
            }
            else{
                if(!(preg_match("/^[1-9][0-9]{5}/", $_POST['user_profile_postalcode']))){
                    $user_profile_postalcode_error = "format Problem";
                    $count++;
                }
                else{
                    //echo "Postal-Code: ".$_POST['user_profile_postalcode']."<br>";
                    $var_vp_postalcode = $_POST['user_profile_postalcode'];
                }
            }
        }
        else{
            $count++;
            $user_profile_postalcode_error = "Postal code is Required";   
        }

//About me Validation


        if(!(strlen($_POST['user_profile_aboutme']) < 201 )) {
            $count++;
            $user_profile_aboutme_error = "Length problem";
        }
        else{
            //echo "About me: ".$_POST['user_profile_aboutme']."<br>";
            $var_vp_aboutme = $_POST['user_profile_aboutme'];
        }

//Insert Query

        if($count>0){
            echo "Invalid Input";
        }
        else{
            //DB Connection and Insert
            $select_query_all = "SELECT * FROM `user_profile` WHERE 
            user_username = '".$var_up_username."' and user_email = '".$var_vp_email."'";
            $result_all=mysqli_query($_connection,$select_query_all);
            if($row_all = mysqli_fetch_array($result_all)){
                 echo "<script type='text/javascript'>alert('User is already there!')</script>";
            }
            else{
               $select_query_username = "SELECT user_username FROM `user_profile` WHERE user_username = '".$var_up_username."'";
                $result_username = mysqli_query($_connection,$select_query_username);
                if($row_username = mysqli_fetch_array($result_username)){
                     echo "<script type='text/javascript'>alert('Username is not available')</script>";
                }
                else{
                    $insert_query = "INSERT INTO `user_profile`(`user_username`, `user_email`, `user_fname`, `user_lname`, `user_address`, `user_city`, `user_country`, `user_postalcode`, `user_aboutme`, `admin_id`) VALUES ('".$var_up_username."','".$var_vp_email."','".$var_vp_fname."','".$var_vp_lname."','".$var_vp_address."','".$var_vp_city."','".$var_vp_country."','".$var_vp_postalcode."','".$var_vp_aboutme."','".$_SESSION['admin_credential']['admin_id']."')";
                    if (mysqli_query($_connection,$insert_query)) {
                        echo "<script type='text/javascript'>alert('Registered successfully!')</script>";
                        ob_start();
                        header('Location: index.php');
                    } 
                    else {  
                        $error= mysqli_error($_connection);
                         echo "<script type='text/javascript'>alert('$error!')</script>";
                     }  
                }
            } 
        }
    }

$count1=0;
$contactus_name_error = $contactus_email_error = $contactus_msg_error = "";
$var_contactus_name = $var_contactus_email = $var_contactus_msg = "";
if((isset($_POST['submit_contactus']))){
// Contact Us Name Error
     if(!($_POST['contactus_name']) == ""){
            if(!(strlen($_POST['contactus_name']) <= 50)){
                $count1++;
                $contactus_name_error ="First name should be less than 50 characters";
            }
            else{
                //echo "First Name: ". $_POST['contactus_name'] . "<br>";
                $var_contactus_name = $_POST['contactus_name'];
            }
        }
        else{
            $count1++;
            $contactus_name_error = "First Name Required";
        }

//Email-id Validation
  
        if(!($_POST['contactus_email'])== ""){
            // if (!(filter_var($_POST['contactus_email'], FILTER_VALIDATE_EMAIL))) {
            //  $contactus_email_error = "Wrong Email Format";
            //  $count++;
            //}
            if (!(preg_match("/^([-a-zA-Z0-9_.]+)@([-a-zA-Z0-9_.]+)\.([a-zA-Z])*$/",$_POST['contactus_email']))) {
                $count1++;
                $contactus_email_error = "Wrong Email Format";
            }
            else{
                //echo "Email Id(regex): ".$_POST['contactus_email']."<br>";
                $var_contactus_email = $_POST['contactus_email'];
            }           
        }
        else{
            $count1++;
            $contactus_email_error = "Email is Required";    
        }
            
         

//Message Validation


        if(!($_POST['contactus_msg']== "")){
            if(!(strlen($_POST['contactus_msg']) < 201 )) {
                $count1++;
                $contactus_msg_error = "Length problem";
            }
            else{
                //echo "Address: ".$_POST['contactus_msg']."<br>";
                $var_contactus_msg = $_POST['contactus_msg'];
            }
        }
        else{
            $count1++;
            $contactus_msg_error = "Message is required";
        }
        
            




	 if($count1>0){
            echo "Invalid Input";
        }
        else{
            //DB Connection and Insert
               $select_query_email = "SELECT contactus_email FROM `contact_us` WHERE contactus_email = '".$var_contactus_email."'";
                $result_email = mysqli_query($_connection,$select_query_email);
                if($row_email = mysqli_fetch_array($result_email)){
                     echo "<script type='text/javascript'>alert('Email has already submitted')</script>";
                }
                else{
                 echo    $insert_query = "INSERT INTO `contact_us`(`contactus_name`, `contactus_email`, `contactus_message`) VALUES ('".$var_contactus_name."','".$var_contactus_email."','".$var_contactus_msg."')";
                 exit;

                 // the message

				$msg = '';
				$msg .="<p><strong>Name :".$var_contactus_name."</strong></p>";
				$msg .="<p><strong>Email :".$var_contactus_email."</strong></p>";
				$msg .="<p><strong>Message :".$var_contactus_msg."</strong></p>";

				mail("priya.dave@indianic.com","Contact Details",$msg);

                    if (mysqli_query($_connection,$insert_query)) {
                        echo "<script type='text/javascript'>alert('Registered successfully!')</script>";
                        ob_start();
                        header('Location: index.php');
                    } 
                    else {  
                        $error= mysqli_error($_connection);
                         echo "<script type='text/javascript'>alert('$error!')</script>";
                     }  
                }
            } 




}

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



<?php ?>


<!-- Start main content -->
	<main role="main">
		<!-- Start About -->
		<section id="mu-about">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-about-area">
						<?php
						$select_about_conference = "SELECT * FROM `conference_detail` WHERE conference_active_flag = '1'";

						$result_about_conference = mysqli_query($_connection,$select_about_conference);
						$active_conference = array();

						while($row_about_conference = mysqli_fetch_assoc($result_about_conference)){
							$active_conference[] = $row_about_conference['conference_id'];
						?>

							<div class="row">
								<div class="col-md-6">
									<div class="mu-about-left">
										<img class="" src="../../upload/<?php echo $row_about_conference['conference_image']?>" alt="Conference Image">
									</div>
								</div>
								<div class="col-md-6">
									<div class="mu-about-right">
										<h2><?php echo $row_about_conference['conference_title']; ?></h2>
										<p><?php echo $row_about_conference['conference_desc']; ?></p>

										
									</div>
								</div>
							</div>
							<!-- End Feature Content -->

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End About -->
	</main>

	<?php } ?>
	
	

		<!-- Start Video -->
		<section id="mu-video">
			<div class="mu-video-overlay">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="mu-video-area">
								<h2>Watch Previous Event Video</h2>
								<a class="mu-video-play-btn" href="#"><i class="fa fa-play" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Start Video content -->
			<div class="mu-video-content">
				<div class="mu-video-iframe-area">
					<a class="mu-video-close-btn" href="#"><i class="fa fa-times" aria-hidden="true"></i></a>
					<iframe width="854" height="480" src="https://www.youtube.com/embed/n9AVEl9764s" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
			<!-- End Video content -->

		</section>
		<!-- End Video -->

		<!-- Start Schedule  -->
		<section id="mu-schedule">
			<div class="container">
				<div class="row">
					<div class="colo-md-12">
						<div class="mu-schedule-area">

							<div class="mu-title-area">
								<h2 class="mu-title">Schedule Detail</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis unde, ut sapiente et voluptatum facilis consectetur incidunt provident asperiores at necessitatibus nulla sequi voluptas libero quasi explicabo veritatis minima porro.</p>
							</div>

							<div class="mu-schedule-content-area">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs mu-schedule-menu" role="tablist">
								    <li role="presentation" class="active"><a href="#first-day" aria-controls="first-day" role="tab" data-toggle="tab">1 Day / 19 Feb</a></li>
								    <li role="presentation"><a href="#second-day" aria-controls="second-day" role="tab" data-toggle="tab">2 Day / 20 Feb</a></li>
								    <li role="presentation"><a href="#third-day" aria-controls="third-day" role="tab" data-toggle="tab">3 Day / 21 Feb</a></li>
								    
								</ul>

								<!-- Tab panes -->
								<div class="tab-content mu-schedule-content">
								    <div role="tabpanel" class="tab-pane fade mu-event-timeline in active" id="first-day">
								    	<ul>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">9.00 AM</p>
								    				<h3>Breakfast</h3>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-1.jpg" alt="event speaker">
								    				<p class="mu-event-time">10.00 AM</p>
								    				<h3>Advanced SVG Animations</h3>
								    				<span>By Karl Groves</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-2.jpg" alt="event speaker">
								    				<p class="mu-event-time">11.00 AM</p>
								    				<h3>Presenting Work with Confidence</h3>
								    				<span>By Sarah Dransner</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-3.jpg" alt="event speaker">
								    				<p class="mu-event-time">12.00 AM</p>
								    				<h3>Keynote on UX & UI Design</h3>
								    				<span>By Ned Stark</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">1.00 PM</p>
								    				<h3>The End</h3>
								    			</div>
								    		</li>
								    	</ul>
								    </div>
								    <div role="tabpanel" class="tab-pane fade mu-event-timeline" id="second-day">
								    	<ul>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">9.00 AM</p>
								    				<h3>Breakfast</h3>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-1.jpg" alt="event speaker">
								    				<p class="mu-event-time">10.00 AM</p>
								    				<h3>Advanced SVG Animations</h3>
								    				<span>By Karl Groves</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-2.jpg" alt="event speaker">
								    				<p class="mu-event-time">11.00 AM</p>
								    				<h3>Presenting Work with Confidence</h3>
								    				<span>By Sarah Dransner</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-3.jpg" alt="event speaker">
								    				<p class="mu-event-time">12.00 AM</p>
								    				<h3>Keynote on UX & UI Design</h3>
								    				<span>By Ned Stark</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">1.00 PM</p>
								    				<h3>The End</h3>
								    			</div>
								    		</li>
								    	</ul>
								    </div>
								    <div role="tabpanel" class="tab-pane fade mu-event-timeline" id="third-day">
								    	<ul>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">9.00 AM</p>
								    				<h3>Breakfast</h3>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-1.jpg" alt="event speaker">
								    				<p class="mu-event-time">10.00 AM</p>
								    				<h3>Advanced SVG Animations</h3>
								    				<span>By Karl Groves</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-2.jpg" alt="event speaker">
								    				<p class="mu-event-time">11.00 AM</p>
								    				<h3>Presenting Work with Confidence</h3>
								    				<span>By Sarah Dransner</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<img src="assets/images/speaker-3.jpg" alt="event speaker">
								    				<p class="mu-event-time">12.00 AM</p>
								    				<h3>Keynote on UX & UI Design</h3>
								    				<span>By Ned Stark</span>
								    			</div>
								    		</li>
								    		<li>
								    			<div class="mu-single-event">
								    				<p class="mu-event-time">1.00 PM</p>
								    				<h3>The End</h3>
								    			</div>
								    		</li>
								    	</ul>
								    </div>
								    
								</div>

							</div>
							
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Schedule -->
<?php 
	$conf_id = implode(',',$active_conference); ?>
	
	

	 <section id="mu-speakers">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-speakers-area">

							<div class="mu-title-area">
								<h2 class="mu-title">Our Speakers</h2>


								
							</div>

							<!-- Start Speakers Content -->
							<div class="mu-speakers-content">

								<div class="mu-speakers-slider">

									<?php
								 $select_speaker_query = "SELECT * FROM `conference_speaker_detail` WHERE `conference_id` IN ($conf_id)";
	 $result_speaker_query = mysqli_query($_connection,$select_speaker_query);
	 while($rows_speaker_query = mysqli_fetch_assoc($result_speaker_query)){ ?>


									<!-- Start single speaker -->

									<div class="mu-single-speakers">

										<img src="../../upload/<?php echo $rows_speaker_query['speaker_image']; ?>">
										<div class="mu-single-speakers-info">
											<h3><?php echo $rows_speaker_query['speaker_name']?></h3>
											<p><?php echo $rows_speaker_query['speaker_designation']?></p>
											<p> Speaking On: <?php echo $rows_speaker_query['speaking_desc']; ?> </p>
											<ul class="mu-single-speakers-social">
												<li><a href="#"><i class="fa fa-facebook"></i></a></li>
												<li><a href="#"><i class="fa fa-twitter"></i></a></li>
												<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
											</ul>
										</div>
									</div>
									<?php }

	

?>
									<!-- End single speaker -->

			
									<!-- End single speaker -->
								</div>
							</div>

		<!-- Start Speakers -->
		
							<!-- End Speakers Content -->

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Speakers -->
<?php 
$select_venue_query = "SELECT * FROM conference_detail WHERE conference_id='".$conf_id."'";
$result_venue_query = mysqli_query($_connection,$select_venue_query);
while($rows_venue_query=mysqli_fetch_assoc($result_venue_query)){
?>
		<!-- Start Venue -->
		<section id="mu-venue">
			<div class="mu-venue-area">
				<div class="row">

					<div class="col-md-6">
						<div class="mu-venue-map">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3508.8176744277202!2d-81.47150788457147!3d28.424757900613237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88e77e378ec5a9a9%3A0x2feec9271ed22c5b!2sOrange+County+Convention+Center!5e0!3m2!1sen!2sbd!4v1503833952781" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
						</div>
					</div>

					<div class="col-md-6">
						<div class="mu-venue-address">
							<h2>VENUE <i class="fa fa-chevron-right" aria-hidden="true"></i></h2>
							<h3><?php echo $rows_venue_query['conference_landmark']; ?> </h3>
							<h4><?php echo $rows_venue_query['conference_city']; ?> , <?php echo $rows_venue_query['conference_state']; ?> </h4>
							<h4><?php echo $rows_venue_query['conference_country']; ?> , <?php echo $rows_venue_query['conference_postalcode']; ?> </h4>
							
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- End Venue -->
	<?php } ?>

		<!-- Start Pricing  -->
		<section id="mu-pricing">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-pricing-area">
							
							<div class="mu-title-area">
								<h2 class="mu-title">Pricing plans</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis unde, ut sapiente et voluptatum facilis consectetur incidunt provident asperiores at necessitatibus nulla sequi voluptas libero quasi explicabo veritatis minima porro.</p>
							</div>
							
							<div class="mu-pricing-conten">
								<div class="row">
									
									<!-- single price item -->
									<div class="col-md-4">
										<div class="mu-single-price">

											<div class="mu-single-price-head">
												<span class="mu-currency">$</span>
												<span class="mu-rate">12</span>
												<span class="mu-time">/all days</span>
											</div>
											<h3 class="mu-price-title">BASIC</h3>
											<ul>
												<li>Basic Class Ticket</li>
												<li>Access to all sessions</li>
												<li>Free Breakfast</li>
											</ul>
											<a class="mu-register-btn" href="#"> Register Now</a>
										</div>
									</div>
									<!-- / single price item -->

									<!-- single price item -->
									<div class="col-md-4">
										<div class="mu-single-price mu-popular-price">
											<span class="mu-price-tag">Popular</span>
											<div class="mu-single-price-head">
												<span class="mu-currency">$</span>
												<span class="mu-rate">22</span>
												<span class="mu-time">/all days</span>
											</div>
											<h3 class="mu-price-title">STANDARD</h3>
											<ul>
												<li>Basic Class Ticket</li>
												<li>Access to all sessions</li>
												<li>Free Breakfast</li>
											</ul>
											<a class="mu-register-btn" href="#"> Register Now</a>
										</div>
									</div>
									<!-- / single price item -->

									<!-- single price item -->
									<div class="col-md-4">
										<div class="mu-single-price">

											<div class="mu-single-price-head">
												<span class="mu-currency">$</span>
												<span class="mu-rate">45</span>
												<span class="mu-time">/all days</span>
											</div>
											<h3 class="mu-price-title">PREMIUM</h3>
											<ul>
												<li>Basic Class Ticket</li>
												<li>Access to all sessions</li>
												<li>Free Breakfast</li>
											</ul>
											<a class="mu-register-btn" href="#"> Register Now</a>
										</div>
									</div>
									<!-- / single price item -->

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Pricing -->

		<!-- Start Register  -->
		<section id="mu-register">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-register-area">

							<div class="mu-title-area">
								<h2 class="mu-title">Register Form</h2>
							</div>

							<div class="mu-register-content">
								<form class="mu-register-form" method="post">

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">                
												 <label style="color:white">Username</label>  <span style="color:red">* <?php echo $user_profile_username_error;?></span>
                                        <input type="text" class="form-control" placeholder="Username" name="user_profile_username" maxlength="10" minlength="6">

                                        
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">                
												 <label style="color:white" for="exampleInputEmail1">Email address</label>  <span style="color:red">* <?php echo $user_profile_email_error;?></span> 
                                        <input type="email" class="form-control" placeholder="Email" name="user_profile_email" maxlength="50">
                                       
											</div>     
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group"> 
											 <label style="color:white">First Name</label>  <span style="color:red">* <?php echo $user_profile_fname_error;?></span>             
												<input type="text" class="form-control" placeholder="First Name" name="user_profile_fname" maxlength="50">
                                        
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group"> 
											 <label style="color:white">Last Name</label>     
											  <span style="color:red">* <?php echo $user_profile_lname_error;?></span>           
												<input type="text" class="form-control" placeholder="Last Name" name="user_profile_lname" maxlength="50">
                                       
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">      
											  <label style="color:white">Address</label> <span style="color:red">* <?php echo $user_profile_address_error;?></span>          
												<textarea rows="5" class="form-control" placeholder="Here can be your description" name="user_profile_address" maxlength="200"> </textarea>
                                        
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group"> 
											   <label style="color:white">City</label>    <span style="color:red">* <?php echo $user_profile_city_error;?></span>            
												 <input type="text" class="form-control" placeholder="City" name="user_profile_city" maxlength="50">>
                                        
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group"> 
											   <label style="color:white">Country</label>   <span style="color:red">* <?php echo $user_profile_country_error;?></span>               
												<input type="text" class="form-control" placeholder="Country" name="user_profile_country" maxlength="50">
                                       
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">  
											   <label style="color:white">Postal Code</label>  <span  style="color:red">* <?php echo $user_profile_postalcode_error;?></span>            
												 <input type="number" class="form-control" placeholder="Postal Code" name="user_profile_postalcode" maxlength="6">
                                        
											</div>
										</div>
									</div>
									 <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label style="color:white">About Me</label>
                                        <span  style="color:red">* <?php echo $user_profile_aboutme_error;?></span> 
                                        <textarea rows="5" class="form-control" placeholder="Here can be your description" name="user_profile_aboutme" maxlength="100"> </textarea>
                                        
                                    </div>
                                </div>
                            </div>
									<div class = "row">
										<div class="col-md-6">
											
										<!-- <div class="form-group"> 
											<select class="form-control" name="ticket" id="ticket">
												<option value="0">Basic ($12)</option>
												<option value="1">Standard ($22)</option>
												<option value="2">Premium ($45)</option>
											</select>
										</div>       -->
										</div>
									</div>

									<button type="submit" name="submit_user" class="mu-reg-submit-btn">SUBMIT</button>

					            </form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Register -->

	

		<!-- Start Sponsors -->
		<section id="mu-sponsors">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-sponsors-area">
							
							<div class="mu-title-area">
								<h2 class="mu-title">Our Sponsors</h2>
								<p>Spnsors for the conference</p>
							</div>
				
							<!-- Start spnonsors brand logo -->
							<div class="mu-sponsors-content">
																				
								<div class="row">
								<?php
				 
$select_sponsor_query = "SELECT * FROM conference_sponsor_detail WHERE conference_id='".$conf_id."'";
$result_sponsor_query = mysqli_query($_connection,$select_sponsor_query);
while($rows_sponsor_query=mysqli_fetch_assoc($result_sponsor_query)){
?> 
								
									<div class="col-md-2 col-sm-4 col-xs-4">
									
										<div class="mu-sponsors-single">

											<img src="<?php echo SPONSOR_PATH?><?php echo $rows_sponsor_query['sponsor_logo'];?>" alt="Brand Logo">
												
										</div>
								
									</div>

									
							<!-- End spnonsors brand logo -->
<?php } ?>
						</div>
						
					</div>
				
				</div>
			</div>
		</section>
		<!-- End Sponsors -->


		<!-- Start Contact -->
		<section id="mu-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mu-contact-area">

							<div class="mu-title-area">
								<h2 class="mu-heading-title">Contact Us</h2>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever</p>
							</div>

							<!-- Start Contact Content -->
							<div class="mu-contact-content">
								<div class="row">

								<div class="col-md-12">
									<div class="mu-contact-form-area">
										<div id="form-messages"></div>
											<form id="ajax-contact" method="post" class="mu-contact-form">
												<div class="form-group">          <span style="color:red"> <?php echo $contactus_name_error; ?> </span>      
													<input type="text" class="form-control" placeholder="Name" id="name" name="contactus_name" maxlength="50">
												</div>
												<div class="form-group">        <span style="color:red"> <?php echo $contactus_email_error; ?> </span>              
													<input type="email" class="form-control" placeholder="Enter Email" id="email" name="contactus_email"  maxlength="50">
												</div>              
												<div class="form-group">
													<span style="color:red"> <?php echo $contactus_msg_error; ?> </span>      
													<textarea class="form-control" placeholder="Message" id="message" name="contactus_msg"  maxlength="300"></textarea>
												</div>
												<input   type="submit" class="mu-send-msg-btn" name="submit_contactus" value="SUBMIT" >
								            </form>
										</div>
									</div>
								</div>
							</div>
							<!-- End Contact Content -->
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- End Contact -->

	</main>
	
	<!-- End main content -->	
			
			
	<!-- Start footer -->
	<footer id="mu-footer" role="contentinfo">
			<div class="container">
				<div class="mu-footer-area">
					<div class="mu-footer-top">
						<div class="mu-social-media">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-google-plus"></i></a>
							<a href="#"><i class="fa fa-linkedin"></i></a>
							<a href="#"><i class="fa fa-youtube"></i></a>
						</div>
					</div>
					<div class="mu-footer-bottom">
						<p class="mu-copy-right">&copy; Copyright <a rel="nofollow" href="http://markups.io">markups.io</a>. All right reserved.</p>
					</div>
				</div>
			</div>

	</footer>
	<!-- End footer -->

	
	
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
	<!-- Slick slider -->
    <script type="text/javascript" src="assets/js/slick.min.js"></script>
    <!-- Event Counter -->
    <script type="text/javascript" src="assets/js/jquery.countdown.min.js"></script>
    <!-- Ajax contact form  -->
    <script type="text/javascript" src="assets/js/app.js"></script>
  
       
	
    <!-- Custom js -->
	<script type="text/javascript" src="assets/js/custom.js"></script>

	
	
    
  </body>
</html>