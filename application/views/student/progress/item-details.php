	<script>
		const grades = <?php echo json_encode($classes);?>[0];
		const isSingleView = true;
	</script>

<div class="container">
	<h3 class="title">Student Progress Details</h3>


	<div class="row mt-3">
		<div class="col-sm-12 col-md-8 col-lg-9">
			<div class="panel">
				<div class="panel-header border-bottom">
					<span> <strong> <?php echo $classes[0]['class_name'] ?> ( <?php echo $classes[0]['class_sy_to']?> )</strong> </span>
				</div>
				<div class="panel-content">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="d-flex">
								<span class="">  Grading Period</span>
								<div class="grading-periods ml-3"> </div>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="search custom-search-layout pull-right">
								<input type="text" name="search" placeholder="Search...">
								<i class="fa fa-search"></i>
							</div>	
						</div>
					</div>
					<div class="mt-3 row">
						<table class="table table-hover table-layout-1">
							<thead>
								<th> Grade Heading </th>
								<th> Type </th>
								<th> Status </th>
								<th> Score </th>
							</thead>
							<tbody>
								<tr class="clickable-content" data-toggle="modal" data-target="#quizInstruction">
									<td>  
										<span class="d-block font-bold">Midterm Exam part 1 </span>
										<span class="d-block small-text">Assigned Date : May 1, 2020 </span>
										<span class="d-block small-text">Due on May 1, 2020 </span>
										</td>
									<td> <i class="fa fa-check text-primary"></i> Taken</td>
									<td class="font-bold">  40 <span class="small-text">out of </span> 60</td>
								</tr>
								<tr class="clickable-content" data-toggle="modal" data-target="#quizInstruction">
									<td>  
										<span class="d-block font-bold">Midterm Exam part 2 </span>
										<span class="d-block small-text">Assigned Date : June 28, 2020 </span>
										<span class="d-block small-text">Due on July 1, 2020 </span>
									</td>
									<td></td>
									<td class="font-bold"> </td>
								</tr>
								<tr class="clickable-content" data-trigger="href" data-target="<? //getSiteLink('assignment/1') ?>">
									<td>
										<span class="d-block font-bold">Test Assignment 1 </span>
										<span class="d-block small-text">Due Date : May 5, 2020 </span>
									</td>
									<td> <i class="fa fa-check text-primary"></i> Submitted</td>
									<td class="font-bold">  30 <span class="small-text">out of </span> 60  </td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4 col-lg-3">
			<?php  $this->load->view('shared/side-due-task/side-due-template'); ?>
		</div>
	</div>	
</div>
 