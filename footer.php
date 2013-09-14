<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package adventure
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			
      <?php $general_options = get_option ( 'adventure_theme_general_options' );
      
      if (isset($general_options['show_footer'])) {
        
        echo 'Nothing set';
        
      
      } else { 
  		  
     
        echo $general_options['show_footer']; 

      } ?>
    </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>