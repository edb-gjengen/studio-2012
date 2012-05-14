<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article class="post page <?php the_title(); ?>" id="post-<?php the_ID(); ?>">

   <h2><?php the_title(); ?></h2>
   <hr \>
   <div class="entry">

   <?php the_content(); ?>

   <?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

   </div>

   <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

   </div>
   
   <?php //comments_template(); ?>

   <?php endwhile; endif; ?>

   <?php get_footer(); ?>