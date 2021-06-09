<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Post_Ajaxify extends \Elementor\Widget_Base {

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
		return 'e-addons-blogpost-jaxify';
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
		return __( 'E Posts Ajaxify (Not compleate )', 'E-Adons' );
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
		$post_types = e_addons_get_post_types() ;
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
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $post_types,
				'default' => 'post',
				'multiple' => false,
			]
		);
		$this->add_control(
			'tax_relation',
			[
				'label' => __( 'Taxonomy Relation', 'E-Adons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'AND' => 'AND',
					'OR' => 'OR'
				),
				'default' => 'OR',
				'multiple' => false,
			]
		);
		foreach ( $post_types as $key => $value ) {
			$taxonomy =  e_addons_get_taxonomies( $key );
			if ( ! $taxonomy[$key] ) continue;
			$this->add_control(
				'tax_type_' . $key,
				[
					'label' => __( 'Taxonomies', 'E-Adons' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'options' => $taxonomy[$key],
					'default' => [ ],
					'multiple' => true,
					'condition' => [
						'post_type' => $key
					],
				]
			);
			// error_log(print_r( $taxonomy[$key],true),3,__DIR__."/log.txt");
			foreach ( $taxonomy[$key] as $tax_key => $tax_value ) {

				$this->add_control(
					'tax_ids_' . $tax_key,
					[
						'label' => __( 'Select ', 'E-Adons' ) . $tax_value,
						'label_block' => true,
						'type' => 'dynamicterms',
						'multiple' => true,
						'sortable' => true,
						'placeholder' => 'Search ' . $tax_value,
						'dynamic_params' => [
							'term_taxonomy' => $tax_key,
							'object_type'   => 'term'
						],
						'condition' => [
							'post_type' => $key,
							'tax_type_' . $key => $tax_key
						],
					]
				);


			}

		}

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
			if( isset( $settings['post_type'] ) && !empty( $settings['post_type'] ) ){
				$post_type = $settings['post_type'];
				$tax_relation = $settings['tax_relation'];
				$posts_per_page = $settings['posts_per_page'];
				$taxonomy = $settings['tax_type_' . $post_type];
				// $pass_term = array();
				$the_args = array(
					'post_type' => $post_type,
					'posts_per_page' => $posts_per_page,
					'tax_query' => array()
				);
				$the_args['tax_query']['relation'] = $tax_relation;
				foreach ($taxonomy as $value) {
					$taxonomy_terms = $settings['tax_ids_' . $value];
						$the_args['tax_query'][] = array(
							'taxonomy' => $value,
							'terms' => $taxonomy_terms,
							'field' => 'slug',
							'operator' => 'IN',
						);
					// $pass_term[$value] = $taxonomy_terms;
				}
				$the_query = new WP_Query($the_args);
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) { $the_query->the_post();
						ob_start();
							foreach ( $taxonomy as $term) {
								$term_obj_list = get_the_terms( get_the_ID() , $term );
								if ( ! empty( $term_obj_list ) && ! is_wp_error( $term_obj_list ) ) {
									$terms_string = join(', ', wp_list_pluck( $term_obj_list, 'name') );
									?>
										<div class="term-list term-key-<?php echo $term; ?>"> <?php  echo $term .' => '. $terms_string ; ?> </div>
									<?php
								}
							}
							echo "<hr />";
						$post_terms_string = ob_get_clean();
						echo $post_terms_string ;

					}
				} else { ?>
					<div class="not-found-post"> <?php echo $settings['not_found_message']; ?> </div>
				<?php }
				wp_reset_postdata();
			}
		echo '</div>';

	}

}
