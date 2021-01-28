

<?php  $QS = json_decode($taskinfo['tsk_options'],true); ?>
<script>
    const viewType = 'quiz';
    const submissions = <?= json_encode($submissions);?>;
    const isOntaskindividualpages = true;
    const taskinfo = <?= json_encode($taskinfo);?>;
    const tid = <?= $taskinfo['task_id'];?>;
</script> 
 

<div class="container">
    <h3 class="title return"> <span class="backbtn clickable-content"> <i class="fa fa-arrow-left"></i> </span>   Grading Overview </h3>
    <div class="panel panel2">
        <div class="panel-content pr-3 pt-4 panel-top-content">
            <div class="toppart-details d-flex">
                <span class="icon"> <i class="fa fa-tasks"></i> </span>
                <div class="left">
                    <div class="d-flex mb-3">
                        <span class="task-title mb-0"> <a href="#"> <strong><?= ucfirst($taskinfo['tsk_title']); ?></strong> </a>      </span>
                        <div class="m-auto status-span status-<?= $taskinfo['tsk_status'] == 0 ? 'closed' : 'open'; ?>" style="    margin-left: 2em!important;"> 
                            <span class=""> <?= $taskinfo['tsk_status'] == 0 ? 'Closed' : 'Open'; ?> </span> 
                        </div>
                    </div>
                    
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Due on  <?= date_format( new Datetime( $taskinfo['tsk_duedate'] ), 'F j, Y @ h:i A' )?> </span>
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Duration :   <?= $taskinfo['quiz_duration'] ?> minutes </span>
                    <span class="d-block"> <i class="fa fa-check"></i> Lock on due :   <?= $taskinfo['tsk_lock_on_due'] == 1 ? 'Yes' : 'No' ?> </span>
                    <?php if( $QS ): ?>
                        
                        <span class="d-block"> <i class="fa fa-cogs"></i> Options :
                            <?php if( isset($QS['israndomize']) && $QS['israndomize'] == 'true'  ) echo 'Randomized, '; ?>
                            <?php if( isset($QS['isaddtogradebook']) && $QS['isaddtogradebook'] == 'true'  ) echo 'Auto add to gradebook, '; ?>
                            <?php if( isset($QS['ishowresult']) && $QS['ishowresult'] == 'true'  ) echo 'Show result after quiz'; ?>
                        </span>
                    <?php endif; ?>
                  

                    
                    <p class="classlist mt-2"> 
                        <span class=""> Assigned to Classes : </span>

                        <?php  foreach( $assignees as $class ):?>
                            <span class="class"> <i class="color" style="background: <?= $class['sc_color']?>;"></i> <?= $class['class_name']?></span>,  
                        <?php endforeach;?>  
                    </p>
                   
                </div>
                <div class="right mr-0 m-auto mt-0 text-right d-flex">
                    <div class="dropdown mr-3">
                        <span class="clickable-content icon-display" data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i>  </span>
                        <ul class="dropdown-menu start-from-right" >
                            <?php if( $taskinfo['tsk_status'] == 1 ): ?>
                                <li> <a href="<?=site_url();?>teacher/classes/quiz/edit:<?= $taskinfo['quiz_id'];?>"> <i class="fa fa-edit text-info"></I> Edit Quiz </a></li>
                            <?php endif; ?>
                            <li> <a href="<?=site_url();?>teacher/classes/quiz/view:<?= $taskinfo['quiz_id'];?>"> <i class="fa fa-eye text-info"></i> View Quiz </a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <span class="clickable-content icon-display" data-toggle="dropdown"> <i class="fa fa-<?= $taskinfo['tsk_status'] == 0 ? 'unlock' : 'lock';?>" data-toggle="tooltip" data-placement=" "></i> </span>
                        <ul class="dropdown-menu start-from-right" >
                           
                            <?php if( $taskinfo['tsk_status'] == 0  ): ?>
                                <li> 
                                    <a href="#" class="d-flex unlock-quiz"> 
                                        <i class="fa fa-unlock text-primary"></I>
                                        <p class="mb-0"> <strong class="mb-2 d-block">Unlock Quiz</strong>  <span class="d-block"> Students will be able to take the quiz </span></p>  
                                    </a>
                                </li>
                            <?php else: ?>
                                
                                <?php if( $taskinfo['tsk_lock_on_due'] == 1): ?>
                                    <li> 
                                        <a href="#" class="d-flex remove-lock-quiz-due"> 
                                            <i class="fa fa-lock text-primary"></I> 
                                            <p class="mb-0"><strong class="mb-2 d-block">Remove Lock after due date</strong>  <span class="d-block"> Task will still be open even after due date. </span></p> 
                                            
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li> 
                                        <a href="#" class="d-flex lock-quiz-due"> 
                                            <i class="fa fa-lock text-primary"></I> 
                                            <p class="mb-0"><strong class="mb-2 d-block">Lock after due date</strong>  <span class="d-block"> Students will be unable to take the quiz after the due date </span></p> 
                                            
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <li> 
                                    <a href="#" class="text-danger d-flex lock-quiz"> 
                                        <i class="fa fa-lock"></I>  
                                        <p class="mb-0"> <strong class="mb-2 d-block">Lock Quiz</strong>  <span class="d-block te"> Students won't be able to take the quiz </span> </p>
                                        
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section mt-3 divider3">
        <div class="search">
            <input type="text" name="search" placeholder="Search student..">
            <i class="fa fa-search"></i>
        </div>
    </div>

    <div class="panel panel2 p-0 mt-3 tab-content">
        <table class="table table-hover details-table">
            <thead>
                <th> Student Name </th>
                <th class="text-center"  > Date Taken </th>
                <th class="text-center" style="width:130px"> Score </th>
                <th class="text-center" style="width: 140px;"></th>
            </thead>
            <tbody> </tbody>
        </table>
    </div>
</div>  