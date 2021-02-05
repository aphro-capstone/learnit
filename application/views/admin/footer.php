			
			</div>
		</div>
	</div>

	<div id="addGrades" class="modal fade">
	  <div class="modal-dialog modal-sm" role="document">
	  	<form id="addGrades" class="addForms" action="<?=site_url();?>admin/addForms">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLiveLabel">Add Grades</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       		<input type="hidden" name="id">
		        	<input type="hidden" name="form" class="noresettrigger" value="grade">
		        	<div class="form-group">
					    <input type="text" class="form-control" name="grade"  required placeholder="Grade">
					</div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
	    </form>
	  </div>
	</div>

	<div id="addColor" class="modal fade">
	  <div class="modal-dialog modal-sm" role="document">
	  	<form id="addColor" class="addForms" action="<?=site_url();?>admin/addForms">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLiveLabel">Add Color</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true"> <i class="fa fa-times"></i></span>
		        </button>
		      </div>
		      <div class="modal-body">
		       		<input type="hidden" name="id">
		        	<input type="hidden" name="form" class="noresettrigger" value="color">
		        	<div class="form-group">
					    <input type="text" class="form-control" name="name" required placeholder="Color Name">
					</div>
					<div class="form-group">
						<label class="form">Color</label>
					    <input type="color" class="form-control" name="color" required placeholder="Color">
					</div>
					<div class="form-group">
						<label class="form">Text Color</label>
					    <input type="color" class="form-control" name="tcolor"  required placeholder="Text Color">
					</div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
	    </form>
	  </div>
	</div>
	<div id="addSubject" class="modal fade">
	  <div class="modal-dialog" role="document">
	  	<form id="addSubject" class="addForms" action="<?=site_url();?>admin/addForms">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLiveLabel">Add Subject</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       		<input type="hidden" name="id">
		        	<input type="hidden" class="noresettrigger" name="form" value="subject">
		        	<div class="form-group">
					    <select name="parentSubject" class="form-control" data-reset="" >
					    	<option value="0"> Select Parent Subject ( Optional ) </option>
					    	<?php  foreach ($subject as $row) : ?>
					    				<?php if( empty($row['s_parent_sub']) ):?>
					    					<option value="<?=$row['s_id']?>"> <?= $row['s_name']?> </option>
					    				<?php endif;  ?>
					    	<?php  endforeach; ?>
					    </select>
					</div>
		        	<div class="form-group">
					    <input type="text" class="form-control" name="name" placeholder="Subject name">
					</div>
					<div class="form-group">
					    <input type="text" class="form-control" name="abbre" placeholder="Subject Abbreviation">
					</div>
					<div class="form-group">
						<textarea class="form-control" name="desc" placeholder="Subject Description"></textarea>
					</div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
		</form>
	  </div>
	</div>

	<div id="addAvailabilityModal" class="modal fade">
	  <div class="modal-dialog" role="document">
	  	<form id="addAvailability" class="addForms" action="<?=site_url();?>admin/addForms">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLiveLabel">Add Availability</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       		<input type="hidden" name="id">
		        	<input type="hidden" class="noresettrigger" name="form" value="postavailablity">
		        	
		        	<div class="form-group">
					    <input type="text" class="form-control" name="name" placeholder="Subject name">
					</div>
					<div class="form-group">
					    <select name="roles" class="form-control selectpicker" multiple  title="Select Roles affected">
					    	<option value="*"> All </option>
					    	<option value="student"> Student </option>
					    	<option value="teacher"> Teacher </option>
					    </select>
					</div> 
					<div class="form-group">
						<textarea class="form-control" name="desc" placeholder="Subject Description"></textarea>
					</div>
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
		</form>
	  </div>
	</div>

	<div id="changeStatus" class="modal fade">
	  <div class="modal-dialog" role="document">
	  	<form  action="<?=site_url();?>admin/changestatus">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Change Status</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body">
					<div class="form-group">
					    <select name="roles" class="form-control selectpicker" multiple  title="Select Roles affected">
					    	<option value="*"> All </option>
					    	<option value="student"> Student </option>
					    	<option value="teacher"> Teacher </option>
					    </select>
					</div> 
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
		</form>
	  </div>
	</div>

	<div id="changeStatus" class="modal fade">
	  <div class="modal-dialog" role="document">
	  	<form  action="<?=site_url();?>admin/changestatus">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Reassign Class</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		      </div>
		      <div class="modal-body">
					<div class="form-group">
						<label for=""> Select new teacher </label>
					    <select name="roles" class="form-control selectpicker"    >
					    	<option value="*"> All </option>
					    	<option value="student"> Student </option>
					    	<option value="teacher"> Teacher </option>
					    </select>
					</div> 
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
		</form>
	  </div>
	</div>



	<script type="text/javascript" src="<?= base_url()?>assets/plugins/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/jquery.form.js"></script>
	<!-- PLUGINS -->

	<!-- if calendar -->
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/multilingual-calendar-date-picker/jquery.calendar.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/bootstrap-notify-master/bootstrap-notify.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/plugins/ChartJS/Chart.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/DataTables/datatables.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugins/moment.js"></script>
	<!-- PLUGINS END -->

	<script type="text/javascript" src="<?= base_url()?>assets/js/project.admin.js"></script>


	<script type="text/javascript">
		jQuery( function(){
			$('#Calendar').calendar({
    			months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    			days: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
    			color:'#153D77'

  			});
 
		});


	</script>


</body>
</html>