 
 
 <?php
 
	$col1 = 'col-md-3 col-lg-3';
	$col2 = 'col-md-9 col-lg-9';
 	$isviewQuiz = true;
	 
	 if( isset($isView)){
		$isviewQuiz = $isView;
	 }



	if(!$isviewQuiz){
		$col1 = 'col-md-12 col-lg-12';
		$col2 = 'col-md-12 col-lg-12';
	}
 ?> 

 <script>
	 const __q__ = <?= json_encode( json_decode($QSD['quiz_questions'],true) );?>;
	 const isQuizview = true;
 </script>

<div class="container">
	<div class="row">

		<?php if($isviewQuiz) : ?>
			<div class="col-sm-12 <?=$col1;?>">
				<div class="panel mt-3" >
					<div class="panel-content">
						<h2 class="normal-title m-0 normal-title m-0 pl-0 pr-0 pb-0"> <i class="fa fa-tasks text-primary"></i>	<?= $QSD['tsk_title'] ?> </h2>
						<hr>
						<div class="d-block mb-2">
							<span> Total Point</span>
							<span class="d-block" style="font-size: 2em;"> <?= $QSD['quiz_score'];?> / <?= $QSD['quiz_total'];?> </span>
						</div>
						<span class="d-block small"> Submitted : <?= date_format( new Datetime( $QSD['datetime_submitted'] ), 'F j, Y @ h:m A' );  ?>  </span>
						<span class="d-block small"> Time Taken : <?= $QSD['duration_consumed']  ?> minutes </span>
					</div>
				</div>

				<div class="panel mt-3" >
					<div class="panel-content">
						<h2 class="normal-title m-0 normal-title m-0 pl-0 pr-0 pb-0 "> <i class="fa fa-question-circle text-primary"></i> Questions overview </h2>
						<hr>
						<div class="legends">
							<span class="d-block mb-1"> Legends </span>
							<div class="legend-item primary"> <i></i>  Perfect   </div>
							<div class="legend-item secondary"> <i></i>  Correct but not Perfect</div>
							<div class="legend-item danger"> <i></i>  All Wrong</div>
						</div>
						<hr>
						<div class="questions-list">
								<div class="question-item-mini correct"> 1  <span class="pull-right"> 1 / 1 </span>  </div>
								<div class="question-item-mini semi"> 2  <span class="pull-right"> 1 / 3 </span>  </div>
								<div class="question-item-mini wrong"> 3  <span class="pull-right"> 0 / 1 </span>  </div>
						</div>
					</div>
				</div>
			</div>

		<?php endif;?>
		<div class="col-sm-12 <?=$col2;?>">
			<div class="panel mt-3 panel2" >
				<div class="panel-header border-bottom d-table full-width">

					<div class="pull-left">
						<p class="mb-0"> Question <span class="question-number">1</span> </p>
						<!-- <p class="mb-0"> 1/1 point/s </p> -->
					</div>
					<div class="pull-right">
						<button class="btn btn-primary control-btn prev-btn disabled" > <i class="fa fa-chevron-left"></i> Prev </button>
						<button class="btn nxt-btn  btn-primary control-btn">  Next <i class="fa fa-chevron-right"></i> </button>
					</div> 
				</div>
				<div class="panel-content">
					<div id="questions-list-frontend" style="width: 100%;">

					</div>
				</div>
			</div>	
		</div>
	
		
	</div>  
	
</div>
 