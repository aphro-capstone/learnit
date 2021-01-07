<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>404 Page Not Found</title>
		<link rel="stylesheet" type="text/css" href="../../learnit/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../../learnit/assets/css/project.css">
	</head>
	<body class="error-page">
		<div class="overlay"></div>
		<div id="container">
			<span class="icon"> <i class="fa fa-warning"></i> </span>
			<h1><?php echo $heading; ?></h1>
			<?php echo $message; ?>	
		</div>
	</body>
</html>