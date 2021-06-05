<?php

add_action('wp_ajax_get_posts', function() {
	$posts = get_posts();
    $response = [];
    foreach($posts as $post){
        $response[] = [
            "id" => $post->ID,
			"text" => $post->post_title,
        ];
    }
    wp_send_json($response);
});

/**
 * Get a list of Taxonomy
 *
 * @return array
 */
function e_addons_get_taxonomies ( $post_type = '' ) {
    $taxonomies = array();
    if( $post_type ){
        $temp = array();
        $object_taxonomies = get_object_taxonomies( $post_type, 'objects' );
        foreach ($object_taxonomies as $key => $value) {
            $temp[$value->name] = $value->label;
        }
        $taxonomies[ $post_type ] = $temp;
    }
	return $taxonomies;
}


/**
 * Get a list of Post type
 *
 * @return array
 */
function e_addons_get_post_types () {
    $args = array(
        'public'   => true,
        '_builtin' => false
    );
    $post_types = get_post_types( $args, 'objects' );
    unset( $post_types['e-landing-page'] );
    unset( $post_types['elementor_library'] );
	$dd_post_Type = wp_list_pluck( $post_types, 'label', 'name' );
    $dd_post_Type['post'] = __('Post', 'E-Adons' );
    return $dd_post_Type;
}

/**
 * Terms List by texonomy
 */
function e_addons_get_terms_list( $taxonomy_name ){
    $term_list = array();
    $temp = array();
    $taxonomies = get_terms( array(
        'taxonomy' => $taxonomy_name,
        'hide_empty' => false
    ) );
    if ( ! empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ) {
        foreach ($taxonomies as $key => $value) {
            $temp[$value->name] = $value->name;
        }
    }
    $term_list[$taxonomy_name] = $temp;
    return $term_list;
}
