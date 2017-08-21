<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
$page_template = apply_filters( 'unisco_layout_post_single', get_theme_mod( 'unisco_layout_post_single', 'right-sidebar' ) );

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
            <div class="<?php echo esc_attr($column); ?>">
                <?php unisco_content_before(); ?>
                <main id="main" class="site-main">

                    <?php
                    unisco_content_top();
                    while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content', get_post_format() );

                        if( unisco_post_hide_post_navigation() == 'no' ) {
	                        the_post_navigation();
	                        if( !empty(  the_post_navigation() ) ) {
		                        echo '<div class="clear post-nav-clear"><hr></div>';
	                        }
                        }

	                    unisco_comments_before();
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
	                    unisco_comments_after();

                    endwhile; // End of the loop.
                    unisco_content_bottom();
                    ?>

                </main><!-- #main -->
	            <?php unisco_content_after(); ?>
            </div><!-- .col-md-8 -->

<?php

if( 'right-sidebar' == $page_template ) {
	get_sidebar();
}

get_footer();
