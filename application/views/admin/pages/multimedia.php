<script>
	const page = 'multimedia';
	const multimedias = <?= json_encode($m);?>;
	
	window.onload = function(){
		showMultimedia();
 
	};
</script>

<div class="row">
<div class="ldBar" data-value="50">
</div>
	<div class="panel">
		<div class="panel-heading d-table full-width"> 
			<h3 class="pull-left">Videos</h3>  
			<button class="btn btn-primary btn-xs btn-3d pull-right" data-toggle="modal" data-target="#uploadMultimedia"> 
					<i class="fa fa-edit mr-1"></i> Add Video </button>
		</div>
		<div class="panel-content mt-4">
		  
			<div class="dataTable-container">
				<table class="table table-striped table-bordered table-hover" id="multimediatable">
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
		<div class="modal-content">
			<form onsubmit="return false;" action="<?=site_url()?>admin/addmultimedia" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLiveLabel">Add Multimedia</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" name="title"  required placeholder="Title">
					</div>
					<div class="form-group">
						<textarea name="desc" class="form-control" placeholder="Description"></textarea>
					</div> 
					<div class="upload d-flex">
						<button type="button" class="btn btn-xs btn-3d select-file-upload btn-info full-width"> <i class="fa fa-upload"></i>  <span>Select upload file</span> </button>
						<button type="button" class="btn btn-xs btn-3d btn-danger clearupload"> <i class="fa fa-trash"></i> </button>
					</div>
					<div class="note"> <small class="font-italic"> (<strong>Note :</strong> Video file size maximum of 1Gb)</small> </div>
					<img id="snapshot" src="" alt="" class="d-none">
					<div class="uploadshow mt-3">

					</div>
					<input type="file" name="multimedia" class="hidden" style="display:none;" accept="video/*, audio/*">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-xs btn-3d" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary btn-xs btn-3d"><i class="fa fa-save"></i> Save</button>
				</div>
				<div class="overlay-loading">
					<div data-preset="fan" class="ldBar label-center" data-value="35" ></div>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="playModal" class="modal fade">
	<div class="modal-dialog modal-lg" role="document"> 
		<div class="modal-content">
				<video class="full-width" controls="" autoplay>
					<source src="">
					Your browser does not support HTML5 video.
				</video> 
		</div>
	</div>
</div>



 