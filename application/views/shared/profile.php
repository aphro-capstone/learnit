<div class="row">
<div class="col col-sm-12  col-md-3 col-lg-5 pr-2">
<div class="container" id="user-profile-page">
	<div class="profile-page-header p-3 pt-6 pb-6">
		<div class="panel">
			<div class="panel-content">
				<div class="column-panel-multi-row d-flex">
					<div class="d-flex justify-content-center">
					

					 <div class="profile-avatar-main">


					 		<div class="img-container image-circular"> 
					 			<img src="<?=base_url() . getSessionData('sess_userImage');?>" alt="" />
					 		</div>	
					 		<div class="avatar-profile-overlay">
					 			<div class="avatar-text-container">
					 				<svg class="d-block m-auto"width="24" height="24" viewBox="0 0 24 24" name="camera-icon"><path fill="#fff" fill-rule="evenodd" stroke="none" stroke-width="1" id="Icon/small/camera" d="M7.23 5.579C7.569 4.659 8.478 4 9.546 4h4.91c1.068 0 1.977.66 2.314 1.579h2.595c.903 0 1.636.707 1.636 1.579V17.42c0 .872-.733 1.579-1.636 1.579H4.636C3.733 19 3 18.293 3 17.421V7.158c0-.872.733-1.58 1.636-1.58h2.595zM12 16.632c2.711 0 4.91-2.121 4.91-4.737S14.71 7.158 12 7.158c-2.711 0-4.91 2.12-4.91 4.737 0 2.616 2.199 4.737 4.91 4.737zm-3.2-5.4c.236.837 1.03 1.452 1.973 1.452 1.13 0 2.045-.883 2.045-1.973 0-.91-.637-1.676-1.505-1.905a3.4 3.4 0 01.687-.07c1.807 0 3.273 1.415 3.273 3.159 0 1.744-1.466 3.158-3.273 3.158-1.807 0-3.273-1.414-3.273-3.158 0-.228.025-.45.072-.663z"></path></svg>
									<span class="d-block text-center">Update Photo</span>
					 			</div>	
					 		</div>

					 	</div>
					 
					
					<div class="profile-info-section">

						<div class="profile-banner-title-container qa-test-profilePageHeader-titleContainer d-flex align-items-baseline">
							<label class="display-full-name pt-1"> <?=getUserName(); ?></label>
							<div class="mt-2_5"></div>
							<p class="student-profile subtext"></p></div>
								<span><small>Student</small></span>

								
							<ul class="personal-info no-style mt-3 pl-3" >
							<li class="" > <i class="fa fa-home"></i> Davao del norte State College</li>
							<span class="icon-edit qa-test-profilePage-editIcon"></span></ul>
					
					</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
				



		<div class="col col-sm-12  col-md-3 col-lg-5 pr-2">
			<div class="panel">
				<div class="panel-content">
					<div class="profile-info-section2">
						<div class="profile-page-header p-3 pt-6 pb-6">
							<div class="column-panel-multi-row d-flex">
					<div class="d-flex justify-content-center">
				
		

						<div class="profile-banner-title-container qa-test-profilePageHeader-titleContainer d-flex align-items-baseline">
							<label class="display-full-name pt-1"> <?=getUserName(); ?></label>
							<div class="mt-2_5"></div>
							<p class="student-profile subtext"></p></div>
								<span><small>Student</small></span>

								
							<ul class="personal-info no-style mt-3 pl-3" >
							<li class="" > <i class="fa fa-home"></i> Davao del norte State College</li>
							<span class="icon-edit qa-test-profilePage-editIcon"></span></ul>
					
					</div>
				</div>
			</div>
		</div>
	</div>
	
		<!-- 
			<div class="panel mt-2">
				<div class="panel-content">
					<div class="heading dropdown">
						<span>My Classess</span>
						<span class="options data-toggle" data-toggle="dropdown"> <i class="fa fa-ellipsis-h" ></i>  </span>
						<ul class="dropdown-menu">
							<?php if(getRole() == 'teacher'): ?>
								<li class="createClassModal"><a href="#" >  Create a Class</a></li> 
                            	<li><a href="#">  View Archived Classess</a></li>	
							<?php endif; ?>
							 
                           		<li class="joinClassModal" ><a href="#joinClass" data-toggle="modal" >  Join a Class </a></li> 
						</ul>
					</div>
					<div class="content row">
 -->
					<!-- 	<?php if( count($classes) == 0 ): ?>
							<div class="placeholders p-4">
								<?php if ( getRole() == 'teacher'): ?>
									<p class="text-center">Teacher has no class yet.  Create one and start interacting with your students</p>
									<p class="text-center"> <a href="#" class="createClassModal"> <i class="fa fa-plus"></i> Create a Class </a> </p>
								<?php else: ?>
									<p class="text-center">Student has no class yet,   enroll now to enjoy the perks of being in a class</p>
									<p class="text-center"> <a href="#joinClass" data-toggle="modal"> <i class="fa fa-plus"></i> Join a Class </a> </p>
								<?php endif ?>
								
							</div>
						<?php else: ?>
							<ul class="no-style mt-3 div-list  full-width mb-0">
								<?php foreach ($classes as $class) : ?>
									<li>
										<a href="<?=getSiteLink('classes/class-' . $class['class_id']);?>" class="pl-4"> 
											<i class="fa fa-circle bullet-type" style="color:<?=$class['sc_color']?>"></i> <?=$class['class_name']?>
										</a> 
									</li>
								<?php endforeach; ?>
								<li class="mt-3"> <a href="<?=getSiteLink('classes')?>" class="pl-4 pt-2 pb-2"> <i class="fa fa-chevron-right "></i> ALL CLASSES</a> </li>

							</ul>
						<?php endif; ?>
						
						 -->

					</div>
				</div>

			<!-- 	<div class="divider2"></div>
				<div class="panel-content">
					<div class="heading dropdown">
						<span>My Groups</span>
						<span class="options data-toggle" data-toggle="dropdown"> <i class="fa fa-ellipsis-h" ></i>  </span>
						<ul class="dropdown-menu">
							<li><a href="#"> Create a Group</a></li> 
                            <li><a href="#"> View Archived Group</a></li> 
                            <li><a href="#"> Join a Group </a></li> 
						</ul>
					</div>
					<div class="content row">

						<div class="placeholders p-4">
							<p class="text-center">Share resources and collaborate with educators like you.</p>
							<p class="text-center"> <a href="#"> <i class="fa fa-plus"></i> Create a Group </a> </p>
						</div>
						<ul class="no-style  mt-3 div-list  full-width d-none">
							<li> <a href="#"> <i class="fa fa-chevron-right"></i> Math</a> </li>
							<li> <a href="#"> <i class="fa fa-chevron-right"></i> Filipino</a> </li>
							<li> <a href="#"> <i class="fa fa-chevron-right"></i> Science</a> </li>
							<li> <a href="#"> <i class="fa fa-chevron-right"></i> History</a> </li>
							<li> <a href="#"> <i class="fa fa-chevron-right"></i> MAPEH	</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		 -->
