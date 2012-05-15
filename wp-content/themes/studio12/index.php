<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

   <div class="postinfo"> <?php the_time('F jS, Y'); ?> </div>
   <hr \>
	<?php the_post_thumbnail(); ?>
   <div class="entry">
     <?php the_excerpt(); ?>
   </div>
   
   <footer class="postmetadata">
     <?php the_tags('Tags: ', ', ', '<br />'); ?>
     Posted in <?php the_category(', ') ?>
   </footer>

</article>

	<?php endwhile; ?>

	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>


   <?php get_footer(); ?>


