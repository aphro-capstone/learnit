

<?php if ( isset($bcrumbs)  && count($bcrumbs) > 0 ): ?>
	<ul class="breadcrumbs">
		<?php foreach ($bcrumbs as $bc): ?>
				<li>
					<?php 
						$content = '';

						$content .= isset($bc['icon']) ? '<i class="fa' . $bc['icon'] .'"></i> ' : '';
						$content .= $bc['content'];
					 ?>

					<?php if( isset($bc['link']) ): ?>
						<a href="<?=$bc['link'];?>"> <?=$content; ?> </a>
					<?php else: ?>
						<?= $content; ?>
					<?php endif; ?>
				</li>
		<?php endforeach; ?>
	</ul>	
<?php endif ?>
