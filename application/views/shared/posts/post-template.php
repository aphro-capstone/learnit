<?php 
	extract($post); 
	$commentCounter = 0;

	$diffDisplay = getTimeDifference( $timestamp_created,false,' ago' );
	 

	if( !empty($comments) ):
		foreach( $comments as $comment ):
			$commentCounter++;
			if( !empty($comment['subcomments']) ){
				$commentCounter += count($comment['subcomments']);
			}
		endforeach;
	endif;
	

	$assignees_ = array();

	if( isset($assignees) ){
		if( is_string( $assignees )  ){
			$assignees_[] = $assignees;
		}else{
			foreach( $assignees as $as ){
				$assignees_[] = $as['class_name'];
			}
		}
	}   
?>
<div class="panel post-panel" data-post-id="<?= $p_id; ?>" data-id-2="<?=$post_ref_type?>">
	<div class="panel-header">
		<div class=" column-panel-multi-row d-flex dropdown">
			<div class="image-left">
				<div class="img-container image-circular"> 
					<img src="<?= base_url()?>assets/images/user.png" alt="" />
				</div>
			</div>
				<div class="text-content">
				<div class="text position-relative" style="top: 5px; font-weight: 500;"> <a href="#" class="poster-name font-bold">  <?= $poster_name;?> </a>
					<?php if( !empty( $assignees_) ): ?>
						posted to <strong> <?= implode(',', $assignees_ );?></strong>
					<?php endif; ?>
				</div>
				<div class="text"><small><?=$diffDisplay;?></small></div>
			</div> 

			<span class="options data-toggle" data-toggle="dropdown"> <i class="fa fa-ellipsis-h" ></i>  </span>
			<ul class="dropdown-menu">
				<li><a href="<?=getSiteLink('post/post-' . $p_id);?>" class=""> <i class="fa fa-link text-info"></i> Post Link </a></li> 
					<?php if($author_id == getUserID()):  ?>
						<?php if( !isset( $tsk_id )) : ?> 
							<li><a href="#" class="post-option edit-psot" > <i class="fa fa-edit text-info"></i> Edit Post</a></li> 
						<?php endif; ?>
						
						<li><a href="#" class="delete-post post-option"> <i class="fa fa-trash text-danger"></i> Delete Post</a></li> 
					<?php endif; ?>
				<li><a href="#" class="post-option hide-post"> <i class="fa fa-eye-slash text-danger"></i> Hide Post</a></li> 
				<li><a href="#" class="post-option turn-on-notification	"> <i class="fa fa-bell text-info"></i> Turn off notification for this post</a></li> 
			</ul>
		</div>
	</div>
	<div class="panel-content">
		<?php if ( $post_ref_type == 1 ) :?>
			<div class="attachment-element mb-3 quiz-attachment">
				<div class="icon"> <i class="fa fa-tasks"></i></div>
				<div class="text-content ml-2">
					<span class="title d-block"> <?=$tsk_title?> </span>
					<span class="duedate d-block mt-3 mb-3 small"> 
						<i class="fa fa-clock-o"></i> 
						Due on <?= date_format( new DateTime( $tsk_duedate ),'m/j , h:i A' ); ?>
					</span>
					<?php if( $tsk_type == 0 ) : ?>
						<p class="mb-0">  <span># of Question :  <?=$quiz_count?> </span> | Duration : <span> <?=$duration; ?> minutes  </span> </p>
					<?php endif;?>
					<p class="task-intruction"> <?=$tsk_instruction; ?> </p>
					<a href="#" class="btn btn-xs attachment-button btn-outline-secondary"> Submissions(<?=$submissionCount;?>) </a>
				</div>
			</div>
		<?php elseif( $post_ref_type == 0 ): ?>
			<div class="texts">
				<p><?= $p_content['t']; ?></p>
			</div>
			<div class="files mb-3">
				<?php $this->load->view('shared/attachment-template',array('attachments' =>   $p_content['a'], 'postID' => $p_id  ) ); ?>
			</div>
			
			<!-- <div class="image row mb-3">
			 	<div class="img-container">
			 		<img src="<?php // base_url()?>assets/images/background.jpg">
			 	</div>
			</div> -->
		<?php endif; ?>	 
		
		<div class="reaction-counts d-table">
			<div class="pull-left d-flex">
				<div class="mini-reaction-item mini-reaction-like">
					<div class="namelist">
						<span class="reaction-name"> Like </span>
						<ul class="no-style mb-0">
							<li>Aphrodite Gajo</li>
							<li>Virna</li>
							<li>isa pa ka member</li>
							<li>ug isa ka member</li>
							<li>ug isa ka member</li> 
						</ul>
					</div>
				</div>
				<div class="mini-reaction-item mini-reaction-love">
					<div class="namelist">
						<span class="reaction-name"> Love </span>
						<ul class="no-style mb-0">
							<li>Aphrodite Gajo</li>
							<li>Virna</li>
							<li>isa pa ka member</li>
							<li>ug isa ka member</li>
							<li>ug isa ka member</li> 
						</ul>
					</div>
				</div>
				<div class="mini-reaction-item mini-reaction-haha">
					<div class="namelist">
						<span class="reaction-name"> Haha </span>
						<ul class="no-style mb-0">
							<li>Aphrodite Gajo</li>
							<li>Virna</li>
							<li>isa pa ka member</li>
							<li>ug isa ka member</li>
							<li>ug isa ka member</li> 
						</ul>
					</div>
				</div> 
				<span class="count ml-1">15</span>
			</div>
			<div class="pull-right">
				<a href="#" class="comment-toggle"> <?=$commentCounter;?> comments </a>
			</div>
		</div>
		<div class="like-share-comment row">
			<div class="item reaction-div d-flex">
				<div class="reactions">
					<div class="">
						<div class="reaction-item reaction-like "></div>
						<div class="reaction-item reaction-love "></div>
						<div class="reaction-item reaction-haha "></div>
						<div class="reaction-item reaction-wow "></div>
						<div class="reaction-item reaction-sad "></div>
						<div class="reaction-item reaction-angry "></div>
					</div>
				</div>
				<span class="icon reaction-trigger"> <i class="fa fa-thumbs-o-up"></i> Like </span>
			</div>
			<div class="item"> <span class="comment-toggle"> <i class="fa fa-comments-o"></i> Comment</span> </div>
			<!-- <div class="item"> <i class="fa fa-share"></i> Share </div> -->
		</div>
		<div class="comments-section mt-3">
			<div class="comments-list">
				<?php 
					// var_dump( $comments );
					if( !empty($comments) ):
						foreach( $comments as $comment ):
							$this->load->view('/shared/posts/comment-template',array('comment' => $comment));
						endforeach;
					endif;
				?>
			</div>
			<?php $this->load->view('/shared/posts/user-comment-template'); ?>
		</div>
	</div>   
</div> 
  