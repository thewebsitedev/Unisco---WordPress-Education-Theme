<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

$page_template = apply_filters( 'unisco_layout_page', get_theme_mod( 'unisco_layout_page', 'right-sidebar' ) );

$container = 'container';
// Set page template to full width
if( 'full-width' == $page_template ){
	$container = 'container-fluid';
}

$column = 'col-md-8';
if( 'full-width' == $page_template || 'no-sidebar' == $page_template ) {
	$column = 'col-md-12';
}

?>
<section class="<?php echo esc_attr( $section_class ); ?>">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row">
            <?php
            if( 'left-sidebar' == $page_template ){
                get_sidebar();
            }
            ?>
            <div class="<?php echo esc_attr( $column ); ?>">
                <main id="main" class="site-main">

                    <?php
                    while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content', 'page' );

                        unisco_comments_before();
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        unisco_comments_after();

                    endwhile; // End of the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- .<?php echo esc_html( $column ); ?> -->

<?php

if( 'right-sidebar' == $page_template ) {
	get_sidebar();
}

get_footer();
