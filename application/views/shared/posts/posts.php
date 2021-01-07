<script>
	const posts = <?= json_encode($posts);?>;
</script>

<div class="mt-2" id="posts">
	<?php
	 
	if( isset( $posts )  && !empty( $posts )):
		foreach( $posts as $post ) :
			 $this->load->view('/shared/posts/post-template',array('post' => $post));
		endforeach;
	
	else: ?>
		<div class="empty-data-div">
			<span class="m-auto"> NO POSTS TO DISPLAY </span>
		</div>	
	
	<?php endif; ?> 
</div>