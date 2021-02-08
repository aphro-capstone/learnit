
<div class="modal fade" id="prompboxnormal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  </div>
      <div class="modal-footer" style="border-top: none;">
        <div class="additionalButtons d-table full-width"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  </div>
      <div class="modal-footer" style="border-top: none;">
      </div>
    </div>
  </div>
</div>






<?php if( isset($modals) &&  in_array('attachlinkModal', $modals) ): ?>
  <div class="modal fade" id="attachlink" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Attach a link</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group input-group-icon left-icon mb-2">
            <input type="text" name="attachlink"  class="form-control" placeholder="http://">  
            <i class="fa fa-link icon"></i>
          </div>
          <div class="form-group">
            <input type="text" name="attachtitle"  class="form-control" placeholder="Title">  
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary"> Attach</button>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>

<?php if( isset($modals) &&  in_array('addLibraryModal', $modals) ): ?>
  <div class="modal fade" id="addLibrary" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xlg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Add file from the library</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <?php $this->load->view('shared/library'); ?>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary"> Attach</button>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>





<?php if( isset($modals) &&  in_array('foldermanageModal', $modals) ): ?>
  <div class="modal fade" id="folderManage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Share folders with this Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-table full-width">
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#Addfolder"> <i class="fa fa-plus"></i> Add Folder  </button>
          </div>
          <div class="folder-container">
            <div class="folder-details">
              <i class="fa fa-folder"></i> Library
            </div>
            <div class="sub-folders">
              <div class="folder-container">
                <div class="folder-details selected">
                  <i class="fa fa-folder"></i> My Quizzes
                </div>
                <div class="sub-folders">
                  <div class="folder-container selected">
                    <div class="folder-details selected">
                      <i class="fa fa-folder"></i> Quiz Subfolder
                    </div>
                  </div>
                </div>
              </div>
              <div class="folder-container">
                <div class="folder-details selected">
                  <i class="fa fa-folder"></i> My Assignments
                </div>
                <div class="sub-folders">
                  <div class="folder-container ">
                    <div class="folder-details">
                      <i class="fa fa-folder"></i> Assignment Subfolder
                    </div>
                  </div>
                  <div class="folder-container">
                    <div class="folder-details selected">
                      <i class="fa fa-folder"></i> Assignment Subfolder 2
                    </div>
                    <div class="sub-folders">
                      <div class="folder-container">
                        <div class="folder-details">
                          <i class="fa fa-folder"></i> Assignment Sub subfolder
                        </div>
                      </div>
                      <div class="folder-container">
                        <div class="folder-details">
                          <i class="fa fa-folder"></i> Assignment Sub subfolder2
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="folder-container">
                <div class="folder-details selected">
                  <i class="fa fa-folder"></i> Extra Folder 
                </div> 
              </div>
            </div>
            
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary"> Done</button>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>

 
<?php if( isset($modals) &&  in_array('addFolderModal', $modals) ): ?>
  <div class="modal fade" id="Addfolder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Add Folder</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" name="foldername"  class="form-control" placeholder="Title">  
          </div> 
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary btnaddfolder"> Add</button>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>

<?php if( isset($modals) &&  in_array('joinClassModal', $modals) ): ?>
  <div class="modal fade" id="joinClass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Join a class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body  scantoggle-container">
          <div class="row code-container">
            <div class="col-xs-8  col-md-9 col-lg-9 col pr-1">
              <div class="form-group mb-0">
                  <input type="text" class="form-control" name="qrCodetext" placeholder="Class Code" required="">
                </div>
            </div>
            <div class="col-xs-4 col-md-3 col-lg-3 col pl-1">
              <a href="#" class="full-width btn btn-primary toggleQRCodeScanner" id="scanQRCodebtn"><i class="fa fa-qrcode"></i> Scan</a>
            </div>
          </div>

          <div class="scanner-container" id="qrCodeScanner" style="display: none;">
              <div class="video">
                <video id="preview" autoplay="autoplay" class="inactive"></video> 
              </div>
              <div class="d-table full-width  mb-5">
                <div class="btn-group btn-group-toggle pull-left" data-toggle="buttons">
                  <label class="btn btn-primary active">
                    <input type="radio" name="options" value="1" autocomplete="off" checked=""> Front Camera
                  </label>
                  <label class="btn btn-secondary">
                    <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                  </label>

                </div>
                <a href="#" class="btn btn-danger pull-right toggleQRCodeScanner"> Cancel Scan </a>
              </div>
              
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Close</button>
          <button class="btn btn-primary joinClassButton"> Join Class </button>
        </div>
      </div>
    </div>
  </div>
