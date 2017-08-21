<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function unisco_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'unisco-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'unisco-front-page';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class for one or two column page layouts.
	if ( is_page() || is_archive() ) {
		if ( 'one-column' === get_theme_mod( 'page_layout' ) ) {
			$classes[] = 'page-one-column';
		} else {
			$classes[] = 'page-two-column';
		}
	}

	// Add class if the site title and tagline is hidden.
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}

	return $classes;
}

add_filter( 'body_class', 'unisco_body_classes' );

/**
 * Count our number of active panels.
 *
 * Primarily used to see if we have any panels active, duh.
 */
function unisco_panel_count() {

	$panel_count = 0;

	/**
	 * Filter number of front page sections in Twenty Seventeen.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $num_sections Number of front page sections.
	 */
	$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i ++ ) {
		if ( get_theme_mod( 'panel_' . $i ) ) {
			$panel_count ++;
		}
	}

	return $panel_count;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function unisco_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Fetches the custom logo image url.
 * @since  1.0.0
 * @return string
 */
function unisco_get_custom_logo_url() {
	$id = get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$image = wp_get_attachment_image_src( $id, 'full' );

		return $image[0];
	}

	return false;
}

/**
 * Displays custom logo.
 * @since  1.0.0
 */
function unisco_custom_logo() {
	$logo_img_url = unisco_get_custom_logo_url();
	?>
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo esc_url( get_home_url() ); ?>"><img src="<?php echo esc_url( $logo_img_url ); ?>"
                                                                    class="responsive-logo img-fluid"
                                                                    alt="responsive-logo"></a>
        </div>
    </div>
	<?php
}

/**
 * Display navigation to next/previous set of posts when applicable.
 * Based on paging nav function from Twenty Fourteen
 */
if ( !function_exists( 'unisco_posts_navigation' ) ) {
	function unisco_posts_navigation() {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 3,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => 'prev',
			'next_text' => 'next',
			'type'      => 'array',
		) );

		if ( $links ) :
			?>
            <nav class="navigation paging-navigation" role="navigation">
                <span class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'unisco' ); ?></span>
                <ul class="pagination justify-content-center">
					<?php
					foreach ( $links as $key => $value ) {
						if ( strip_tags( $value ) == 'prev' ):
							preg_match_all( '/<a[^>]+href=([\'"])(.+?)\1[^>]*>/i', $value, $prev );
							?>
                            <li class="page-item">
                                <a class="page-link page-next"
                                   href="<?php echo esc_url( ! empty( $prev ) ? $prev[2][0] : '#' ); ?>"
                                   aria-label="<?php esc_attr_e( 'Previous', 'unisco' ); ?>">
                                    <i class="icon-arrow-left" aria-hidden="true"></i>
                                    <span class="sr-only"><?php esc_html_e( 'Previous', 'unisco' ); ?></span>
                                </a>
                            </li>
							<?php
                        elseif ( strip_tags( $value ) == 'next' ):
							preg_match_all( '/<a[^>]+href=([\'"])(.+?)\1[^>]*>/i', $value, $next );
							?>
                            <li class="page-item">
                                <a class="page-link page-next"
                                   href="<?php echo esc_url( ! empty( $next ) ? $next[2][0] : '#' ); ?>"
                                   aria-label="<?php esc_attr_e( 'Next', 'unisco' ); ?>">
                                    <i class="icon-arrow-right" aria-hidden="true"></i>
                                    <span class="sr-only"><?php esc_html_e( 'Next', 'unisco' ); ?></span>
                                </a>
                            </li>
							<?php
						else:
							?>
                            <li class="page-item"><?php echo wp_kses_post( $value ); ?></li>
							<?php
						endif;
					}
					?>
                </ul>
            </nav><!-- .navigation -->
			<?php
		endif;
	}
}

/**
 * Site title and description markup
 */
if ( !function_exists( 'unisco_site_title_description' ) ) {
	function unisco_site_title_description( $title_tag = 'h1' ) {
		$name = get_bloginfo( 'name', 'display' );
		if ( $name ) : ?>
            <<?php echo esc_html($title_tag); ?> class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $name ); ?></a></<?php echo esc_html($title_tag); ?>>
		<?php endif;
		$tagline = get_bloginfo( 'description', 'display' );
		$display_tagline = get_theme_mod( 'unisco_display_site_tagline', true );
		if ( $display_tagline ) : ?>
            <p class="site-tagline"><?php echo esc_html( $tagline ); ?></p>
		<?php endif;
	}
}

/**
 * Meta options
 */
if ( !function_exists( 'unisco_get_meta_options' ) ) {
	function unisco_get_meta_options() {
		if ( isset( $post ) ) {
			$meta = get_post_meta( $post->ID, 'unisco_options', true );
		} else {
			$meta = array();
		}
		return $meta;
	}
}

/**
 * Hide post navigation
 */
if ( !function_exists( 'unisco_post_hide_post_navigation' ) ) {
	function unisco_post_hide_post_navigation() {
		return apply_filters( 'unisco_post_hide_post_navigation', get_theme_mod( 'unisco_post_hide_post_navigation', 'no' ) );
	}
}