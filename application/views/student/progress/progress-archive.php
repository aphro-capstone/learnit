
<div class="container">
	<h3 class="title">Student Progress</h3>
	<div class="row mt-3">
		<div class="col-sm-12 col-md-8 col-lg-9">
			<div class="panel">
				<div class="panel-header border-bottom">
					<span> You got 5 Classess </span>
				</div>
				<div class="panel-content">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="search custom-search-layout">
					            <input type="text" name="search" placeholder="Search class..">
					            <i class="fa fa-search"></i>
					        </div>	
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="pull-right">
								<div class="dropdown">
						      		<span data-toggle="dropdown"> Sort by <i class="fa fa-chevron-down"></i> </span>
			                        <ul class="dropdown-menu  start-from-right">
			                            <li><a href="#"> A-Z</a></li> 
			                            <li><a href="#"> Date Joined</a></li> 
			                        </ul>
			                    </div>
							</div>
						</div>
					</div>
					<div id="class-progress-list" class="d-table full-width mt-3">
						<?php for($a = 0 ; $a < 5 ; $a++): ?>
							<?php $this->load->view('student/progress/progress-item'); ?>
						<?php endfor; ?>	
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4 col-lg-3">
			<?php  $this->load->view('shared/side-due-task/side-due-template'); ?>
		</div>
	</div>	
</div>