<?php endif;?>

<?php if( isset($modals) &&  in_array('gradebookModals', $modals) ): ?>
  <div class="modal fade" id="createGradebook" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Add Grade Collumn</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group"> <input type="text" name="name"  class="form-control" placeholder="Column Title"> </div>
          <div class="form-group"> <input type="text" name="default-over"  class="form-control" placeholder="Enter Default Over"> </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Close</button>
          <button class="btn btn-primary createGradebookBtn"> Add Grade </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="gradingPeriodModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <form action="" method="post" id="gradingperiod">
          <div class="modal-header" style="border-bottom: none;">
            <h5 class="modal-title">New Grading Period</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group"> <input type="text" name=""  class="form-control" placeholder="Period Name"> </div>
          </div>
          <div class="modal-footer" style="border-top: none;">
            <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Close</button>
            <button class="btn btn-primary"> Add Grade </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif;?>


<?php if( isset($modals) &&  in_array('assignModals', $modals) ): ?>
  <div class="modal fade" id="assignmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assignment Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body file-input-container-wrapper">
          <div class="form-group">
          <input type="text" class="form-control" name="title" placeholder="Assignment Title">
          </div>
          <div class="form-group">
            <textarea class="form-control" name="instruction" placeholder="Assignment Intruction"></textarea>
          </div>
          <div class="form-group d-flex">
            <label for="exampleInputEmail1">Attachments</label>
            <div class="buttons d-flex attachment-buttons ml-3">
              <span class="clickable-content attachfilebutton" data-toggle="tooltip" data-placement="bottom" data-original-title="Attach Files" > <i class="fa fa-paperclip"></i> </span>
              <span class="clickable-content" data-toggle="tooltip" data-placement="bottom" data-original-title="Attach Link" > <i class="fa fa-link"></i> </span>
              <span class="clickable-content" data-toggle="tooltip" data-placement="bottom" data-original-title="Add from library" > <i class="fa fa-book"></i> </span>
            </div>
          </div>
          <div class="file-input-container small-img-attachments">
            <div class="images"></div>
            <div class="files"></div>
           
          </div>
         
          <hr>
          <div class="form-group"> 
            <label for="exampleInputEmail1">Assign to : </label>
            <select class="form-control selectpicker btn-primary" title="Please Select" multiple name="assignIds">
              <optgroup label="Classes">
                
                <?php foreach( $classesInfo as $class) :  ?>
                  <?php if(isset($TE)): 
                    $isSelected = false;  
                    foreach( $assignees as $assignee ):
                      if( $assignee['class_id'] == $class['class_id'] ){
                        $isSelected = true;
                        break;
                      } 
                    endforeach;
                  ?>
                    <option value="<?=$class['class_id'];?>" <?= $isSelected ? 'selected' :'';?>><?=$class['class_name'];?></option> 
                  <?php else: ?>
                    <option value="<?=$class['class_id'];?>" <?= $classinfo['class_id'] == $class['class_id'] ? 'selected' : ''; ?>  ><?=$class['class_name'];?></option> 
                  <?php endif; ?>
                 
                <?php endforeach;?>
              </optgroup>  
            </select>
          </div>
          <div class="form-group">
            <label>Due </label>
            <div class="d-flex">
              <div class="input-group-icon left-icon mr-3">
                <i class="icon fa fa-calendar"></i>
                <input type="text" class="datepicker form-control">
              </div> 
              <select name="time_h" class="mr-1 form-control w-auto">
                <?php  for($i = 1; $i < 13; $i++) : ?>
                  <option value="<?=$i;?>" <?= $i == 11 ? 'selected' : ''; ?>  ><?=$i;?></option>
                <?php endfor;?>
              </select>
              <span class="mr-1 mt-auto mb-auto" style="font-weight:bold"> : </span> 
              <select name="time_m" class="mr-1 form-control w-auto">
                <?php  for($i = 1; $i < 60; $i++) : ?>
                  <option value="<?=$i;?>" <?= $i == 59 ? 'selected' : ''; ?>><?=$i;?></option>
                <?php endfor;?>
              </select>
              <select name="time_a" class="form-control w-auto">
                <option value="am">AM</option> 
                <option value="pm" selected>PM</option> 
              </select>
            </div>
          </div>  
        <div class="form-group">
          <div class="custom-checkbox ml-3">
            <input type="checkbox" name="islockondue">
            <span class="checkbox fa fa-check"></span>
            <span class="label"> Lock on Due  </span>
          </div>
        </div>
          <hr>
          <div class="form-group">
              <label for="exampleInputEmail1">Other option  </label>
              <div class="custom-checkbox mb-2 ml-3 other-option-div">
                  <input type="checkbox" name="isaddtogradebook">
                  <span class="checkbox  fa fa-check"></span>
                  <span class="label"> Automatically add to Gradebook ( Current Period ) </span>
              </div> 
            </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary createAssignment" style="background: <?= !isset($TE) ? $classinfo['color'] : ''; ?>"><?= isset($TE) ? 'Update Assignment' : 'Create Assignment'; ?> </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="loadAssignment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Assignments</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group input-search mb-2">
            <input type="text" name="title"  class="form-control" placeholder="Assignment Title">  
            <i class="fa fa-search"></i>
          </div>
          <div id="assignment-list">
            <div class="result"> 2 results found ::</div>
            <div class="assignment-item radioboxinput-container">
              <div class="d-flex">
                <div class="radioboxinput checked mr-2">
                  <div class="frontend"></div>
                  <input type="radio" name="ass">
                </div>  
              </div>
              <div class="text">
                <span class="assignment-title d-block">Sample Assignment 1</span>
                <span class="assignment-creationdate">( Created on ::  01/01/2020 ) </span>
              </div>
            </div>
            <div class="assignment-item radioboxinput-container">
              <div class="d-flex">
                <div class="radioboxinput mr-2">
                  <div class="frontend"></div>
                  <input type="radio" name="ass">
                </div>  
              </div>
              
              <div class="text">
                <span class="assignment-title d-block">Sample assignment 2</span>
                <span class="assignment-creationdate">( Created on ::  01/01/2020 ) </span>
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
          <button type="button" class="btn btn-primary changeable-color"> Load Assignment </button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>


