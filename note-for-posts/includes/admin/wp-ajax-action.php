<?php

/**
 * Ajax Post Search in the Metabox
 *
 * @see Ajax using jQuery (http://api.jquery.com/jquery.ajax)
 * @see AJAX in Plugins (https://codex.wordpress.org/AJAX_in_Plugins)
 * @since 1.0.0
 * @return void
 * 
 */

/*
 * The JavaScript for our AJAX call
 */
function n4p_footer_ajax_script() {
  wp_nonce_field('ajax_action', 'ajax_nonce_field'); // is a good practice to add nonces for HTTP Requests
?>
  <script type="text/javascript">
  
    jQuery(document).ready(function($) {
      $( '#posts-wrap .chosen-container' ).click( function(){

        // This only run the Ajax Query Once, afer removing ajaxable class
        if($( '#post-selects.ajaxable' ).length < 1){
          return;
        }

        // To get the value of an input field
        var postID = $( '#get-post-id' ).val();
        var getNonce = $('input[name="ajax_nonce_field"]').val(); 

        $.ajax({
          method: "POST",
          url: ajaxurl,
          data: { 
                'action': 'n4p_action', // Related to wp_ajax_{n4p_action}
                'postID': postID, // hidden field for post ID
                'ajaxNonceField': getNonce // hidden nonce field
          }
        })
        .done(function(res) { 

          // console.log('Ajax Success! Data: ' + res);
          // Remove class `ajaxable` and only run the ajax once
          $('#post-selects').removeClass('ajaxable'); 

          // Do not proceed if it is an empty value
          if(!res){
            console.log('No data returned!');
            console.log('Or check your `post ID` and nonce `field`');
            return;
          } 

          // Removing the current option lists and replacing it with new values    
          $("#post-selects option").remove(); 

          var data = JSON.parse(res); // Takes a well-formed JSON string

          // Handling data array
          for(var i=0; i<data.length; i++){
            var selected = data[i]['selected'] ? 'selected="selected"' : '';
            $( '#post-selects' ).append('<option '+ selected +' value="' + data[i]['ID'] + '">' + data[i]['post_title'] + '</option>');
          }
          $("#post-selects").trigger("chosen:updated"); // Chosen JS Plugin (reconstructed)
            
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
          // Error handler
          console.log( 'AJAX Fail! Status Code: ' +jqXHR.status+ '; Error Thrown:' +errorThrown );
        });
      }); 
    });
  </script>

<?php
}
add_action( 'admin_footer', 'n4p_footer_ajax_script' );

/**
 * The AJAX handler function
 * @see AJAX in Plugins (https://codex.wordpress.org/AJAX_in_Plugins)
 */
function n4p_ajax_handler() {
  $post_id = isset($_POST['postID']) ? $_POST['postID'] : ''; // To get the value from input hidden field.
  $nonce = isset($_POST['ajaxNonceField']) ? $_POST['ajaxNonceField'] : '';

  // return if there's no value
  if(!$post_id || !$nonce || ! wp_verify_nonce($nonce, 'ajax_action')){
    wp_die(); // execute die() if doesn't meet the security
  }

  $new_single = array();
  $post_type = NOTE_FOR_POSTS_PTYPE; // default: $post_type = 'post'
  
  // Get all posts array
  $args = array( 
            'post_type'        => $post_type,  // Post Type called `post`
            'numberposts'      => '-1',
            'orderby'          => 'date',
            'order'            => 'DESC',
  );
  $get_posts = get_posts($args, ARRAY_A); 

  // Add some test data here - a custom field, that is
  $meta_key='n4p_postmeta_input_key'; 
  
  // WP Posts Array Handler
  foreach ($get_posts as $single_post) {
    $is_found = false; // Boolean to check if meta value is a post ID
    
    // Only Execute if Post Meta Exist
    if( get_post_meta( $post_id, $meta_key, true ) ) {
      
      // Array handler for meta_values
      foreach ( get_post_meta( $post_id, $meta_key, false ) as $meta_value) {
        if($single_post->ID == $meta_value){
          $is_found = true;
          break; // there's no sense to find the next match
        } 
      }
    }
    $single_post->selected = $is_found ? true : false; // Adding new object property called `selected`
    $new_single[] = $single_post;
  }
  echo json_encode($new_single);
  wp_die(); // just to be safe
}
add_action( 'wp_ajax_n4p_action', 'n4p_ajax_handler' );


