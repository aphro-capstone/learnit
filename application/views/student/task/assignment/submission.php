 
<?php  
    $subContent = json_decode($submission['submission_content'],true);
?>

<div class="submission-panel p-4">
    <div class="text-sub">
        <span class="block">Text : </span>
        <p> <?php echo $subContent['text']; ?> </p>
    </div>
    <span> Attachments : </span>
    <div class="files">
        <?php $this->load->view('shared/attachment-template',array('attachments' =>   json_decode( $subContent['attchments'],true ),'type' => 'ass_submit', 'dataID' => $submission['tsa_id']  ) ); ?>
    </div>
    </div>
</div>