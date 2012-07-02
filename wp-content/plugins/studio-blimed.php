<?php

/*
Plugin Name: Blimed form
Plugin URI: 
Description: form-shortcode
Version: 1
Author: Sjur Hernes
Author URI: 
*/


//include_once './studio-blimed-admin.php';
register_activation_hook( __FILE__,  'studio_blimed_install' );
register_deactivation_hook( __FILE__,  'studio_blimed_uninstall' );

/** drops table on deactivation TODO : Get backup on deactivation */

function studio_blimed_uninstall() {
  global $wpdb;
  $studio_blimed_table = $wpdb->prefix . "studio_blimed_table";
  $wpdb->query("DROP TABLE IF EXISTS $studio_blimed_table ;");
}
/** Activation of plugin, creates the tables */

function studio_blimed_install() {
  global $wpdb;
  $studio_blimed_table = $wpdb->prefix . 'studio_blimed_table';

  if ( $wpdb->get_var( "show tables like 'studio_blimed_table'" ) != $studio_blimed_table ) {

    $sql = "CREATE TABLE $studio_blimed_table ( 
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      name tinytext NOT NULL,
      studsted tinytext NOT NULL,
      adresse tinytext NOT NULL,
      mail tinytext NOT NULL,
      tlf tinytext NOT NULL,
      valg tinytext NOT NULL,
      UNIQUE KEY id (id)
      )";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

  }
}


/** 
 * Shows form and inserts on _POST
 */
function blimed_form( ) {

/*
Template Name: blimed
*/


  global $wpdb;
  $table_name = $wpdb->prefix . 'studio_blimed_table';
  $backspinn = '';

  if (isset($_POST['save'])) {

    // Some values should allways be there
    if ($_POST['funk_name']  != 'Navn' && 
	$_POST['funk_mail']  != 'Mail' &&
	$_POST['funk_tlf']   != 'Tlf' &&
	$_POST['funk_valg'] != 'Hva vil du jobbe med?') {      

      // Insert into db. $settinnidb will have value if successfull :)
      $settinnidb = $wpdb->insert( $table_name, array( 'name'        => mysql_real_escape_string($_POST['funk_name'])                   ,
						       'tlf'         => mysql_real_escape_string($_POST['funk_tlf'])                    ,
						       'mail'        => mysql_real_escape_string($_POST['funk_mail'])                   ,
						       'studsted'    => mysql_real_escape_string($_POST['funk_studsted'])               ,
						       'adresse'    => mysql_real_escape_string($_POST['funk_adresse'])               ,
						       'valg'       => mysql_real_escape_string($_POST['funk_valg'])                  ,
						       )
				   );
      
      if ($settinnidb) {
	echo '<div id="blimed_tilbake_ok"><p>Du er nå registrert</p></div>';
	
      } else echo '<div id="blimed_tilbake_fail"><p>Beklager teknisk feil, sjekk verdiene og prøv på nytt</p></div>';
    } else echo '<div id="blimed_tilbake_fail"><p>Du må oppgi navn, epost, tlf og et arbeidsområde</p></div>';    

  } 
  echo '    <div id="studioform">
   <form id="funk_data_form" method="post" action="">
		<input type="text" onclick="this.value=\'\';" name="funk_name" id="funk_name" value="Navn" title="Navn" />
		<input type="text" onclick="this.value=\'\';" name="funk_mail" id="funk_mail" value="Mail" title="Mail" />
		<input type="text" onclick="this.value=\'\';" name="funk_tlf" id="funk_tlf" value="Tlf" title="Tlf" />
		<input type="text" onclick="this.value=\'\';" name="funk_adresse" id="funk_adresse" value="Adresse" title="Adresse" />
		<input type="text" onclick="this.value=\'\';" name="funk_studsted" id="funk_studsted" value="Studiested" title="Studiested" />
		<div class="styled-select">
		<select id="funk_valg" name="funk_valg">
			<option value="">Hva vil du jobbe med?</option>
			<option value="vertskap">Vertskap</option>
			<option value="konsert">Konsert</option>
			<option value="bar">Bar</option>
                        <option value="teknisk">Teknisk</option>
                        <option value="transport">Transport</option>
                        <option value="pr">PR</option>
			<option value="trivsel">Trivsel</option>
			</select>
		</div>
		<input id="saveForm" class="submitButton" type="submit" name="save" value="Send" />
		</form></div>';
}

add_shortcode('blimed_form', 'blimed_form');

function blimed_admin_content($param){

    global $wpdb;
        
    $show_query = "SELECT * FROM ".$wpdb->prefix."studio_blimed_table";

    if ($param == 'all') {
        echo "Søket som er utført er: " . $show_query . "<br /><br />";
        $funks = $wpdb->get_results($show_query);
        blimed_print_table($funks);
    } else {
      echo "Søket som er utført er: " . $show_query . " WHERE valg = '" . $param . "'<br /><br />";
      $funks = $wpdb->get_results($show_query." WHERE valg = '".$param."'");
      blimed_print_table($funks);
    }
}

function blimed_print_table( $funks ){
        echo "<table style='border:1px;'>
            <tr>
                <th>Navn&nbsp;&nbsp;</th>
                <th>Epost&nbsp;&nbsp;</th>
                <th>Telefon&nbsp;&nbsp;</th>
                <th>Adresse&nbsp;&nbsp;</th>
                <th>Studiested&nbsp;&nbsp;</th>
                <th>Valg&nbsp;&nbsp;</th>
            </tr>
        ";
        foreach ($funks as $funk) {
            echo "<tr>
                    <td>$funk->name&nbsp;&nbsp;</td>
                    <td>$funk->mail&nbsp;&nbsp;</td>
                    <td>$funk->tlf&nbsp;&nbsp;</td>
                    <td>$funk->adresse&nbsp;&nbsp;</td>
                    <td>$funk->studsted&nbsp;&nbsp;</td>
                    <td>$funk->valg&nbsp;&nbsp;</td>
                  </tr>" ;
        }
        echo "</table><br /><br />";
}


function blimed_admin() {
	echo '
<div class="wrap">
    <h1>test</h1>

    <form id="select stuff" method="post" action="">
        hvem skal vises:
        <select id="blimed_admin_sort" name="blimed_admin_sort">
            <option value="all">all</option>
            <option value="vertskap">Vertskap</option>
            <option value="konsert">Konsert</option>
            <option value="bar">Bar</option>
            <option value="teknisk">Teknisk</option>
            <option value="transport">Transport</option>
            <option value="pr">PR</option>
            <option value="trivsel">Trivsel</option>
        </select>
        <input id="saveForm" class="submitButton" type="submit" name="sort" value="Sorter" />
    </form>
    '; 

    if($_POST['sort'])
        blimed_admin_content($_POST['blimed_admin_sort']);
    else
        blimed_admin_content('all'); 
    echo '
</div>';
}

function blimed_admin_test() {
	add_menu_page('blimed', 'blimed', 'manage_options', 'blimed-admin-slug', 'blimed_admin');
}

add_action('admin_menu', 'blimed_admin_test');

