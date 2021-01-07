

<script>
    const isOntaskindividualpages = false;
</script>
 
<div class="container">
    
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
                                <div class="item class-item"> 
                                    <a  href="#" class=""> 
                                        <span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
                                        All Classess
                                    </a> 
                                </div>
                                <?php foreach($classlist as $class): ?>
                                    <div class="item class-item"> 
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
                    <li> <a class="active" href="#div1"  data-toggle="tab"> <i class="fa fa-eye"></i>  Review  </a> </li>
                    <li > <a href="#div2"  data-toggle="tab"> <i class="fa fa-check"></i> Reviewed  </a> </li>
                    <li > <a href="#div3"  data-toggle="tab"> <i class="fa fa-clock-o    "></i> Scheduled  </a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="divider3">
        <div class="content">
            
            <div class="dropdown">
                <span class="clickable-content" data-toggle="dropdown"> <i class="fa fa-filter"></i> All works <i class="fa fa-chevron-down"></i>  </span>
                <ul class="dropdown-menu start-from-right text-right" >
                    <li> <a href="#"> All Works </a></li>
                    <li> <a href="#"> Assignments </a></li>
                    <li> <a href="#"> Quizzes </a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel panel2 p-0 mt-2 tab-content">
        <div class="tab-pane fade active show" id="div1">
            <table class="table table-hover">
                <thead>
                    <th> Assignment / Quiz Name </th>
                    <th class="text-center" style="width:100px;"> Submissions </th>
                    <th style="width:160px;"></th>
                </thead>
                <tbody>
                    <?php foreach( $tasks as $task ): ?>
                        <tr class="due-item">
                            <td >
                                <div class="due-info">
                                    <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                    <div class="item-info">

                                        <?php  if( $task['tsk_type'] == 0 ):?>
                                            <a href="<?=getSiteLink('classes/quiz/quiz:' . $task['tsk_id']);?>" class="title"> <?= ucfirst( $task['tsk_title'] );?></a>
                                        <?php else: ?>
                                            <a href="<?=getSiteLink('classes/assignment/assignment:'. $task['tsk_id']);?>" class="title"> <?= ucfirst( $task['tsk_title'] );?></a>
                                        <?php endif;?>
                                        
                                        <span class="d-block"> Due : <?= date_format( new Datetime( $task['tsk_duedate']), 'F d, Y @ h:i A' );?></span>
                                        <p class="pl-0"> Assigned to ::  
                                            <?php foreach( $task['assignee'] as $assignee): ?>

                                                <span class="pl-3 position-relative"> <i class="class-color" style="background:<?= $assignee['sc_color'];?>"></i>  <?=$assignee['class_name'];  ?>     </span>  
                                            <?php endforeach; ?>
                                            </p>        
                                    </div>
                                </div>
                            </td>
                            <td class="v-mid text-center"><?= $task['submissions_count'][0]['submission_count'];?></td>
                            <td class="v-mid text-center"> <a href="#" class="btn btn-xs btn-outline-primary"> <i class="fa fa-checked"></i> Marked as reviewed </a>  </td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="div2">
            <table class="table table-hover">
                <thead>
                    <th> Assignment / Quiz Name </th>
                    <th class="text-center" style="width:100px;"> Submissions </th>
                    <th style="width:180px;"></th>
                </thead>
                <tbody>
                    <tr class="due-item">
                        <td >
                            <div class="due-info">
                                <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                <div class="item-info">
                                    <a href="#" class="title">Assignment 1</a>
                                    <span class="d-block"> Due : May 30, 2020 @ 11:59 PM</span>
                                    <p> <span class="class-color"></span> <span class="className"> Class1 </span></p>
                                </div>
                            </div>
                        </td>
                        <td class="v-mid text-center">30</td>
                        <td class="v-mid text-center"> <a href="#" class="btn btn-xs btn-outline-warning"> <i class="fa fa-checked"></i> Marked as unreviewed </a>  </td>
                    </tr>
                    <tr class="due-item">
                        <td >
                            <div class="due-info">
                                <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                <div class="item-info">
                                    <a href="#" class="title">Quiz 1</a>
                                    <span class="d-block"> Due : May 30, 2020 @ 11:59 PM</span>
                                    <p> <span class="class-color"></span> <span class="className">  Class1 </span></p>
                                </div>
                            </div>
                        </td>
                        <td class="v-mid text-center">30</td>
                        <td class="v-mid text-center">20</td>
                        <td class="v-mid text-center"> <a href="#" class="btn btn-xs btn-outline-warning"> <i class="fa fa-checked"></i> Marked as unreviewed </a>  </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="div3">
            <table class="table table-hover">
                <thead>
                    <th> Assignment / Quiz Name </th>
                    <th class="text-center"> Scheduled </th>
                    <th style="width:160px;"></th>
                </thead>
                <tbody>
                    <tr class="due-item">
                        <td >
                            <div class="due-info">
                                <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                <div class="item-info">
                                    <a href="#" class="title">Assignment 1</a>
                                    <span class="d-block"> Due : May 30, 2020 @ 11:59 PM</span>
                                    <p> <span class="class-color"></span> <span class="className"> Class1 </span></p>
                                </div>
                            </div>
                        </td>
                        <td class="v-mid text-center">August 1, 2020</td>
                        <td class="v-mid text-center"> <a href="#" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i> Remove </a>  </td>
                    </tr>
                    <tr class="due-item">
                        <td >
                            <div class="due-info">
                                <div class="icon"> <i class="fa fa-tasks"></i>  </div>
                                <div class="item-info">
                                    <a href="#" class="title">Assignment 1</a>
                                    <span class="d-block"> Due : May 30, 2020 @ 11:59 PM</span>
                                    <p> <span class="class-color"></span> <span class="className"> Class1 </span></p>
                                </div>
                            </div>
                        </td>
                        <td class="v-mid text-center">August 1, 2020</td>
                        <td class="v-mid text-center"> <a href="#" class="btn btn-xs btn-outline-danger"> <i class="fa fa-trash"></i> Remove </a>  </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>