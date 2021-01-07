
<?php
    $is2ndlvl = false;
    
    if(isset( $subcomment )){
        $is2ndlvl = true;
        $com_ = $subcomment;
    }else{
        $com_ = $comment;
    }
    
?>
<div class="comment" data-id="<?= $com_['c_id']?>">
    <div class="user-image img-container image-circular">
        <a href="<?= site_url('user/profile/' . $com_['commentor_id']);?>">
            <img src="<?= base_url()?>assets/images/user.png" alt="user-image">
        </a>
    </div>
    <div class="wrapper dropdown">
        <div class="comment-content">
            <div class="comment-text">
                <p class="mb-0 no-wrap"> <a href="#" class="user-name"> <?=$com_['commentor_name']?> </a></p>
                <p class=""> <?= $com_['c_content']['t']; ?> </p>
            </div>
            <div class="links"> 
                <div class="reactions"> </div>
                <a href="#" class="like-comment"> Like </a>
                <a href="#" class="reply-comment"> Reply </a>
                <span class="post-time small"> <?= getTimeDifference($com_['timestamp_created'],true); ?></span> 	
            </div> 
            <?php if( !$is2ndlvl ):  ?>
                <div class="sub-comments">
                    <?php 
                        if( !empty($comment['subcomments']) ):
                            foreach( $comment['subcomments'] as $subc ):
                                $this->load->view('/shared/posts/comment-template',array('subcomment' => $subc));
                            endforeach;
                        endif;
                    ?> 
                </div>
            <?php endif;?>
        </div>
        <span class="options data-toggle" data-toggle="dropdown" aria-expanded="true"> <i class="fa fa-ellipsis-h"></i>  </span>
        <ul class="dropdown-menu" style="position: absolute; transform: translate3d(514px, 32px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-start">
            <li><a href="#"> <i class="fa fa-edit text-info"></i> Edit</a></li> 
            <li><a href="#"> <i class="fa fa-trash-o text-danger"></i> Delete</a></li> 
        </ul>
        <?php if( !$is2ndlvl )$this->load->view('/shared/posts/user-comment-template'); ?>
    </div>

    
</div>