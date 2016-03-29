<?php
/**
 * Metabox Add Action
 *
 * @since 1.0.0
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register Two (2) Meta Boxes.
 * @link Add Meta Box https://developer.wordpress.org/reference/functions/add_meta_box/
 * @link Save Post https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function n4p_register_meta_boxes() {
		$post_type = 'note';
		/** Search Posts Metabox **/
		add_meta_box( 
			'n4p_normal_high', __( 'Select Post(s)', 'n4p-txt' ),  
			'n4p_display_normal_high_metabox', // Callback function
			$post_type, 
			'normal', 
			'high' 
		);
		/** Shortcode Metabox (right side) **/
		add_meta_box( 
			'n4p_side_default', __( 'Note Shorcodes', 'n4p-txt' ), 
			'n4p_display_side_default_metabox', // Callback function
			$post_type, 
			'side', 
			'default' 
		);
}
add_action( 'add_meta_boxes', 'n4p_register_meta_boxes' );

/**
 * Save Post for Metabox Best Practices
 *  
 * @since 1.0.0
 * @return void
 */

function n4p_save_meta_box($post_id){

	$meta_key='n4p_postmeta_input_key'; 

	// If post is an autosave, avoid it!
	if ( wp_is_post_autosave( $post_id || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) ) {
		return;
 	}

	// If this isn't a 'note' post type, don't update it.
	if ( get_post_type( $post_id ) != 'note' ) 
		return;
	

	// If the custom field is found, update the postmeta record
		// Also, filter the HTML just to be safe
	if ( isset( $_POST[$meta_key]  ) ) {
		update_post_meta( $post_id, $meta_key,  esc_html( $_POST[$meta_key] ) );
	}
	
	$old_postmeta = get_post_meta($post_id, $meta_key);
	$new_postmeta = isset ( $_POST[$meta_key] )  ? $_POST[$meta_key] : array();
	
	// If there's no values, delete post meta;
	if ( empty ($new_postmeta) ) {
	   // completely delete all meta values for the post
	   delete_post_meta($post_id, $meta_key);
	} else {
	  $already = array();
	  if ( ! empty($old_postmeta) ) {
	    foreach ($old_postmeta as $value) {
	      if ( ! in_array($value, $new_postmeta) ) {
	        // this value was selected, but now it isn't so delete it
	        delete_post_meta($post_id, $meta_key, $value);
	      } else {
	        // this value already saved, we can skip it from saving
	        $already[] = $value;
	      }
	    }
	  }
	  // we only need to save new values 
	  $to_save = array_diff($new_postmeta, $already);
	  if ( ! empty($to_save) ) {
	    foreach ( $to_save as $save_value ) {
	    		add_post_meta( $post_id, $meta_key, $save_value);
	    }
	  }
	}
}
add_action( 'save_post', 'n4p_save_meta_box' );



/**
 * Display Metabox on the right side
 *  - Simple example to display shortcode
 *
 * @since 1.0.0
 * @global array $post contains all posts
 * @return void
 */

function n4p_display_side_default_metabox() {
	global $post;

	$shortcode     = '[n4p-sc id="' . absint( $post->ID ) . '"]';
?>
	<p><?php _e( 'Shortcode generator that can be inserted into post or page.', 'n4p-txt' ); ?></p>
	<p><strong><?php _e( 'Note Shortcode:', 'n4p-txt' ); ?></strong></p>
	<input type="text" id="notes-sc" class="notes-sc widefat" readonly="readonly" value="<?php echo htmlentities( $shortcode ); ?>">
	<small><i><?php _e( 'Display this note into page or post', 'n4p-txt' ); ?></i></small>
	<p><strong><?php _e( 'Display All Notes:', 'n4p-txt' ); ?></strong></p>
	<p><input type="text" id="n4p-sc-all" class="edd-pt-all widefat" readonly="readonly" value="[n4p-sc]"></p>

<?php
}


/**
 * Metabox for post IDs dropdown
 *
 * @since 1.0.0
 * @param array $post Current post data
 * @return void
 */

function n4p_display_normal_high_metabox($post) {
	$options = "";
	$post_id = $post->ID; // Post ID of a curret Post Type `note`

	// Add some test data here - a custom field, that is
	$meta_key='n4p_postmeta_input_key';
	
    // you can independently call N4P_DB_Query::get_posts_v2($post_id)
    // @see Relational DB Query (includes/class-relational-db-query.php)
	$posts_with_note = N4P()->db->get_posts_v2($post_id); 
	
	// Only execute if not empty
	if ( !empty($posts_with_note) ){

		// Array handler for $selected_posts
		foreach ($posts_with_note as $selected_post) {
			
			// Concatenating to $options String
			$options .= "<option selected=\"selected\" value=\"{$selected_post->ID}\">{$selected_post->post_title}</option>";
		}
	}
?>
	<p><?php _e('Append this <b>note</b> to a particular post(s)', 'n4p-txt') ?></p>
	<input id="get-post-id" type="hidden" value="<?php echo $post_id; ?>">
	<div id="posts-wrap">
	<select id="post-selects" class="post-selects ajaxable" name="<?php echo $meta_key."[]"; ?>" multiple>
	  <?php echo $options; ?>
	</select>
	</div>

<?php
}




