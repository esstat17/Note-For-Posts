<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link Plugin Text Domain Docs (https://developer.wordpress.org/reference/functions/load_plugin_textdomain/)
 * @link How to Internationalize Your Plugin (https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/)
 * @since      1.0.0
 * @package    N4P
 * @subpackage N4P/includes
 *
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

function n4p_load_textdomain() {
    // Set filter for language directory
    $lang_dir = NOTE_FOR_POSTS_DIR . '/languages/';  // define( 'NOTE_FOR_POSTS_DIR', plugin_dir_path( __FILE__ );
    $lang_dir = apply_filters( 'n4p_lang_dir', $lang_dir );
   
   // Traditional WordPress plugin locale filter
    $locale = apply_filters( 'plugin_locale', get_locale(), 'n4p-txt' );
    $mofile = sprintf( '%1$s-%2$s.mo', 'n4p-txt', $locale );
   
   // Setup paths to current locale file
    $mofile_local   = $lang_dir . $mofile;
    $mofile_global  = WP_LANG_DIR . '/n4p-txt/' . $mofile;
   
   if( file_exists( $mofile_global ) ) {
        
        // Look in global /wp-content/languages/n4p-txt/ folder
        load_textdomain( 'n4p-txt', $mofile_global );
    } elseif( file_exists( $mofile_local ) ) {
        
        // Look in local /wp-content/plugins/n4p-txt/languages/ folder
        load_textdomain( 'n4p-txt', $mofile_local );
    } else {
        
        // Load the default language files
        load_plugin_textdomain( 'n4p-txt', false, $lang_dir );
    }
}

add_action( 'plugins_loaded', 'n4p_load_textdomain' );