
<script>
    const viewType = 'quiz';
    const submissions = <?= json_encode($submissions);?>;
    const isOntaskindividualpages = true;
</script> 
 

<div class="container">
    <h3 class="title return"> <span class="backbtn clickable-content"> <i class="fa fa-arrow-left"></i> </span>   Grading Overview </h3>
    <div class="panel panel2">
        <div class="panel-content pr-3 pt-4 panel-top-content">
            <div class="toppart-details d-flex">
                <span class="icon"> <i class="fa fa-tasks"></i> </span>
                <div class="left">
                    <span class="task-title"> <a href="#"> <strong><?= ucfirst($taskinfo['tsk_title']); ?></strong> </a>   </span>
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Due on  <?= date_format( new Datetime( $taskinfo['tsk_duedate'] ), 'F j, Y @ h:i A' )?> </span>
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Duration :   <?= $taskinfo['quiz_duration'] ?> minutes </span>
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
                            <li> <a href="<?=site_url();?>teacher/classes/quiz/createquiz"> <i class="fa fa-edit text-info"></I> Edit Quiz </a></li>
                            <li> <a href="<?=site_url();?>teacher/classes/quiz/createquiz"> <i class="fa fa-eye text-info"></i> View Quiz </a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <span class="clickable-content icon-display" data-toggle="dropdown"> <i class="fa fa-lock" data-toggle="tooltip" data-placement=" "></i> </span>
                        <ul class="dropdown-menu start-from-right" >
                            <li> 
                                <a href="#" class="d-flex"> 
                                    <i class="fa fa-unlock text-primary"></I>
                                    <p class="mb-0"> <strong class="mb-2 d-block">Unlock Quiz</strong>  <span class="d-block"> Students will be able to take the quiz </span></p>  
                                    
                                </a>
                            </li>
                            <li> 
                                <a href="#" class="d-flex"> 
                                    <i class="fa fa-lock text-primary"></I> 
                                    <p class="mb-0"><strong class="mb-2 d-block">Lock after due date</strong>  <span class="d-block"> Students will be unable to take the quiz after the due date </span></p> 
                                    
                                </a>
                            </li>
                            <li> 
                                <a href="#" class="text-danger d-flex"> 
                                    <i class="fa fa-lock"></I>  
                                    <p class="mb-0"> <strong class="mb-2 d-block">Lock Quiz</strong>  <span class="d-block te"> Students won't be able to take the quiz </span> </p>
                                    
                                </a>
                            </li>
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