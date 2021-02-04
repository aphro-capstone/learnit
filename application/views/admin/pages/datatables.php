 <?php 
	$curdate = new Datetime();
	$curmonth = date('m');
	$curyear = date('Y');

	$query_year_from;
	$query_year_to;
	
	if( $curmonth > __SCHOOL_YEAR_MONTH_START__  ){
		$query_year_to = $curyear + 1;
		$query_year_from = $curyear;
	}else{
		$query_year_to = $curyear;
		$query_year_from = $curyear - 1;
	}
 
 
 
 ?>
<script>
	const page = 'datatables';
	const users = <?php echo json_encode( $userlist );?>;
	const classlist = <?php echo json_encode( $classlist );?>;
</script>

<div class="row">
	<div class="panel">
		<div class="panel-heading d-table full-width">
			<h3 class="pull-left">Teachers</h3>
			<a href="<?=site_url()?>admin/reportExcel/teacherlist" class="btn btn-xs btn-3d btn-info pull-right report-download" data-download="teacherlist"> <i class="fa fa-download"></i> Download teachers list </a>
		</div>
		<div class="panel-content mt-4">

			<div class="dataTable-container">
				<table class="table table-striped table-bordered table-hover" id="teachertable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th class="text-center">Contact #</th>
							<th class="text-center">Status</th>
							<th class="text-center">Application Status</th>
							<th class="text-center">Total Classes Handles</th>
							<th class="text-center">Active Classes</th>
							<th>Date Registered</th>
							<th>Active/Inactive Start Date</th>
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
			<a href="<?=site_url()?>admin/reportExcel/studlist" class="btn btn-xs btn-3d btn-info pull-right report-download" data-download="studlist"> <i class="fa fa-download"></i> Download student list </a>
		</div>
		<div class="panel-content mt-4">
			<div class="dataTable-container">
				<table class="table table-bordered table-hover"  id="studtable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th class="text-center">Guardian Contact #</th>
							<th class="text-center">Status</th>
							<th class="text-center">Application Status</th>
							<th class="text-center">Active Classes</th> 
							<th>Date Registered</th>
							<th>Active/Inactive Start Date</th>
							<th class="text-center"> Actions </th>
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
			
			<button class="btn btn-xs btn-3d btn-danger pull-right" id="endschoolyear"> <i class="fa fa-times"></i> End School Year <?= $query_year_from . ' - ' . $query_year_to; ?></button>
			<a href="<?=site_url()?>admin/reportExcel/classlist" class="btn btn-xs btn-3d btn-info pull-right mr-2 report-download" data-download="classlist" > <i class="fa fa-download"></i> Download Class list </a>
		</div>
		<div class="panel-content mt-4">
			<div class="dataTable-container">
				<table class="table table-bordered table-hover"  id="classtable">
					<thead>
						<tr>
							<th> ID </th>
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