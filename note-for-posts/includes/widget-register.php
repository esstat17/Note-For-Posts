<?php
/**
 * Register Widget for Note
 * 
 * @see Widget API at https://codex.wordpress.org/Widgets_API
 * @todo Replace only if your creating your own Plugin
 * @todo n4p - Find all and replace text
 * @todo N4P - Find all and replace text
 * @todo note - Find all and replace text
 *        
 */
/**
 * Independencies
 */
// require_onnce plugin_dir_path( __FILE__ ) . 'includes/class-relational-db-query.php';
// require_onnce plugin_dir_path( __FILE__ ) . 'includes/class-friedly.html.php';

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Friendly HTML Ouput in the Widget
 * to display post type note
 *
 * @param array $arr accepting arguments such as note title, content, author id, & index
 * @return void
 *
 */

class N4P_Widget_Ext extends WP_Widget {
  /**
   * Constructs the new widget.
   *
   * @see WP_Widget::__construct()
   */
  public function __construct() {
    parent::__construct(
      'n4p_widget_options', // Base ID
      __("Note(s) for this Post", 'n4p-txt'),
      array( 
        'classname' => 'note_widget_options', 
        'description' => __( "Display Notes in the Sidebar", 'n4p-txt' ) 
      ),
      array() // you can pass width/height values here.
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
   * @param array $instance Saved values from database.
   */
  public function widget ( $args, $instance ) {
    global $post;

    // Get widget field values
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $widget_title = empty($title) ? $args["widget_name"] : $title; 

    // Start sample widget body creation with output code (get arguments from options and output something)
    $friendly_html =  '<div id="note-content" class="note-content note-widget">';
    $index = 0;
    $notes = array(); // variable init for array

    // Get related notes for a current post; 
    // if it is a single post, get associated notes; else display all notes
    if(is_single()){
    

        // you can independently call N4P_DB_Query::get_notes($post->ID)
        // @see Relational DB Query (includes/class-relational-db-query.php)
        $notes = N4P()->db->get_notes($post->ID);

        // if it has a value, get the associated notes; else no records found
        if( !empty($notes) ){
          foreach ($notes as $note) {
            $index++;
            $arr = array(
              'index'         => $index,
              'note_id'       => $note->ID,
              'note_title'    => $note->post_title,
              'note_content'  => $note->post_content,
              'author_id'     => $post->post_author
            );

            // you can also independently call, use N4P_Friendly_HTML::text_slider($arr);
            // see HTML Helper (includes/class-friedly.html.php)
            $friendly_html .= N4P()->html->text_slider($arr);
          }
        } else {
          $friendly_html .= N4P()->html->text_slider(array('records_found' => false)); 

        }
      
    } else {
        $max = $instance['max_results'];
        $sort = $instance['sort_dropdown'];
        $post_type = 'note';

        /**
         * @see Get Posts https://developer.wordpress.org/reference/functions/get_posts/
         */ 
        $settings = array( 
          'numberposts'   => $max,
          'offset'           => 0,
          'category'         => '',
          'category_name'    => '',
          'orderby'          => 'date',
          'order'            => $sort,
          'include'          => '',
          'exclude'          => '',
          'meta_key'         => '',
          'meta_value'       => '',
          'post_type'        => $post_type,
          'post_mime_type'   => '',
          'post_parent'      => '',
          'author'     => '',
          'post_status'      => 'publish',
          'suppress_filters' => true 
        );
        $notes = get_posts($settings, ARRAY_A); // Accepts OBJECT, ARRAY_A, or ARRAY_N
       
          foreach ($notes as $note) {
            $index++;
            $arr = array(
              'index'         => $index,
              'note_id'       => $note->ID,
              'note_title'    => $note->post_title,
              'note_content'  => $note->post_content,
              'author_id'     => $note->post_author
            );
            $friendly_html .= N4P()->html->text_slider($arr);
          }
     
    }   
    $friendly_html .= '</div>';   

    // End sample widget body creation
    if ( !empty( $friendly_html ) ) {
      echo $args['before_widget'];
      if ( $widget_title ) {
        echo $args['before_title'] . $widget_title . $args['after_title'];
      }
      echo $friendly_html; // This displays our HTML output with DB data
      echo $args['after_widget'];
    }
  } 
  
  /**
   * Updates the new instance when widget is updated in admin
   *
   * @return array $instance new instance after update
   */
  public function update ( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      $instance['max_results'] = ( !empty( $new_instance['max_results'] ) ) ? strip_tags( $new_instance['max_results'] ) : '';
      $instance['sort_dropdown'] = $new_instance['sort_dropdown'];
      
      return $instance;
  }
  
  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form ( $instance ) {
      $defaults = array(
          'title' => '',
          'max_results' => '5',
          'sort_dropdown' => '',
      );
        $instance =  wp_parse_args( $instance, $defaults );
        $title = esc_attr( $instance[ 'title' ] );
        $max_results = esc_attr( $instance[ 'max_results' ] );
        $sort_dropdown = esc_attr( $instance[ 'sort_dropdown' ] );
?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( "Title:", 'n4p-txt'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('max_results'); ?>"><?php _e( "Max Results:", 'n4p-txt'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('max_results'); ?>" name="<?php echo $this->get_field_name('max_results'); ?>" type="text" value="<?php echo $max_results; ?>" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('sort_dropdown'); ?>"><?php _e( "Sort:", 'n4p-txt' ); ?></label>
        <select name="<?php echo $this->get_field_name('sort_dropdown'); ?>" id="<?php echo $this->get_field_id('sort_dropdown'); ?>" class="widefat">
          <option value="asc"<?php selected( $instance['sort_dropdown'], 'asc' ); ?>><?php _e( "ASC", 'n4p-txt' ); ?></option>
          <option value="desc"<?php selected( $instance['sort_dropdown'], 'desc' ); ?>><?php _e( "DESC", 'n4p-txt' ); ?></option>
        </select>
      </p>
<?php
  }
}

/**
 * Register the new widget.
 *
 * @see 'widgets_init'
 */
function n4p_register_widgets() {
  register_widget('N4P_Widget_Ext');
}


// Add a sample widget
add_action( 'widgets_init', 'n4p_register_widgets' );


