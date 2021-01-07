<div class="panel panel2">
	<div class="panel-header d-table full-width">
		<h3 class="pull-left">Members</h3>
		<div class="pull-right">
			<div class="form-group m-0 position-relative input-search">
              <input type="text" name="" class="form-control" placeholder="Search Member">  
              <i class="fa fa-search"></i>
            </div>
		</div>
	</div>
	<div class="panel-content pl-0 pr-0">
		<div class="d-flex pl-3 pr-3">
			<div class="m-auto ml-0 d-flex">
				<span class=""> STUDENTS</span>
				<span class="count">(1)</span>
				<div class="dropdown ml-2">
					<a href="#" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </a>
					<ul class="dropdown-menu" style="">
						<small class="ml-2">Sort by</small>
						<li> <a href="#"> Firstname A-Z  </a>  </li>
						<li> <a href="#"> Firstname Z-A  </a>  </li>
						<li> <a href="#"> Lastname A-Z  </a>  </li>
						<li> <a href="#"> Lastname Z-A  </a>  </li>
					</ul>	
				</div>
			</div>
			<?php if (getRole() == 'teacher'): ?>
				<div class="m-auto mr-0">
					<button class="btn btn-primary changeable-color hoverable-btn" data-toggle="modal" data-target="#codeModal"> <i class="fa fa-plus"></i> <span>Add Members</span> </button>
				</div>	
			<?php endif ?>
		</div>
		<div id="members_list">
			<div class="user-item item">
				<div class="user-image img-container">
					<img src="<?=base_url();?>assets/images/user1.jfif">
				</div>
				<div class="user-info">
					<a href="#"><span class="user-name">Aphrodite Gajo</span></a>
					<span class="user-role">Student Contributor</span>
				</div>
				<div class="dropdown user-menu-dd">
					<?php if ( getRole() == 'teacher'): ?>
						<span class="mr-2" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<li> <a href="#"> <i class="fa fa-eye text-info"></i> View Progress  </a>  </li>
							<li> <a href="#" class="removebtnConfirm"> <i class="fa fa-trash text-danger"></i> Remove from class  </a>  </li>
						</ul>		
					<?php endif ?>
					
				</div>
			</div>
			<div class="user-item item">
				<div class="user-image img-container">
					<img src="<?=base_url();?>assets/images/user1.jfif">
				</div>
				<div class="user-info">	
					<a href="#"><span class="user-name">Aphrodite Gajo</span></a>
					<span class="user-role">Student Contributor</span>
				</div>
				<div class="dropdown user-menu-dd">
					<span class="mr-2" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
					<ul class="dropdown-menu start-from-right" style="">
						<li> <a href="#"> <i class="fa fa-eye text-info"></i> View Progress  </a>  </li>
						<li> <a href="#" class="removebtnConfirm"> <i class="fa fa-trash text-danger"></i> Remove from class  </a>  </li>
					</ul>	
				</div>
			</div>
			<div class="user-item item">
				<div class="user-image img-container">
					<img src="<?=base_url();?>assets/images/user1.jfif">
				</div>
				<div class="user-info">
					<span class="user-name">Aphrodite Gajo</span>
					<span class="user-role">Student Contributor</span>
				</div>
				<div class="dropdown user-menu-dd">
					<span class="mr-2" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
					<ul class="dropdown-menu start-from-right" style="">
						<li> <a href="#"> <i class="fa fa-eye text-info"></i> View Progress  </a>  </li>
						<li> <a href="#" class="removebtnConfirm"> <i class="fa fa-trash text-danger"></i> Remove from class  </a>  </li>
					</ul>	
				</div>
			</div>
		</div>
	</div>
</div>