


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
		    width: 80%;
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
			margin-bottom: 0;
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
			<?php 
				$option_ = 0;
				
				if( isset($option) ) $option_ = $option;

			?>

			
			
			<?php if( $option == 0 ) : ?>    <!--  Enrollee teacher -->
				<h2> Congratulation! </h2>
				<p> This is to notify you that student, <?= $fname . ' ' .  $lname;?>, has enrolled in your class "<?=$classname;?>" </p>
			<?php elseif( $option == 1 ): ?>  <!--  Reenrollee teacher -->
				<h2> Congratulation! </h2>
				<p> This is to notify you that student, <?= $studname;?>, has reenrolled in the class "<?=$classname;?>" </p>
			<?php elseif( $option == 2 ): ?>  <!--  Wthdraw teacher -->
				<h2> Oh noooo! </h2>
				<p> This is to notify you that student, <?= $studname;?>, has withdrawn from your class "<?=$classname;?>" </p>

			<?php elseif( $option == 3 ): ?>
				<h2> Congratulation! </h2>
				<p> This is to notify you that Mr./Ms. <?= $studname;?> successfully enrolled in class "<?=$classname;?>" </p>

			<?php elseif( $option == 4 ): ?>
				<h2> Congratulation! </h2>
				<p> This is to notify you that Mr./Ms. <?= $studname;?> successfully reenrolled to class "<?=$classname;?>" </p>

			 <?php else: ?>
				<h2> Oh noooo! </h2>
				<p> This is to notify you that Mr./Ms. <?= $studname;?> has withdrawn from the class "<?=$classname;?>" </p>

			 <?php endif; ?> 
			
		</div>
		<div id="copyright"> <strong>COPYRIGHT &copy; 2020</strong> | LearnIT Philippines</div>
	</div>

</body>
</html>