<?php /*
Plugin Name: Monster One Sticky
Plugin URI: https://moshikov.co/
Description: This plugin rewrite rulles save your posts. This state important for rules One Sticky Post.
Version: 1.0
Author: Vladislav Moshikov
Author URI: http://moshikov.co/
Copyright: Vladislav Moshikov
Text Domain: monster-onesticky
License: GPL3
*/


add_action( 'draft_to_publish', 'monsterOneSticky' );
add_action( 'future_to_publish', 'monsterOneSticky' );
add_action( 'new_to_publish', 'monsterOneSticky' );
add_action( 'pending_to_publish', 'monsterOneSticky' );
add_action( 'publish_to_publish', 'monsterOneSticky' );

function monsterOneSticky( $post_id ) {
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! wp_is_post_revision( $post_id ) ) {
        $post_id = $post_id->ID;
    }
    $sticky = ( isset( $_POST['sticky'] ) && $_POST['sticky'] == 'sticky' ) || is_sticky( $post_id );
    if( $sticky ) {
        $sticky_posts = array();
        $sticky_posts_list = get_option( 'sticky_posts', array() );
        $new_sticky_posts_list = array();
        foreach ($sticky_posts_list as $sticky_post) {
            $postStatus =  get_post_status ( $sticky_post );
            if ( get_post_status ( $sticky_post ) != 'publish' || $sticky_post == $post_id ) {
                array_push( $new_sticky_posts_list, $sticky_post );
            }
        }
        update_option( 'sticky_posts', $new_sticky_posts_list );
    }
}
  
?>