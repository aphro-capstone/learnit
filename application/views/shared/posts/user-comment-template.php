<div class="user-comment-input">
    <div class="user-image img-container image-circular">
        <img src="<?=base_url() . getSessionData('sess_userImage');?>" alt="user-image">
    </div>
    <div class="wrapper">
        <div class="text-input" contenteditable="true" checkplaceholder placeholder="Write a comment">  </div>
        <div class="buttons">
            <a href="#" class="button-icons attachfilebutton" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Attach Image/file"> <i class="fa fa-book"></i> </a>
            <a href="#addLibrary" class="button-icons"  data-toggle="modal"> <i class="fa fa-book" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Get from Library"></i> </a>
        </div>
    </div>
</div>