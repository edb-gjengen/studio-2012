<?php
add_theme_support('nav-menus');
add_theme_support( 'automatic-feed-links' ); //automatic_feed_links();
add_theme_support( 'post-thumbnails' ); // Makes it easier with image-links :D
add_image_size('restpost', 200, 200, true);
add_image_size('firstpost', 590, 250, true);
register_nav_menus( array('header-menu' => 'Header Menu' ) );
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
// Custom background :)
add_custom_background();

function studio2012_enqueue_scripts() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
  wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'studio2012_enqueue_scripts');

if (function_exists('register_sidebar')) {
  register_sidebar(array(
			 'name' => 'Sidebar Widgets',
			 'id'   => 'sidebar-widgets',
			 'description'   => 'These are widgets for the left sidebar.',
			 'before_widget' => '<div id="widget-side-left %1$s" class="widget-side-left widget %2$s">',
			 'after_widget'  => '</div>',
			 'before_title'  => '<h2>',
			  'after_title'   => '</h2>'
			 ));
}

if (function_exists('register_sidebar')) {
  register_sidebar(array(
			 'name' => 'Sidebar Widgets2',
			 'id'   => 'sidebar-widgets2',
			 'description'   => 'These are widgets for the right sidebar.',
			 'before_widget' => '<div id="widget-side-right %1$s" class="widget-side-right widget %2$s">',
			 'after_widget'  => '</div>',
			 'before_title'  => '<h2>',
			  'after_title'   => '</h2>'
			 ));
}

class Program_Widget extends WP_Widget {
  
  function Program_Widget() { parent::WP_Widget(false, 'Program'); }
  function form($instance) {}
  function update($new_instance, $old_instance) { return $new_instance; }
 
  function widget($args, $instance) {
    global $post, $wp_locale;
    $args['title'] = 'Dagens Program';
    $events = new WP_Query( array('post_type' => 'event','posts_per_page' => -1,'meta_key' => 'neuf_events_starttime','orderby' => 'meta_value','order' => 'ASC') );
    echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
    if ( $events->have_posts() ) {
      echo '<ul id="event-widget">';
      while ( $events->have_posts() ) {
	$events->the_post();
	if(date('d m Y', time()) == date('d m Y', get_post_meta($post->ID, 'neuf_events_starttime', true)))
	  echo '<li class="'.get_post_meta($post->ID, 'neuf_events_type', true).'">' . date("d/m - H:i", get_post_meta($post->ID, 'neuf_events_starttime', true)) . ' <br /> <a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
      } echo '</ul>';
      wp_reset_query();
    } echo $args['after_widget'];
  }
}

class Artist_Widget extends WP_Widget {
  function Artist_Widget() { parent::WP_Widget(false, 'Artister'); }
  function form($instance) {}
  function update($new_instance, $old_instance) { return $new_instance; }
  
  function widget($args, $instance) {
    global $post, $wp_locale;
    $args['title'] = '';
    $studart = new WP_Query( array('post_type' => 'artist', 'posts_per_page' => -1, 'orderby' => 'meta_value', 'meta_key' => 'studio_artist_font'));
    echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
    if ( $studart->have_posts() ) {
      while ( $studart->have_posts() ) {
	$studart->the_post();

	// event-lenka
	$event = get_post_meta($post->ID, 'studio_artist_event', true);
	// ekstern lenke for artisten
	echo '<p class="artist '.get_post_meta($post->ID, 'studio_artist_font', true).' '.get_post_meta($post->ID, 'studio_artist_color', true)."\"><a href=\"" . get_post($event)->guid . "\">" . get_the_title() . '</a></p>';

      }
    } echo "<hr />";
    echo $args['after_widget'];
  }
}

register_widget('Program_Widget'); 
register_widget('Artist_Widget'); 

function custom_excerpt_length( $length ) {
  return 35;
}

?>