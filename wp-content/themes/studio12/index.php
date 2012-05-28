<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>
<div id="main-content">
<?php if (have_posts()) :
$post = $posts[0]; $c=0; 
while (have_posts()) : the_post();
$c++; ?>

<?php if($c == 1) : ?>
<article <?php post_class("firstpostindex") ?> id="post-<?php the_ID(); ?>">
  <?php the_post_thumbnail("firstpost"); ?>
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

   <div class="entry">
     <?php the_excerpt(25); ?>
   </div>

       <hr />
</article>
       <?php else : ?>
<article <?php post_class("regular") ?> id="post-<?php the_ID(); ?>">
       <?php the_post_thumbnail(); ?>
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
   <div class="entry">
     <?php the_excerpt(25); ?>
   </div>
  <br />
       <hr />
</article>

       <?php endif; ?>

	<?php endwhile; ?>

	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>

  </div>
   <?php get_footer(); ?>