<!-- 
		<div class="col col-sm-12  col-md-6 col-lg-6 pl-2 pr-2">
			<?php $this->load->view('shared/posts/my-post'); ?>
			<?php $this->load->view('shared/posts/posts'); ?>
		</div>
		<div class="col col-sm-12  col-md-3 col-lg-3 pl-2">
			<div class="panel">
				<div class="panel-content">
					<div id="Calendar"></div>
				</div>
				<div class="divider2"></div>
				<div class="panel-header heading bor" >
				 	<strong>Due this week.</strong>	 
				</div>
				<div class="border-top border-bottom pl-3 pr-3 p-2 text-center">
					<span> ( May 11-16 ) </span>
				</div>
				<div class="panel-content">
					<div class="collapsible-item pt-1">
					 	<div class="collapse-toggle clickable-content collapsed" data-toggle="collapse" data-target="#due-math-div"> <i class="fa fa-circle bullet-type" aria-hidden="true"></i> Math <span class="pull-right"> <i class="fa fa-chevron-down"></i> </span> </div>
						<div class="collapse collapsible-list" id="due-math-div">
						  <div class="item due-date-item">
						  		<span class="due-title pull-left">Ass. 1</span>
						  		<span class="due-due pull-right">Thurs @ 1pm</span>
						  </div>
						  <div class="item due-date-item">
						  		<span class="due-name pull-left">Ass. 2</span>
						  		<span class="due-name pull-right">Wed @ 1pm</span>
						  </div>
						</div>
					</div>
					<div class="collapsible-item pt-1">
					 	<div class="collapse-toggle clickable-content collapsed" data-toggle="collapse" data-target="#due-filipino-div"> <i class="fa fa-circle bullet-type" aria-hidden="true"></i> Filipino <span class="pull-right"> <i class="fa fa-chevron-down"></i> </span> </div>
						<div class="collapse collapsible-list" id="due-filipino-div">
						  <div class="item due-date-item">
						  		<span class="due-title pull-left">Ass. 1</span>
						  		<span class="due-due pull-right">Thurs @ 1pm</span>
						  </div>
						  <div class="item due-date-item">
						  		<span class="due-name pull-left">Ass. 2</span>
						  		<span class="due-name pull-right">Wed @ 1pm</span>
						  </div>
						</div>
					</div>
					<div class="collapsible-item pt-1">
					 	<div class="collapse-toggle clickable-content collapsed" data-toggle="collapse" data-target="#due-science-div"> <i class="fa fa-circle bullet-type" aria-hidden="true"></i> Science <span class="pull-right"> <i class="fa fa-chevron-down"></i> </span> </div>
						<div class="collapse collapsible-list" id="due-science-div">
						  <div class="item due-date-item">
						  		<span class="due-title pull-left">Ass. 1</span>
						  		<span class="due-due pull-right">Thurs @ 1pm</span>
						  </div>
						  <div class="item due-date-item">
						  		<span class="due-name pull-left">Ass. 2</span>
						  		<span class="due-name pull-right">Wed @ 1pm</span>
						  </div>
						</div>
					</div>
				</div>

			</div> -->

		<!-- 	<div class="links page-map mt-3">
				<ul class="no-style">
					<li> <a href="#"> Language</a></li>
					<li> <a href="#"> Theme</a></li>
					<li> <a href="#"> Support</a></li>
					<li> <a href="#"> About</a></li>
					<li> <a href="#"> Career</a></li>
					<li> <a href="#"> Privacy</a></li>
					<li> <a href="#"> Terms of Service</a></li>
					<li> <a href="#"> Contact Us</a></li>
					<li> <a href="#"> Twitter</a></li>
					<li> <a href="#"> Facebook</a></li>
					<li> <a href="#"> Developers </a></li>
				</ul>
				<span class="copywrite"> LearnIT &copy; 2020 </span>
			</div>
		</div>
	</div>
</div>

 -->
