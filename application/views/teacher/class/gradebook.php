 
<h1 class="page-title pt-3 pl-3"> Class Gradebook </h1>


<section class="first-section bg-white pl-3 pr-3 pt-2 pb-2">
	<div class="d-flex ">
		<span class=""> Class in view ::  </span>

		<div class="dropdown ml-2">
			
			<div class="clickable-content data-toggle" data-toggle="dropdown" >
				<span class="text">  <?php echo $classlist[ 0 ]['class_name'] ?> </span> <i class="fa fa-chevron-down"></i>
			</div>
			<ul class="dropdown-menu full-width classes-dropdown" style="">

				<?php for($x = 0; $x <  count($classlist); $x++ ): $class = $classlist[$x];  ?>
					<li class="<?= $x == 0 ? 'active' : '';?>" data-class-id="<?= $class['class_id']; ?>">  
						<a class="position-relative pl-3" href="#"> 
							<span class="left-bg" style="background-color:<?= $class['sc_color']?>"></span>   
							<?php echo $class['class_name']; ?>
						</a>  
					</li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</section>

<div class="wrapper grading-content">
	
	<div class="content">
		<section class="d-flex full-width bg-none p-3 navigation-section"> 
			<ul class="no-style d-flex mr-0 ml-auto right mb-0">
				<li class="mr-4"> <span> Arrows </span> <span> <i class="fa fa-arrow-right"></i></span><span> Move between cells  </span></li>
				<li class="mr-4"> <span> ESC </span> <span> <i class="fa fa-arrow-right"></i></span><span> Cancel  </span></li>
				<li class="mr-4"> <span> Enter </span> <span> <i class="fa fa-arrow-right"></i></span><span> Edit/onfirm  </span></li>
			</ul>
		</section>
		<section id="gradebook-container" class="bg-white p-3 position-relative">
			<div class="headpart">
				<div class="pull-left d-flex">
					<span class="text"> Grading Period: </span>
					<ul class="periods no-style d-flex m-auto">
						<li class="ml-2"><button type="button" class="btn btn-sm btn-secondary"> 1 </button></li> 
						<li class="ml-2 addgradeli"><button type="button" class="btn btn-sm btn-primary" id="addgradingperioud" data-toggle="tooltip" data-placement="top" title="add grading period"> <i class="fa fa-plus"></i></button></li>
					</ul>
				</div>
				<div class="pull-right d-flex">
					<button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#createGradebook"> <i class="fa fa-plus"></i> <span>Add Grade Column</span>  </button>
					<button type="button" class="btn btn-info ml-2 export-gradebook"> <i class="fa fa-download"></i> <span>Export</span>  </button>
					<button type="button" class="btn btn-danger ml-2 deleteperiod"> <i class="fa fa-trash"></i> <span>Delete current period</span>  </button>
				</div>
				
			</div>
 			<div class="contain">
			 	<div class="loading">
					<div class="overlay"></div>
					<div class="sk-spinner sk-spinner-wave">
						<div class="sk-rect1"></div>
						<div class="sk-rect2"></div>
						<div class="sk-rect3"></div>
						<div class="sk-rect4"></div>
						<div class="sk-rect5"></div>
					</div>	
				</div>
				<div class="grid gradebook-grid">
					<table class="table gradebook-table table-bordered" id="gradebook-table">
						<thead class="grid-header">
							<th class="student-header fixed-td table-header"> Students </th> 
						</thead>
						<tbody class="grid-body"> </tbody>
					</table>
				</div>
				<div class="no-student-yet text-center">
					<div class="scholl faded m-auto img-container" style="max-width: 27vmin; width: 80%;">
						<img src="<?=site_url();?>/assets/images/school.png" alt="">
					</div>
					<span class="mt-3 d-block faded" style="font-weight: 600; font-size: 20px;">No student had enrolled in class yet.</span>
				</div>
			 </div>
		</section>
	</div>
	
</div>


