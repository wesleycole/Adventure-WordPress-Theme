<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package flatness_factor
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="nav" style="display:none">
	  <div class="nav-title">  
	  	<a href="javascript:$.pageslide.close()">close</a>
	    <h2>Menu</h2>
	  </div>
	  <?php wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => new Arrow_Walker_Nav_Menu() ) ); ?>
	</div>	
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<nav>
				<a href="#nav" class="menu-toggle"><i class="icon-reorder"></i> Menu</a>
				<i class="icon-twitter"></i>
				<i class="icon-facebook"></i>
				<i class="icon-instagram"></i>
				<i class="icon-flickr"></i>
			</nav>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
