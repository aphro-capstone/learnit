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
                            <li><a href="#" value="1"> Ongoing</a></li> 
                            <li><a href="#" value="0"> Completed</a></li> 
                            <li><a href="#" value="2"> Submitted</a></li> 
                        </ul>
                    </div>

				</div>
				<div class="panel-content tasks-container"> </div>
 
			</div>
		</div>
	</div>
</div>