<?php 
    $curDate = new DateTime();
?>

<script>
    const isOntaskindividualpages = false;
    const tasksss = <?= json_encode($tasks);?>;
</script>
 
<div class="container" id="due-task-page">
    
    <div class="panel panel2">
        <div class="panel-content pl-5 pr-5 pb-0">
            <div class="toppart">
                <div class="d-flex ">
                    <span class=""> Class : </span>

                    <div class="dropdown ml-2">
                        <div class="clickable-content data-toggle" data-toggle="dropdown" >
                            <span class="text">  All Classes   </span> <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-menu dropdown-w-search">
                            <div class="search">
                                <input type="text" >
                                <i class="fa fa-search icon"></i>
                            </div>
                            <div class="search-results classes-dropdown">
                                <div class="item class-item active"> 
                                    <a  href="#" class=""> 
                                        <span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
                                        All Classess
                                    </a> 
                                </div>
                                <?php foreach($classlist as $class): ?>
                                    <div class="item class-item" cid="<?= $class['class_id'];?>"> 
                                        <a  href="#"> 
                                            <span class="left-bg changeable-color" style="background-color:<?= $class['sc_color']?>"></span>   
                                            <?=$class['class_name'];  ?>
                                        </a> 
                                    </div>
                                <?php endforeach; ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <ul class="tabs nav nav-tabs">
                    <li class="" > <a class="active toggle-tasks forreview" href="#div1"  data-toggle="tab"> <i class="fa fa-eye"></i>  For Review  </a> </li>
                    <li class=""> <a class="toggle-tasks forreviewed" href="#div2"  data-toggle="tab"> <i class="fa fa-check"></i> Reviewed  </a> </li> 
                </ul>
            </div>
        </div>
    </div>
    <div class="divider3">
        <div class="content">
            
            <div class="dropdown">
                <span class="clickable-content" data-toggle="dropdown"> 
                    <i class="fa fa-filter"></i> <span class="text"> All works </span> <i class="fa fa-chevron-down"></i>  </span>
                <ul class="dropdown-menu start-from-right text-right all-work-dd" >
                    <li> <a href="#" data-val="0"> All Works </a></li>
                    <li> <a href="#" data-val="1"> Assignments </a></li>
                    <li> <a href="#" data-val="2"> Quizzes </a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel panel2 p-0 mt-2 tab-content">
        <div class="show-unreview" id="div1">
            <table class="table table-hover">
                <thead>
                    <th> Assignment / Quiz Name </th>
                    <th class="text-center" style="width:200px;"> Status </th>
                    <th class="text-center" style="width:100px;"> Submissions </th>
                    <th style="width:160px;"></th>
                </thead>
                <tbody>
                    <?php foreach( $tasks as $task ): ?>
                        <?php 
                            $cid = array();
                            foreach($task['assignee'] as $assignee){
                                $cid[] =  intval($assignee['class_id']) ;
                            }    
                        ?>
                        <tr class="due-item <?=$task['tsk_type'] == 0? 'quiz-item' : 'ass-item'; ?> <?= $task['is_reviewed'] == 0 ? 'unreviewed': 'reviewed';?>" data-tid = "<?= $task['tsk_id']?>"  data-cid='<?= json_encode($cid);?>'>
                            <td >
                                <div class="due-info">
                                    <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                    <div class="item-info">

                                        <?php  if( $task['tsk_type'] == 0 ):?>
                                            <a href="<?=getSiteLink('classes/quiz/quiz:' . $task['tsk_id']);?>" class="title"> <?= ucfirst( $task['tsk_title'] );?></a>
                                        <?php else: ?>
                                            <a href="<?=getSiteLink('classes/assignment/assignment:'. $task['tsk_id']);?>" class="title"> <?= ucfirst( $task['tsk_title'] );?></a>
                                        <?php endif;?> 
                                        <span class="d-block"> Assigned Date : <?= date_format( new Datetime( $task['assigned_date']), 'F d, Y @ h:i A' );?></span>
                                        <span class="d-block"> Due : <?= date_format( new Datetime( $task['tsk_duedate']), 'F d, Y @ h:i A' );?></span>
                                        <p class="pl-0"> Assigned to ::  
                                            <?php foreach( $task['assignee'] as $assignee): ?>

                                                <span class="pl-3 position-relative"> <i class="class-color" style="background:<?= $assignee['sc_color'];?>"></i>  <?=$assignee['class_name'];  ?>     </span>  
                                            <?php endforeach; ?>
                                            </p>        
                                    </div>
                                </div>
                            </td>
                            <td class="v-mid text-center status-td">

                                <?php if( $task['tsk_status'] == 0 ): ?>
                                    <div class="status-closed"> <span> Closed </span> </div>
                                <?php else: ?>
                                    <div class="status-open"> <span>Open</span>  </div>
                                <?php endif; ?>
 
                            </td>
                            <td class="v-mid text-center"><?= $task['submissions_count'][0]['submission_count'];?></td>
                            <td class="v-mid text-center"> 
                                <?php  if( $task['is_reviewed'] == 0 ): ?>
                                    <a href="#" class="btn btn-xs btn-outline-primary mark-review"> Marked as reviewed </a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-xs btn-outline-danger mark-unreview"> Marked as unreviewed </a>
                                <?php  endif; ?>
                                  
                            </td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        </div>  
    </div>
</div>