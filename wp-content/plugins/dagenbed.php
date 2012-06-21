<?php
/*
  Plugin Name: trololol
  Plugin URI: http://www.dagen.ifi.uio.no
  Description: Plugin to manage sponsors for dagen@ifi
  Version 0.1
  Author: Sjur Hernes
  Author URI: grey.sjux.net
  License: GPL v2 or later
*/
?>

<?php

if (!class_exists("DagenBed")) {

  class DagenBed{

    function DagenBed(){

      /**
	 Create the fields the post type should have
      */
      function dagen_bedrift_post_type() {
	register_post_type(
			   'bedrift',
			   array(
				 'labels' => array(
						   'name'                  =>      __( 'Bedrifter'                       ),
						   'singular_name'         =>      __( 'Bedrift'                         ),
						   'add_new'               =>      __( 'Legg til ny bedrift'             ),
						   'add_new_item'          =>      __( 'Legg til ny bedrift'             ),
						   'edit_item'             =>      __( 'Rediger bedrift'                 ),
						   'new_item'              =>      __( 'Legg til ny bedrift'             ),
						   'view_item'             =>      __( 'Vis bedrift'                     ),
						   'search_items'          =>      __( 'Søk etter bedrift'               ),
						   'not_found'             =>      __( 'ingen bedrifter funnet'          ),
						   'not_found_in_trash'    =>      __( 'ingen bedrifter funnet i søppel' )
						   ),
				 'public'              =>  true,
				 'publicly_queryable'  =>  true,
				 // gives url the_site()/bedrift
				 'rewrite'             =>  array(
								 'slug' => 'bedrift', 
								 'with_front' => false),
				 'query_var'           =>  'bedrift',
				 'capability_type'     =>  'bedrift',
				 'map_meta_cap'        => true,
				 'supports'            =>  array(
								 'title',
								 'editor',
								 'author',
								 'thumbnail',
								 'administrator'
								 ),
				 'register_meta_box_cb' => 'add_bedrift_metaboxes',
				 )
			   );
      }

       
      /*******************************************************************************
      ********************************************************************************
      **  Add meta-boxes   ***********************************************************
      ********************************************************************************
      *******************************************************************************/

      function add_bedrift_metaboxes() {

	add_meta_box(
		     'dagen_bedrifts_type',
		     __('Bedriftstype'),
		     'dagen_bedtype_custom_box',
		     'bedrift',
		     'side',
		     'high'
		     );
      }

      /*******************************************************************************
      ********************************************************************************
      **  Eventtype metabox   ********************************************************
      ********************************************************************************
      *******************************************************************************/

      function dagen_bedtype_custom_box(){

	global $post;

	$dagen_bedrift_type = get_post_meta($post->ID, 'dagen_bedrift_type', true);

	echo "Type:";
	echo '<select name="dagen_bedrift_type">';
	echo $dagen_bedrift_type;

	$types = array(array( 'id' => 3, 'name' => 'Standplass' ), 
			array( 'id' => 1, 'name' => 'Hovedsponsor'), 
			array( 'id' => 2, 'name' => 'Sammarbeidspartner'));

	foreach($types as $type){
	  echo '<option value="' . $type['id'] . '"';
	  if($type['id'] == $dagen_bedrift_type)
	    echo ' selected="selected"';
	  echo '>' . $type['name'] . '</option>';
	}
	echo '</select>';
      }

      /**
       *  When the post is saved, saves our custom data
       */ 


      function dagen_bedrift_save_info( $post_id ) {

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  return $post_id;

	// Check permissions
	// TODO
	if ( !current_user_can( 'edit_post', $post_id ) 
	     /*&& get_current_user()->user_login == get_post_meta($post_id, 'author', true)*/ ) return $post_id;

	// Get posted data
	$bedrift_type = $_POST['dagen_bedrift_type'];
	
	if ( !get_post_meta($post_id, 'dagen_bedrift_type') ) {
	  add_post_meta($post_id, 'dagen_bedrift_type', $bedrift_type, true);
	}elseif($bedrift_type != get_post_meta($post_id, 'dagen_bedrift_type', true)){
	  update_post_meta($post_id, 'dagen_bedrift_type',$bedrift_type);
	}

	return $post_id;
    }

      /** View of the custom page */

      function dagen_bedrift_list() {
	global $post, $wp_locale;
	
	$bedrifter = new WP_Query( array(
					 'post_type' => 'bedrift',
					 'posts_per_page' => -1,
					 'meta_key' => 'dagen_bedrift_type',
					 'orderby' => 'meta_value',
					 'order' => 'ASC'
					 ) 
				   );
	$html = '';
	
	if ( $bedrifter->have_posts() ) :
	  $date = "";
	
	$html .= '<table class="bedrift-table">';
	
	while ( $bedrifter->have_posts() ) :
	  $bedrifter->the_post();
	$types = array(1 => "hovedsponsor", 2 => "Samarbeidspartnere", 3 => "Bedrift");
	$type  = get_post_meta( $post->ID, 'dagen_bedrift_type',   true);
	
	$html .= '    <tr>';
	$html .= '        <td class="title" style="padding-right:10px;"><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
	$html .= '        <td class="bedtype" style="font-size:smaller;">' . $types[$type] . '</td>';
	$html .= '    </tr>';
	endwhile;
	
	$html .= '</table><!-- .event-table -->';
	endif;

	//if( current_user_can('upload_files') { $html .= 'uploading works'; }
	return $html;
	
      }
    }
  }
}

if (class_exists("DagenBed")) {
  $dagen_bedrift_object = new DagenBed();
}  

if ( isset($dagen_bedrift_object)){

  /** 
      Register the bedrift post type
  */
  add_action(    'init',                 'dagen_bedrift_post_type', 0);
  add_action(    'save_post',            'dagen_bedrift_save_info');
  add_shortcode( 'dagen-bedrift-list',   'dagen_bedrift_list'  );

  // make a new role, that only can edit and delete own bedrifts
  add_role('bedrift', 'Bedrift', 
	array(	'read' => 1,
		'edit_bedrifts' => true, 
		'edit_published_bedrifts' => true, 
		'publish_bedrifts' => true, 
		'delete_bedrifts' => true, 
		'delete_published_bedrifts' => true, 
		'upload_files' => true
	));
  
  // give all power to the admins!!
  $role = get_role('administrator');
  $role->add_cap('edit_bedrifts'); 
  $role->add_cap('edit_published_bedrifts'); 
  $role->add_cap('edit_others_bedrifts'); 
  $role->add_cap('publish_bedrifts'); 
  $role->add_cap('delete_bedrifts'); 
  $role->add_cap('delete_others_bedrifts'); 
}

?>
