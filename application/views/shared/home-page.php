 
<div class="container">
	<div class="row">
		<div class="col col-sm-12  col-md-3 col-lg-3 pr-2">
			<div class="panel">
				<div class="panel-content">
					<div class="column-panel-multi-row d-flex">
						<div class="image-left">
							<div class="img-container image-circular"> 
								<img src="<?=base_url() . getSessionData('sess_userImage');?>" alt="" />
							</div>
						</div>
						<div class="text-content">
							<div class="text position-relative" style="top: 5px; font-weight: 500;"> <?= getUserName();  ?></div>
							<div class="text"><small><a href="<?=site_url();?>teacher/profile"> View Profile </a></small></div>
						</div>
					</div>
					<div class="divider"></div>
					<ul class="personal-info no-style mt-3 pl-3" >
						<li class="" > <i class="fa fa-home"></i> { School }</li>
					</ul>
				</div>
			</div>
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

						<?php if( count($classes) == 0 ): ?>
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
						
						
					</div>
				</div>

				<div class="divider2"></div>
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
				
				<?php $this->load->view('shared/side-due-task/side-due-template',array('duetasks' => $duetasks)); ?>
			</div>

			<div class="links page-map mt-3">
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
