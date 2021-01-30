 
<?php  
    $subContent = json_decode($submission['submission_content'],true);
?>

<div class="tab-pane submission-panel p-4 <?= $index == $lastInd ? 'active' : '';?>" id="submission_<?php echo $index?>">
    <div class="text-sub">
        <span class="block">Text : </span>
        <p> <?php echo $subContent['text']; ?> </p>
    </div>
    <span> Attachments : </span>
    <div class="files">
        <?php $this->load->view('shared/attachment-template',array('attachments' =>   json_decode( $subContent['attchments'],true ),'type' => 'assignment'  ) ); ?>
    </div>
    </div>
</div>