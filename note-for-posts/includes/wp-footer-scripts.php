<?php
/**
 * Register Widget for Note
 * 
 * @see Widget API at https://developer.wordpress.org/reference/functions/wp_footer/
 * @since  1.0.2
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 *        
 */

function n4p_frontend_footer_scripts(){
	$plain_html = get_option('n4p_option_7', 0);
	if(empty($plain_html)):
?>

<script type="text/javascript">
  jQuery(document).ready(function($) { 
    $('.note-content').sss({
      slideShow : true, // Set to false to prevent SSS from automatically animating.
      startOn : 0, // Slide to display first. Uses array notation (0 = first slide).
      transition : 400, // Length (in milliseconds) of the fade transition.
      speed : 5500, // Slideshow speed in milliseconds.
      arrows : true // Set to false to hide navigation arrows.
    });
  })
</script>
<?php   
	endif;
}
add_action('wp_footer', 'n4p_frontend_footer_scripts');




