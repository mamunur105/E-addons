<?php global $post; ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
	<?php ob_start(); ?>
	<?php  if ( has_post_thumbnail() ) { ?>
		<div class="image-featured">
			<a href="<?php the_permalink(); ?>" class="post-overlay">
				<?php the_post_thumbnail(); ?>
			</a>
		</div>
	<?php } ?>
	<div class="post-content">
		<div class="post-meta">
			<div class="post-cats"><i class="fa fa-tag"></i><?php the_category( ', ' )?></div>
			<div class="post-time"><i class="fa fa-calendar"></i> <?php the_time(get_option('date_format')); ?></div>
		</div>
		<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title()?></a></h2>
		<div class="post-excerpt"><?php the_excerpt(); ?></div>
	</div>
	<?php $content = ob_get_clean();
		$post_id = get_the_ID() ;
		$content = apply_filters('e-addons-post-content', $content, $post );
		echo $content;
	?>
</div>