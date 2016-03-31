<?php
/**
 * Register New Post Type
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @copyright   Copyright (c) 2016
 * @since       1.0
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Find all and replace text
 * @todo Note
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Post Type Function
 * @since       1.0.0
 * @return void
 */
function n4p_custom_post_type(){
    
    /**
     * CPT Labels
     * @since       1.0.0
    */
  $labels = array(
              'name'              => _x('Notes','n4p-txt'),
              'singular_name'     => _x('Note','n4p-txt'),
              'menu_name'         => _x('Notes','n4p-txt'),
              'name_admin_bar'    => _x('Notes', 'add notes on admin bar', 'n4p-txt' ),
              'add_new'           => _x('Add New','n4p-txt'),
              'add_new_item'      => __('Add New Note','n4p-txt'),
              'edit_item'         => __('Edit Note','n4p-txt'),
              'new_item'          => __('New Note','n4p-txt'),
              'all_items'         => __('Notes','n4p-txt'),
              'view_item'         => __('View Notes','n4p-txt'),
              'search_items'      => __('Search Notes','n4p-txt'),
              'parent_item_colon' => __('Parent Notes:','n4p-txt'),
              'not_found'         => __('No Notes found','n4p-txt'),
              'not_found_in_trash'=> __('No Notes found in Trash','n4p-txt'),       
    );
    
  /**
   * CPT Arguments
   */
  $args = array(
            'labels'              => $labels,
            'description'         => __( 'Description for Notes', 'n4p-txt' ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true, 
            // 'show_in_menu' => 'edit.php?post_type=post', // If you want to hook to an existing post type
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'note' ),
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'has_archive'         => true, 
            'hierarchical'        => false,
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-testimonial',
            'supports'            => array( 'title', 'editor', 'author')
          );
  register_post_type( 'note', $args ); // Post Type `note` reflects to the wp_posts DB Table
}

add_action( 'init', 'n4p_custom_post_type');

/**
 * Rewrite flush for Permalink
 *
 * To get permalinks to work when you activate the plugin use the following example, 
 * paying attention to how my_cpt_init is called in the register_activation_hook callback:
 */
function n4p_rewrite_flush() {
    n4p_custom_post_type();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'n4p_rewrite_flush' );

