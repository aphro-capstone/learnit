<script type="text/javascript">
	let classColor = '<?=$classinfo['color'];?>';
	let classID = '<?=$classinfo['class_id'];?>';
</script>

<style type="text/css" id="class-changeable-colors">
	 
	.changeable-color,
	.changeable-color:hover,
	.changeable-color:active:active,
	.changeable-color:focus,
	.changeable-color:visited
	{
		background: <?=$classinfo['color'];?>;
		color: <?=$classinfo['tcolor'];?>;
	}
</style>




<div class="container">
	<div class="row">

		<div class="col col-sm-12 col-md-3 col-lg-3">
			<div class="dropdown">
				<a href="#" class="btn btn-primary data-toggle full-width p-3 changeable-color" data-toggle="dropdown" style="    border-radius: 30px">  <i class="fa fa-bars"></i> My Classes </a>
				<ul class="dropdown-menu full-width classes-dropdown">
					<?php if (count($classesInfo) > 0): ?>
						<?php foreach ($classesInfo as $ci): ?>
							<?php if( $ci['class_id'] == $classinfo['class_id'] ) continue; ?>
							 <li class="pl-3">  
								<a class="position-relative pl-3" href="<?=site_url('teacher/classes/class-' . $ci['class_id'] ); ?>" > 	
									<span class="left-bg" style="background-color:<?=$ci['sc_color'];?>"></span>   
									<?= $ci['class_name']?>
								</a>  
							</li>
						<?php endforeach; ?>
					<?php else: ?>
						<li class="pl-3"> No more Classes </li>
					<?php endif ?>
					
				</ul>
			</div>

			<div class="row d-block">
				<ul class="tabs nav nav-tabs vertical-nav-tabs no-style mt-4 mb-1">
					<li> <a href="#posts" data-toggle="tab" class="pl-3 pr-3 pt-2 pb-2 content-hover active">Posts</a>  </li>
					<li> <a href="#folders" data-toggle="tab" class="pl-3 pr-3 pt-2 pb-2 content-hover">Files/Folders</a>  </li>
					<li> <a href="#members" data-toggle="tab" class="pl-3 pr-3 pt-2 pb-2 content-hover">Members</a>  </li>
				</ul>
				<!-- <div class="small-groups pl-3 pr-3 mt-3">
					<div class=" clickable-content">
						Small Groups (1) 
						<span class="pull-right collapse-toggle"  data-toggle="collapse" data-target="#small-group" aria-expanded="true" >  <i class="fa fa-chevron-down"></i> </span> 
						<span class="	 pull-right mr-3" data-toggle="tooltip" data-placement="bottom" data-original-title="Add small group"> <i class="fa fa-plus"></i> </span>
					</div>
					<div class="collapsible-list collapse show" id="small-group" style="">
					  	<div class="item clickable-content content-hover"> Group 1</div>
					  	<div class="item clickable-content content-hover"> Group 2</div>
					  	<div class="item clickable-content content-hover"> Group 3</div>
					  	<div class="item clickable-content content-hover"> Group 4</div>
					</div>

				</div> -->
			</div>
			

			
		</div>
		<div class="col col-sm-12 col-md-9 col-lg-9">
			<div class="panel panel-class-heading classinfo-panel">
				<div class="panel-content ">
					<div class="classInfo">
						<span class="left-bg changeable-color"></span>
						<h4 class="title"> <?=$classinfo['class_name'];?>	</h4>
						<p class="m-0 subtitle"> <span class="teachername"> <?= getRole() == 'student' ? $classinfo['teachername']: getUserName();?> </span> <span class="subject"> <?=$classinfo['subject']?></span> | <span class="grade"> <?=$classinfo['grade'];?> </span> </p>
					</div>
					<div class="pl-4 mt-3">
						<!-- <p class="m-0"> Teacher <span class="teachername"> Gajo </span> </p> -->
						<p class="m-0 mt-2 class-desciption"> <?=$classinfo['class_desc']?> </p>
					</div>
					<div class="footer-part  mt-4 pr-3 d-table full-width pl-4">

						<?php if ( getRole() == 'teacher' ): ?>
							<button class="btn btn-info changeable-color" data-toggle="modal" data-target="#codeModal"> <i class="fa fa-qrcode"></i> Class code : <span class="code"><?=$classinfo['class_code'];?></span> </button>
						
							<div class="dropdown pull-right">
								<button class="btn btn-primary changeable-color" data-toggle="dropdown" > <i class="fa fa-plus"></i> </button>
								<ul class="dropdown-menu start-from-right">
									<li > <a class="attachment-select-frst-trigger" href="#assignmentModal" data-toggle="modal"> Create Assignment </a>  </li>
									<li > <a href="#loadAssignment" data-toggle="modal"> Load Existing Assignment </a>   </li>
									<li > <a href="<?=site_url();?>teacher/classes/quiz/createquiz"> Create Quiz </a>   </li>
									<li > <a href="#"> Load Existing Quiz </a>  </li>
								</ul>	
							</div>
							<div class="dropdown pull-right p-2">
								<a href="#" data-toggle="dropdown" class="p-2">  <i class="fa fa-ellipsis-h"></i></a>
								<ul class="dropdown-menu start-from-right" style="width:250px;">
									
									<li class="no-hover">
										<div class="joinURL pt-2 pb-4 pl-2 pr-2 border-bottom">
											<span class="d-block">Join URL</span>
											<input type="text" value="https://edmo.do/j/xs8bk3" class="changeable-color">
										</div>
									</li>
									<li class="dropdown-submenu position-relative">
										<a href="#" class="data-toggle stop-propagate" data-toggle="dropdown" > Change Class Color  </a> 
										<div class="dropdown-menu color-change-menu p-2">
											<div class="color-list color-picker colorlist ">
											</div>
										</div>
									</li>
									<li> <a href="#codeModal" data-toggle="modal"  > Invite People </a> </li>
									<li> <a href="#" class="updateClassModal"> Advance Settings </a> </li>
								</ul>	
							</div>
						<?php else: ?>
							<button class="btn btn-outline-danger pull-right hoverable-btn withdrawClass" data-attr-id="<?= $classinfo['student_class_id']; ?>"> <i class="fa fa-times"></i> <span>Withdraw from Class</span> </button>
						<?php endif ?>
							

													
					</div>
				</div>
			</div>

			<div class="row mt-3">
				<div class="col col-sm-12 col-md-8 pr-0">
					<div class="tab-content">
						<div class="tab-pane active" id="posts">
							<?php $this->load->view('/shared/posts/my-post',array('originator' => 'class')); ?>
							<div class="divider2"></div>
							<?php $this->load->view('/shared/posts/posts'); ?>	
						</div>
						<div class="tab-pane" id="folders">
							<?php $this->load->view('shared/folder-templates/folder',array('title' => 'Shared Folders/Files', 'option' => 2)); ?>		
						</div>
						<div class="tab-pane" id="members">
							<?php $this->load->view('teacher/class/class-single/class-members'); ?>		
						</div>
					</div>
					
					
				</div>
				<div class="col col-sm-12 col-md-4">
					<?php $this->load->view('/shared/side-due-task/side-due-template'); ?>

					<?php if( getRole() == 'teacher' ): ?>
						<div class="panel mt-3 p-3">
							<a href="#codeModal" data-toggle="modal"  class="btn btn-primary full-width changeable-color" > <i class="fa fa-users"></i> Invite People </a>
						</div>	
					<?php endif; ?>
				</div>
			</div>
		</div>
		 
	</div>
	</div>
</div>