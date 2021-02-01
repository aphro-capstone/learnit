<?php
 
?>
<script>
    const submissions = <?=json_encode( $submissions );?>;
    const assignees = <?=json_encode( $assignees );?>;
    const viewType = 'assignment';
    const isOntaskindividualpages = true;
    const TI = <?php echo json_encode( $taskinfo );?>;
    const tid = <?php echo $taskinfo['tsk_id'];?>;
    const aid = <?php echo $taskinfo['ass_id'];?>;
</script>



<div class="container" id="assignment-details">
    <h3 class="title return"> <span class="backbtn clickable-content"> <i class="fa fa-arrow-left"></i> </span>   Grading Overview </h3>
    <div class="panel panel2"> 
        <div class="panel-content pr-3 pb-0 pt-4  panel-top-content">
            <div class="toppart-details d-flex">
                <span class="icon"> <i class="fa fa-tasks"></i> </span>
                <div class="left">
                    <span class="task-title"><a href="#"> <strong><?= ucfirst($taskinfo['tsk_title']);?></strong> </a>   </span>
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Due on <?= date_format( new Datetime( $taskinfo['tsk_duedate'] ) ,"F d, Y @ h:i A");?> </span>
                   
                    <?php if( count($assignees) == 1 ): ?>
                        <p class="classlist"><span class="block"> <span> Assigned Class : </span> <span class="class"> <i class="color" style="background: #fecb00;"></i> <?php echo $assignees[0]['class_name']; ?></span>    </p>
                    <?php else: ?>
                        <div class="d-flex ">
                            <span class=""> Viewing : </span>

                            <div class="dropdown ml-2">
                                <div class="clickable-content data-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="text viewing-class" >  All Classes   </span> <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="dropdown-menu dropdown-w-search pt-0" style="">
                                    <div class="search">
                                        <input type="text">
                                        <i class="fa fa-search icon"></i>
                                    </div>
                                    <div class="search-results classes-dropdown">
                                        <div class="item class-item default"> 
                                            <a href="#" class="">  <span class="left-bg changeable-color" style="background-color:#3583e5"></span>  All Classess
                                            </a> 
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    
                </div>
                <div class="right mr-0 m-auto mt-0 text-right">
                    <div class="dropdown">
                        <span class="clickable-content" data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i>  </span>
                        <ul class="dropdown-menu start-from-right" >
                            <li> <a href="#" class="edit-assignment"> <i class="fa fa-edit text-primary"></I> Edit Assignment </a></li>
                            <li> <a href="<?=getSiteLink('classes/assignment/view:' . $taskinfo['ass_id'])?>" class="view-assignment"> <i class="fa fa-eye text-info"></i> View Assignment </a></li>
                            <li> 
                                <?php $lockdue = $taskinfo['tsk_lock_on_due'] == 1; ?>
                                <div class="custom-checkbox p-2 <?= $lockdue ? 'checked':''; ?>"  >
                                    <input type="checkbox" name="lock-on-due">
                                    <span class="checkbox fa fa-check lockassondue"></span>
                                    <span class="label">  Lock  submission after due date  </span>
                                </div>
                            </li> 
                        </ul>
                    </div>
                    
                    <span class="d-block mt-3 mb-3"> <strong>Average Grade Score : <span class="average-percentage">0%</span></strong>  </span>
                </div>
            </div>
            <div class="mt-4">
                <ul class="tabs nav nav-tabs">
                    <li class="mr-0"> <a class="active sorttrigger" data-sort="all-stud" href="#"> All Students </a> </li>
                    <li class="mr-0"> <a class="sorttrigger" data-sort="not-graded" href="#"> Not Graded  </a> </li>
                    <li class="mr-0"> <a class="sorttrigger" data-sort="graded" href="#"> Graded  </a> </li>
                </ul>
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
                <th class="text-center"> Datetime of Submission </th>
                <th class="text-center" style="width:130px"> Grade/Score </th>
                <th class="text-center" style="width: 200px;"> </th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>