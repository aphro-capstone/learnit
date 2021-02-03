

<script>
	const page = 'datatables';
	const users = <?php echo json_encode( $userlist );?>;
	const classlist = <?php echo json_encode( $classlist );?>;
</script>

<div class="row">
	<div class="panel">
		<div class="panel-heading d-table full-width">
			<h3 class="pull-left">Teachers</h3>
		</div>
		<div class="panel-content mt-4">
			<div class="dataTable-container">
				<table class="table table-striped table-bordered table-hover" id="teachertable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th class="text-center">Status</th>
							<th class="text-center">Application Status</th>
							<th class="text-center">Classes Handled</th>
							<th>Date Registered</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody> </tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="panel mt-3">
		<div class="panel-heading d-table full-width">
			<h3 class="pull-left">Students</h3>
		</div>
		<div class="panel-content mt-4">
			<div class="dataTable-container">
				<table class="table table-bordered table-hover"  id="studtable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Status</th>
							<th>Application Status</th>
							<th>Active Classes</th> 
							<th>Date Registered</th>
							<th> Actions </th>
						</tr>
					</thead>
					<tbody> </tbody>
				</table>
			</div>
		</div>
	</div>
		<div class="panel mt-3">
		<div class="panel-heading d-table full-width">
			<h3 class="pull-left">Class</h3>
			<button class="btn btn-xs btn-3d btn-danger pull-right"> <i class="fa fa-times"></i> End Current School Year </button>
		</div>
		<div class="panel-content mt-4">
			<div class="dataTable-container">
				<table class="table table-bordered table-hover"  id="classtable">
					<thead>
						<tr>
							<th>Class ID</th>
							<th>Class Name</th>
							<th>Class Status</th>
							<th>Code</th>
							<th>Code Status</th>
							<th>S/Y</th>
							<th>Teacher</th> 
							<th># of students</th>
							<th>Date Created</th>
							<th class="text-center"> Action </th>
						</tr>
					</thead>
					<tbody> </tbody>
				</table>
			</div>
		</div>
	</div>




</div>