

<?php 
	
	$title = isset($title) ? $title : "Folders";
	 
		//  Option 1 is library, 
	    //  Option 2 is from Class view
	$opt = isset($option) ? $option : 1;
 ?>	

<div class="panel panel2 folder-panel" id="folder-panel1">
	<div class="panel-header d-table full-width">
		<h3 > <?=$title;?></h3>
		<div class="row mt-3">
			<div class="col-sm-12 col-lg-7 col-md-7">
				<div class="search">
		            <input type="text" name="search" placeholder="Search ..">
		            <i class="fa fa-search"></i>
		        </div>
			</div>
			<div class="col-sm-12 col-lg-5 col-md-5">

				<?php if($opt == 1) : ?>
					<div class="dropdown pull-right">
						<button class="btn btn-primary"  data-toggle="dropdown" >  <i class="fa fa-plus"> New </i> </button>
						<ul class="dropdown-menu start-from-right" style="">
								<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
								<li> <a href="#"> <i class="fa fa-arrows text-success"></i> Move  </a>  </li>
								<li> <a href="#"> <i class="fa fa-copy text-primary"></i> Copy  </a>  </li>
								<li> <a href="#"> <i class="fa fa-share-alt text-primary"></i> Share  </a>  </li>
								<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
						</ul>	
					</div>
				<?php elseif($opt == 2 ): ?>
					<?php if( getRole() == 'teacher' ): ?>
						<a href="#folderManage" class="btn btn-primary pull-right hoverable-btn" data-toggle="modal" > <i class="fa fa-file"></i> <span>Manage</span> </a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="panel-content pl-0 pr-0">
		
		<div class="d-table">
			<div class="pull-left" style="margin-left: 75px!important;">
				<span class=""> Name</span>
			</div>
			<div class="pull-right" style="margin-right: 90px;">
				Date Modified <span class="sorting clickable-content"> <i class="fa fa-chevron-down"></i></span>
			</div>
		</div>

		<div id="folders_list">

			<?php if ( getRole() == 'teacher'): ?>
				<div class="folder-item item">
					<div class="folder-icon"> <i class="fa fa-folder"></i></div>
					<div class="folder-info">
						<div class="folder-name clickableFolder">Quizzes</div>
						<?php if($opt == 2): ?>
							<div class="author"> Author : Aphrodite Gajo</div>
						<?php endif; ?>
						
					</div>
					
					
					<div class="folder-date">
						<span> 5/22/2020 </span>
					</div>
					<div class="dropdown folder-menu-dd"></div>
				</div>
				<div class="folder-item item">
					<div class="folder-icon"> <i class="fa fa-folder"></i></div>
					<div class="folder-info">
						<div class="folder-name clickableFolder">Assignments</div>
						<?php if($opt == 2): ?>
							<div class="author"> Author : Aphrodite Gajo</div>
						<?php endif; ?>
					</div>
					<div class="folder-date">
						<span> 5/22/2020 </span>
					</div>
					<div class="dropdown folder-menu-dd"></div>
				</div>
			<?php endif ?>
			<div class="folder-item item">
				<div class="folder-icon"> <i class="fa fa-folder"></i></div>
				<div class="folder-info">
					<div class="folder-name clickableFolder">Extra Folder</div>
					<?php if($opt == 2): ?>
						<div class="author"> Author : Aphrodite Gajo</div>
					<?php endif; ?>
				</div>
				<div class="folder-date">
					<span> 5/22/2020 </span>
				</div>
				<div class="dropdown folder-menu-dd">
					<div class="dropdown pull-right">
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<?php if($opt == 1): ?>
								<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
								<li> <a href="#"> <i class="fa fa-arrows text-success"></i> Move  </a>  </li>
								<li> <a href="#"> <i class="fa fa-copy text-primary"></i> Copy  </a>  </li>
								<li> <a href="#"> <i class="fa fa-share-alt text-primary"></i> Share  </a>  </li>
								<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
							<?php elseif($opt == 2): ?>
								<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Unshare  </a>  </li>
							<?php endif; ?>
							
						</ul>	
					</div>	
				</div>
			</div>
			<div class="folder-item item">
				<div class="folder-icon"> <i class="fa fa-folder"></i></div>
				<div class="folder-info">
					<div class="folder-name clickableFolder">Extra Folder 2</div>
					<?php if($opt == 2): ?>
						<div class="author"> Author : Aphrodite Gajo</div>
					<?php endif; ?>
				</div>
				<div class="folder-date">
					<span> 5/22/2020 </span>
				</div>
				<div class="dropdown folder-menu-dd">
					<div class="dropdown pull-right">
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<?php if($opt == 1): ?>
								<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
								<li> <a href="#"> <i class="fa fa-arrows text-success"></i> Move  </a>  </li>
								<li> <a href="#"> <i class="fa fa-copy text-primary"></i> Copy  </a>  </li>
								<li> <a href="#"> <i class="fa fa-share-alt text-primary"></i> Share  </a>  </li>
								<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
							<?php elseif($opt == 2): ?>
								<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Unshare  </a>  </li>
							<?php endif; ?>
							
						</ul>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