<?php if( isset($modals) &&  in_array('quizModals', $modals) ): ?>

  <div class="modal fade" id="submitQuiz" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Assign Quiz </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Assign to : </label>
          <select class="form-control selectpicker btn-primary" title="Please Select" multiple name="assignIds">
            <optgroup label="Classes">
              <?php foreach( $classList as $class) :
                    $isSelected = false;
                    if(  isset( $TE)  ):
                      foreach( $assignees as $aa ){
                        if( $aa['class_id'] == $class['class_id'] ){
                          $isSelected = true;
                          break;
                        } 
                      }
                    endif;  
              ?>
                <option value="<?=$class['class_id'];?>" <?= $isSelected ? 'selected' : ''; ?>><?=$class['class_name'];?></option> 
              <?php endforeach;?>
            </optgroup>  
          </select>
        </div>
        <div class="form-group duedate-fg" >
            <label>Due </label>
            <div class="d-flex">
              <div class="input-group-icon left-icon mr-3">
                <i class="icon fa fa-calendar"></i>
                <input type="text" class="datepicker form-control">
              </div> 
              <select name="time_h" class="mr-1 form-control w-auto">
                <?php  for($i = 1; $i < 13; $i++) : ?>
                  <option value="<?=$i;?>" <?= $i == 11 ? 'selected' : ''; ?>  ><?=$i;?></option>
                <?php endfor;?>
              </select>
              <span class="mr-1 mt-auto mb-auto" style="font-weight:bold"> : </span> 
              <select name="time_m" class="mr-1 form-control w-auto">
                <?php  for($i = 1; $i < 60; $i++) : ?>
                  <option value="<?=$i;?>" <?= $i == 59 ? 'selected' : ''; ?>><?=$i;?></option>
                <?php endfor;?>
              </select>
              <select name="time_a" class="form-control w-auto">
                <option value="am">AM</option> 
                <option value="pm" selected>PM</option> 
              </select>
            </div>
          </div>  
        <div class="form-group">
          <div class="custom-checkbox ml-3">
            <input type="checkbox" name="islockondue">
            <span class="checkbox fa fa-check"></span>
            <span class="label"> Lock on Due  </span>
          </div>
        </div> 
        <div class="form-group d-flex">

          <label for="" class="strong mr-1 mt-auto	"> Duration :  </label>
          <input type="number" value="60" name="duration" class="form-control form-control mr-2 ml-0" style="width:100px">
          <span class="mt-auto mb-auto"> Minutes</span>
        </div> 
        <hr>
        <div class="form-group">
              <label for="exampleInputEmail1">Other option  </label>
              <!-- <div class="custom-checkbox mb-2 ml-3 other-option-div">
                <input type="checkbox" name="israndomize" >
                <span class="checkbox  fa fa-check"></span>
                <span class="label"> Randomize Questions </span>
          </div> -->
          <div class="custom-checkbox mb-2 ml-3 other-option-div">
                <input type="checkbox" name="isaddtogradebook">
                <span class="checkbox  fa fa-check"></span>
                <span class="label"> Automatically add to Gradebook ( Current Period ) </span>
          </div>
          <div class="custom-checkbox ml-3 other-option-div">
                <input type="checkbox" name="ishowresult">
                <span class="checkbox  fa fa-check"></span>
                <span class="label"> Show results to students after taking test.</span>
              </div>
            </div>

        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> close</button> 
          <a class="btn btn-primary submitQuiz" href="#">  Save </a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="taskInstruction" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> <i class="fa fa-tasks text-primary"></i> <span class="title"></span>    </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">  <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <div class="intro">
              <div class="d-flex">
                  
                <a class="mr-2" href="<?= getSiteLink('classes/class-19'); ?>"> <i class="fa fa-link"></i>  <span class="assigned-classes">Test class </span> </a>  
                 |<span class="ml-2"><i class="fa fa-clock-o"></i></span> <span class="due-date ml-1">Due : May 1, 2020</span> 
              </div>

                <p class="quiz-info"> <span class="question-count"> 30 </span> Questions  |  <span class="total-points"> 60</span> Points  | <span class="duration">60</span> minutes 
                 <?php if(getRole() == 'student') { ?><span class="pull-right hasTaken"><strong> Submitted </strong> </span><?php }?> </p>
          </div>
          <hr>
          <p class="instructions">
              Midterm Exam - Part 1<br />
              <br />
                1. 2 points per questions<br />
                2. You have only 60 minutes to finish the part 1 of this exam.<br />
                3. You can take any time untul May 31, 2020. But once you take it, you need to finish it within one seating and please be mindful of the time limit.<br />
                4. Correct answers will be shown once all students have taken the exam.
          </p>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Close</button>
          <?php if( getRole() == 'student' ):?>
              <a class="btn btn-primary quiz-info view-quiz-result-student" href="#"> View Result</a>
              <a class="btn btn-primary ass-info view-assignment-student" href="#"> View Assignment</a>
              <a class="btn btn-primary quiz-info take-quiz-student" href="#">  Take Quiz </a>
          <?php else:?>
              <a class="btn btn-primary quiz-info view-quiz-teacher" href="#"> View Quiz</a>
              <a class="btn btn-primary ass-info view-quiz-teacher" href="#"> View Assignment</a>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="quizAnswers" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Student Quiz Answers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div class="answer-list">
                  <div class="answer-item answer-correct">
                    <p> <strong>Question #1 :</strong> This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka</p>
                    <p class="mb-0"> <strong>Correct Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                    <p class="mb-0"> <strong>Student's Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                  </div>
                  <div class="answer-item answer-correct">
                    <p> <strong>Question #2 :</strong> This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka</p>
                    <p class="mb-0"> <strong>Correct Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                    <p class="mb-0"> <strong>Student's Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                  </div>
                  <div class="answer-item answer-wrong">
                    <p> <strong>Question #3 :</strong> This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka</p>
                    <p class="mb-0"> <strong>Correct Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                    <p class="mb-0"> <strong>Student's Answer :</strong> <span class="answer"> B. Test wrong answer</span>  </p>
                  </div>
                  <div class="answer-item answer-correct">
                    <p> <strong>Question #4 :</strong> This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka</p>
                    <p class="mb-0"> <strong>Correct Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                    <p class="mb-0"> <strong>Student's Answer :</strong> <span class="answer"> A. Test answer</span>  </p>
                  </div>
                  <div class="answer-item answer-wrong">
                    <p> <strong>Question #5 :</strong> This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka. This is a sample quiz question : Lorem ipsum dolor wakaka</p>
                    <p class="mb-0"> <strong>Correct Answer :</strong> <span class="answer"> TRUE</span>  </p>
                    <p class="mb-0"> <strong>Student's Answer :</strong> <span class="answer"> FALSE</span>  </p>
                  </div>
              </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Close</button>
          <?php if ( getRole() == 'teacher'): ?>
              <button class="btn btn-primary"> Add Grade </button>
          <?php endif ?>

        </div>
      </div>
    </div>
  </div> 

  
  <div class="modal fade" id="imageenlargeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content"> 
         <img src="" alt="">
      </div>
    </div>
  </div> 
