<?php
 
?>
<script>
    const submissions = <?=json_encode( $submissions );?>;
    const assignees = <?=json_encode( $assignees );?>;
    const viewType = 'assignment';
    const isOntaskindividualpages = true;

</script>



<div class="container">
    <h3 class="title return"> <span class="backbtn clickable-content"> <i class="fa fa-arrow-left"></i> </span>   Grading Overview </h3>
    <div class="panel panel2"> 
        <div class="panel-content pr-3 pb-0 pt-4  panel-top-content">
            <div class="toppart-details d-flex">
                <span class="icon"> <i class="fa fa-tasks"></i> </span>
                <div class="left">
                    <span class="task-title"><a href="#"> <strong><?= ucfirst($taskinfo['tsk_title']);?></strong> </a>   </span>
                    <span class="d-block"> <i class="fa fa-clock-o"></i> Due on <?= date_format( new Datetime( $taskinfo['tsk_duedate'] ) ,"F d, Y @ h:i A");?> </span>
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
                                    <div class="item class-item"> 
                                        <a href="#"> 
                                            <span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
                                            Class 1
                                        </a> 
                                    </div>
                                    <div class="item class-item"> 
                                        <a href="#"> 
                                            <span class="left-bg changeable-color" style="background-color:#3583e5"></span>   
                                            Class 2
                                        </a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right mr-0 m-auto mt-0 text-right">
                    <div class="dropdown">
                        <span class="clickable-content" data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i>  </span>
                        <ul class="dropdown-menu start-from-right" >
                            <li> <a href="#"> <i class="fa fa-edit text-primary"></I> Edit Assignment </a></li>
                            <li> <a href="#"> <i class="fa fa-eye text-info"></i> View Assignment </a></li>
                            <li>
                                <div class="custom-checkbox p-2">
                                    <input type="checkbox" name="">
                                    <span class="checkbox fa fa-check"></span>
                                    <span class="label"> Lock assignment submission after due  </span>
                                </div>
                            </li>
                            <li>
                                <div class="custom-checkbox p-2">
                                    <input type="checkbox" name="">
                                    <span class="checkbox fa fa-check"></span>
                                    <span class="label"> Viewable in gradebook  </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <span class="d-block mt-3 mb-3"> <strong>Average Grade Score : 64% </strong>  </span>
                </div>
            </div>
            <div class="mt-4">
                <ul class="tabs nav nav-tabs">
                    <li class="mr-0"> <a class="active" href="#"> All Students </a> </li>
                    <li class="mr-0"> <a class="" href="#"> Not Turned In ( 0 ) </a> </li>
                    <li class="mr-0"> <a class="" href="#"> Graded ( 0 ) </a> </li>
                    <li class="mr-0"> <a class="" href="#"> Turned In ( 0 ) </a> </li>
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
                <th class="text-center" style="width: 140px;"> </th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>