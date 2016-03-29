<?php
/**
 * Helper for Friedly HTML Output
 * 
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Find all and replace text
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Helper for Friedly HTML Output
 *
 * @since 1.0.0
 * @todo To independently call, you can use N4P_Friendly_HTML::text_slider($arr);
 */
class N4P_Friendly_HTML {

    /**
     * Friendly HTML Ouput
     *
     * @access public
     * @since 1.0.0
     * @param array $arr accepting arguments such as note title, content, author id, & index
     * @return string $output_html Notes in a Friendly HTML Output 
     *
     */
    public function text_slider($arr = array()){

        $defaults = array(
            'records_found'   => true,
            'index'           => 0,
        );
        $arr = wp_parse_args($arr, $defaults);        

          // Simplified Conditional Statement
          // get_option('option_name', 'default value') 
          // @see Get Options https://codex.wordpress.org/Function_Reference/get_option
          $disable_title = get_option('n4p_option_3', 0);
          $disable_content = get_option('n4p_option_4', 0);
          $disable_author = get_option('n4p_option_5', 0);
          $disable_date = get_option('n4p_option_6', 0);

          $output_html = '<div class="note-list note-list-'.$arr['index'].' note-text">';     

          // If display array if it has a record, otherwise show no records found.
          if($arr['records_found']){

            $author_name = get_the_author_meta('display_name', $arr['author_id'] );    
            $note_date = get_the_date(get_option('date_format', 'F j, Y'), $arr['note_id']);  // @link Get The Date https://codex.wordpress.org/Function_Reference/get_the_date
            if(empty($disable_title)){
              $output_html .= '<span class="note-title">'. $arr['note_title'] .'</span>';
            }
            if(empty($disable_content)){
              $output_html .= '<span class="note-content">'. $arr['note_content'] .'</span>';
            }
            if(empty($disable_author)){
              $output_html .= '<span class="note-author">'. $author_name .'</span>';
            }
            if(empty($disable_date)){
              $output_html .= '<span class="note-date">'. $note_date .'</span>';
            }
          } else {
            $output_html .= '<span class="note-empty">'.__( 'No related notes for this post', 'n4p-txt' ) .'</span>';
          }     

          $output_html .= '</div>';
          return $output_html;
    }

}

