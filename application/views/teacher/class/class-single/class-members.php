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
				<span class="count">( <?php  echo count($members) ; ?> )</span>
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

			<?php if( count($members) ) :   ?>
				<?php foreach( $members as $member ):?>
					<div class="user-item item" data-user-id="<?= $member['user_id'];?>">
						<?php  $userProfinfo = json_decode($member['ui_profile_data'],true); ?>
						<div class="user-image img-container">
							<img src="<?=base_url() . ( isset($userProfinfo['userimage']) ? $userProfinfo['userimage'] : 'assets/images/user1.jfif' )  ;?>">
						</div>
						<div class="user-info">
							<a href="<?=getSiteLink('profile/' . $member['user_id']); ?>"><span class="user-name"><?= ucwords( $member['studname'] );?></span></a>
							<span class="user-role">Student Contributor</span>
						</div>
						<div class="dropdown user-menu-dd">
							<?php if ( getRole() == 'teacher'): ?>
								<span class="mr-2" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
								<ul class="dropdown-menu start-from-right" style="">
									<li> <a href="#"> <i class="fa fa-eye text-info"></i> View Progress  </a>  </li>
									<li> <a href="#"> <i class="fa fa-key text-warning"></i> Change student's password  </a>  </li>
									<li> <a href="#" class="removebtnConfirm"> <i class="fa fa-trash text-danger"></i> Remove from class  </a>  </li>
								</ul>		
							<?php endif ?>
							
						</div>
					</div>
				<?php endforeach; ?>
			<?php else:  ?>
				<div class="no-student p-3"> 
					<div class="scholl faded m-auto img-container" style="max-width: 230px; width: 80%;">
						<img src="<?=site_url()?>assets/images/school.png" alt="">
					</div>
					<p class="text-center mt-3"> No students yet.</p>
				</div>
			<?php endif; ?> 
		</div>
	</div>
</div>