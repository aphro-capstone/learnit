<div class="container">
	<div class="row mt-3">
		<div class="col-sm-12 col-lg-12 col-md-12 col">
			<div class="header">

				<h3 class="title pull-left"><?= !$archives_page ? 'My Classes' : ( getRole() == 'teacher' ? 'Archived Classes' : 'Previous Classes' ); ?></h3>

				<div class="options pull-right dropdown">
					<a href="#" class="btn btn-primary options data-toggle" data-toggle="dropdown" >  <i class="fa fa-cog"></i> Options</a>
					<ul class="dropdown-menu start-from-right">
						<?php if ( getRole() == 'teacher'): ?>
							<?php if( $archives_page ): ?>
								<li> <a href="<?= getSiteLink('classes');?>"> View Active Classes </a></li>	
							<?php else: ?>
								<li class="createClassModal"> <a href="#"> Create a Class </a></li>	
								<li> <a href="<?= getSiteLink('classes/archives');?>"> View Archieved Classes </a></li>	
							<?php endif; ?>
							
						<?php else: ?>
							<?php if( $archives_page ): ?>
								<li> <a href="<?= getSiteLink('classes');?>"> View Active Classes </a></li>	
							<?php else: ?>
								<li> <a href="#joinClass" data-toggle="modal"> Join a Class </a></li>
								<li> <a href="<?= getSiteLink('classes/previous');?>"> Previous Classes </a></li>
							<?php endif; ?>

							
						<?php endif ?>
						
						
						
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col col-sm-12  col-md-9 col-lg-9 pr-2">
			<div class="row">	
				<!-- foreachClass -->
				<?php  foreach ($classes as $class): ?>
					<div class="col-sm-12 col-md-6 col-lg-6 mb-3" data-id="<?= getRole() == 'teacher' ? $class['class_id'] : $class['cs_id']; ?>">
						<div class="panel classinfo-panel clickable-content" >
							<div class="panel-content border-bottom pb-5" data-trigger="href" data-target="<?= getSiteLink('classes/class-'. $class['class_id'] );?>">
								<div class="classInfo">
									<span class="left-bg" style="background-color:<?= $class['sc_color'];?>"></span>
									<h4> <?= $class['class_name'];?></h4>
									<?php // var_dump($class); ?>
									<p class="m-0 subtitle"> <span class="teachername"> <?= getRole() == 'student' ? $class['teachername'] : getUserName(); ?> </span> <span class="subject"> <?= $class['s_name']; ?></span></p>
								</div>
							</div> 
							<div class="panel-content">
								<div class="d-table full-width dropdown">
									<?php if ( getRole() == 'teacher'): ?>
										<?php if(  !$archives_page ):  ?>
											<a href="#" class="pull-right btn mr-2 btn-outline-primary hoverable-btn archiveClass" > <i class="fa fa-archive"></i> <span> Archive Class</span> </a>
										<?php else: ?>
											<a href="#" class="pull-right btn mr-2 btn-outline-primary hoverable-btn unarchiveClass" > <i class="fa fa-archive"></i> <span> Unarchive Class</span> </a>
										<?php endif; ?>
										
										<a href="#" class="pull-right btn mr-2 btn-outline-danger hoverable-btn deleteClass"> <i class="fa fa-trash"></i>  <span> Delete Class</span></a>	
									<?php else: ?>
										<a href="#" class="pull-right btn mr-2 btn-outline-danger hoverable-btn withdrawClass" > <i class="fa fa-times "  ></i> <span>Withdraw from class</span> </a>
									<?php endif ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="col-sm-12 col-md-6 col-lg-6 mt-3">

					<?php if ( getRole() == 'teacher'): ?>
						<?php if( !$archives_page ): ?>
							<div class="addClass-panel clickable-content createClassModal">
								<div class="placeholder">
									<span class="d-block"> <i class="fa fa-plus"></i> </span>
									<span class="d-block">  Create New Class </span>
								</div>
							</div>
						<?php  endif;?>
					<?php else: ?>
						<div class="addClass-panel clickable-content " data-toggle="modal" data-target="#joinClass">
							<div class="placeholder">
								<span class="d-block"> <i class="fa fa-plus"></i> </span>
								<span class="d-block">  Join a Class </span>
							</div>
						</div>
					<?php endif ?>

					
				</div>

			</div> 
		</div>
		<div class="col col-sm-12 col-md-3 col-lg-3 pl-2">

			<?php $this->load->view('shared/side-due-task/side-due-template'); ?>
		</div>
	</div>
</div>