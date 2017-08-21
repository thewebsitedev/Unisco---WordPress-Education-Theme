<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package unisco
 */

get_header();

$page_template = apply_filters( 'unisco_layout_404', get_theme_mod( 'unisco_layout_404', 'right-sidebar' ) );

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
                        <div class="search-content">
                            <p><?php esc_html_e( 'It looks like nothing was found at this location.', 'unisco' ); ?></p>
                            <p><?php esc_html_e( 'Maybe try one of the links from below or another search?', 'unisco' ); ?></p>
                            <br>
                            <div class="widget">
		                        <?php get_search_form(); ?>
                            </div>
	                        <?php
	                        the_widget( 'WP_Widget_Recent_Posts', array(), array(
		                        'before_title' => '<h3 class="widget-title">',
		                        'after_title'  => '</h3>'
	                        ) );

	                        // Only show the widget if site has multiple categories.
	                        if ( unisco_categorized_blog() ) :
		                        ?>
                                <div class="widget widget_categories">
                                    <h3 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'unisco' ); ?></h3>
                                    <ul>
				                        <?php
				                        wp_list_categories( array(
					                        'orderby' => 'count',
					                        'order' => 'DESC',
					                        'show_count' => 1,
					                        'title_li' => '',
					                        'number' => 10,
				                        ) );
				                        ?>
                                    </ul>
                                </div><!-- .widget -->
		                        <?php
	                        endif;

	                        /* translators: %1$s: smiley */
	                        $archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'unisco' ), convert_smilies( ':)' ) ) . '</p>';
	                        the_widget( 'WP_Widget_Archives', 'dropdown=1', "before_title=<h3 class='widget-title'>&after_title=</h3>$archive_content" );

	                        the_widget( 'WP_Widget_Tag_Cloud', array(), array(
		                        'before_title' => '<h3 class="widget-title">',
		                        'after_title'  => '</h3>'
	                        ) );
	                        ?>
                        </div>
                    </main>
                </div><!-- #primary -->
<?php

if( 'right-sidebar' == $page_template ) {
	get_sidebar();
}

get_footer();
