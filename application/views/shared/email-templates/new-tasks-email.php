<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.container{ 
			padding: 70px;
   			padding-bottom: 30px;
    		background: #dbdbdb; 
    	}
		#message{
			padding: 15px;
		    width: 80%;
		    background: #fff;
		    margin: auto;
		    border-radius: 5px;
		    box-shadow: 1px 5px 9px #00000038;
		    padding-bottom: 30px;
		}
		#message h2{
			margin-bottom: 5px;
		    margin-top: 0;
		    font-size: 25px;
		}

		#message p{
			margin-bottom: 0;
		    font-size: 14px;
		    margin-top: 0;
		}

		#image{
			width: 300px;
			margin: auto;
			margin-bottom: 20px;
		}
		#image img{
			width: 100%;
		}

		#copyright{
			margin-top: 20px;
		    font-size: 15px;
		    color: #000;
			text-align: center;
		}
	</style>
</head>
<body>

	<div class="container">
		<div id="image">
			<img src="cid:<?php echo $cid; ?>" alt="photo1" />
		</div>
		<div  id="message"> 
			<p class="text-left" style="margin-bottom:30px;">Good day <strong>Mr./Ms <?php echo $guardian_name; ?></strong>,</h3>
			<p> A new <?= $taskname; ?> has been posted on class <strong> <?= $classname; ?> </strong> </p>
			<p> Please click the link to see the <?= $taskname; ?>  : <a href="<?= site_url('student/post/'. $postID) ?>"><?=  site_url('student/post/'. $postID) ?></a></p>
		</div>
		<div id="copyright"> <strong>COPYRIGHT &copy; 2020</strong> | LearnIT Philippines</div>
	</div>

</body>
</html>