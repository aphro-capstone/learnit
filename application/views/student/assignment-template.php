
<?php 

	 
	$dueDate = date_create($AD['tsk_duedate']); 
	$currentDate =  new DateTime();

	$taskRemark = $dueDate < $currentDate ? 'late' : 'aa';

	$teacherView = isset( $teacherView ) ? $teacherView : 'false';
?>

<script>
	const assID = <?=$AD['ass_id'];?>;
	const tskID = <?=$AD['task_id'];?>;
	const teacherview = <?= $teacherView;?>;
</script>

 
<div class="container" id="assignment-template" >
	<div class="d-table"> 
		<h3 class="page-title">   
			<?php if( $teacherView == 'true' ): ?>
				<a href="<?= getSiteLink('classes/assignment/assignment:' . $AD['task_id']);?>"> <i class="fa fa-arrow-left"></i> </a> 
			<?php endif; ?>
			Assignment Details</h3>
				
		<div class="pull-right">
			<?php $this->load->view('shared/breadcrumbs', isset($bcrumbs) ? array( 'bcrumbs' => $bcrumbs ) : array() );  ?>
		</div>	
	</div>
	

	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4 pr-1"> 
			<div class="ribbon-container">
				<div class="panel panel2">

					<?php if($taskRemark == 'late'):  ?>
						<div class="ribbon top-right-ribbon ribbon1 ribbon-danger">
							<div class="content">
								<span> Late </span>
							</div>
						</div>
					<?php endif; ?>
 
					<div class="panel-content">
						<div class="d-flex"> 
							<i class="icon fa fa-clock-o jumbo-text mr-2 <?= $taskRemark == 'late' ? 'text-danger' : '' ?>"></i> 
							<div class="">
								<span class="d-block font-bold <?= $taskRemark == 'late' ? 'text-danger' : '' ?>"> <?= $taskRemark == 'late' ? 'Past Due' : 'Due Date' ?> </span>
								<span class="small-text"> <?php echo date_format( date_create($AD['tsk_duedate']), 'Y/m/d @ H:i a') ?> </span>
							</div>
						</div>
						<div class="d-flex mt-2">
							<div class="img-container mr-2" style="width:36px;s">
								<img src="<?=base_url() . 'assets/images/avatars/user.png'; ?>">
							</div>
							<div class="">
								<?php if( $teacherView == 'true' ): ?>
									<span class="d-block"> <?= $AD['teachername'];?> </span>
								<?php endif; ?>
								<span class="d-block"> <a href="<?=getSiteLink('classes/class-' . $AD['class_id'])?>"> <?=$AD['class_name']?> </a> </span>
							</div>
						</div>
						<hr>
						<span class="d-block font-bold">  Instructions </span>
						<p class="instruction-content mt-2">
							<?= $AD['tsk_instruction'];?>
						</p>
						<hr> 
						<span class="d-block font-bold">  Attachment : </span>
						<div class="files">
							
							<?php $this->load->view('shared/attachment-template',array('attachments' =>   json_decode( $AD['ass_attachments'],true ),'type' => 'ass_attach', 'dataID' => $AD['ass_id']  ) ); ?>
						</div>
					</div>
				</div>	
			</div>
			
		</div>

		<div class="col-sm-12 col-md-8 col-lg-8">
			<div class="panel">
				<h4 class="panel-header border-bottom"> <strong> Title : <?= $AD['tsk_title'];?>	</strong></h4>
				<div class="panel-content">
						
					<?php if( (isset($AD['submissions'])) && count( $AD['submissions']  ) != 0  ||  (isset($allowRevision) && $allowRevision)):  ?>
						<ul class="tabs nav nav-tabs ">
							<?php  for( $x = 0; $x < count($AD['submissions']); $x++ ):
								$submission = $AD['submissions'][$x];
								$date = date_format(new Datetime( $submission['datetime_submitted'] ), 'F d, Y');
							?>
								<li> <a href="#submission_<?=$x;?>" data-toggle="tab" class=""> <?php echo $date ?> </a>  </li>
							<?php endfor; ?>		
						</ul>
						<div class="tab-content">
							<?php  for( $x = 0; $x < count($AD['submissions']); $x++ ):
								$this->load->view('student/task/assignment/submission', array('submission' => $AD['submissions'][$x] , 'index' => $x,'lastInd' => count($AD['submissions']) - 1 ));
							?>
							 
							<?php endfor; ?>
						</div>
							
						
					<?php else: ?>
						<textarea class="add-text"> Add Text </textarea>
						<div class='drop-item-box custom_drag-drop' id="drop-item-box">
							<div class="dz-message placeholder" data-dz-message>
								<span class="jumbo-text font-bold faded"> No submitted item. </span>
								<span class="d-block"> Drop your files/attachments in here or  </span>
							</div>

						</div>
						<div class="d-table full-with mt-4">
							<button class="btn btn-outline-secondary hoverable-btn mr-2 add-text-btn"> <i class="fa fa-file-text-o"></i> <span>Add text</span> </button>
							<button class="btn btn-outline-secondary hoverable-btn" data-toggle="modal" data-target="#addLibrary"> <i class="fa fa-book"></i> <span>Add file from backpack</span> </button>
							<button class="btn btn-primary pull-right submitAssignment"> <i class="fa fa-sent"></i> Submit Assignment </button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>