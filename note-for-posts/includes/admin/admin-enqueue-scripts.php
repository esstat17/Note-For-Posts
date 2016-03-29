<?php
/**
 * Register and enqueue a stylesheets and scripts in the Frontend.
 *
 * @see WP Enqueue Scripts Docs (https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/)
 * @todo Replace only if you're creating your own Plugin
 * @todo n4p - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue a CSS in the WordPress Admin.
 */
function n4p_admin_style() {
        wp_register_style( 
          'n4p-admin-style', // ID for Enqueuing
          NOTE_FOR_POSTS_URL. 'assets/css/admin/style.css', // define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ ) )
          false, // shows at header styles
          '1.0.0' // version
        );
        wp_enqueue_style( 'n4p-admin-style' ); // Enqueuing this CSS file
}
add_action( 'admin_enqueue_scripts', 'n4p_admin_style' );

/**
 * Enqueue a JS in the WordPress Admin.
 */
function n4p_admin_script() {
    wp_register_script( 
      'n4p-admin-script', // ID for Enqueuing
      NOTE_FOR_POSTS_URL. 'assets/js/admin/script.js', // define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ ) )
      array('jquery'), // jQuery Dependency
      '1.0.0', 
      true ); // shows at the footer scripts
    wp_enqueue_script( 'n4p-admin-script' ); // Enqueuing this CSS file
}
add_action( 'admin_enqueue_scripts', 'n4p_admin_script' );

/**
 * Enqueue a Vendor JS in the WP Admin.
 * @see Choosen JS Docs at http://harvesthq.github.io/chosen/
 */
function n4p_admin_chosen_script() {
    wp_register_script( 
      'n4p-chosen-script', // ID for Enqueuing
      NOTE_FOR_POSTS_URL. 'assets/js/admin/chosen.min.js', // define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ ) )
      array('jquery'), // jQuery Dependency
      '1.5.1', // version
      true ); // shows at the footer scripts
    wp_enqueue_script( 'n4p-chosen-script' ); // Enqueuing this CSS file
}
add_action( 'admin_enqueue_scripts', 'n4p_admin_chosen_script' );

/**
 * Enqueue a vendor CSS in the WP Admin.
 */
function n4p_admin_chosen_style() {
  wp_register_style( 
     'n4p-chosen-style', // ID for Enqueuing
     NOTE_FOR_POSTS_URL. 'assets/css/admin/chosen.css', // define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ ) )
     false, // shows at header styles
     '1.5.1' // version
   );
   wp_enqueue_style( 'n4p-chosen-style' ); // Enqueuing this CSS file
}
add_action( 'admin_enqueue_scripts', 'n4p_admin_chosen_style' );


