<!DOCTYPE html>
<html>
	<head>
		<title> Learn IT Project</title>
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url(); ?>assets/images/favicon.ico" type="image/x-icon">


		<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/project.css">

	</head>
	<body class="login-page">

		<div class="overlay"></div>

		<div class="cont1 d-flex">
			<div class="logo img-container">
				<img src="<?= base_url(); ?>/assets/images/logo white.png">
			</div>
			<div class="loginContainers" id="loginContainer">
				<div class="overlay"></div>
				<div class="contain position-relative pt-5 pb-5 pl-5 pr-5">
					<p class="error-code">
						<?php echo $message;?>
						<?php if($approved): ?>
							<a  href="<?=site_url();?>" class="btn btn-primary d-block mt-3 "> Login Now </a>
						<?php endif; ?>	
					</p>
				</div>
			</div>
		</div>


		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/jquery-3.5.0.min.js"></script>
		<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>