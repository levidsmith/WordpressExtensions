<?php
/*
Plugin Name: Game Index for levidsmith.com 
Description: Game Index widget
*/
/* Start Adding Functions Below this Line */


// Creating the widget 
class game_index_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'game_index_widget', 

// Widget name will appear in UI
__('Game Index', 'game_index_widget_domain'), 

// Widget description
array( 'description' => __( 'Game Index Listing', 'game_index_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
#echo __( 'Hello, World!A', 'game_index_widget_domain' );
  $this->getGameListings();
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'game_index_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}

function getGameListings() {
  global $post;
  add_image_size('game_index_widget_size', 85, 45, false);
  $listings = new WP_Query();
  $query_args = $args = array( 'posts_per_page' => 100, 'offset' => 1, 'category_name' => 'featured-games', 'orderby' => 'title', 'order' => 'ASC');
  $listings->query($query_args);
  if ($listings->found_posts > 0) {
    echo '<ul class="game_index_widget">';

    while($listings->have_posts()) {
      $listings->the_post();
      $listItem = '<li>';
      $listItem .= '<a href="' . get_permalink() . '">';
      $listItem .= get_the_title() . '</a>';
      $listItem .= '</li>';
      echo $listItem;
    }

    echo '</ul>';
    wp_reset_postdata();
  } else {
    echo '<p>No games found</p>';
  }
}

} // Class game_index_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'game_index_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

/* Stop Adding Functions Below this Line */
?>
