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

/*
 * The JavaScript for our AJAX call
 */
function n4p_admin_footer_choosen() {

  // Simplified Conditional Statement
  $placeholder = !get_option('n4p_option_2') ? __('Type and Search for Post(s)', 'n4p-txt') : get_option('n4p_option_2');
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("#post-selects").attr("data-placeholder", "<?php echo $placeholder; ?>").chosen({width: "50%"});
    });
  </script>
  <?php
}
add_action( 'admin_footer', 'n4p_admin_footer_choosen' );

