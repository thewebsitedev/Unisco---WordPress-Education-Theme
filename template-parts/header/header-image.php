<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage unisco
 * @since 1.0
 * @version 1.0
 */

?>
<div class="custom-header">
    <?php unisco_header_before(); ?>
    <div id="nav-menu" class="container<?php echo esc_attr( unisco_header_menu_class() ); ?>">
		<?php
		get_template_part( 'template-parts/header/header', 'nav' );
		?>
        <div class="row hidden-md-down">
            <div class="col-md-12">
			    <?php unisco_site_title_description(); ?>
            </div>
        </div>
        <?php
		// Display if no slider
		if( empty( unisco_header_menu_class() ) && unisco_hide_title( $post ) != 'yes' ) {
			get_template_part( 'template-parts/header/header', 'title' );
		}
		?>
    </div><!-- .container -->
	<?php
	// display front slider
	if ( unisco_header_front_slider() && get_theme_mod( 'unisco_slider_front', 'no' ) === 'yes' && is_front_page() ) {
		get_template_part( 'template-parts/header/header', 'slider' );
	}
	unisco_header_after();
	?>
</div><!-- .custom-header -->