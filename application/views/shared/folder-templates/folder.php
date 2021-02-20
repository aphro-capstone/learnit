

<?php 
	
	$title = isset($title) ? $title : "Folders";
	 
		//  Option 1 is library, 
	    //  Option 2 is from Class view
	$opt = isset($option) ? $option : 1;
 ?>	


<div class="panel panel2 folder-panel" id="folder-panel1">
	<div class="panel-header d-table full-width">
		<h3 class="type1-elems"  > <?=$title;?></h3>
		<div class="type2-elems">
			<h3 class="folder-breadcrumb d-flex "> 
					<i class="fa fa-folder returnFolder clickable-content"></i> 
					<i class="fa fa-chevron-right"></i> 
					<span class="foldername"> <?=$title;?> </span></h3>
		</div>
		<div class="row mt-3">
			<div class="col-sm-12 col-lg-7 col-md-7">
				<div class="search">
		            <input type="text" name="search" placeholder="Search ..">
		            <i class="fa fa-search"></i>
		        </div>
			</div>
			<div class="col-sm-12 col-lg-5 col-md-5">

				<?php if($opt == 1) : ?>
					<div class="dropdown pull-right type1-elems">
						<button class="btn btn-primary" data-toggle="modal" data-target="#Addfolder"> <i class="fa fa-folder"></i> New Folder  </button>
					</div>

					<div class="dropdown pull-right type2-elems">
						<div class="dropdown pull-right">
							<a href="#" class="btn btn-primary pull-right" data-toggle="dropdown"> <i class="fa fa-plus"></i> <span >New</span> </a>
							<ul class="dropdown-menu start-from-right" style="">
								<li> <a href="#Addfolder" data-toggle="modal" > <i class="fa fa-folder-o text-primary"></i>	New Folder  </a>  </li>
								<li> <a href="#uploadLibraryFiles" data-toggle="modal"> <i class="fa fa-upload text-info"></i>	File Upload  </a>  </li>
							</ul>	
						</div>	
					</div>


				<?php elseif($opt == 2 ): ?>
					<?php if( getRole() == 'teacher' ): ?>
							<a   href="#folderManage" class="pull-right btn btn-info" data-toggle="modal" > <i class="fa fa-file" data-toggle="tooltip" data-placement="left" data-title="Manage"></i>  </a>
					<?php else: ?>
							
					<?php endif; ?>
					<a id="downloadStandalone" href="#" class="pull-right mr-1 btn btn-primary" data-toggle="tooltip" data-placement="left" data-title="Download for offline use."> <i class="fa fa-download"></i> </a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="panel-content pl-0 pr-0 folders-panel">
			<div class="content">
				<div class="d-table">
					<div class="pull-left" style="margin-left: 75px!important;">
						<span class=""> Name</span>
					</div>
					<div class="pull-right" style="margin-right: 90px;">
						Date Created <span class="sorting clickable-content"> <i class="fa fa-chevron-down"></i></span>
					</div>
				</div>			
				<div id="folders_list"> </div>
			</div>		

			<div class="no-folder-show">
				<div class="text-center mt-3 mb-3 faded">
					<img src="<?=site_url()?>/assets/images/folder_nothing.png" style="max-width: 160px;width: 80%;">
				</div>
				<p class="text-center"> There is nothing to show. </p>
				<div class="text-center">
					<button class="btn btn-primary" data-toggle="modal" data-target="#Addfolder"> <i class="fa fa-plus"></i> New Folder </button>
				</div>
			</div>			
	</div>
</div> 


