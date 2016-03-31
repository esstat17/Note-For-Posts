<?php
/**
 * WP Submenu and Add and Update Options
 *
 * @since 1.0.0
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo note - Find all and replace text
 * @todo Note - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Sub menu hooks (unused)
 * 
 *
 * @since 1.0
 * @return void
 */

function n4p_register_submenu() {
	add_submenu_page( 
		'edit.php?post_type=note', // for tools 'tools.php', for options 'options.php'
		__( 'Note Settings', 'n4p-txt' ), // Page Title
		__( 'Settings', 'n4p-txt' ), // Menu Title
		 'manage_options', // Capability
		 'n4p-submenu-page', // Menu Slug 
		 'n4p_submenu_admin_page_callback' ); // Function
}

add_action( 'admin_menu', 'n4p_register_submenu');

/**
 * WP Options (Get, Update, and Add)
 *
 * @see Options API (https://codex.wordpress.org/Options_API)
 */
function n4p_submenu_admin_page_callback() {

	// $_POST needs to be sanitized
	if(isset($_POST['submit'])
		&& check_admin_referer('np4_option_action','n4p_option_field') // @see WP Docs for check_admin_referer()
	){

		/** Array DB $options; if emtpy assign empty string */
		$options = array(
			'n4p_option_1' => isset($_POST["n4p_option_1"]) ? $_POST["n4p_option_1"]  : "",
			'n4p_option_2' => isset($_POST['n4p_option_2']) ? $_POST['n4p_option_2']  : "",
			'n4p_option_3' => isset($_POST['n4p_option_3']) ? $_POST['n4p_option_3']  : "",
			'n4p_option_4' => isset($_POST['n4p_option_4']) ? $_POST['n4p_option_4']  : "",	
			'n4p_option_5' => isset($_POST['n4p_option_5']) ? $_POST['n4p_option_5']  : "",
			'n4p_option_6' => isset($_POST['n4p_option_6']) ? $_POST['n4p_option_6']  : "",
			'n4p_option_7' => isset($_POST['n4p_option_7']) ? $_POST['n4p_option_7']  : ""
		);

		/* Handling var Array */	
		foreach($options as $option_name => $option_value) {
			// If option name exist, update it; else add it!
			if ( get_option( $option_name ) !== false ) {
				update_option($option_name, $option_value);
			} else {	
				add_option( $option_name, $option_value, '', 'yes');
			}
		}
	}
?>	
	<div id="note-setting-page" class="wrap">
		<h1><?php _e('Note Settings', 'n4p-txt'); ?></h1>
		<span class="title"><?php _e('General Configuration Settings for Notes', 'n4p-txt'); ?></span>

		<form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>">
			<?php wp_nonce_field('np4_option_action','n4p_option_field'); ?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="n4p_option_1"><?php _e('Attached to Post Type:', 'n4p-txt'); ?></label></th>
						<td>
							<select name="n4p_option_1" class="n4p_option_1">
							<?php
								// Get Post Type List @see https://codex.wordpress.org/Function_Reference/get_post_types
								foreach ( get_post_types( '', 'names' ) as $post_type ):
									// Just Omit the Post Type `note`
									if($post_type!='note'):
							?>
   										<option value="<?php echo $post_type; ?>" <?php echo selected(get_option('n4p_option_1'), $post_type); ?>><?php echo $post_type; ?></option>
   							<?php		
   									endif;
								endforeach;
							?>
							</select>
							<?php _e('Default: <kbd>post</kbd>', 'n4p-txt'); ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="n4p_option_2"><?php _e('Placeholder for Post Search (optional)', 'n4p-txt'); ?></label></th>
						<td><input class="n4p_option_2 regular-text" name="n4p_option_2" type="text" value="<?php echo get_option('n4p_option_2'); ?>"></td>
					</tr>	
				</tbody>
			</table>
			<h2 class="title"><?php _e('Display Settings', 'n4p-txt'); ?></h2>
			<p><?php _e('You can control over the frontend display, whether to show <kbd>Title</kbd>, <kbd>Author</kbd>, <kbd>Content</kbd>, or <kbd>Date</kbd>.', 'n4p-txt'); ?></p>
			<table class="form-table">
				<tbody> 
					<tr>
						<th scope="row"><?php _e('Don\'t Display Title', 'n4p-txt'); ?></th>
						<td>
							<label for="n4p_option_3">
								<input class="n4p_option_3" name="n4p_option_3" type="checkbox" value="1" <?php checked(get_option('n4p_option_3'), 1); ?>>
							<?php _e('Remove <kbd>post_title</kbd> from the display', 'n4p-txt'); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Don\'t Display Content', 'n4p-txt'); ?></th>
						<td>
							<label for="n4p_option_4">
								<input class="n4p_option_4" name="n4p_option_4" type="checkbox" value="1" <?php checked(get_option('n4p_option_4'), 1); ?>>
							<?php _e('Remove <kbd>post_content</kbd> from the display', 'n4p-txt'); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Don\'t Display Author', 'n4p-txt'); ?></th>
						<td>
							<label for="n4p_option_5">
								<input class="n4p_option_5" name="n4p_option_5" type="checkbox" value="1" <?php checked(get_option('n4p_option_5'), 1); ?>>
							<?php _e('Remove <kbd>author</kbd> from the display', 'n4p-txt'); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php _e('Don\'t Display Date', 'n4p-txt'); ?></th>
						<td>
							<label for="n4p_option_6">
								<input class="n4p_option_6" name="n4p_option_6" type="checkbox" value="1" <?php checked(get_option('n4p_option_6'), 1); ?>>
							<?php _e('Remove <kbd>date</kbd> from the display', 'n4p-txt'); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
			<h2 class="title"><?php _e('Shortcode Features and Usage', 'n4p-txt'); ?></h2>
			<p><?php _e('Just insert into Posts or Pages :)', 'n4p-txt'); ?></p>
			<table class="form-table">
				<tbody> 
					<tr>
						<ul>
							<li><code>[n4p-sc]</code> - Display all Notes</li>
							<li><code>[n4p-sc id="ID"]</code> - Display only a particular note</li>
							<li><code>[n4p-sc max="INT"]</code> - Number of Notes per Page. Default 5</li>
							<li><code>[n4p-sc sort="ASC"]</code> - Sorted as ascending. Default to DESC</li>
							<li><code>[n4p-sc sort="ASC" max="2"]</code> - Sorted as ascending and a maximum of 2 results</li>
						</ul>
					</tr>
				
				</tbody>
			</table>
			<p class="submit"><input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes', 'n4p-txt'); ?>" /></p>
		</form>
	</div>

<?php 	
}





