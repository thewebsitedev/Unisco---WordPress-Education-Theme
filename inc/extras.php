<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package unisco
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function unisco_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'unisco_pingback_header' );

/**
 * Top menu fallback
 * @since  1.0.0
 *
 * @param  array $args
 *
 * @return string
 */
function unisco_top_menu( $args ) {
	extract( $args );
	$link = $link_before
	        . '<a href="' . admin_url( 'nav-menus.php' ) . '" class="nav-link text-center">' . $before . __( 'Add a menu', 'unisco' ) . $after . '</a>'
	        . $link_after;

	if ( ! current_user_can( 'manage_options' ) ) {
		$link = null;
	}
	// We have a list
	if ( false !== stripos( $items_wrap, '<ul' ) or false !== stripos( $items_wrap, '<ol' ) ) {
		$link = "<li class='nav-item'>$link</li>";
	}
	$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
	if ( ! empty ( $container ) ) {
		$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
	}
	if ( $echo ) {
		echo wp_kses( $output, array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
				'class' => array(),
				'id'    => array()
			)
		) );
	}

	return $output;
}

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 *
 * @return int (Maybe) modified excerpt length.
 */
function unisco_custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'unisco_custom_excerpt_length', 999 );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 *
 * @return string (Maybe) modified "read more" excerpt string.
 */
function unisco_excerpt_more( $more ) {
	return sprintf( '<br /><a class="read-more" href="%1$s">%2$s</a>',
		get_permalink( get_the_ID() ),
		__( 'Read More', 'unisco' )
	);
}
add_filter( 'excerpt_more', 'unisco_excerpt_more' );

function unisco_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:', 'unisco' ) . '</label>
    <input type="text" placeholder="' . esc_attr__( 'Search', 'unisco' ) . '" value="' . get_search_query() . '" name="s" id="s" class="blog-search" />
    <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search', 'unisco' ) . '" class="btn btn-warning btn-blogsearch text-uppercase" />
    </div>
    </form>';

	return $form;
}
add_filter( 'get_search_form', 'unisco_search_form', 100 );

function unisco_format_comment( $comment, $args, $depth ) {

	// $GLOBALS['comment'] = $comment; ?>

    <div <?php comment_class( 'row' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <div class="blodpost-tab-img">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), $size = '70' ); ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="blogpost-tab-description">
                        <h6 class="comment-author">
                            <a href="<?php echo esc_url( $comment->comment_author_url ); ?>"><?php echo esc_html( $comment->comment_author ); ?></a>
                        </h6>
						<?php comment_text(); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
                            <em><?php esc_html_e( 'Your comment is awaiting moderation.', 'unisco' ) ?></em><br/>
						<?php endif; ?>
                        <p class="blogpost-rply">
							<?php comment_reply_link( array_merge( $args, array( 'depth'     => $depth,
							                                                     'max_depth' => $args['max_depth']
							) ) ) ?>
                            <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>"><span><?php printf( '%1$s', get_comment_date(), get_comment_time() ) ?></span></a>
                        </p>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

<?php }

function unisco_comment_form_submit_button( $submit_button, $args ) {
	?>
    <div class="col-12">
        <input type="submit" name="<?php echo esc_attr( $args['name_submit'] ); ?>"
               value="<?php echo esc_attr( $args['label_submit'] ); ?>"
               class="<?php echo esc_attr( $args['class_submit'] ); ?>"/>
    </div>
    <!-- // end .col-12 -->
	<?php
}
add_filter( 'comment_form_submit_button', 'unisco_comment_form_submit_button', 10, 2 );

/**
 * function to darken hex color
 * https://coderwall.com/p/dvecdg/darken-hex-color-in-php
 *
 * @param string $rgb
 * @param int $darker
 *
 * @return string
 */
