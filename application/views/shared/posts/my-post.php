
<?php 

	$placeholder = 'Share your thoughts with other teachers';
	$allowViews = true;


	if(isset($originator) && $originator == 'class'){
		$placeholder = 'Start a discussion, share class materials, etc...';
		$allowViews = false;
	}
 ?>


<div class="panel file-input-container-wrapper <?= isset( $isprofilepage ) ? 'expanded focused-content no-popup' : '' ;  ?>" id="yourPosts">
	<div class="panel-header">
		<div class=" column-panel-multi-row d-flex">
			<div class="image-left">
				<div class="img-container image-circular"> 
					<img src="<?=base_url() . getSessionData('sess_userImage');?>" alt="" />
				</div>
			</div>
			<div class="text-content unexpanded-content" data-trigger="expand,focus" data-target=".panel"> <?=$placeholder; ?> </div>
			<div class="text-content expanded-content">
				<div class="text position-relative" style="top: 5px; font-weight: 500;">  <?= getUserName();  ?> </div>
				<div class="text"><small> </small></div>
			</div>

			<div class="buttons unexpanded-content"> 
				<a href="#" class="button-icons attachfilebutton" data-toggle="tooltip" data-placement="bottom" title="Attach Image/file" > <i class="fa fa-book"></i> </a> 
				<a href="#addLibrary" data-toggle="modal" class="button-icons"> <i class="fa fa-book"  data-toggle="tooltip" data-placement="bottom" title="Get from Library" ></i> </a> 
				 
			</div>
		</div>
	</div> 
	<div class="panel-content expanded-content pb-0">
		<div class="content">
			<textarea class="textarea1" placeholder="<?=$placeholder;?>"></textarea>
			<div class="file-input-container">
				<div class="images"></div>
				<div class="files"></div>
			</div>
		</div>
		<?php if($allowViews): ?>
			<div class="row">
				<div class="visibletoSection">
					<div class="viewstatic collapsed" data-toggle="collapse" data-target="#visibletolist"> 
						Visible to : <i class="fa fa-globe"></i> <span class="text"> Any teacher on DNSC </span>
						<span class="pull-right"> <i class="fa fa-chevron-down"></i> </span>
					</div>
					<div class="collapsible-list collapse" id="visibletolist">
						<div class="item">
							<label> <i class="fa fa-globe"></i> <span class="text">Everyone on LearnIT  </span> </label>
							<div class="radioboxinput">
								<div class="frontend"></div>
								<input type="radio" name="viewTO">
							</div>
						</div>
						<div class="item">
							<label>
								 <i class="fa fa-users"></i> <span class="text"> Any student under me  </span>
							</label>
							<div class="radioboxinput">
								<div class="frontend"></div>
								<input type="radio" name="viewTO">
							</div>
						</div>
						<div class="item active" >
							<label> <i class="fa fa-users"></i> <span class="text">Any teacher on DNSC  </span> </label>
							<div class="radioboxinput checked">
								<div class="frontend"></div>
								<input type="radio" name="viewTO">
							</div>
						</div>
						<div class="item">
							<label> <i class="fa fa-users"></i> <span class="text">Any teacher and student on LearnIT  </span> </label>
							<div class="radioboxinput">
								<div class="frontend"></div>
								<input type="radio" name="viewTO">
							</div>
						</div>
						<div class="item">
							<label> <i class="fa fa-user-plus"></i> <span class="text">My Connections only  </span> </label>
							<div class="radioboxinput">
								<div class="frontend"></div>
								<input type="radio" name="viewTO">
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div> 
	<div class="panel-footer expanded-content">
		<div class="d-table full-width">
			<div class="buttons pull-left"> 
				<a href="#" class="button-icons attachfilebutton" data-toggle="tooltip" data-placement="top" title="Attach Image/file" > <i class="fa fa-book"></i> </a> 
				<a href="#" class="button-icons ember-from-library" data-toggle="tooltip" data-placement="top" title="Get from Library" > <i class="fa fa-book"></i> </a> 
				<!-- <a href="#" class="button-icons ember-from-video" data-toggle="tooltip" data-placement="top" title="Embed Video URL" > <i class="fa fa-globe"></i> </a>  -->
			</div>
			<button class="btn btn-primary pull-right" id="postBtn"> Post </button>
		</div>
	</div>
</div>