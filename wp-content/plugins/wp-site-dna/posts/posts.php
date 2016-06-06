<?php

defined( 'ABSPATH' ) || die();

function install_posts ( $user_id = 1 ) {
    require_once dirname( __FILE__) . '/data.php';
    global $wpdb;
    $now = date( 'Y-m-d H:i:s' );
    $now_gmt = date( 'Y-m-d H:i:s' ); //adjust
    $posts = get_posts_data();
    if ( ! empty ( $posts ) ) foreach ( $posts as $post ) {
        if ( $post['build'] ) {
            if ( ! get_page_by_title ( $post['post_title'], OBJECT, 'post' ) ) { 
                $guid = get_option( 'home' ) . '/' . $post['post_name'];
                $wpdb->insert( $wpdb->posts, 
                    array(
                        'post_author' => $user_id, 
                        'post_date' => $now, 
                        'post_date_gmt' => $now_gmt, 
                        'post_content' => $post['post_content'],
                        'post_excerpt' => '', 
                        'post_title' => $post['post_title'], 
                        'post_name' => $post['post_name'],
                        'post_modified' => $now, 
                        'post_modified_gmt' => $now_gmt, 
                        'guid' => $guid, 
                        'post_type' => WP_POST_TYPE,
                        'comment_count' => 0, 
                        'to_ping' => '', 
                        'pinged' => '', 
                        'post_content_filtered' => '' 
                    )
                );                                
            }
        }
    } 
}
  