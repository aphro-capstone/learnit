
<?php 
	$isContained = true;

?>

<div class="<?= $isContained ? 'panel' : ''; ?>">
	<div class="panel-header heading bor" >
		<strong>Due this week.</strong>	 
	</div>
	<div class="border-top border-bottom pl-3 pr-3 p-2 text-center dropdown">
		<span> ( <?php echo $duetasks['daterange']; ?> ) </span>
		<div class="dropdown pull-right display-inline due-task-filter">
			<span class="clickable-content" data-toggle="dropdown"> <i class="fa fa-filter"></i> </span>
			<ul class="dropdown-menu start-from-right text-right">
				<li divs="all" > <a href="#"> All </a></li>
				<li divs="active" > <a href="#"> Active </a></li>
				<?php if(getRole() != 'teacher'): ?>
					<li divs="submitted" > <a href="#"> Submitted </a></li>
					<li divs="submitted" > <a href="#"> No Submisions </a></li>
				<?php else: ?>
					<li divs="has-submits" > <a href="#"> Has Submissions </a></li>
					<li divs="no-submits" > <a href="#"> No Submissions </a></li>
				<?php endif; ?>
				
				<li divs="today" > <a href="#"> Due Today </a></li>
				<li divs="late" > <a href="#"> Late </a></li>
				<li divs="closed" > <a href="#"> Closed </a></li>
			</ul>
		</div>
	</div>
	<div class="panel-content">
		<?php if( count( $duetasks['result'] ) > 0 ): ?>
			<?php  foreach( $duetasks['result'] as $task ): ?>
				<?php $this->load->view('shared/side-due-task/side-due-item',array( 'task' => $task )); ?>
			<?php endforeach; ?>	
		<?php else: ?>
			<p class="faded text-center"> No task due this week </p>
		<?php endif ?>
	</div>

</div>