<?php endif;?>




<?php if( isset($modals) &&  in_array('codemodal', $modals) ): ?>
  <div class="modal fade" id="codeModal" >
      <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;">
              <h5 class="modal-title">Invite people to <?= $classinfo['class_name'];?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="tabs-container">
                  <ul class="tabs nav nav-tabs tabs-horizontal no-style m-0">
                    <li> <a href="#" class="active" data-toggle="tab" data-target="#share-code"> Share Class Code  </a>  <span class="bottom-border changeable-color" > </span> </li>
                    <li> <a href="#" class="" data-toggle="tab" data-target="#share-email"> Invite by email  </a> <span class="bottom-border changeable-color" > </span></li>
                  </ul>
                  <hr>
                  <div class="tabs-content">
                    <div class="tab  fade active show" id="share-code">
                        <h6 class="title">Share Class Code with students or other teachers </h6>
                        <div class="border p-2 mt-4">
                            <div class="top text-center">
                                <?php if( $classinfo['code_status'] ==  1 ): ?>
                                  <button class="btn btn-xs btn-primary lock-btn"> <i class="fa fa-lock"></i>  Lock Code  </button>
                                <?php else: ?>
                                  <button class="btn btn-xs btn-warning lock-btn"> <i class="fa fa-unlock"></i>  UnLock Code  </button>
                                <?php endif; ?>
                                | 
                                <button class="btn btn-xs btn-primary code-btn" data-code="<?=$classinfo['class_code']; ?>"> <i class="fa fa-qrcode"></i>  QRCode </button>
                                <span class="resetCode pull-right clickable-content "> 
                                    <i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" data-title="Reset Code"></i>
                                </span> 
                            </div>
                            <div class="code-wrapper p-4">
                                <div class="code mt-2 mb-2 ml-auto mr-auto position-relative text-center" >
                                  <span class="code-div input p-2" id="code-div"> <?=$classinfo['class_code']; ?> 
                                      <i class="copyIcon fa fa-copy clickable-content copycode" data-toggle="tooltip" data-placement="top" data-title="Copy"></i>
                                  </span>
                                </div>
                                <div class="qrcode">
                                    <div id="qrcode" class="d-flex qrcodediv" data-code-color="<?=$classinfo['color']; ?>" data-code-text-color="<?=$classinfo['tcolor']?>"></div>
                                </div>
                            </div>
                            
                            <div class="message-wrapper message-warning message-unlock <?php echo $classinfo['code_status'] ==  1 ? 'show' : ''; ?> ">
                                <div class="icon-wrapper"> <i class="fa fa-info-circle m-auto"></i></div>
                                <div class="text-wrapper pl-3 pr-3 pt-2 pb-2">
                                    <p class="m-0">Unlocked class codes will allow anyone to instantly join, so <strong>don't share this code in unsecure public places</strong>.</p>
                                </div>
                            </div>
                            <div class="message-wrapper message-info message-lock <?php echo $classinfo['code_status'] ==  0 ? 'show' : '';?>">
                                <div class="icon-wrapper"> <i class="fa fa-info-circle m-auto"></i></div>
                                <div class="text-wrapper pl-3 pr-3 pt-2 pb-2">
                                    <p class="m-0">Students or other teachers may use a LOCKED Class Code to request access to a Class. You can accept their join request in the Members tab..</p>
                                </div>
                            </div>
                      </div>
                    </div>




                    <div class="tab fade " id="share-pdf">
                      <h6 class="title">Share PDF Instructions with students or other teachers </h6>
                      <p class="mt-3">This PDF includes step-by-step instructions on how students and parents can join this Class and get connected.</p>
                      <button class="btn btn-primary full-width mt-4">  View PDF Instruction  </button>
                    </div>
                    <div class="tab fade " id="share-email">
                      <h6 class="title">Invite students or teachers to join Edmodo by sending them an email.</h6>
                      <p>They'll receive instructions on how to join asd.</p>

                      <div class="form-group mt-5 position-relative input-search">
                        <input type="text" name=""  class="form-control" placeholder="Type email or name">  
                        <i class="fa fa-search"></i>
                      </div>
                      
                    </div>
                  </div>  
              </div>
            </div>
            
            <div class="modal-footer" style="border-top: none;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary changeable-color" data-dismiss="modal" >Done</button>
            </div>
          </div>
      </div>
  </div>

