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
   <h2><?php the_title(); ?></h2>
<?php
the_content();
wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

</div>

<?php edit_post_link('Edit this entry','','.'); ?>

</article>

</div>

<?php endwhile; endif; ?>
<?php get_footer(); ?>
