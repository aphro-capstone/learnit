


<h1 class="page-title pt-3 pl-3"> Class Gradebook </h1>


<section class="first-section bg-white pl-3 pr-3 pt-2 pb-2">
	<div class="d-flex ">
		<span class=""> Class in view ::  </span>

		<div class="dropdown">
			
			<div class="clickable-content data-toggle" data-toggle="dropdown" >
				<span class="text">  Test </span> <i class="fa fa-chevron-down"></i>
			</div>
			<ul class="dropdown-menu full-width classes-dropdown" style="">
				<li class="pl-3">  
					<a class="position-relative pl-3" href="http://joemarie.local/capstone_project/teacher/classes/class-4"> 
						<span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
						Class 2
					</a>  
				</li>
				<li class="pl-3">  
					<a class="position-relative pl-3" href="http://joemarie.local/capstone_project/teacher/classes/class-4"> 
						<span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
						Class 2
					</a>  
				</li>
				<li class="pl-3">  
					<a class="position-relative pl-3" href="http://joemarie.local/capstone_project/teacher/classes/class-4"> 
						<span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
						Class 2
					</a>  
				</li>
				<li class="pl-3">  
					<a class="position-relative pl-3" href="http://joemarie.local/capstone_project/teacher/classes/class-4"> 
						<span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
						Class 2
					</a>  
				</li>
			</ul>
		</div>
	</div>
</section>


<section class="d-flex full-width bg-none p-3 navigation-section"> 
	<!-- <ul class="nav nav-pills no-style left">
		<li class="tab-link"> <a href="#" ></a>Grades </li>
		<li class="tab-link"> Badges </li>
	</ul> -->
	<ul class="no-style d-flex mr-0 ml-auto right mb-0">
		<li class="mr-4"> <span> Arrows </span> <span> <i class="fa fa-arrow-right"></i></span><span> Move between cells  </span></li>
		<li class="mr-4"> <span> ESC </span> <span> <i class="fa fa-arrow-right"></i></span><span> Cancel  </span></li>
		<li class="mr-4"> <span> Enter </span> <span> <i class="fa fa-arrow-right"></i></span><span> Edit/onfirm  </span></li>
	</ul>
</section>

<section id="gradebook-container" class="bg-white p-3">
	<div class="headpart">
		<div class="pull-left d-flex">
			<span class="text"> Grading Period: </span>
			<ul class="periods no-style d-flex m-auto">
				<li class="ml-2"><button type="button" class="btn btn-sm btn-secondary"> 1 </button></li>
				<li class="ml-2"><button type="button" class="btn btn-sm btn-outline-secondary"> 2 </button></li>
				<li class="ml-2"><button type="button" class="btn btn-sm btn-outline-secondary"> 3 </button></li>
				<li class="ml-2"><button type="button" class="btn btn-sm btn-outline-secondary"> 4 </button></li>
				<li class="ml-2"><button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> </button></li>
			</ul>
		</div>
		<div class="pull-right d-flex">
			<button type="button" class="btn btn-primary ml-2 hoverable-btn" data-toggle="modal" data-target="#createGradebook"> <i class="fa fa-plus"></i> <span>Add Grade</span>  </button>
			<button type="button" class="btn btn-info ml-2 hoverable-btn"> <i class="fa fa-download"></i> <span>Export</span>  </button>
			<button type="button" class="btn btn-danger ml-2 hoverable-btn"> <i class="fa fa-trash"></i> <span>Delete</span>  </button>
		</div>
		
	</div>

	<div class="grid gradebook-grid">
		<table class="table gradebook-table table-bordered" id="gradebook-table">
			<thead class="grid-header">
				<th class="student-header fixed-td table-header"> Students </th>
				<th class="grade-header table-header"> Assignment1 </th>
				<th class="grade-header table-header"> Assignment2 </th>
				<th class="grade-header table-header"> Assignment3 </th>
				<th class="grade-header table-header"> Assignment4 </th>
				<th class="grade-header table-header"> Assignment5 </th>
				<th class="grade-header table-header"> Assignment6 </th>
				<th class="grade-header table-header"> Assignment7 </th>
				<th class="grade-header table-header"> Assignment8 </th>
				<th class="grade-header table-header"> Assignment9 </th>
			</thead>
			<tbody class="grid-body">
				<tr>
					<td class="student-item fixed-td table-header">
						<div class="img-container image-circular"> <img src="<?=base_url();?>assets/images/user.png"></div>
						<span class="text"> Aphrodite Gajo </span>
						<span class="percentage"> 23% </span>	
					</td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
				</tr>
				<tr>
					<td class="student-item fixed-td table-header">
						<div class="img-container image-circular"> <img src="<?=base_url();?>assets/images/user.png"></div>
						<span class="text"> Aphrodite Gajo </span>
						<span class="percentage"> 23% </span>	
					</td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
				</tr>
				<tr>
					<td class="student-item fixed-td table-header">
						<div class="img-container image-circular"> <img src="<?=base_url();?>assets/images/user.png"></div>
						<span class="text"> Aphrodite Gajo </span>
						<span class="percentage"> 23% </span>	
					</td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
				</tr>
				<tr>
					<td class="student-item fixed-td table-header">
						<div class="img-container image-circular"> <img src="<?=base_url();?>assets/images/user.png"></div>
						<span class="text"> Aphrodite Gajo </span>
						<span class="percentage"> 23% </span>	
					</td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
				</tr>
				<tr>
					<td class="student-item fixed-td table-header">
						<div class="img-container image-circular"> <img src="<?=base_url();?>assets/images/user.png"></div>
						<span class="text"> Aphrodite Gajo </span>
						<span class="percentage"> 23% </span>	
					</td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
					<td class="grade-content-td"> <div class="grade-content"> <input type="text" placeholder="Score"> / <input type="text" name="" placeholder="Over"> </div> </td>
				</tr>
			</tbody>
		</table>
	</div>

</section>