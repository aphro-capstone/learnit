 

<?php 
    $images = array();
    $files = array();
    
    if( gettype( $attachments) == 'string' ) $attachments = json_decode($attachments,true);
    
    foreach($attachments as $a): 
        if(in_array( $a['type'] ,array('png','jpg','jpeg','webp','gif') )) : 
            $images[] = $a;
        else: 
            $files[] = $a;
        endif; 
    endforeach; 
 
        
?>

<div class="image-attachments image-count-<?=count($images);?>">
    <?php 
        foreach( $images as $a ): 
            $img = file_get_contents(getcwd(). '/assets/uploads/' . $a['path']  );
            $imgbase64 = 'data:image/' . $a['type'] . ';base64,' . base64_encode($img); 
    ?>
            <div class="image img-container"> <a href="<?= $imgbase64;?>" data-lightbox="example-<?php isset($postID) ? $postID : '';?>"> <img class="enlargeable-image" src="<?=$imgbase64;?>" alt=""> </a> </div>
        <?php endforeach;
    ?>
</div>

<div class="file-attachments">
    <?php foreach( $files as $a ):  ?>
            <div class="attachment-item downloadable" data-name="<?=$a['name'];?>" data-type="<?php echo isset($type) ? $type : 'post'; ?>"  data-id="<?php echo isset($dataID) ? $dataID : '';?>">
                <div class="file-type-image pull-left mr-2">
                    <div class="attachment-image image-<?= $a['type'];?>"></div>
                </div>
                <span class="text pull-left"> <?=$a['name'];?> </span>
                <span class="size pull-right"> <?=  computeAttachmentSize($a['size']) ;?> </span>
            </div>
    <?php endforeach; ?>
</div> 
