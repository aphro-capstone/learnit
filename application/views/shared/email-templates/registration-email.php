


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.container{ 
			padding: 70px;
   			padding-bottom: 30px;
    		background: #dbdbdb; 
    		    text-align: center;
    	}
		#message{
			padding: 15px;
		    width: 475px;
		    background: #fff;
		    margin: auto;
		    border-radius: 5px;
		    box-shadow: 1px 5px 9px #00000038;
		    text-align: center;
		    padding-bottom: 30px;
		}
		#message h2{
			margin-bottom: 5px;
		    margin-top: 0;
		    font-size: 25px;
		}

		#message p{
			margin-bottom: 25px;
		    font-size: 14px;
		    font-weight: 600;
		    margin-top: 0;
		}
		#message a{
			background: #7A96E0;
		    padding: 10px 20px;
		    color: #fff;
		    text-decoration: none;
		    font-size: 16px;
		    margin-top: 10px;
		    margin-bottom: 20px;
		    border-radius: 3px;
		    border: 1px solid #748ccc;
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
		}
	</style>
</head>
<body>
 
	<div class="container">
		<div id="image"> 
			<img src="cid:<?php echo $cid; ?>" alt="photo1" />
		</div>
		<div  id="message">
			<h2>  Almost Done! </h2>
			<p> Verify email address by clicking the link below. </p>
			<p> Verification Code :: <?=$code;?></p>
			<a href="<?=site_url(); ?>home/verifyEmail/<?=$code;?>"> Verify Email</a>	
		</div>
		<div id="copyright"> <strong>COPYRIGHT &copy; 2020</strong> | LearnIT Philippines</div>
	</div>

</body>
</html>