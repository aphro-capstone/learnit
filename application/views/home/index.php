<!DOCTYPE html>
<html>
	<head>
		<title> Learn IT Project</title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url(); ?>assets/images/favicon.ico" type="image/x-icon">


		<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/project.css">
		<link rel="stylesheet" media="screen and (min-width: 900px)" href="widescreen.css">
	</head>


	<body class="login-page">
		<div class="navmobile-overlay"></div>
		<nav class="navbar navbar-expand-lg navbar-light bg-light pull-right">
		  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <i class="fa fa-bars"></i>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="#" data-toggle="scrollto" data-target="#login">
		        	<i class="fa fa-home"></i> Log In</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#" data-toggle="scrollto" data-target="#features">
		        	<i class="fa fa-reorder"></i> Features </a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#" data-toggle="scrollto" data-target="#activities">
		        	<i class="fa fa-gamepad"></i> Activities </a>
		      </li>
		      
		    </ul>
		   
		  </div>
		</nav>

			<!-- <header class="container-fluid ">
				<div class="container">

					<nav class="   navbar navbar-expand-lg p-0 pull-right">

						  <div class="collapse navbar-collapse" id="navbarNav">
						    <ul class="navbar-nav mr-auto">
						      <li class="nav-item">
						        <a class="nav-link" href="#" data-toggle="scrollto" data-target="#login">
							            <i class="fa fa-home"></i>  Log In </a>
						      </li>
						      <li class="nav-item">
						       <a class="nav-link" href="#" data-toggle="scrollto" data-target="#features">
							            <i class="fa fa-reorder"></i>  Features </a>
						      </li>
						      <li class="nav-item">
						       <a class="nav-link" href="#" data-toggle="scrollto" data-target="#activities">
							            <i class="fa fa-gamepad"></i>  Activities </a>
						      </li>
						    </ul>
						 
						  </div>
						</nav>
			</header> -->
			

		<div class="cont1 d-flex" id="login"> 
			<div class="logo img-container">
				<img src="<?= base_url(); ?>/assets/images/logo-light.png">
			</div>
			<div class="loginContainers" id="loginContainer">
				<div class="overlay"></div>
				<div class="loading">
					<div class="overlay"></div>
					<div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>	
				</div>
				<div class="contain position-relative pt-3 pb-3 pl-5 pr-5">
					<form id="login-form" class="logintabs pt-4 pb-4 login_reg" action="<?=base_url();?>/home/login">
					  	<h2 class="title"> Login to <strong>LeartIT</strong></h2>
					  	<p class="semi-title"></p>
					  	<!-- <div class="row">
					  		<div class="col col-sm-12 col-md-6 col-lg-6"></div>
					  		<div class="col col-sm-12 col-md-6 col-lg-6"></div>
					  	</div> -->
					  	<div class="form-group">	
					    	<input type="text" class="form-control" name="uname" placeholder="Enter username / email / phone #">
					  	</div>
					  	<div class="form-group"> 
					    	<input type="password" class="form-control" name="pass" placeholder="Password">
					  	</div>
					  	<p class="text-center"> <a href="#" id="fgPassword"  role="Tabs" data-target="#forgot-password-form" data-entity-locator=".logintabs"> Forgot Password ? </a></p>
					  	<button type="submit" class="btn btn-primary  full-width">LOGIN</button>
					  	<p class="text-center">  Don't have an  account ? <a href="#" id="signUpbtn"  role="Tabs" data-target="#signup-form" data-entity-locator=".logintabs">Sign up</a></p>
					</form>

					<form id="forgot-password-form" class="logintabs pt-4 pb-4" style="display: none;">
						<p> <span class="c-pointer" role="Tabs" data-target="#login-form" data-entity-locator=".logintabs" >
							<i class="fa fa-chevron-left"></i> Back </span> 
						</p>

						<h2 class="title"> Forgot password</h2>
						<p class="semi-title"> Provide your email/phone # and we will sent the request there. </p>

					  	<div class="form-group">	
					    	<input type="text" class="form-control"  placeholder="Email/Phone #">
					  	</div>
					  	<button type="submit" class="btn btn-primary  full-width">RESET PASSWORD</button>
					</form>

					<div action="<?=site_url();?>home/registration" id="signup-form" class="logintabs pb-3 pt-3" style="display: none;">
						
					
						<div id="account-select" class="signup-selection">
							<p> <span class="c-pointer" role="Tabs" data-target="#login-form" data-entity-locator=".logintabs">
								<i class="fa fa-chevron-left"></i> Back </span> 
							</p>

							<h2 class="title"> Signup new account</h2>
							<p class="semi-title"> Choose which account you would like to create </p>

							<div class="selection">
								<div class="option bordered b-white hover-change" role="Tabs" data-target="#teacher-signup" data-entity-locator=".signup-selection">
									<div class="icon"> <div class="img-container"> <img src="<?= base_url(); ?>assets/images/teacher-icon.png"> </div> </div>
									<div class="text">
										<h4> Teacher Account </h4>
										<p class="mb-0"> Create an account as a teacher, an educator, etc.. </p>
									</div>
								</div>
								<div class="option bordered b-white hover-change" role="Tabs" data-target="#student-signup" data-entity-locator=".signup-selection">
									<div class="icon">  <div class="img-container"> <img src="<?= base_url(); ?>assets/images/student-icon.png"> </div> </div>
									<div class="text">
										<h4> Student Account </h4>
										<p class="mb-0"> Create an account as a student </p>
									</div>
								</div>
							</div>	
						</div>

						<form action="<?=site_url();?>home/registration" id="teacher-signup" class="signup-selection formReg" style="display: none;">

							<p> <span class="c-pointer hover-text-gold" role="Tabs" data-target="#account-select" data-entity-locator=".signup-selection">
								<i class="fa fa-chevron-left"></i> Back </span> 
							</p>

							<h2 class="title"> Signup as a Teacher</h2>
							<p class="semi-title"> Fill-up the required info and submit </p>
							
							
							<input type="hidden" name="form" value="teacher">

							<div class="row">
								<div class="col-xs-6  col-sm-6 col-lg-6 col pr-1">
									<div class="form-group mb-0">
										<input type="text" class="form-control" placeholder="Firstname" name="fname" required="">
									</div>
								</div>
								<div class="col col-xs-6 col-sm-6 col-lg-6  pl-1">
									<div class="form-group mb-0">
										<input type="text" class="form-control" placeholder="Lastname" name="lname" required="">
									</div>
								</div>
							</div>
							<div class="divider2"></div>
							<div class="form-group">
						    	<input type="email" class="form-control" name="email" placeholder="Email">
						  	</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Password">
								<i class="fa fa-view password-view-"></i>
						  	</div>
						  	<button type="submit" class="btn btn-primary full-width">Create account</button>
						</form>

						<form action="<?=site_url();?>home/registration" id="student-signup" class="signup-selection formReg " style="display: none;">
							<input type="hidden" name="form" value="student">
							<p> <span class="c-pointer hover-text-gold" role="Tabs" data-target="#account-select" data-entity-locator=".signup-selection">
								<i class="fa fa-chevron-left"></i> Back </span> 
							</p>

							<h2 class="title"> Signup as a Student</h2>
							<p class="semi-title"> Fill-up the required info and submit </p>

							<div class="collapsible-divs fields">
								<div class="row">
									<div class="col-xs-6  col-sm-6 col-lg-6 col pr-1">
										<div class="form-group mb-0">
									    	<input type="text" class="form-control" placeholder="Firstname" name="fname" required="">
									  	</div>
									</div>
									<div class="col col-xs-6 col-sm-6 col-lg-6  pl-1">
										<div class="form-group mb-0">
									    	<input type="text" class="form-control" placeholder="Lastname" name="lname" required="">
									  	</div>
									</div>
								</div>

								<div class="divider2"></div>

								<div class="form-group">
							    	<input type="text" class="form-control " placeholder="Username" name="uname" required="">
							  	</div>
								<div class="form-group">
							    	<input type="password" class="form-control" placeholder="Password" name="password" required="">
							  	</div>
							  	<div class="divider2"></div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Parent/Guardian Name" required="" name="guardianname">
								</div>
							  	<div class="form-group">
							    	<input type="text" class="form-control" placeholder="Parents/Guardian Phone #" required="" name="guardianphone">
							  	</div>
							  	<div class="form-group">
							    	<input type="text" class="form-control" placeholder="Email ( Optional )"  name="email">
							  	</div> 
							</div>
							
							<div class="collapsible-divs collapsed mb-4" id="qrCodeScanner">
								<div class="video">
									<video id="preview"></video>	
								</div>
								<div class="d-table full-width  mb-5">
									<div class="btn-group btn-group-toggle pull-left" data-toggle="buttons">
									  <label class="btn btn-primary active">
									    <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
									  </label>
									  <label class="btn btn-secondary">
									    <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
									  </label>

									</div>
									<a href="#" class="btn btn-danger cancelscan pull-right"> Cancel Scan </a>
								</div>
								
							</div>

						  	<button type="submit" class="btn btn-primary full-width submit-btn">Create account</button>
						</form>
						<form action="<?=site_url();?>home/verifyStudentMobile" id="student-mobile-verify" " style="display: none;">
							<input type="hidden" name="form" value="student">
							<p> <span class="c-pointer hover-text-gold" role="Tabs" data-target="#account-select" data-entity-locator=".signup-selection">
								<i class="fa fa-chevron-left"></i> Back </span> 
							</p>

							<h2 class="title"> Mobile Verification</h2>
							<p class="semi-title"> Verify the mobile number listed during registration </p>

							<div class="form-group mb-0">
								<input type="text" class="form-control" placeholder="Verification Code" name="mobileverify" required="">
							</div>

						  	<button type="submit" class="btn btn-primary full-width submit-btn mt-3">Verify Account</button>
						</form>

						<p><small>Already have an account? Click <a href="#" role="Tabs" data-target="#login-form" data-entity-locator=".logintabs">here</a> to log in</small></p>
						
						
					</div>
				</div>
			</div>
		</div>


		<div class="container-fuid bg-white w-img-left block-container pl-3 pr-3" id="features">
			<div class="row">
				<div class="col-sm-12 col-md-5 col-lg-5 pl-0 pr-0">
					<div class="ffeat img-container">
						<img src="<?= base_url(); ?>/assets/images/lfeatures.png">
					</div>
				</div>
			<div class="col-sm-12 col-md-7 col-lg-7 d-flex">
				<div class="m-auto">
					<h6 class="block-title">  <span>Features</span>  </h6>
					<p class="block-text"> 
						User accounts for teachers and students with email verification, QrCode for unique class code, Simulations, Assessments and Games, Download and Upload files, Import/Export Gradebook, Accessibility on personal computer and smartphones, and Message notification.
					</p>
				</div>
			</div>			
			</div>
		</div>

		<div class="container-fuid bg-white w-img-right block-container pl-3 pr-3" id="activities">
			<div class="row">
				<div class="col-sm-12 col-md-7 col-lg-7 d-flex">
					<div class="m-auto">
						<h6 class="block-title">  <span>Activities</span>  </h6>
						<p class="block-text"> 
							Challenge your minds with any Activities and Games 
						</p>
					</div>
				</div>	
				<div class="col-sm-12 col-md-5 col-lg-5 pl-0 pr-0">
					<div class="ffeat img-container">
						<img src="<?= base_url(); ?>/assets/images/lactivities.png">
					</div>
				</div>
					
			</div>
		</div>

			
		

		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/bootstrap-notify-master/bootstrap-notify.min.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/qrcode/instascan.min.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/js/project.home.js"></script>
		<!-- <script type="text/javascript" src="<? //= base_url(); ?>assets/js/project.common.js"></script> -->

 		<script type="text/javascript">
		    
		</script>




				
		




	</body>
</html>