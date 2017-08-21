<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package unisco
 */

get_header();

$page_template = apply_filters( 'unisco_layout_search', get_theme_mod( 'unisco_layout_search', 'right-sidebar' ) );

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
    <section class="blog-wrap">
        <div class="<?php echo esc_attr($container); ?>">
            <div class="row">
                <?php
                if( 'left-sidebar' == $page_template ){
                    get_sidebar();
                }
                ?>
                <div class="<?php echo esc_attr($column); ?>">
                    <main id="main" class="site-main" role="main">

                        <?php
                        if ( have_posts() ) :
                            /* Start the Loop */
                            while ( have_posts() ) : the_post();

                                /**
                                 * Run the loop for the search to output the results.
                                 * If you want to overload this in a child theme then include a file
                                 * called content-search.php and that will be used instead.
                                 */
                                get_template_part( 'template-parts/content', 'search' );

                            endwhile;

                            the_posts_navigation();

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
