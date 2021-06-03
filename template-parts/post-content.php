<?php global $post; ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
	<?php ob_start(); ?>
	<div class="image-featured">
		<a href="" class="post-overlay">
			<img src="" />
		</a>
	</div>
	<div class="post-content">
		<div class="post-meta">
			<p>
				Published on June 2, 2021 <span>in</span>
				<a href="">Development</a>
			</p>
		</div>
		<h4 class="post-title">
			<a href="">Making your WordPress website (way) faster, how do we do it?	</a>
		</h4>
		<p class="post-excerpt"> </p>
	</div>
	<?php $content = ob_get_clean();
		$post_id = get_the_ID() ;
		$content = apply_filters('e-addons-post-content', $content, $post );
		echo $content;
	?>
</div>