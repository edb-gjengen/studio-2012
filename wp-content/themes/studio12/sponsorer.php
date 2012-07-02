/*
  Template Name: bedrifter
*/

<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>
<div id="main-content">
<?php 
  $type = 'bedrift';
$args=array(
	    'post_type' => $type,
	    'post_status' => 'publish',
	    'paged' => $paged,
	    'ignore_sticky_posts'=> 1
	    'meta_key' => 'dagen_bedrift_type',
	    'orderby' => 'meta_value',
	    'order' => 'ASC'
	    );
$temp = $wp_query;  // assign orginal query to temp variable for later use   
$wp_query = null;
$wp_query = new WP_Query($args); 
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php get_template_part( 'loop', 'index' );?>

<article <?php post_class("regular") ?> id="post-<?php the_ID(); ?>">
<div style="height: 210px;">
  
  <?php if (has_post_thumbnail()) { echo the_post_thumbnail('restpost'); } ?>
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
   <div class="entry">
     <?php the_excerpt(); ?>
   </div>
  <a href="<?php the_permalink() ?>">
  <img class="lesmer" src="<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png" alt="Les Mer" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_ned_lesmer.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png'"  /></a>
</div>
       <hr />
</article>

	<?php endwhile; ?>

	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>

  </div>
  <?php get_template_part( 'loop', 'index' );?>
  <?php get_footer(); ?>


