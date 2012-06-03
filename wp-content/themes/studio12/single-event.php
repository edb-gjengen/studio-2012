
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div id="main-content">
<article <?php post_class("event") ?> id="post-<?php the_ID(); ?>">
      
   <div class="entry">

   <?php 

   if (has_post_thumbnail())
     echo the_post_thumbnail("singlepost"); ?>
 <h2 /><?php the_title(); ?></h2>
<?php
  $type = get_post_meta($post->ID, 'neuf_events_type', true);
  echo '<div class="event-time">' . date('H:i', get_post_meta($post->ID, 'neuf_events_starttime', true)) . '</div>';
echo '<div class="event-sted">lokale: ' . get_the_title(get_post_meta($post->ID, 'neuf_events_venue', true)) . '</a></div>';

the_content();

wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

</div>

<?php edit_post_link('Edit this entry','','.'); ?>

</article>

</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
