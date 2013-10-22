<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package flyleaf
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
	  	<a class="slide-close" href="javascript:$.pageslide.close()">close</a>
	    <h2>Menu</h2>
	  </div>
	  <?php wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => new Arrow_Walker_Nav_Menu() ) ); ?>
	</div>	
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<nav class="primary">
			<a href="#nav" class="menu-toggle"><i class="icon-reorder"></i> Menu</a>
		</nav>
		<div class="site-branding">
			<?php $header_image = get_header_image();
				if ( ! empty( $header_image ) ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
				</a>
			<?php } // if ( ! empty( $header_image ) ) ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<nav class="social">
				<?php $social_options = get_option ( 'flyleaf_theme_social_options' ); ?>
					<?php echo $social_options['twitter'] ? '<a href="' . esc_url( $social_options['twitter'] ) . '"<i class="icon-twitter icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['facebook'] ? '<a href="' . esc_url( $social_options['facebook'] ) . '"<i class="icon-facebook icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['googleplus'] ? '<a href="' . esc_url( $social_options['googleplus'] ) . '"<i class="icon-google-plus-sign icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['instagram'] ? '<a href="' . esc_url( $social_options['instagram'] ) . '"<i class="icon-instagram icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['github'] ? '<a href="' .esc_url( $social_options['github'] ) . '"<i class="icon-github icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['youtube'] ? '<a href="' .esc_url( $social_options['youtube'] ) . '"<i class="icon-youtube-play icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['pinterest'] ? '<a href="' .esc_url( $social_options['pinterest'] ) . '"<i class="icon-pinterest-sign icon-large"></i></a>' : ''; ?>
					<?php echo $social_options['linkedin'] ? '<a href="' .esc_url( $social_options['linkedin'] ) . '"<i class="icon-linkedin-sign icon-large"></i></a>' : ''; ?>
			</nav>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
