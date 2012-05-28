
<div id="sidebar-left" class="sidebar">
  
   <a href="<?php echo get_page_by_title('Bli Frivillig!')->guid; ?>">
	<img id="frivilligknapp" src="<?php echo get_template_directory_uri(); ?>/images/knapp_frivillig.png" alt="blimed" onmouseover=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_frivillig_mouseover.png'" onmouseout=" this.src='<?php echo get_template_directory_uri(); ?>/images/knapp_frivillig.png'"  />
   </a>

   <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : else : ?>
    
        <!-- All this stuff in here only shows up if you DON\'T have any widgets active in this zone -->

   <?php get_search_form(); ?>
    
   <h2>Archives</h2>
   <ul>
   <?php wp_get_archives('type=monthly'); ?>
   </ul>
        
        <h2>Categories</h2>
        <ul>
   <?php wp_list_categories('show_count=1&title_li='); ?>
        </ul>
        
   <?php wp_list_bookmarks(); ?>
    
   <h2>Meta</h2>
   <ul>
   <?php wp_register(); ?>
   <li><?php wp_loginout(); ?></li>
   <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
   <?php wp_meta(); ?>
   </ul>
   
   <h2>Subscribe</h2>
   <ul>
   <li><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a></li>
   <li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a></li>
   </ul>
   
   <?php endif; ?>

</div>
