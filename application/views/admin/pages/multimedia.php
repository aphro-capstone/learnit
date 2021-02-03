<script>
	const page = 'multimedia';
	const multimedias = <?= json_encode($m);?>;
</script>

<div class="row">
	<div class="panel">
		<div class="panel-heading d-table full-width"> 
			<h3 class="pull-left">Teachers</h3>  
			<button class="btn btn-primary btn-xs btn-3d pull-right" data-toggle="modal" data-target="#uploadMultimedia"> 
					<i class="fa fa-edit mr-1"></i> Add Multimedia </button>
		</div>
		<div class="panel-content mt-4">
		  
			<div class="dataTable-container">
				<table class="table table-striped table-bordered table-hover" id="teachertable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th class="text-center">Size</th>
							<th class="text-center">Upload Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody> </tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<div id="uploadMultimedia" class="modal fade">
	  <div class="modal-dialog" role="document">
	  	<form id="addGrades" class="addForms" action="<?=site_url();?>admin/addForms">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLiveLabel">Add Multimedia</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
		      </div>
		      <div class="modal-body">
		        	<div class="form-group">
					    <input type="text" class="form-control" name="title"  required placeholder="Title">
					</div>
					<div class="form-group">
					   <textarea name="desc" placeholder="Description"></textarea>
					</div> 
					<div class="upload">
						<button class="btn btn-xs btn-3d select-file-upload"> <i class="fa fa-upload"></i> </button>
					</div>
		        	<input type="file" name="multimedia" class="hidden">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
		      </div>
		    </div>
	    </form>
	  </div>
	</div>