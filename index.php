<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

get_header();

if ( isset( $post ) ) {
	$vc_enabled = get_post_meta( $post->ID, '_wpb_vc_js_status', true );
} else {
	$vc_enabled = false;
}
$section_class = $vc_enabled === 'true' ? 'vc-wrap' : 'blog-wrap';

$page_template = apply_filters( 'unisco_layout_post_archive', get_theme_mod( 'unisco_layout_post_archive', 'right-sidebar' ) );

$container = 'container';
// Set page template to full width
if( 'full-width' == $page_template ){
	$container = 'container-fluid';
}

$column = 'col-md-8';
if( 'full-width' == $page_template || 'no-sidebar' == $page_template ) {
	$column = 'col-md-12';
}

if( 'left-sidebar' == $page_template ){
	get_sidebar();
}
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row">
            <div class="<?php echo esc_attr( $column ); ?>">
                <main id="main" class="site-main">

                    <?php
                    if ( have_posts() ) :

                        if ( is_home() && ! is_front_page() ) : ?>
                            <header>
                                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                            </header>

                            <?php
                        endif;

                        /* Start the Loop */
                        while ( have_posts() ) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/content', get_post_format() );

                        endwhile;

                        unisco_posts_navigation();

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif; ?>

                </main><!-- #main -->
            </div><!-- .col-md-8 -->

<?php
if( 'right-sidebar' == $page_template ) {
	get_sidebar();
}
get_footer();
