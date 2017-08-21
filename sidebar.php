<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package unisco
 */

if( isset( $post ) ){
	$meta = get_post_meta( $post->ID, 'unisco_options', true );
} else {
	$meta  = array();
}

if( ! isset( $meta['sidebar'] ) || empty( $meta['sidebar'] ) ){
	$meta['sidebar'] = 'sidebar-1';
	if( $post_type === 'course' ){
		$meta['sidebar'] = 'course';
    }
}

if ( ! is_active_sidebar( $meta['sidebar'] ) ) {
	return;
}

unisco_sidebars_before();
?>

<div class="col-md-4">
    <aside id="secondary" class="widget-area" role="complementary">
		<?php
        unisco_sidebar_top();
        dynamic_sidebar( $meta['sidebar'] );
		unisco_sidebar_bottom();
        ?>
    </aside><!-- #secondary -->
</div><!-- .col-md-4 -->

<?php unisco_sidebars_after(); ?>