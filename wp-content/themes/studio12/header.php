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
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">  
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  



  <![endif]-->  
   <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>  
  <div id="fb-root"></div>
       <script>(function(d, s, id) {
	   var js, fjs = d.getElementsByTagName(s)[0];
	   if (d.getElementById(id)) return;
	   js = d.createElement(s); js.id = id;
	   js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	   fjs.parentNode.insertBefore(js, fjs);
	 }(document, 'script', 'facebook-jssdk'));</script>
  <div id="page-wrap">
    <div id="header">
       <img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" />
       <img id="banner" src="<?php echo get_template_directory_uri(); ?>/images/header.png" usemap="#homemap" />
       <map name="homemap">
           <area shape="rect" coords="15,40,410,166" href='<?php echo site_url(); ?>' alt="Home" />
           <area shape="circle" coords="1118,102,5" href="https://twitter.com/#!/helgebr" alt="Helge!" />
       </map>
    </div>
       <div id="nav"><?php wp_nav_menu(array('link_before' => ''));?></div>




