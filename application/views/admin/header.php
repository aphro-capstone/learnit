<!DOCTYPE html>
<html>
	<head>
		<title> <?=$pagetitle;?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="<?= base_url()?>assets/images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url()?>assets/images/favicon.ico" type="image/x-icon">


		<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/plugins/font-awesome/css/font-awesome.min.css">

		<!--  Condition if allow calendar -->
		<link rel="stylesheet" href="<?= base_url()?>assets/plugins/multilingual-calendar-date-picker/jquery.calendar.min.css" />

		<link rel="stylesheet" href="<?= base_url()?>assets/plugins/ChartJS/Chart.min.css" />

		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/plugins/DataTables/datatables.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/plugins/select2/css/select2.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.css">
		 
		<!--  Condition if allow calendar END -->
		<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/admin.project.css">

		<script type="text/javascript">
			const domainOrigin = '<?=site_url();?>';
		</script>
	</head>
	<body>

		
		<header class="header">
			<div class="full-width p-3 d-flex">
				<div class="pull-left d-flex">
					<div class="logo pl-3 pr-3 ">
						<div class="img-container">
							<a href="<?=site_url();?>"><img src="<?= base_url()?>assets/images/logo-signedin.png"></a>
						</div>
					</div>
					<div class="nav pl-3 pr-3 nav-toggle m-auto" >
						<a href="#" class="head-icon"> <i class="fa fa-bars"></i></a>
					</div>
				</div>

				<div class="pull-right mt-auto mb-auto mr-0 ml-auto">
					<ul class="no-style d-flex m-0 p-2">
						<li class="pr-3">
							<a href="#" class="head-icon"> <i class="fa fa-envelope-open"></i></a>
						</li>
						<!-- <li class="pr-3"> 
							<a href="#" class="head-icon"> <i class="fa fa-bell"> </i></a>
						</li> -->
						<li class="pr-3">
							<a href="<?=site_url();?>admin/logout" class="head-icon" data-toggle="tooltip" data-placement="left" data-original-title="logout" > <i class="fa fa-sign-out"></i></a>
						</li>
					</ul>
				</div>
 
			</div>
		</header>

		<div class="container-wrapper d-flex">
			<div id="sidenav">
				<div class="userProfile pt-5 pb-5 dropdown">
					<div class="img-container">
						<img src="<?=base_url();?>assets/images/user.png" alt="">
					</div>
					<p class="m-0 text-center mt-1 mb-2"> Administrator</p>
				</div>
				<ul class="sidebar-nav no-style m-0">
					<li class="<?php echo $nav_active == 'dashboard' ? 'active' : ''; ?>"> 
						<a href="<?=site_url();?>admin">  <i class="fa fa-home"></i>  Dashboard </a>
					</li>
					<li class="<?php echo $nav_active == 'datatable' ? 'active' : ''; ?>" > <a href="<?=site_url();?>admin/datatables">  <i class="fa fa-table"></i>  Datatables </a> </li>
					<li class="<?php echo $nav_active == 'multimedia' ? 'active' : ''; ?>" > <a href="<?=site_url();?>admin/multimedia">  <i class="fa fa-gamepad"></i>  Multimedia </a> </li>
					<li class="<?php echo $nav_active == 'settings-nav' ? 'active' : ''; ?>"> <a href="<?=site_url();?>admin/settings">  <i class="fa fa-cogs"></i>  Settings </a> </li>
				</ul>				
			</div>
			<div id="main-container" >
				<div class="heading p-5">
					<h3 class="page-title"><?=$pagetitle; ?></h3>
					<p class="page-sub-title mb-5"><?=$pagesub;  ?></p>
				</div>
				<div class="content-wrapper">
					
			
