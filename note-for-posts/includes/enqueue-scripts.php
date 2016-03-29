<?php
/**
 * Register and enqueue a stylesheets and scripts in the Frontend.
 *
 * @see WP Enqueue Scripts Docs (https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts)
 * @todo Replace only if you're creating your own Plugin
 * @todo n4p - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue a CSS in the WordPress Frontend.
 */
function n4p_style() {
        wp_register_style( 
          'n4p-style', // ID for Enqueuing
          NOTE_FOR_POSTS_URL. 'assets/css/style.css', // URI define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ )
          false, // shows at header styles
          '1.0.0' // version
        );
        wp_enqueue_style( 'n4p-style' ); // Enqueuing this CSS file
}
add_action( 'wp_enqueue_scripts', 'n4p_style' );

/**
 * Enqueue a JS in the WordPress Frontend.
 */
function n4p_script() {
    wp_register_script( 
      'n4p-script', // ID for Enqueuing
      NOTE_FOR_POSTS_URL. 'assets/js/script.js', // URI define( 'NOTE_FOR_POSTS_URL', plugin_dir_url( __FILE__ )
      array('jquery'), // jQuery Dependency
      '1.0.0', 
      true ); // shows at the footer scripts
    wp_enqueue_script( 'n4p-script' ); // Enqueuing this CSS file
}
add_action( 'wp_enqueue_scripts', 'n4p_script' );


