<?php

/**
 * Relational DB SELECT for Post and Note
 * - using WP Post Meta
 *
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Custom post type. Replace it with your custom post
 *
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Relational DB Query
 *
 * To independently use this, 
 * N4P_DB_Query::get_posts($post_id); // $post_id of a current `note` post type
 * N4P_DB_Query::get_notes($post_id) - $post_id of a current `post` post type
 *
 * @since 1.0.0
 */
class N4P_DB_Query {

	/**
	 * Relational DB SELECT to get Posts of a current Note
	 *
	 * @access public
	 * @since 1.0.0
	 * @param int $post_id Post ID of a current Post Type `note`
	 * @return array $posts_with_note Posts results of a current note
	 */
	public function get_posts($post_id){ 	

		$posts_with_note = array();
		$post_type = NOTE_FOR_POSTS_PTYPE; // default: $post_type = 'post'
		$args = array( 'post_type' => $post_type);
		$all_posts = get_posts($args); // Get WP Posts
		$post_meta_key = 'n4p_postmeta_input_key'; // @todo make sure this is a correct key	

		// Only Execute if Post Meta Exist
		if( get_post_meta( $post_id, $post_meta_key, true ) ) {
			// Array Handler
			foreach($all_posts as $single_post){	

				$single_post_id = $single_post->ID;	

				// This do the DB relation trick
				foreach( get_post_meta($post_id, $post_meta_key, false) as $meta_value )  { 
					// Let's find all posts with notes
					if($meta_value == $single_post_id ){		
						$posts_with_note[] = $single_post; // Store into array if found a match
						break; // If match found, there's no sense of continue searching
					}
				}
			}
		} 
		return $posts_with_note;
	}	

	/**
	 * Relational DB SELECT to get Posts of a current Note Version 2
	 *
	 * @access public
	 * @since 1.0.0
	 * @param int $post_id Post ID of a current Post Type `note`
	 * @return array $posts_with_note Posts results of a current note
	 */
	public function get_posts_v2($post_id){ 	

		$posts_with_note = array();
		$get_meta_values = array();

		// Add some test data here - a custom field, that is
		$meta_key='n4p_postmeta_input_key';
		$post_type = NOTE_FOR_POSTS_PTYPE; // default: $post_type = 'post'

		// Only Execute if Post Meta Exist
		if( get_post_meta( $post_id, $meta_key, true ) ) {
			
			// Array handler for meta_values
			foreach ( get_post_meta( $post_id, $meta_key, false ) as $meta_value) { // $meta_value is a post ID
					$get_meta_values[] = $meta_value; // assigning to $get_meta_values array
			}

			// Get Posts that was included in the `include` key
			$args = array( 'post_type'		=> $post_type, 
						   'numberposts'	=> '-1',
						   'orderby'        => 'date',
						   'order'          => 'DESC',
						   'include'        => $get_meta_values // Since Meta Values stores Post ID(s)
					); 
			$posts_with_note = get_posts($args); // Assigning to Var Array
		}
		return $posts_with_note;
	}	
	/**
	 * Relational DB SELECT to get Notes of a current Post (Reversed)
	 *
	 * @access public
	 * @since 1.0.0
	 * @param int $post_id Post ID of a current Post Type `post`
	 * @return array $notes_with_post Notes results of a current post
	 */
	function get_notes($post_id){ 	

		$notes_with_post = array();
		$post_type = 'note'; // @todo just aim the correct post_type
		
		$args = array( 'post_type' => $post_type); 
		$all_notes = get_posts($args); // Get All Notes Array
		$post_meta_key = 'n4p_postmeta_input_key'; // @todo make sure this is a correct key	
		
		// Notes Array Handler
		foreach($all_notes as $single_note){	
			$single_note_id = $single_note->ID;	

			// Only Execute if Post Meta Exist
			if( get_post_meta( $single_note_id, $post_meta_key, true ) ) {
			
				// This do the DB relation trick
				foreach( get_post_meta($single_note_id, $post_meta_key, false) as $meta_value )  {
					// Let's find all posts with notes
					if($meta_value == $post_id ){		
						$notes_with_post[] = $single_note; // Store into array if found a match
						break; // If match found, there's no sense of continue searching
					}
				}
			
			}
		}	
		return $notes_with_post;
	}
}


