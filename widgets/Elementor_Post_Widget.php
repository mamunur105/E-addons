<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Post_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'e-addons-blogpost';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'E Posts', 'E-Adons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-th';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'E-addons' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$dd_post_Type = [] ;
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $args, 'objects' );
		unset( $post_types['e-landing-page'] );
		unset( $post_types['elementor_library'] );
		foreach( $post_types as $type){
			$dd_post_Type[$type->name] = $type->label;
		}
		$dd_post_Type['post'] = __('Post', 'E-Adons' );

		// $taxonomies = get_object_taxonomies( $post_types , 'objects');

		// error_log(print_r($post_types,true),3,__DIR__."/post_types.txt");
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'E-Adons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post Type', 'E-Adons' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $dd_post_Type,
				'default' => [ 'post' ],
			]
		);
		$this->add_control(
			'post_type_terms',
			[
				'label' => __( 'Terms', 'E-Adons' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [],
				'default' => [ 'post' ],
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per page', 'E-Adons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '-1',
				'min' => '-1'
			]
		);
		$this->add_control(
			'not_found_message',
			[
				'label' => __( 'Not Founs Message', 'E-Adons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);
		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		echo '<div class="e-addons-post">';
			if( isset( $settings['post_type'] ) ){
				$post_types = $settings['post_type'];
				$posts_per_page = $settings['posts_per_page'];
				$the_args = array(
					'post_type' => $post_types,
					'posts_per_page' => $posts_per_page
					// 'tax_query' => array(
					// 	array(
					// 		'taxonomy' => 'category',
					// 		'terms' => $category_slug,
					// 		'field' => 'slug',
					// 		'operator' => 'IN',
					// 	)
					// ),
					// 'meta_query' => array(
					// 	'relation' => 'OR',
					// 	array(
					// 		'key'     => 'presenters_people',
					// 		'value'   => $post->ID,
					// 		'compare' => 'LIKE'
					// 	),
					// 	array(
					// 		'key'     => 'author',
					// 		'value'   => $post->ID,
					// 		'compare' => 'LIKE'
					// 	)
					// )
				);
				// $the_args['tax_query'] = array(
				// 	array(
				// 		'taxonomy' => 'category',
				// 		'terms' => $category_slug,
				// 		'field' => 'slug',
				// 		'operator' => 'IN',
				// 	)
				// );
				$the_query = new WP_Query($the_args);
				// The Loop
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) { $the_query->the_post();
						include plugin_dir_path( __DIR__ ).'/template-parts/post-content.php';
					}
				} else { ?>
					<div class="not-found-post"> <?php echo $settings['not_found_message']; ?> </div>
				<?php }
				// Restore original Post Data
				wp_reset_postdata();
			}
		echo '</div>';

	}

}