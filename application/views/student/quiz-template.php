 
 
 <?php
 
	$col1 = 'col-md-3 col-lg-3';
	$col2 = 'col-md-9 col-lg-9';
	$isviewQuiz =  isset($isView) ? $isView : true;
	$VQWS = isset( $VQWS_ ) ? $VQWS_ : true;  // view quiz with student


	if(!$isviewQuiz){
		$col1 = 'col-md-4 col-lg-3';
		$col2 = 'col-md-8 col-lg-9';
	}else{
		$col1 = 'col-md-4 cold-lg-3';
		$col2 = 'col-md-8 cold-lg-9';
	} 

	if( getRole() == 'student' && $isviewQuiz ){
		$col1 = 'col-md-12 col-lg-12';
	}

	if( !$VQWS ){
		// $col1 = 'd-none';
		// $col2 = 'col-md-12 col-sm-12 col-lg-12';
	}
 ?> 

 <script>
	const __q__ = <?= json_encode( json_decode($QSD['quiz_questions'],true) );?>;
	const isQuizview = true;
	const studQuizView =  <?= $isviewQuiz ? 'true' : 'false';?>;
	const VQWS = <?= $VQWS ? 'true' : 'false' ; ?>;
	const quiz_duration = <?= $QSD['quiz_duration'] ?>;
	const quiz = <?= isset($quizid) ? $quizid : $QSD['quiz_id'];?>;
	const task = <?= isset($QSD['tsk_id']) ? $QSD['tsk_id'] : $QSD['task_id'];?>;
	

	<?php if (($isviewQuiz || isset( $teacherView )) && $VQWS ):?>
		const quiz_answers = JSON.parse(<?= json_encode( json_decode($QSD['quiz_answers'],true))?>);
	<?php endif;?>

	
	const QSD = <?php echo json_encode($QSD);?>; 
	
 </script>
<div class="container <?= $isviewQuiz ? 'viewing' : 'taking';?>   <?= !$VQWS ? 'teacher-viewing-empty' :''?>" id="student-quiz-view">

	<?php if( getRole() == 'teacher' ): ?>
		<h5 class="title return"> <a href="<?=getSiteLink('classes/quiz/quiz:' . $QSD['tsk_id']);?>"> <i class="fa fa-arrow-left"></i> </span>  Back   </a> </h5>
	<?php endif; ?>
	
	
	<div class="row">

		
		<?php if($VQWS): ?>
			<div class="col-sm-12 <?=$col1;?>">
				<?php if($isviewQuiz) : ?>
					<div class="<?php echo getRole() == 'student' ? 'row': '' ?> ">
						<div class="<?php echo getRole() == 'student' ? 'col-sm-12 col-md-6 col-lg-6': '' ?> ">
							<div class="panel mt-3" >
								<div class="panel-content">
									<h2 class="normal-title m-0 normal-title m-0 pl-0 pr-0 pb-0"> <i class="fa fa-tasks text-primary"></i>	<?= $QSD['tsk_title'] ?> </h2>
									<?php if( getRole() == 'teacher' && $VQWS): ?>
										<h2 class="normal-title m-0 normal-title m-0 pl-0 pr-0 pb-0"> <i class="fa fa-user text-info"></i>	<?= $QSD['studname'] ?> </h2>
									<?php endif; ?>
									<hr>
									<div class="d-block mb-2">
										<span> Total Point</span>
										<span class="d-block" style="font-size: 2em;"> <?= $QSD['quiz_score'];?> / <?= $QSD['quiz_total'];?> </span>
									</div>
									<span class="d-block small"> Submitted : <?= date_format( new Datetime( $QSD['datetime_submitted'] ), 'F j, Y @ h:m A' );  ?>  </span>
									<span class="d-block small"> Time Taken : <?= $QSD['duration_consumed']  ?>s </span>
								</div>
							</div>
						</div>
						
						<div class="<?php echo getRole() == 'student' ? 'col-sm-12 col-md-6 col-lg-6': '' ?> ">
							<ul class="no-style questions-overview mt-3" >
								<li class="header"> Question Overviews </li>
								<li class="overview-legends">
									<ul class="no-style">
										<li> <div class="color perfect"></div> Perfect   </li>
										<li> <div class="color semi-perfect"></div> Semi-Perfect   </li>
										<li> <div class="color wrong"></div> Wrong   </li>
									</ul>
								</li>
							</ul>
							<ul class="overview-items no-style">	</ul>
					</div>	
					</div>
					

					

				<?php else: ?>
					<ul class="no-style questions-overview mt-3" >
						<li class="header"> Question Overviews </li>
						<li class="overview-legends">
							<ul class="no-style">
								<li> <div class="color no-answer"></div> No Answer </li>
								<li> <div class="color answered"></div> Answered </li>
							</ul>
						</li>
					</ul>
					<ul class="overview-items no-style">	</ul>
					
				<?php endif;?>
			</div>
		<?php else :  ?>
			<div class="col-sm-12 <?=$col1;?>">
				<div class="panel mt-3" >
					<div class="panel-content">
						<h2 class="normal-title m-0 normal-title m-0 pl-0 pr-0 pb-0"> <i class="fa fa-tasks text-primary"></i>	<?= $QSD['tsk_title'] ?> </h2>
						<hr>
						
						<div class="d-block mb-2">
							<span> Total Point  : <?php echo $QSD['quiz_total']; ?></span>
						</div>
						<div class="block">
							<span class="block"> Instruction : </span>
							<p class="ml-2"> <?php echo $QSD['tsk_instruction']; ?> </p>
						</div>

					</div>
				</div>
			</div>
		<?php endif; ?>
		
		
		
		
		
		<div class="col-sm-12 <?=$col2;?> <?php echo $isView && getRole() == 'student' ? 'd-none':''  ?> ">
			<div class="panel mt-3 panel2" >
				<?php if(!$isviewQuiz): ?>
					<div class="panel-header border-bottom d-flex full-width">
						<h5> Title : <?php echo $QSD['tsk_title']; ?></h5>
						<p class="countdown-timer"> Timer : <strong> 60:00 </strong> </span> </p> 
					</div>
				<?php endif; ?>
				<div class="panel-content position-relative">
					<div id="questions-list-frontend" style="width: 100%;"> </div>
					
					
					<?php if(  !$isviewQuiz ): ?>
						<div class="overlay-loading loading" style="display:flex">
							<div class="overlay"></div>
						</div>
					<?php endif; ?>
				</div>
				<div class="panel-footer border-top text-center mt-2 d-table full-width">
					<?php if( !$isviewQuiz ): ?>
						<button class="btn btn-primary btn-lg startquiz"> <i class="fa fa-enter"></i> Start Taking Quiz </button>
						<button class="btn btn-primary btn-lg submitQuiz pull-left" style="display:none;"> <i class="fa fa-enter"></i> Submit Quiz </button>
					<?php endif; ?>
					
					
					
					<div class="pull-right" <?php echo (!$isviewQuiz || getRole() == 'teacher') && $VQWS ? 'style="display:none;"' : '';  ?>>
						<button class="btn btn-primary control-btn prev-btn disabled" > <i class="fa fa-chevron-left"></i> Prev </button>
						<button class="btn nxt-btn  btn-primary control-btn">  Next <i class="fa fa-chevron-right"></i> </button>
					</div> 
				</div>
			</div>	
		</div>
	
		
	</div>  
	
</div>
 