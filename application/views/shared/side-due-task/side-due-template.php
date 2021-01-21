
<?php 
	$isContained = true;


?>

<div class="<?= $isContained ? 'panel' : ''; ?>">
	<div class="panel-header heading bor" >
		<strong>Due this week.</strong>	 
	</div>
	<div class="border-top border-bottom pl-3 pr-3 p-2 text-center">
		<span> ( May 11-16 ) </span>
	</div>
	<div class="panel-content">
		
		<?php $this->load->view('shared/side-due-task/side-due-item'); ?>

		<?php $this->load->view('shared/side-due-task/side-due-item'); ?>
		
		<?php $this->load->view('shared/side-due-task/side-due-item'); ?>

		
	</div>

</div>
