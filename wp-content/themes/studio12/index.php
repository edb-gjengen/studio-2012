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
<div >
  <?php the_post_thumbnail('firstpost'); ?>
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

   <div class="entry">
     <?php the_excerpt(); ?>
   </div>
  <a href="<?php the_permalink() ?>">
  <img class="lesmer" src="<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png" alt="Les Mer" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_ned_lesmer.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png'"  /></a>
</div>
       <hr style="margin-top: 2em;" />
</article>
       <?php else : ?>
<article <?php post_class("regular") ?> id="post-<?php the_ID(); ?>">
<div style="height: 220px;">
       <?php the_post_thumbnail('restpost'); ?>
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
   <div class="entry">
     <?php the_excerpt(); ?>
   </div>
  <a href="<?php the_permalink() ?>">
  <img class="lesmer" src="<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png" alt="Les Mer" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_ned_lesmer.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png'"  /></a>
</div>
       <hr />
</article>

       <?php endif; ?>

	<?php endwhile; ?>

	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>

  </div>
   <?php get_footer(); ?>


