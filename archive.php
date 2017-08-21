<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

get_header();

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
<section class="blog-wrap">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row">
            <div class="<?php echo esc_attr($column); ?>">
                <main id="main" class="site-main">

                    <?php
                    if ( have_posts() ) : ?>

                        <?php
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
            </div><!-- .<?php echo esc_html($column); ?> -->

<?php
if( 'right-sidebar' == $page_template ) {
	get_sidebar();
}
get_footer();
