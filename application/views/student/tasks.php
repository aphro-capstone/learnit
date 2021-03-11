<script>
	const tasks = <?php echo json_encode( $tasks );?>;
</script>


<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4">
			<ul class="panel-like-tabs class-item-container">
                <li class="title">  <span> Task Categories</span></li>
            </ul>
		</div>
		<div class="col-sm-12 col-md-8 col-lg-8">
			<div class="panel panel2">
				<div class="panel-header d-table border-bottom">
					<div class="dropdown pull-left status-dd" >
                    	<button class="btn btn-default" data-toggle="dropdown"> <span>Ongoing</span> <i class="fa fa-chevron-down"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="#"> Ongoing</a></li> 
                            <li><a href="#"> Completed</a></li> 
                        </ul>
                    </div>

				</div>
				<div class="panel-content tasks-container">

					<div class="task-item" data-toggle="modal" data-target="#quizInstruction">
						<div class="task-icon"	>
							<div class="ribbon left-ribbon ribbon-primary ribbon1">
								<div class="content big-text">
									<i class="fa fa-tasks"></i>
								</div>
							</div>
						</div>
						<div class="task-details">
							<p class="big-text">Example Quiz task </p>
							<span class="text-danger"> <i class="fa fa-clock-o"></i> Due on May 01,2020 </span>
							<p class=""> 60 Questions | 2 Hours</p>
							<hr>
							<span class="d-block font-bold"> Instruction </span>
							<p>
								1) This is by individual, pair or trio exercise.<br>
								2) This is an alternative exercise if you cannot do Final Module Exercise 3A.<br>
								3) You are task to do a Correlational Analysis on two continuous CODID-19 data.<br>

							</p>
						</div>
					</div>
					<div class="task-item" data-toggle="href" data-target="<?php getSiteLink('assignment/1'); ?>">
						<div class="task-icon"	>
							<div class="ribbon left-ribbon ribbon-primary ribbon1">
								<div class="content big-text">
									<i class="fa fa-tasks"></i>
								</div>
							</div>
						</div>
						<div class="task-details">
							<p class="big-text">Example Assignment task </p>
							<span class="text-danger"> <i class="fa fa-clock-o"></i> Due on May 01,2020 </span>
							<p class=""> 60 Questions | 2 Hours</p>
							<hr>
							<span class="d-block font-bold"> Instruction </span>
							<p>
								1) This is by individual, pair or trio exercise.<br>
								2) This is an alternative exercise if you cannot do Final Module Exercise 3A.<br>
								3) You are task to do a Correlational Analysis on two continuous CODID-19 data.<br>

							</p>
						</div>
					</div>
				</div>


				</div>
			</div>
		</div>
	</div>
</div>