<?php
/**
 * Template part for displaying page content in pages.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

$hide_footer_meta = apply_filters( 'unisco_page_hide_footer_meta', get_theme_mod( 'unisco_page_hide_footer_meta', 'no' ) );

?>

<article id="post-<?php the_ID(); ?>">
	<?php if ( '' !== get_the_post_thumbnail() || !empty( unisco_header_menu_class() ) ) : ?>
    <header class="entry-header">
        <?php if ( '' !== get_the_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <?php the_post_thumbnail( 'unisco-featured-image', array( 'class' => 'img-fluid' ) ); ?>
        </div><!-- .post-thumbnail -->
        <?php
            endif;
        // Display if slider
        if( !empty( unisco_header_menu_class() ) ) {
	        get_template_part( 'template-parts/content', 'title' );
        }
        ?>
    </header><!-- .entry-header -->
	<?php endif; ?>

    <div class="entry-content">
        <h6 class="edit-link-page">
			<?php
			edit_post_link(
				sprintf(
				/* translators: %s: Name of current post */
					esc_html__( 'Edit', 'unisco' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
        </h6>
		<?php
		// if default blog page, category page or any archive page
		// then display excerpt else whole content
		// is_home() || is_category() || is_archive()
		the_content( sprintf(
			wp_kses(
			/* translators: %s: Name of current post. */
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'unisco' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'unisco' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

	<?php
    if( $hide_footer_meta == 'no' && !is_home() && !is_front_page() ){
	    get_template_part( 'template-parts/content', 'footer' );
    }
    ?>
</article><!-- #post-## -->
