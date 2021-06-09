<?php 
	global $post;
	$post_id = get_the_ID() ;
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
	<?php ob_start(); ?>
	<?php // print_r( $pass_term ); ?>
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
		ob_start();
			// print_r( $pass_term );
			foreach ( $pass_term as $key => $term) {
				$term_obj_list = get_the_terms( $post_id , $key );
				if ( ! empty( $term_obj_list ) && ! is_wp_error( $term_obj_list ) ) {
					$terms_string = join(', ', wp_list_pluck( $term_obj_list, 'name') );
					?>
						<div class="term-list term-key-<?php echo $key; ?>"> <?php  echo $key .' => '. $terms_string ; ?> </div>
					<?php
				}
			}
		$post_terms_string = ob_get_clean();

		$post_terms_string = apply_filters('e_addons_post_terms_string', $post_terms_string, $post, $pass_term );
		$content = $content.$post_terms_string ;
		$content = apply_filters('e_addons_post_content', $content, $post, $pass_term );
		echo $content;
	?>
</div>