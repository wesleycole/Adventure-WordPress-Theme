<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package flyleaf
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			
      <?php $general_options = get_option ( 'flyleaf_theme_general_options' );
      
      if (isset($general_options['show_footer']) && !empty($general_options['show_footer'] ) ) {
        echo $general_options['show_footer']; 
      } else { ?>
        <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'flyleaf' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'flyleaf' ), 'WordPress' ); ?></a>
        <span class="sep"> | </span>
        <?php printf( __( 'Theme: %1$s by %2$s.', 'flyleaf' ), 'flyleaf', '<a href="http://wesleymcole.com/" rel="designer">Wes Cole & Ryan Andrews</a>' ); 
      } ?>
    </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>