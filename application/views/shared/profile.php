<script>
	const ___D___= <?= json_encode($UI);?>;
</script>




<div class="container" id="user-profile-page">

		<div class="left">
			<div class="column-panel-multi-row d-flex mb-3">
				<div class="m-auto">
						 
				 	<div class="profile-avatar-main">
				 		<div class="img-container d-flex"> 
				 			<img class="m-auto" src="<?=base_url() . getSessionData('sess_userImage');?>" alt="" />
				 		</div>	
				 		<div class="avatar-profile-overlay">
				 			<div class="avatar-text-container">
				 				<svg class="d-block m-auto"width="24" height="24" viewBox="0 0 24 24" name="camera-icon"><path fill="#fff" fill-rule="evenodd" stroke="none" stroke-width="1" id="Icon/small/camera" d="M7.23 5.579C7.569 4.659 8.478 4 9.546 4h4.91c1.068 0 1.977.66 2.314 1.579h2.595c.903 0 1.636.707 1.636 1.579V17.42c0 .872-.733 1.579-1.636 1.579H4.636C3.733 19 3 18.293 3 17.421V7.158c0-.872.733-1.58 1.636-1.58h2.595zM12 16.632c2.711 0 4.91-2.121 4.91-4.737S14.71 7.158 12 7.158c-2.711 0-4.91 2.12-4.91 4.737 0 2.616 2.199 4.737 4.91 4.737zm-3.2-5.4c.236.837 1.03 1.452 1.973 1.452 1.13 0 2.045-.883 2.045-1.973 0-.91-.637-1.676-1.505-1.905a3.4 3.4 0 01.687-.07c1.807 0 3.273 1.415 3.273 3.159 0 1.744-1.466 3.158-3.273 3.158-1.807 0-3.273-1.414-3.273-3.158 0-.228.025-.45.072-.663z"></path></svg>
								<span class="d-block text-center">Update Photo</span>
				 			</div>	
						 </div>
						 <form action="" id="savePhotoForm">
						 	<input type="file" class="hide" accept=".jpg,.jpeg,.png" >
						 </form>
					 </div>

					 <p class="mb-0 mt-1 text-center"><button class="btn btn-primary btn-xs" style="display:none" id="savePhoto"> <i class="fa fa-save"></i> Save </button> </p>
					 
				 
					<div class="profile-info-section">
							<div class="profile-banner-title-container qa-test-profilePageHeader-titleContainer d-flex align-items-baseline">
								<h4 class="display-full-name pt-1"> <?=getUserName(); ?></h4>
								<p class="student-profile subtext"></p></div>
									<span><small class="stu">Student</small></span>

								<ul class="personal-info no-style mt-3 pl-3" >
								<li class="" > <i class="fa fa-home"></i> Davao del norte State College</li>
								<span class="icon-edit qa-test-profilePage-editIcon"></span></ul>
					</div>
					

				</div>
			</div>
				<ul class="tabs nav nav-tabs vertical-nav-tabs no-style mt-4 mb-1">
					<li> <a href="#about" data-toggle="tab" class="pl-3 pr-3 pt-2 pb-2 content-hover active">About</a>  </li>
					
					<?php if( getRole() == 'student' ): ?>
						<li> <a href="#classen" data-toggle="tab" class="pl-3 pr-3 pt-2 pb-2 content-hover">Class Enrolled</a>  </li>
					<?php endif; ?>
				
				</ul>
		</div>

		<div class="right">
			<?php $this->load->view('shared/posts/my-post',array('isprofilepage' => true)); ?>

			<div class="tab-content mt-2">
				<div class="tab-pane fade active show" id="about">
					<div class="panel panel2">
						<div class="panel-header"> <h2>Personal Info</h2></div>
						<div class="panel-content">
								<form class="form">

									 
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-calendar mr-1"></i> Full Name</label>
										<div class="col-sm-9">
											<div class="row">
												<div class="col-lg-4 pr-1">
													<div class="input-group input-group-icon-right">
														<input type="text" class="form-control" name="fname" placeholder="Firstname" readonly="true">
													</div>
												</div>
												<div class="col-lg-4 pr-1 pl-1">
													<div class="input-group input-group-icon-right">
														<input type="text" class="form-control" name="mname" placeholder="Middlename" readonly="true">
													</div>
												</div>
												<div class="col-lg-4 pl-1">
													<div class="input-group input-group-icon-right">
														<input type="text" class="form-control" name="lname" placeholder="Lastname" readonly="true">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-calendar mr-1"></i> Date of Birth</label>
										<div class="col-sm-9">
										<input type="date" readonly="true" class="form-control" name="day_birth">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-transgender mr-1"></i> Gender</label>
										<div class="col-sm-9 d-flex">
											<div class="form-check form-check-inline m-auto ml-0">
												<input class="form-check-input" type="radio" name="gender" value="Male">
												<label class="form-check-label" for="inlineRadio1">Male</label>
												<input class="form-check-input ml-4" type="radio" name="gender" value="Female">
												<label class="form-check-label" for="inlineRadio2">Female</label>
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-envelope mr-1"></i> Email Address</label>
										<div class="col-sm-9">
										<input type="text" readonly="true" name="email" class="form-control" placeholder="@gmail.com">
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-phone mr-1"></i> <?= getRole() == 'student' ? 'Guardian Phone #' : 'Contact #';?></label>
										<div class="col-sm-9">
										<input type="tel" readonly="true" name="contact" class="form-control" placeholder="Contact Number">
										</div>
									</div>
									<?php if(getRole() == 'student'): ?>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">
												<i class="fa fa-phone mr-1"></i> Guardian Name</label>
											<div class="col-sm-9">
											<input type="tel" readonly="true" name="guardian_name" class="form-control" placeholder="Contact Number">
											</div>
										</div>
									<?php endif; ?>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">
											<i class="fa fa-home mr-1"></i> Address</label>
										<div class="col-sm-9">
										<input type="text" readonly="true" name="addr" class="form-control" placeholder="Current Address">
										</div>
									</div> 
							
								
								</form>
								<div class="d-table">
									<button class="btn btn-outline-primary hoverable-btn pull-right editprofileBtn">
										<i class="fa fa-edit mr-1"></i> Edit Profile
									</button>
									<button class="btn btn-outline-secondary hoverable-btn pull-right saveProfileBtn">
										<i class="fa fa-save mr-1"></i>  Save
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="tab-pane fade" id="image-profile">
					<div class="panel panel2">
						<div class="panel-header"> <h2>Profile Image</h2></div>
						<div class="panel-content">
							<div class="profile-image">
								<div>
									<img id="profimage" src="<?=base_url() . getSessionData('sess_userImage');?>">
								</div>
							</div>
							<input type="file" class="hidden" name="photo">
							<button class="btn btn-primary">
									<i class="fa fa-upload"></i> Upload Photo
							</button>
							<div class="d-table">
							 
								<button class="btn btn-outline-secondary hoverable-btn pull-right savePhoto">
									<i class="fa fa-save mr-1"></i>  Save
								</button>
							</div>
						</div>
					</div>
				</div>		 -->
				<div class="tab-pane fade " id="classen">
					<div class="panel panel2">
						<div class="panel-header"> <h2>Class Enrolled</h2></div>
						<div class="panel-content">
							
						</div>

					</div>
				</div>
			</div>


			
			
			
		</div>

</div>

 