<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package unisco
 */

?>
</div><!-- .row -->
</div><!-- .container -->
</section><!-- .blog-wrap -->

<?php
/**
 * Before footer hook
 * Plugin developers can use this hook
 * to output content before footer
 */
unisco_footer_before();
?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container site-info">
        <?php unisco_footer_top();
        $hide_widgets = apply_filters( 'unisco_hide_footer_widgets', 'no' );
        if( $hide_widgets == 'no' ):
        ?>
        <div class="row">
			<?php
			if ( is_active_sidebar( 'footer' ) ) {
				dynamic_sidebar( 'footer' );
			}
			?>
        </div>
        <?php
        endif;
        $hide_copyright = apply_filters( 'unisco_hide_copyright_area', 'no' );
        if( $hide_copyright == 'no' ) :
        ?>
        <div class="row copyright">
            <div class="col-md-12 text-center">
                <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'unisco' ) ); ?>"><?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'unisco' ), 'WordPress' );
					?></a>
                <span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'unisco' ), 'UNISCO', '<a href="' . esc_url("https://snapthemes.io/" ) . '" rel="designer">SnapThemes</a>' );
				?>
            </div>
        </div>
	    <?php endif; unisco_footer_bottom(); ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php unisco_footer_after(); wp_footer(); unisco_body_bottom(); ?>

</body>
</html>
