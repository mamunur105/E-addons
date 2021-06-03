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