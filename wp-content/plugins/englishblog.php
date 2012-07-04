<?php
/*
  Plugin Name: english blog
  Plugin URI: http://www.dagen.ifi.uio.no
  Description: To hhave an english alternative blog
  Version 0.1
  Author: Sjur Hernes
  Author URI: grey.sjux.net
  License: GPL v2 or later
*/
?>

<?php

if (!class_exists("StudioEnglish")) {

  class StudioEnglish {
    
    function StudioEnglish(){
      
      function studio_blog_english_type() {
	register_post_type(
			   'englishblog',
			   array(
				 'labels' => array(
						   'name'                  =>      __( 'English'                       ),
						   'singular_name'         =>      __( 'English'                         ),
						   'add_new'               =>      __( 'Legg til ny post'             ),
						   'add_new_item'          =>      __( 'Legg til ny post'             ),
						   'edit_item'             =>      __( 'Rediger post'                 ),
						   'new_item'              =>      __( 'Legg til ny post'             ),
						   'view_item'             =>      __( 'Vis post'                     ),
						   'search_items'          =>      __( 'Søk etter post'               ),
						   'not_found'             =>      __( 'ingen posts funnet'          ),
						   'not_found_in_trash'    =>      __( 'ingen posts funnet i søppel' )
						   ),
				 'menu_position'       =>  9,
				 'public'              =>  true,
				 'publicly_queryable'  =>  true,
				 'show-ui'             =>  true,
				 'rewrite'             =>  array(
								 'slug' => 'english', 
								 'with_front' => false),
				 'query_var'           =>  'englishpost',
				 'capability_type'     =>  'post',
				 'map_meta_cap'        => true,
				 'supports'            =>  array(
								 'title',
								 'editor',
								 'author',
								 'thumbnail',
								 'administrator'
								 ),
				 )
			   );
      }
    }
  }
}

if (class_exists("StudioEnglish")) {
  $studio_english_object = new StudioEnglish();
}  

if ( isset($studio_english_object)){
  add_action( 'init',      'studio_blog_english_type', 0);
  add_action( 'save_post', 'studio_blog_english_save');
}

?>
