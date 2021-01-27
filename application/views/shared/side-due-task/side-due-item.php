
<?php  extract( $task );  ?>


<div class="task-container collapsible-item  due-task-item remark-<?php echo $remark;?> <?php echo $sub_count > 0 ? 'has-submits' : '';?>" data-task-id="<?= $tsk_id; ?>" data-toggle="collapse" data-target="#due-task-item-<?=$tsk_id?>">
    <div class=" icon-hold collapse-toggle " > 
        <div class="icon"><i class="fa fa-tasks" aria-hidden="true"></i> </div>
        
        <!-- <span class="pull-right"> <i class="fa fa-chevron-down"></i> </span>  -->
    </div>
    <div class="title" class="collapse-toggle clickable-content collapsed" data-toggle="collapse" data-target="#due-task-item-<?=$tsk_id?>"> <?php echo $tsk_title; ?> </div>
    <div class="collapse collapsible-list collapsible-div mt-2 <?php echo getRole() == 'teacher' && $remark == 'late' ? 'w-button' : '';?>" id="due-task-item-<?=$tsk_id?>">
        <p class="mb-0 small"> Class/es :  <strong><?php echo $assignees ?></strong> </p>
        <p class="mb-0 small"> Status : <strong> <?php echo $remark == 'today' ? 'due today' : $remark; ?></strong> </p>
        
        <?php if( getRole() == 'teacher' ): ?>
            <p class="mb-0 small"> Submissions : <strong><?= $sub_count ?> </strong></p>
        <?php endif; ?>
        <p class="mb-0 small"> <strong><i class="fa fa-clock-o"></i> <?php  echo (new DateTime( $tsk_duedate ))->format('M d, Y h:i a') ?> </strong> </p>
        
        <div class="d-flex full-width">
            <?php if( getRole() == 'teacher'): ?>
                <?php if($remark == 'late'): ?>
                    <button class="btn closeTaskBtn  mt-2 mr-1 mb-2 btn-xs btn-outline-danger hoverable-btn  "> <i class="fa fa-times-circle"></i> <span>close task</span> </button>    
                <?php endif; ?>
                <a href="<?= getSiteLink('classes/' . ($tsk_type == 1 ? 'assignment/assignment:' . $tsk_id : 'quiz/quiz:' . $tsk_id))?>"  class="btn mt-2 mb-2 btn-xs btn-outline-info hoverable-btn"> <i class="fa fa-eye  "></i> <span> View task</span> </a> 
            <?php else: ?>\
                <?php if(  $tsk_type == 0 ): ?>
                    
                    <a href="<?= getSiteLink('quiz/'.  ( $sub_count > 0 ? 'view' : 'quiz' )  .':' .  $quiz_id ); ?>"  class="btn mt-2 mb-2 btn-xs btn-outline-info hoverable-btn"> <i class="fa fa-eye  "></i> <span> <?=  $sub_count > 0 ? 'View' : 'Take' ?> Quiz</span> </a> 
                <?php else: ?>
                    <a href="<?= getSiteLink('assignment/assignment:' .  $as_id ); ?>"  class="btn mt-2 mb-2 btn-xs btn-outline-info hoverable-btn"> <i class="fa fa-eye  "></i> <span> View Assignment</span> </a> 
                <?php endif; ?>
            <?php endif; ?>


        </div>
    </div>

    
     
</div> 
 