<script>
	const activeClass = "<?= getActiveClass(); ?>";
	const isQuizview = false;
	const teacherEdit = <?= isset( $TE) ?  $TE : 'false';?>;
</script>

<?php if( isset(  $TE ) ):  ?>
	<script>
		const quiz_questions = JSON.parse( <?= json_encode( $TI['quiz_questions'] );?> );
		const assignees =  <?= json_encode( $assignees ); ?> ;
		const TI = <?= json_encode( $TI );?>;
	</script>
<?php endif; ?>
 
<div class="container quiz-form-container">
	<div class="" style="    max-width: 90%; margin: auto;">
		<div class="ribbon-container left">
			<div class="panel panel2">
				<div class="panel-header border-bottom">
					<h3 class="normal-title m-0"> Quiz Details</h3  >
				</div>
				<div class="panel-content">
					<div class="form-group">
			          <label >Quiz Title</label>
			          <input type="text" name="title"  class="form-control" placeholder="Quiz Title" value="<?=  isset($TI['tsk_title']) ? $TI['tsk_title'] : '';  ?>">
			        </div>

			        <div class="form-group">
			          <label >Instructions</label>
			          <textarea class="form-control" name="instruction" placeholder="" style="min-height: 110px;" ><?= isset( $TI['tsk_instruction']) ? $TI['tsk_instruction'] : '';?></textarea>
			        </div>
				</div>
			</div>

			<div class="panel mt-3 panel2">
				<div class="panel-header border-bottom d-table full-width">
					<h3 class="normal-title m-0 d-table"> 
						<span class="pull-left" >Questions</span>   
						<div class="pull-right" > Total Questions : <span class="total-question">9</span> | Total Points : <span class="total-point">0</span> </div>
					</h3>
				</div>
				<div class="panel-content">
					<div id="questions-list"> </div>
				</div>
			</div>
			<div class="mt-3 d-flex">
				<button class="btn btn-primary btn-md m-auto p-3 addAnotherQuestion mr-0"> <i class="fa fa-plus"></i> Add New Question </button>
			</div>

		</div>
	</div>
	

</div>





<div class="side-options">
	<button class="btn createQuiz mb-2">  <?= !isset( $TI['quiz_id'] ) ? '<i class="fa fa-plus"></i> Create Quiz':'<i class="fa fa-save"></i> Update Quiz'; ?> </button>						
	<!-- <button class="btn createQuiz mb-3"> <i class="fa fa-plus"></i> Preview </button> -->
	<div class="form-group mb-3">
		<input type="number" class="form-control jumptoinput"  placeholder="jump to question">
	</div>
	<?php if( isset($TE) && $TE ): ?> 
		<a class="btn btn-danger full-width" href="<?=  site_url('teacher/classes/quiz/quiz:'. $TI['tsk_id']); ?>"> <i class="fa fa-chevron-left"></i> return </a>
	<?php else: ?>
		<a class="btn btn-danger full-width" href="<?=  site_url('teacher/classes/class-'. getActiveClass() ); ?>"> <i class="fa fa-chevron-left"></i> return </a>
	<?php endif; ?>
</div>