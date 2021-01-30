
	</div>

	<?php $this->load->view('shared/modals'); ?>

 

	<form action="" id="uploadformelement">
		
		<input type="file" name="attachFile" multiple="true" id="attachFile" class="d-none"  accept="video/*, image/*, .pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx,.txt">
	</form>



	<script type="text/javascript" src="<?= base_url()?>assets/plugins/jquery-ui.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	

	
	<!-- PLUGINS -->
	
	<!-- if QRCODE -->
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/qrcode/easy.qrcode.min.js"></script>
	<!-- if calendar -->
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/multilingual-calendar-date-picker/jquery.calendar.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/bootstrap-notify-master/bootstrap-notify.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/jquery-confirm/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/bootstrap-select-1.13.14\dist\js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/moment.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/qrcode/instascan.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugins/lightbox/js/lightbox.js"></script>
	<!-- PLUGINS END -->

	<script type="text/javascript" src="<?= base_url()?>assets/js/project.modals.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/js/project.common.js"></script>

	
	<?php if(getSessionData('sess_userRole') == 'teacher'):  ?>
		<script type="text/javascript" src="<?= base_url()?>assets/js/project.teacher.js"></script>
	<?php else: ?>
		<script type="text/javascript" src="<?= base_url()?>assets/js/project.student.js"></script>
	<?php endif; ?>


	<?php if( isset($projectScripts)  ): ?>
		<?php foreach ($projectScripts as $script) : ?>
			<script type="text/javascript" src="<?=base_url()?>assets/js/<?=$script;?>.js"></script>
		<?php endforeach; ?>
	<?php endif; ?>


	<script type="text/javascript">
		jQuery( function(){
			$('#Calendar').calendar({
    			months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    			days: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
    			color:'#7897e1'

  			});
		});
	</script>

</body>
</html>