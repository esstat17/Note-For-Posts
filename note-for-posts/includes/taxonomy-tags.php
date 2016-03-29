<?php

/**
 * Create taxonomies for Post Type `note`.
 *
 * @see Register Taxonomy Documentation at https://codex.wordpress.org/Function_Reference/register_taxonomy
 *
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo note - Find all and replace text
 * @todo Replace `note` Post Type
 * @todo Replace `note-tag` Slug
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

function n4p_note_tag_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $post_type = 'note';
    $labels = array(
        'name'                       => _x( 'Tags', 'n4p-txt' ),
        'singular_name'              => _x( 'Tag', 'n4p-txt' ),
        'search_items'               => __( 'Search Tags', 'n4p-txt' ),
        'popular_items'              => __( 'Popular Tags', 'n4p-txt' ),
        'all_items'                  => __( 'All Tags', 'n4p-txt' ),
        'parent_item'                => __( 'Parent Tag', 'n4p-txt' ),
        'parent_item_colon'          => __( 'Parent Tag:', 'n4p-txt' ),
        'edit_item'                  => __( 'Edit Tag', 'n4p-txt' ),
        'update_item'                => __( 'Update Tag', 'n4p-txt' ),
        'add_new_item'               => __( 'Add New Tag', 'n4p-txt' ),
        'new_item_name'              => __( 'New Tag Name', 'n4p-txt' ),
        'separate_items_with_commas' => __( 'Separate note tags w/ commas', 'n4p-txt' ),
        'add_or_remove_items'        => __( 'Add or remove note tags', 'n4p-txt' ),
        'choose_from_most_used'      => __( 'Choose from the most used note tags', 'n4p-txt' ),
        'not_found'                  => __( 'No note tags found.', 'n4p-txt' ),
        'menu_name'                  => __( 'Tags', 'n4p-txt' ),
      );    

      $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'note-tag' ),
      );
 
    register_taxonomy( 'note_tag', $post_type, $args );
}
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'n4p_note_tag_taxonomies');

/**
 * Rewrite flush for Permalink
 *
 * To get permalinks to work when you activate the plugin use the following example, 
 * paying attention to how n4p_note_tag_taxonomies is called in the register_activation_hook callback:
 */
function n4p_rewrite_flush_tag() {
    n4p_note_tag_taxonomies();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'n4p_rewrite_flush_tag' );