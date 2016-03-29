<?php
/**
 * Dashboard to Manage Post Columns
 * 
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_$post_type_posts_columns
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Find all and replace text
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Dependency File or Function 
 * 
 * @todo function n4p_get_posts_of_a_current_note($post_id) The required file is needed
 * @todo function n4p_get_notes_of_a_current_post($post_id) Same file is required
 */

// require_once plugin_dir_path( __FILE__ ) . 'includes/admin/relational-db-query.php';

/**
 * Manage Notes Table Header <th> Columns
 * - Managing columns for 
 * @param array $columns Array of the columns
 * @return array $columns Updated Array for this post type `note`
 * @since       1.0.0
 */
function n4p_column_table_head($columns) {
    unset( $columns['author'] ); // We remove it for column positioning
    unset( $columns['date'] );
    $columns['post_ids'] = __('Post ID(s)', 'n4p-txt'); 
    $columns['shortcode'] = __('Shortcodes', 'n4p-txt'); 
    $columns['author'] = __('Noted By', 'n4p-txt');
    $columns['date'] = __('Date Published', 'n4p-txt');

	return $columns;
}
add_filter('manage_note_posts_columns' , 'n4p_column_table_head'); // manage_{$post_type}_posts_columns

/**
 * Manage Notes Table Description <td> Columns
 * @since 1.0.0
 * @param array $columns New arrays from Table Heads
 * @param array $post_id Post IDs
 * @return void
 */

function n4p_column_table_description( $columns, $post_id) {
	global $post;
	$link = "";
	$author_id = $post->post_author;
	$value = '[n4p-sc id="' . absint( $post_id ) . '"]';
	if ( get_post_type( $post_id ) == 'note' ) {	// Only execute for our new custom post type
		switch ( $columns ) {
			case 'post_ids':
				$posts_with_note =  N4P()->db->get_posts($post_id); // @todo included from relational-db-query.php
				foreach($posts_with_note as $post_note){
					$post_note_id = $post_note->ID;
					$uri = esc_url( admin_url( 'post.php?post=' . $post_note->ID . '&action=edit' ) );
					$link .=  " <span class=\"post-list post-list-{$post_note_id}\"><a href=\"{$uri}\">{$post_note_id}</a></span>,";
					
				}
				$link = rtrim($link,","); // trim the last comma (,)
				echo $link;
				break;
			case 'shortcode':
				echo '<input id="n4p-input" class="n4p-input" type="text" readonly="readonly" value="'.htmlentities($value).'">';
				break;

			case 'author':
				echo get_the_author_meta( 'display_name', $author_id );
				break;
		}
	}
}
add_action( 'manage_posts_custom_column', 'n4p_column_table_description', 10, 2 );

// Well, you can actually end here, but what if you want insert custom coloun into Post Columns?

/**
 * Manage Post Table Header <th> Columns
 * @since 1.0.0
 * @param array $columns Table Head Titles
 * @return array $columns New Table Head Values
 */
function n4p_note_column_table_head($columns){
	$defaults = array('notes' => __( 'Note ID(s)', 'n4p-txt' ) );
	$columns = array_merge($columns, $defaults);
    return $columns;
}
add_filter( 'manage_post_posts_columns', 'n4p_note_column_table_head'); // manage_${post_type}_posts_columns

/**
 * Manage Notes Table Description <td> Columns
 *
 * @since 1.0.0
 * @param array $columns New arrays from Table Heads
 * @param array $post_id Post IDs
 * @return void
 */
function n4p_note_column_table_description( $columns, $post_id ) {
	if ( get_post_type( $post_id ) == 'post') {
		$link = "";
		switch ( $columns ) {
			case 'notes':
				$notes_with_post = N4P()->db->get_notes($post_id);
				foreach($notes_with_post as $note_post){
					$note_post_id = $note_post->ID;
					$uri = esc_url( admin_url( 'post.php?post=' . $note_post_id . '&action=edit' ) );
					$link .=  " <span class=\"note-list note-list-{$note_post_id}\"><a href=\"$uri\">{$note_post_id}</a></span>,";		
				}
				$link = rtrim($link,","); // trim the last comma (,)
				echo $link;						
				break;
				}
	}
}
add_action( 'manage_posts_custom_column', 'n4p_note_column_table_description', 10, 2 );

/**
 * Registers the Sortable Columns
 *
 * @since 1.0.0
 * @param array $columns Array of the column headers
 * @return array $columns Array of sortable columns
 */
function n4p_sortable_note_columns( $columns ) {
	$columns['author'] = __('Noted By', 'n4p-txt');

	return $columns;
}
add_filter(  'manage_edit-note_sortable_columns', 'n4p_sortable_note_columns' );





