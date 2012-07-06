<?php
/*
  Template Name: english
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php get_sidebar("right"); ?>
<?php
$type = 'englishblog';
$args=array(
            'post_type' => $type,
            'post_status' => 'publish',
            'paged' => $paged,
            'ignore_sticky_posts'=> 1
            );
$temp = $wp_query;  // assign orginal query to temp variable for later use                                                                                     
$wp_query = null;
$wp_query = new WP_Query($args);
?>
<div id="main-content">
<?php if (have_posts()) :
$post = $posts[0]; $c=0; 
while (have_posts()) : the_post();
$c++; ?>

<?php if($c == 1) : ?>
<article <?php post_class("firstpostindex") ?> id="post-<?php the_ID(); ?>">
  <?php 
  if(has_post_thumbnail()){ 
    echo "<div style='height: 370px;'>";
    the_post_thumbnail('firstpost');
  } else { 
    echo "<div style='height: 125px;'>";
  } 
  ?>
  <div class="social">
  <a href="<?php the_permalink() ?>">
  <img class="lesmer" src="<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png" alt="Les Mer" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_ned_lesmer.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png'"  /></a>
  <div class="fb-like lesmer" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="40" data-show-faces="false"></div>
<a href="https://twitter.com/share" class="twitter-share-button lesmer" data-url="<?php the_permalink() ?>" data-count="none" data-hashtags="STUDiO2012">Tweet</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  </div>


   <div class="entry">
     <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
     <?php the_excerpt(); ?>
   </div>

</div>
       <hr style="margin-top: 3em;" />
</article>
       <?php else : ?>
<article <?php post_class("regular") ?> id="post-<?php the_ID(); ?>">
<div style="height: 210px;">
<div class="social">
  <a href="<?php the_permalink() ?>">
  <img class="lesmer" src="<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png" alt="Les Mer" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_ned_lesmer.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_opp_lesmer.png'"  /></a>
  <div class="fb-like lesmer" data-href="<?php the_permalink() ?>" data-send="false" data-layout="button_count" data-width="40" data-show-faces="false"></div>
<a href="https://twitter.com/share" class="twitter-share-button lesmer" data-url="<?php the_permalink() ?>" data-count="none" data-hashtags="STUDiO2012">Tweet</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  </div>
       <?php the_post_thumbnail('restpost'); ?>
   <div class="entry">
   <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

     <?php the_excerpt(); ?>
   </div>
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