<?php endif; ?>


<?php if(isset($classinfo)):  ?>
  <div class="modal fade" id="classUpdate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Advance Settings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Class name" name="class_name">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Class Abbreviation(Optional)" name="abbr">
          </div>
          <div class="form-group">
            <select class=""></select>
          </div>  
          <div class="form-group">
            <select name="grades"></select>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          
          <button type="button" class="btn btn-primary changeable-color" data-dismiss="modal" >Done</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="create-small-group" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Create Small Group</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group input-group-icon left-icon mb-2">
            <input type="text" class="form-control" placeholder="Small Group Name">  
          </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary"> Create</button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="modal fade" id="gamesinte" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xlg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div id="game-container"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="multimedia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xlg" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div id="multimedia-container"> </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="setGrade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h5 class="modal-title">Grade Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex">
            <div class="form-group input-group-icon left-icon mb-0">
              <input type="text" class="form-control text-center " name="score" placeholder="Enter Grade">  
            </div>
            <span class="no-wrap ml-2 mr-2 mt-auto mb-auto"> out of </span>
            <div class="form-group input-group-icon left-icon mb-0">
              <input type="text" class="form-control text-center" name="over" placeholder="Over">  
            </div>
        </div>
        
      </div>
      <div class="modal-footer" style="border-top: none;">
        <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
        <button class="btn btn-primary" id="setGradebtn">Set Grade</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="uploadLibraryFiles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <h5 class="modal-title">Upload files to library</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="drop-item-box custom_drag-drop" id="drop-item-box">
                <div class="dz-message placeholder" data-dz-message="">
                  <span class="jumbo-text font-bold faded"> No submitted item. </span>
                  <span class="d-block"> Drop your files/attachments in here or  </span>
                </div>
              </div>
        </div>
        <div class="modal-footer" style="border-top: none;">
          <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
          <button class="btn btn-primary" id="uploadFileslibrary">Upload Files</button>
        </div>
      </div>
    </div>
  </div>


<div class="modal fade" id="libraryfoldershareupload" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <h5 class="modal-title">Share folder to class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer" style="border-top: none;">
        <button class="btn btn-default" data-dismiss="modal" aria-label="close"> Cancel</button>
        <button class="btn btn-primary" id="sharefolderlib">Share Folder</button>
      </div>
    </div>
  </div>
</div>
