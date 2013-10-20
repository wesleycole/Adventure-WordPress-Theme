<?php
/**
 * @package flyleaf
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php 
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		  the_post_thumbnail( 'thumbnail');
		} 
		?>
		<div class="entry-header-info">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<div class="meta">
				<p><span class="author"><i class="icon-user"></i> <?php the_author() ?></span><span class="date"><i class="icon-calendar"></i> <?php the_date(); ?></span></p>
			</div>
		</div>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'flyleaf' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'flyleaf' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ' ', 'flyleaf' ) );
				if ( $categories_list && flyleaf_categorized_blog() ) :
			?>
			<p class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'flyleaf' ), $categories_list ); ?>
			
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( '', 'flyleaf' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tags %1$s', 'flyleaf' ), $tags_list ); ?>
			</span></p>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
		

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'flyleaf' ), __( '1 Comment', 'flyleaf' ), __( '% Comments', 'flyleaf' ) ); ?></span>
		<?php endif; ?>
		
		</p>
		

		

		<?php edit_post_link( __( 'Edit', 'flyleaf' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