<div class="panel panel2 folder-content" id="folder-panel2" style="display: none;">
	<div class="panel-header d-table">
		<h3 class="pull-left folder-breadcrumb d-flex"> <i class="fa fa-folder returnFolder clickable-content"></i> 	<i class="fa fa-chevron-right"></i> <span class="foldername"> Quizzes </span></h3>
		<div class="dropdown pull-right">
			<div class="dropdown pull-right">
				<a href="#" class="btn btn-primary pull-right" data-toggle="dropdown"> <i class="fa fa-plus"></i> <span >New</span> </a>
				<ul class="dropdown-menu start-from-right" style="">
					<li> <a href="#">File Upload  </a>  </li>
					<li> <a href="#">Folder </a>  </li>
					<li> <a href="#">Link </a>  </li>
					<li> <a href="#">Quiz  </a>  </li>
				</ul>	
			</div>	
		</div>
	</div>
	<div class="panel-content pl-0 pr-0">
		<div class="d-table">
			<div class="pull-left" style="margin-left: 75px!important;">
				<span class=""> Name</span>
			</div>
			<div class="pull-right" style="margin-right: 45px;">
				Date Modified <span class="sorting clickable-content"> <i class="fa fa-chevron-down"></i></span>
			</div>
		</div>

		<div id="folders_list mt-3">
 			<div class="folder-item file-item item">
				<div class="folder-icon icon"> <i class="fa fa-file"></i></div>
				<div class="folder-info">
					<div class="folder-name">Example file 1</div>
				</div>
				<div class="folder-date"> <span> 5/22/2020 </span> </div>
				<div class="dropdown folder-menu-dd">
					<div class="dropdown pull-right">
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
							<li> <a href="#"> <i class="fa fa-tasks text-primary"></i> Assign  </a>  </li>
							<li> <a href="#"> <i class="fa fa-arrows text-primary"></i> Move  </a>  </li>
							<li> <a href="#"> <i class="fa fa-copy text-info"></i> Copy  </a>  </li>
							<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
						</ul>	
					</div>	
				</div>
			</div>
			<div class="folder-item file-item item">
				<div class="folder-icon icon"> <i class="fa fa-file-excel-o"></i></div>
				<div class="folder-info">
					<div class="folder-name">Example file 2</div>
				</div>
				<div class="folder-date"> <span> 5/22/2020 </span> </div>
				<div class="dropdown folder-menu-dd">
					<div class="dropdown pull-right">
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
							<li> <a href="#"> <i class="fa fa-tasks text-primary"></i> Assign  </a>  </li>
							<li> <a href="#"> <i class="fa fa-arrows text-primary"></i> Move  </a>  </li>
							<li> <a href="#"> <i class="fa fa-copy text-info"></i> Copy  </a>  </li>
							<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
						</ul>	
					</div>	
				</div>
			</div>
			<div class="folder-item file-item item">
				<div class="folder-icon icon"> <i class="fa fa-file"></i></div>
				<div class="folder-info">
					<div class="folder-name">Example file 3</div>
				</div>
				<div class="folder-date"> <span> 5/22/2020 </span> </div>
				<div class="dropdown folder-menu-dd">
					<div class="dropdown pull-right">
						<span class="btn btn-default" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-chevron-down"></i> </span>
						<ul class="dropdown-menu start-from-right" style="">
							<li> <a href="#"> <i class="fa fa-edit text-info"></i> Edit  </a>  </li>
							<li> <a href="#"> <i class="fa fa-tasks text-primary"></i> Assign  </a>  </li>
							<li> <a href="#"> <i class="fa fa-arrows text-primary"></i> Move  </a>  </li>
							<li> <a href="#"> <i class="fa fa-copy text-info"></i> Copy  </a>  </li>
							<li> <a href="#"> <i class="fa fa-trash text-danger"></i> Delete  </a>  </li>
						</ul>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>



