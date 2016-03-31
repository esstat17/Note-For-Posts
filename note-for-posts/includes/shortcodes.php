<?php
/**
 * Shortcodes API
 * @since       1.0.0
 * @see Shortcode API https://codex.wordpress.org/Shortcode_API
 *
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo note - Find all and replace text 
 *
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Dependency File or Function 
 * 
 * @todo The required file is needed for n4p_get_posts_of_a_current_note($post_id) function
 */

// require_once plugin_dir_path( __FILE__ ) . 'includes/admin/relational-db-query.php';

/**
 * Shortcode Features and Usage
 * 
 * Just insert into Posts or Pages :)
 * [n4p-sc] - Display all Notes
 * [n4p-sc id="ID"] - Display only particular note
 * [n4p-sc max="INT"] - Number of Notes per Page. Default 5
 * [n4p-sc sort="ASC"] - Sorting. Default to DESC
 * [n4p-sc sort="ASC" max="2"] - Sorted as ascending and a maximum of 2 results
 *
 */

function n4p_shortcode_func( $atts ) {
	global $post;

	$default = array(
		'id' => '',
		'max' => '5', // post per page
		'sort' => 'DESC'
	);
	$a = shortcode_atts( $default, $atts );

	$id = absint($a['id']);
	$max = absint($a['max']);
	$sort = $a['sort'];

	$post_type = 'note';
	$friendly_html = '<div class="note-content note-in-posts">';
	$post_title = "";
	$index = 0;

	// If $id is empty, show all Notes, else only show single a single note
	if(empty($id)){
		$args = array( // can be rearranged
				'numberposts'   => $max,
				'offset'           => 0,
				'category'         => '',
				'category_name'    => '',
				'orderby'          => 'date',
				'order'            => $sort,
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => $post_type,
				'post_mime_type'   => '',
				'post_parent'      => '',
				'author'	   => '',
				'post_status'      => 'publish',
				'suppress_filters' => true 
		);
		/**
		 * @see Get Posts https://developer.wordpress.org/reference/functions/get_posts/
		 */ 
		$get_notes = get_posts($args, ARRAY_A); // Accepts OBJECT, ARRAY_A, or ARRAY_N

		foreach ($get_notes as $note) {
			$index++;
			$arr = array(
              'index'         => $index,
              'note_id'       => $note->ID,
              'note_title'    => $note->post_title,
              'note_content'  => $note->post_content,
              'author_id'     => $note->post_author
            );
            $friendly_html .= N4P()->html->text_slider($arr); // @see includes/class-friendly-html.php
			
		}

	} else {
		 
		 // Only display `note` Post Type 
		if( get_post_type($id) == $post_type ){
 			$single_note = get_post ($id, ARRAY_A); // Accepts OBJECT, ARRAY_A, or ARRAY_N
			$arr = array(
			  'note_id'       => $single_note['ID'],
              'note_title'    => $single_note['post_title'],
              'note_content'  => $single_note['post_content'],
              'author_id'     => $single_note['post_author']
            );
            $friendly_html .= N4P()->html->text_slider($arr); 	
 		}
 	}
 	$friendly_html .=  '</div>';
	return $friendly_html;
}
add_shortcode( 'n4p-sc', 'n4p_shortcode_func' );
