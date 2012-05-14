<!doctype html>  
<html style="margin-top:0% !important;" lang="no">  
<head>  
  <meta charset="<?php bloginfo('charset'); ?>">  
  <title>
   <?php 
   if (is_home()) { 
     bloginfo('name'); 
   } elseif (is_single() || is_page()) {
   wp_title('');
 }   
   ?>
  </title>  
  <meta name="description" content="<?php bloginfo('description'); ?>">  
  <meta name="author" content="Studio 2012">
  <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'> 
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">  
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
  <![endif]-->  
   <?php wp_head(); ?>
</head>  
<body <?php body_class(); ?>>  
   <div id="page-wrap">
    <div id="header">
       <img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" />
       <img id="banner" src="<?php echo get_template_directory_uri(); ?>/images/header.png" />
    </div>
       <div id="nav"><?php wp_nav_menu(array('link_before' => ''));?></div>




