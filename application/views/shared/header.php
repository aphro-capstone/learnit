<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<?php 
		$body_class = isset($pageTitle) ?  str_replace(' ', '', strtolower($pageTitle) )  : '';
	 ?>

	<title>LEARNIT <?=isset($pageTitle) ? ' | ' . $pageTitle : '';?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="<?= base_url()?>assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= base_url()?>assets/images/favicon.ico" type="image/x-icon">


	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/jquery-confirm/jquery-confirm.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/plugins/lightbox/css/lightbox.css">


	<!--  Condition if allow calendar -->
	<link rel="stylesheet" href="<?= base_url()?>assets/plugins/multilingual-calendar-date-picker/jquery.calendar.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/plugins/bootstrap-select-1.13.14\dist/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
	 
	<!--  Condition if allow calendar END -->
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/project.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/icons.css">
	
	


	<?php if( isset($projectCss)  ): ?>
		<?php foreach ($projectCss as $css) : ?>
			<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/project/<?=$css;?>.css">
		<?php endforeach; ?>
	<?php endif; ?>

	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/light-theme.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/project.mediaqueries.css">

	<script type="text/javascript">
		const SITE_URL = '<?=site_url();?>';
		const BASE_URL = '<?=base_url();?>';
		const USER_ROLE = '<?=getSessionData('sess_userRole');?>';
	</script>
		<script type="text/javascript" src="<?= base_url()?>assets/plugins/jquery-3.5.1.min.js"></script>
</head>
<body id="<?=$body_class;?>" class="<?= isset($body_classes) ? $body_classes : ''; ?>" >
	<div class='overlay-loading loading'>
		<div class="overlay"></div>
		<div class="sk-spinner sk-spinner-wave">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>	
	</div>
	<header class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-8 col-lg-8 col left-content">
					<div class="logo img-container">
						<a href="<?=site_url();?>"><img src="<?= base_url()?>assets/images/logo-signedin.png"></a>
						
					</div>

					<?php $this->load->view('shared/navs');?>
					
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 col right-content m-auto">
					<ul class="navbar-nav">
				      <!-- <li class="nav-link">
				      	<div class="search">
				      		<input type="text" name="search" placeholder="Search..">
				      		<i class="fa fa-search"></i>
				      	</div>
				      </li> -->
				      <li class="nav-link dropdown">
				        <a class="notification-link" data-toggle="dropdown" href="#"> <i class="fa fa-bell"></i></a>
				        <div class="notification-bar dropdown-menu">
				        	<div class="heading">
				        		<h4> Notification </h4>
				        		<a href="#" charset="see-all-link"> See all </a>
				        	</div>
				        	<div class="notification-contents">
				        		<div class="placeholder">
				        			<h3>You have no notification</h3>
				        			<p>Updates from classes, student submissions, teacher posts, and content partners will all appear here.</p>
				        		</div>
				        	</div>
				        </div>
				      </li>
				      <li class="dropdown navbar-user">
				      		<a href="#" class="" data-toggle="dropdown" >
				      			<div class="user-nav img-container image-circular">
					      			 <img src="<?=base_url() . getSessionData('sess_userImage');?>" alt="ddd" />
					      		</div>
				      		</a>
	                        
	                        <ul class="dropdown-menu animated fadeInLeft">
	                            <li><a href="#"><i class="fa fa-users"></i> Profile</a></li> 
	                            <!-- <li><a href="#"><i class="fa fa-users"></i> Invite Teachers</a></li>  -->
	                            <!-- <li><a href="#"><i class="fa fa-users"></i> Connections</a></li>  -->
	                            <!-- <li><a href="#"><i class="fa fa-users"></i> Groups</a></li>  -->
	                            <!-- <li><a href="#"><i class="fa fa-users"></i> Account Settings</a></li>  -->

	                            <li><a href="<?=site_url() .'/'. getSessionData('sess_userRole') . '/logout';?>"> <i class="fa fa-sign-out"></i> Log Out</a></li>
	                        </ul>
	                    </li>
				    </ul>
				</div>
			</div>
		</div>
	</header>
	<div class="container-fluid" id="main-content">
		<div class="overlay-content"></div>