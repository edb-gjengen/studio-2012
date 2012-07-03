<?php
/*
  Plugin Name: neuf-events
  Plugin URI: http://www.studioweb.no
  Description: Plugin to manage events for STUDiO
  Version 0.1
  Author: Sjur Hernes
  Author URI: grey.sjux.net
  License: GPL v2 or later
*/
?>

<?php

if (!class_exists("NeufEvents")) {

  class NeufEvents{

    function NeufEvents(){

      /**
	 Create the fields the post type should have
      */
      function neuf_events_post_type() {
	register_post_type(
			   'event',
			   array(
				 'labels' => array(
						   'name'                  =>      __( 'Arrangementer'                     ),
						   'singular_name'         =>      __( 'Arrangement'                       ),
						   'add_new'               =>      __( 'Legg til nytt arrangement'         ),
						   'add_new_item'          =>      __( 'Legg til nytt arrangement'         ),
						   'edit_item'             =>      __( 'Rediger arrangement'               ),
						   'new_item'              =>      __( 'Legg til nytt arrangement'         ),
						   'view_item'             =>      __( 'Vis arrangement'                   ),
						   'search_items'          =>      __( 'Søk etter arrangement'             ),
						   'not_found'             =>      __( 'ingen arrangement funnet'          ),
						   'not_found_in_trash'    =>      __( 'ingen arrangement funnet i søppel' )
						   ),
				 'menu_position'       =>  4,
				 'public'              =>  true,
				 'publicly_queryable'  =>  true,
				 'query_var'           =>  'event',
				 'show_ui'             =>  true,
				 'rewrite'             =>  false,
				 'capability_type'     =>  'post',
				 'supports'            =>  array(
								 'title',
								 'editor',
								 'thumbnail',
								 'administrator',
								 ),
				 'register_meta_box_cb' => 'add_events_metaboxes',
				 )
			   );
      }

       
      /*******************************************************************************
      ********************************************************************************
      **  Add meta-boxes   ***********************************************************
      ********************************************************************************
      *******************************************************************************/

      function add_events_metaboxes() {
	// Date-selection for events

        wp_register_style('timecss', plugins_url("/neuf-events/style/jquery-ui-1.8.12.custom.css", dirname(__FILE__)));

        wp_register_script('timepicker', plugins_url("/neuf-events/script/jquery-ui-timepicker-addon.js", dirname(__FILE__)));
        wp_register_script('timedefs', plugins_url("/neuf-events/script/timepickdef.js", dirname(__FILE__)));

        // for upgrading jQuery ui, get core, widget, mouse, slider and datepicker                                                                                            
        wp_register_script('custom-jqui', plugins_url("/neuf-events/script/jquery-ui-1.8.11.custom.min.js", dirname(__FILE__)));

        wp_enqueue_style('timecss');
        wp_enqueue_script('jquery');
        wp_enqueue_script('custom-jqui');
        wp_enqueue_script('timepicker');
        wp_enqueue_script('timedefs');

        add_meta_box(
		     'neuf_events_timestamps',
		     __('Dato og klokkeslett'),
		     'neuf_date_custom_box',
		     'event',
		     'side',
		     'high'
		     );


	add_meta_box(
		     'neuf_event_type',
		     __('Arrangementstype'),
		     'neuf_eventtype_custom_box',
		     'event',
		     'side',
		     'high'
		     );

	add_meta_box(
		     'neuf_eventvenue',
		     __('Sted'),
		     'neuf_eventvenue_custom_box',
		     'event',
		     'side'
		     );

      }


      /*******************************************************************************
      ********************************************************************************
      **  Start and endtime metabox   ************************************************
      ********************************************************************************
      *******************************************************************************/

     function neuf_date_custom_box() {
     
        global $post;
	
	$start = get_post_meta($post->ID, 'neuf_events_starttime', true);
	
	if( $start ) {
	  echo '<label for="neuf_events_starttime">Start:</label><input type="text" class="datepicker required" name="neuf_events_starttime" id="neuf_events_starttime" value="'.date("d.m.Y H:i", intval($start)).'" /><br />';
	  echo 'N&aring;v&aelig;rende dato: '.date("d.m.Y H:i", intval($start));
	} else {
	  echo '<label for="neuf_events_starttime">Start:</label><input type="text" class="datepicker required" name="neuf_events_starttime" id="neuf_events_starttime" value="" /><br />';
	}

     }

      /*******************************************************************************
      ********************************************************************************
      **  Eventtype metabox   ********************************************************
      ********************************************************************************
      *******************************************************************************/

      function neuf_eventtype_custom_box(){

	global $post;

	$event_artist = get_post_meta($post->ID, 'neuf_events_artist', true);
	$neuf_event_type = get_post_meta($post->ID, 'neuf_events_type', true);

	echo "Type:";
	echo '<select name="neuf_events_type">';
	echo $neuf_event_type;

	$types = array( 'Annet','Foredrag','Klubb','Konsert','Quiz',
			'Stand-up','Konkurranse', 'Lyntale'
		       );

	foreach($types as $type){
	  echo '<option value="' . $type . '"';
	  if($type == $neuf_event_type)
	    echo ' selected="selected"';
	  echo '>' . $type . '</option>';
	}
	echo '</select>';

	echo '<br />Artist/Foredragsholder:<br /><input type="text" name="neuf_events_artist" value="'.$event_artist.'" />';
      }



      /*******************************************************************************
      ********************************************************************************
      **  Event venue metabox ********************************************************
      ********************************************************************************
      *******************************************************************************/

      function neuf_eventvenue_custom_box(){

	global $post;

	$neuf_event_venue = get_post_meta($post->ID, 'neuf_events_venue', true);

	echo 'Sted:';
	echo '<select name="neuf_events_venue">';
	echo $neuf_event_venue;

        if (class_exists("NeufVenues")) {
          $venues = query_posts( array('post_type' => 'venue', 'posts_per_page' => -1, 'order' => 'ASC'));

          foreach ($venues as $venue) {
            if ($venue->post_title != '' ){
              echo '<option value="'.$venue->ID.'"';
              if($venue->ID == $neuf_event_venue)
                echo ' selected="selected"';
              echo '>'.$venue->post_title.'</option>';
            }
          }

        } else {
	  $venues = array (array('id' => 1, 'name' => 'Smalltalk'),
			   array('id' => 2, 'name' => 'Simula'),
			   array('id' => 3, 'name' => 'Kantina') , 
			   array('id' => 4, 'name' => 'Escape'),
			   array('id' => 5, 'name' => 'Java')
			   );
	  
          foreach ($venues as $venue) {
            echo '<option value="'.$venue['id'].'"';
            if($venue['id'] == $neuf_event_venue)
              echo ' selected="selected"';
            echo '>'.$venue['name'].'</option>';
	  }
	}
	echo '</select>';
	
      }
      
      /**
       *  When the post is saved, saves our custom data
       */ 

      function neuf_events_save_info( $post_id ) {

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  return $post_id;

	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;

	// Get posted data

	$tosave['neuf_events_venue'] = $_POST['neuf_events_venue'];
	$tosave['neuf_events_type'] = $_POST['neuf_events_type'];
	$tosave['neuf_events_artist'] = $_POST['neuf_events_artist'];
	$tosave['neuf_events_starttime'] = strtotime( $_POST['neuf_events_starttime']);
	
        // Update or add post meta                                                                                                                                                
        foreach($tosave as $key=>$value)
	  if(!update_post_meta($post_id, $key, $value))
	    add_post_meta($post_id, $key, $value, true);
	
	return $post_id;
    }

      /** View of the custom page */


      function neuf_events_program() {
	global $post, $wp_locale;
	
	$deys = array('MANDAG 13.08.2012', 'TIRSDAG 14.08.2012', 'ONSDAG 15.08.2012', 
		      'TORSDAG 16.08.2012', 'FREDAG 17.08.2012', 'LØRDAG 18.08.2012', 'SØNDAG 19.08.2012',
		      'MANDAG 20.08.2012', 'TIRSDAG 21.08.2012', 'ONSDAG 22.08.2012', 
		      'TORSDAG 23.08.2012', 'FREDAG 24.08.2012', 'LØRDAG 25.08.2012', 'SØNDAG 16.08.2012');

	$events = new WP_Query( array(
				      'post_type' => 'event',
				      'posts_per_page' => -1,
				      'meta_key' => 'neuf_events_starttime',
				      'orderby' => 'meta_value',
				      'order' => 'ASC',
				      ) 
				);
	$html = '';
	$html .= '<form id="thisdate" action="" method="post">';
	$html .= '<ul id="programNavbar">';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="13" name="date">MAN <span class="dateColor">13.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="14" name="date">TIRS <span class="dateColor">14.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="15" name="date">ONS <span class="dateColor">15.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="16" name="date">TORS <span class="dateColor">16.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="17" name="date">FRE <span class="dateColor">17.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="18" name="date">LØR <span class="dateColor">18.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="19" name="date">SØN <span class="dateColor">19.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="20" name="date">MAN <span class="dateColor">20.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="21" name="date">TIRS <span class="dateColor">21.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="22" name="date">ONS <span class="dateColor">22.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="23" name="date">TORS <span class="dateColor">23.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="24" name="date">FRE <span class="dateColor">24.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="25" name="date">LØR <span class="dateColor">25.08</span></button></li>';
	$html .= '   <li class="programNavbarTab"><button type="submit" value="26" name="date">SØN <span class="dateColor">26.08</span></button></li>';
	$html .= '</ul></form><hr />';

	if ( $events->have_posts() ) {
	  $date = 13;
	  $bol = true;
	  $html .= '<table class="event-table">';
	  
	  while ( $events->have_posts() ) :
	    $events->the_post();
	  
	  $time = get_post_meta( $post->ID, 'neuf_events_starttime',  true) ;
	  if (date("Y", $time) == date("Y", time()) && (!isset($_POST['date']) || $_POST['date'] == date("d", $time))) {
	    $venue = get_post_meta( $post->ID, 'neuf_events_venue',  true );
	    $type  = get_post_meta( $post->ID, 'neuf_events_type',   true);
	    $artist = get_post_meta( $post->ID, 'neuf_events_artist',  true) ;
	    if(!isset($_POST['date']) && $date == intval(date("d", $time))){
	      $html .= '    <tr class="eventnewday"><td>'.$deys[$date - 13].'</td></tr>'; $date++;
	    }
	    if(isset($_POST['date']) && $bol){
	      $html .= '    <tr class="eventnewday"><td>'.$deys[intval($_POST['date']) - 13].'</td></tr>';
	      $bol = false;
	    }
	    $html .= '    <tr class="tr_event" onclick="document.location = \''.get_permalink().'\';">';
	    $html .= '        <td class="title '.$type.'" style="padding-left: 4em; padding-right:2em; text-align:right;">' . get_the_title() . '</td>';
	    $html .= '        <td class="time"  style="width:10%; text-align: left;">' . date("H:i", $time) . '</td>';
	    $html .= '        <td class="place" style="width:25%; text-align: left; color: #666;">' . get_the_title($venue) . '</td>';
	    $html .= '    </tr>';
	  } 
	  endwhile;
	  
	  $html .= '</table><!-- .event-table -->';
	}
	
	return $html;

      }

      function neuf_events_arkiv() {
	global $post, $wp_locale;
	
	$events = new WP_Query( array(
				      'post_type' => 'event',
				      'posts_per_page' => -1,
				      'meta_key' => 'neuf_events_starttime',
				      'orderby' => 'meta_value',
				      'order' => 'ASC'
				      ) 
				);
	$html = '';
	
	if ( $events->have_posts() ) :
	  $date = "";

	$html .= '<table class="event-table">';
	$event_aar = "";
	while ( $events->have_posts() ) {
	  $events->the_post();
	
	  $time = get_post_meta( $post->ID, 'neuf_events_starttime',  true) ;
	  if (date("Y", $time) != date("Y")) {
	    if (date("Y", $time) != $event_aar) {
	      $html .= '<tr class="arkivaar"><td><strong>'.date("Y", $time).'</strong></td></tr>';
	      $event_aar = date("Y", $time);
	    } 
	    $venue = get_post_meta( $post->ID, 'neuf_events_venue',  true );
	    $type  = get_post_meta( $post->ID, 'neuf_events_type',   true);
	    $artist = get_post_meta( $post->ID, 'neuf_events_artist',  true) ;
	    
	    $html .= '    <tr>';
	    $html .= '        <td class="time" style="width:10%;">' . date("H:i", $time) . '</td>';
	    $html .= '        <td class="artist" style="width:10%;">' . $artist . '</td>';
	    $html .= '        <td class="title" style="padding-right:10px;"><a href="' . get_permalink() . '">' . get_the_title() . '</a></td>';
	    $html .= '        <td class="type" style="font-size:smaller;">' . $type . '</td>';
	    $html .= '        <td class="place" style="width:27%;padding-left:10px;">' . get_the_title($venue) . '</td>';
	    $html .= '    </tr>';
	  }
	}
	  
	$html .= '</table><!-- .event-table -->';
	endif;
	
	return $html;
	
      }
    }
  }
}

if (class_exists("NeufEvents")) {
  $neuf_event_object = new NeufEvents();
}  

if ( isset($neuf_event_object)){

  /** 
      Register the event post type
  */
  add_action(       'init'                , 'neuf_events_post_type');
  add_action(       'save_post'           , 'neuf_events_save_info');
  add_shortcode(    'neuf-events-program', 'neuf_events_program'  );
  add_shortcode(    'neuf-events-arkiv'  , 'neuf_events_arkiv'  );

}

?>
