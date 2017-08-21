<?php
/**
 * Displays header navigation
 *
 * @package WordPress
 * @subpackage unisco
 * @since 1.0
 * @version 1.0
 */

// unisco_custom_logo();
$logo_img_url = unisco_get_custom_logo_url();
$responsive_logo_img_url = get_theme_mod( 'unisco_mobile_logo' ); // default --> get_theme_file_uri( '/images/responsive-logo.png' )
if ( isset( $post ) ) {
	$meta = get_post_meta( $post->ID, 'unisco_options', true );
} else {
	$meta = array();
}
?>
<div class="row">
    <div class="col-md-12 mobile-logo">
        <?php if( !empty($responsive_logo_img_url) ) : ?>
        <a href="<?php echo esc_url( site_url() ); ?>"><img src="<?php echo esc_url( $responsive_logo_img_url ); ?>" class="img-fluid responsive-logo" alt="<?php bloginfo( 'name' ); ?>"></a>
        <?php endif; unisco_site_title_description( 'p' ); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <nav class="navbar navbar-light bg-faded hidden-lg-up<?php echo esc_attr( empty($responsive_logo_img_url) ? ' mobile-logo-hidden' : ''); ?>">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-menu"></span>
            </button>
        </nav>
        <div class="navbar-light navbar-toggleable-md collapse nav-collapse bg-faded" id="navbarNavDropdown">
            <div class="row align-items-center">
                <div class="col-12 col-lg-<?php echo esc_attr( !empty( $logo_img_url ) ? '5' : '6' ); ?>">
                    <?php
                    $navbar_default = array(
                        'theme_location' => 'top-left',
                        'depth'          => 2,
                        'menu_id'        => 'top-left-menu',
                        'menu_class'     => 'navbar-nav justify-content-end',
                        'container'      => false,
                        'fallback_cb'    => 'unisco_top_menu',
                        'walker'         => new bs4Navwalker()
                    );
        //			 Override menu based on page options
                     if( isset( $meta['main_menu_left'] ) && is_numeric( $meta['main_menu_left'] ) ) {
                         $navbar_default[ 'menu' ] = $meta['main_menu_left'];
                     }
        //			 Hide / Display main menu
                     if( isset( $meta['hide_menu'] ) && $meta['hide_menu'] != 'yes' || !isset( $meta['hide_menu'] ) ) {
                         wp_nav_menu( $navbar_default );
                     }

                    ?>
                </div>
	            <?php if( !empty( $logo_img_url ) ) : ?>
                <div class="col-2 hidden-md-down">
                    <div class="center-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand custom-logo-link site-logo">
                            <img src="<?php echo esc_url( $logo_img_url ); ?>" class="img-fluid custom-logo" alt="<?php bloginfo( 'name' ); ?>"/>
                        </a>
                    </div>
                </div>
	            <?php endif; ?>
                <div class="col-12 col-lg-<?php echo esc_attr( !empty( $logo_img_url ) ? '5' : '6' ); ?>">
                    <?php
                    $navbar_two_default = array(
                        'theme_location' => 'top-right',
                        'depth'          => 2,
                        'menu_id'        => 'top-right-menu',
                        'menu_class'     => 'navbar-nav justify-content-start',
                        'container'      => false,
                        'fallback_cb'    => 'unisco_top_menu',
                        'walker'         => new bs4Navwalker()
                    );
        //			Override menu based on page options
                    if( isset( $meta['main_menu_right'] ) && is_numeric( $meta['main_menu_right'] ) ) {
                        $navbar_two_default[ 'menu' ] = $meta['main_menu_right'];
                    }
        //			 Hide / Display main menu
                    if( isset( $meta['hide_menu'] ) && $meta['hide_menu'] != 'yes' || !isset( $meta['hide_menu'] ) ) {
                        wp_nav_menu( $navbar_two_default );
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>