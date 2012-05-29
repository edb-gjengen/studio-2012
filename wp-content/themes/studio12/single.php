<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="main-content">
<article <?php post_class("event") ?> id="post-<?php the_ID(); ?>">
   
   <h2><?php the_title(); ?></h2>
   
   <div class="entry">

      <?php 

   if (has_post_thumbnail())
     echo the_post_thumbnail("singlepost");

if ($post->post_type == "event") {
  $type = get_post_meta($post->ID, 'neuf_events_type', true);
  echo '<div class="event-time">Starter: ' . date('H:i', get_post_meta($post->ID, 'neuf_events_starttime', true)) . '</div>';
  echo '<div class="event-sted">Sted: <a href="'.get_permalink(get_post_meta($post->ID, 'neuf_events_venue', true)).'">' . get_the_title(get_post_meta($post->ID, 'neuf_events_venue', true)) . '</a></div>';
  if ($type == 'Konsert' || $type == 'Stand-up')
    echo '<div class="event-artist">Artist: ' . get_post_meta($post->ID, 'neuf_events_artist', true) . '</div>';
  elseif ($type == 'Foredrag')// noe
    echo '<div class="event-artist">Foredragsholder : ' . get_post_meta($post->ID, 'neuf_events_artist', true) . '</div>';
} elseif ($post->post_type == "venue") { 
  echo '<div class="venue-size">Kapasitet: ' . get_post_meta($post->ID, 'neuf_venues_venuesize', true) . '</div>';
}  

?>



<?php the_content(); ?>
   

   
<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

<?php the_tags( 'Tags: ', ', ', ''); ?>
   
</div>

<?php edit_post_link('Edit this entry','','.'); ?>

</article>

</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
