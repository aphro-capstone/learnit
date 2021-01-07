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

<!--Add buttons to initiate auth sequence and sign out-->
<button id="authorize_button">Authorize</button>
    <button id="signout_button">Sign Out</button>

    <pre id="content" style="white-space: pre-wrap;"></pre>

    <script type="text/javascript">
      // Client ID and API key from the Developer Console
      var CLIENT_ID = '249071111208-1lt3vheuqfei4prl37dgfgse5gue75if.apps.googleusercontent.com';
      var API_KEY = 'AIzaSyBXB4ZqEyhUrl3PRhoHZwzyumwrSGj5g2E';

      // Array of API discovery doc URLs for APIs used by the quickstart
      var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/drive/v3/rest"];

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      var SCOPES = 'https://www.googleapis.com/auth/drive.metadata.readonly';

      var authorizeButton = document.getElementById('authorize_button');
      var signoutButton = document.getElementById('signout_button');

      /**
       *  On load, called to load the auth2 library and API client library.
       */
      function handleClientLoad() {
        gapi.load('client:auth2', initClient);
      }

      /**
       *  Initializes the API client library and sets up sign-in state
       *  listeners.
       */
      function initClient() {
        gapi.client.init({
          apiKey: API_KEY,
          clientId: CLIENT_ID,
          discoveryDocs: DISCOVERY_DOCS,
          scope: SCOPES
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
          authorizeButton.onclick = handleAuthClick;
          signoutButton.onclick = handleSignoutClick;
        }, function(error) {
          appendPre(JSON.stringify(error, null, 2));
        });
      }

      /**
       *  Called when the signed in status changes, to update the UI
       *  appropriately. After a sign-in, the API is called.
       */
      function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
          authorizeButton.style.display = 'none';
          signoutButton.style.display = 'block';
          listFiles();
        } else {
          authorizeButton.style.display = 'block';
          signoutButton.style.display = 'none';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
      }

      /**
       * Append a pre element to the body containing the given message
       * as its text node. Used to display the results of the API call.
       *
       * @param {string} message Text to be placed in pre element.
       */
      function appendPre(message) {
        var pre = document.getElementById('content');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
      }

      /**
       * Print files.
       */
      function listFiles() {
        gapi.client.drive.files.list({
          'pageSize': 10,
          'fields': "nextPageToken, files(id, name)"
        }).then(function(response) {
          appendPre('Files:');
          var files = response.result.files;
          if (files && files.length > 0) {
            for (var i = 0; i < files.length; i++) {
              var file = files[i];
              appendPre(file.name + ' (' + file.id + ')');
            }
          } else {
            appendPre('No files found.');
          }
        });
      }

    </script>

    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>