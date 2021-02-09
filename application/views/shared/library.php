 
<div class="container">
    <div class="row">
        <div class="col sm-12 col-lg-3 col-md-3">
            <ul class="tabs nav nav-tabs panel-like-tabs">
                <li class="title">  <span>My Items</span></li>
                <li> <a class="active" href="#div1" data-toggle="tab">    <i class="fa fa-files-o"></i> Library  </a> </li>
                <li> <a href="#oneDriveTab" data-toggle="tab" class="has-as-icon">  <i class="as-icon onedrive"></i> Onedrive  </a> </li>
                <li> <a href="#googleDriveTab" data-toggle="tab" class="has-as-icon">  <i class="as-icon google-drive"></i> Google Drive  </a> </li>
            </ul>

            <ul class="panel-like-tabs mt-5" id="googleDrive" style="display: none;">
                <li class="title">  <span>Google Drive</span></li>
                <li class="p-3"> <button class="btn btn-primary full-width has-as-icon"> <i class="as-icon google-drive"></i>  Disconnect Account </button></li>
            </ul>

            <ul class="panel-like-tabs mt-5" id="oneDrive" style="display: none;">
                <li class="title">  <span>Google Drive</span></li>
                <li class="p-3"> <button class="btn btn-primary full-width has-as-icon"> <i class="as-icon onedrive"></i>  Disconnect Account </button></li>
            </ul>
        </div>
        <div class="col col-sm-12 col-lg-9 col-md-9 tab-content">
            <div class="tab-pane fade active show" id="div1">
                <?php $this->load->view('shared/folder-templates/folder'); ?>
            </div>
            <div class="tab-pane fade" id="oneDriveTab">
                <div class="panel panel2" id="folder-panel1">
                    <div class="panel-header d-table full-width">
                        <h3 class="pull-left">OneDrive</h3> 
                    </div>
                    <div class="panel-content pb-5">
                        <div class="text-center mt-5 mb-3">
                            <img src="<?=base_url();?>assets/images/sprite-library-onedrive.png"  style="max-width: 500px;">
                        </div>
                        <p class="m-0 text-center"> Get access to OneDrive, OneNote, Sway, and more with Office 365 </p>
                        <p class="mb-0 mt-3 text-center m"> <a href="#" class="linkOnedrive btn btn-primary" > Connect office 365 Now </a> </p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="googleDriveTab">
                <div class="panel panel2" id="folder-panel1">
                    <div class="panel-header d-table full-width">
                        <h3 class="pull-left">Google Drive</h3> 
                    </div>
                    <div class="panel-content pb-5">
                        <div class="text-center mt-3 mb-3">
                            <img src="<?=base_url();?>assets/images/google_drive_logo.png" style="max-width: 500px;">
                        </div>
                        <p class="m-0 text-center"> Access your Google Drive files in here. </p>
                        <p class="mb-0 mt-3 text-center m"> <a href="#" class="linkOnedrive btn btn-primary" > Connect to Google Drive now </a> </p>
                    </div>
                </div>
            </div>


        
        </div>
    </div>
    
</div>
 