function unisco_darken_color( $rgb, $darker=2 ) {
	$hash = (strpos($rgb, '#') !== false) ? '#' : '';
	$rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
	if(strlen($rgb) != 6) return $hash.'000000';
	$darker = ($darker > 1) ? $darker : 1;

	list($R16,$G16,$B16) = str_split($rgb,2);

	$R = sprintf("%02X", floor(hexdec($R16)/$darker));
	$G = sprintf("%02X", floor(hexdec($G16)/$darker));
	$B = sprintf("%02X", floor(hexdec($B16)/$darker));

	return $hash.$R.$G.$B;
}

/**
 * Add custom form element to all widgets
 *
 * @param $t
 * @param $return
 * @param $instance
 *
 * @return array
 */
function unisco_in_widget_form( $t, $return, $instance ){
	if ( !isset( $instance['unisco_widget_size'] ) ) {
		$instance['unisco_widget_size'] = '12';
	}
	?>
    <p>
        <label for="<?php echo esc_attr( $t->get_field_id('unisco_widget_size') ); ?>"><?php echo esc_html('Size:','unisco'); ?></label>
        <select id="<?php echo esc_attr( $t->get_field_id('unisco_widget_size') ); ?>" name="<?php echo esc_attr( $t->get_field_name('unisco_widget_size') ); ?>">
            <option <?php selected( $instance['unisco_widget_size'], '1' ); ?> value="1">1</option>
            <option <?php selected( $instance['unisco_widget_size'], '2' ); ?> value="2">2</option>
            <option <?php selected( $instance['unisco_widget_size'], '3' ); ?> value="3">3</option>
            <option <?php selected( $instance['unisco_widget_size'], '4' ); ?> value="4">4</option>
            <option <?php selected( $instance['unisco_widget_size'], '5' ); ?> value="5">5</option>
            <option <?php selected( $instance['unisco_widget_size'], '6' ); ?> value="6">6</option>
            <option <?php selected( $instance['unisco_widget_size'], '7' ); ?> value="7">7</option>
            <option <?php selected( $instance['unisco_widget_size'], '8' ); ?> value="8">8</option>
            <option <?php selected( $instance['unisco_widget_size'], '9' ); ?> value="9">9</option>
            <option <?php selected( $instance['unisco_widget_size'], '10' ); ?> value="10">10</option>
            <option <?php selected( $instance['unisco_widget_size'], '11' ); ?> value="11">11</option>
            <option <?php selected( $instance['unisco_widget_size'], '12' ); ?> value="12">12</option>
        </select>
    </p>
	<?php
	return array( $t, $return, $instance );
}
add_action('in_widget_form', 'unisco_in_widget_form', 5, 3);

/**
 * Store custom form element value on widget save
 *
 * @param $instance
 * @param $new_instance
 * @param $old_instance
 *
 * @return mixed
 */
function unisco_in_widget_form_update( $instance, $new_instance, $old_instance ){
	$instance['unisco_widget_size'] = $new_instance['unisco_widget_size'];
	return $instance;
}
add_filter('widget_update_callback', 'unisco_in_widget_form_update',5,3);

/**
 * Modify widget output for custom form element
 *
 * @param $params
 *
 * @return mixed
 */
function unisco_dynamic_sidebar_params( $params ){
	global $wp_registered_widgets;
	$widget_id = $params[0]['widget_id'];
	$widget_obj = $wp_registered_widgets[$widget_id];
	$widget_opt = get_option( $widget_obj['callback'][0]->option_name );
	$widget_num = $widget_obj['params'][0]['number'];
	if( isset( $widget_opt[$widget_num]['unisco_widget_size'] ) )
		$size = 'col-md-' . $widget_opt[$widget_num]['unisco_widget_size'] . ' ';
	else
		$size = 'col-md-12 ';
	$params[0]['before_widget'] = preg_replace('/class="/', 'class="'.$size,  $params[0]['before_widget'], 1);
	return $params;
}
add_filter('dynamic_sidebar_params', 'unisco_dynamic_sidebar_params');