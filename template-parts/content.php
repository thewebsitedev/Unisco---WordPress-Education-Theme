<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

$hide_post_meta = apply_filters( 'unisco_post_hide_meta', get_theme_mod( 'unisco_post_single_hide_meta', 'no' ) );
$hide_footer_meta = apply_filters( 'unisco_post_hide_footer_meta', get_theme_mod( 'unisco_post_single_hide_footer_meta', 'no' ) );

unisco_entry_before();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single-item' ); ?>>
    <?php unisco_entry_top();
    $post_thumbnail = get_the_post_thumbnail();
    if ( '' !== get_the_post_thumbnail() || !empty( unisco_header_menu_class() ) ) : ?>
        <header class="entry-header">
		    <?php if ( '' !== get_the_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
				    <?php the_post_thumbnail( 'unisco-featured-image', array( 'class' => 'img-fluid' ) ); ?>
                </div><!-- .post-thumbnail -->
			    <?php
		    endif;
		    // Display if slider
		    if( !empty( unisco_header_menu_class() ) ) {
			    get_template_part( 'template-parts/content', 'title' );
		    }
		    ?>
        </header><!-- .entry-header -->
    <?php endif; ?>

    <div class="entry-content blog-title_block">
	    <?php
        unisco_entry_title();
	    if( is_archive() || is_home() ) :
	    ?>
        <h4><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h4>
        <?php
        endif;
        if( $hide_post_meta == 'no' ) :
        ?>
        <h6>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"><i class="fa fa-user" aria-hidden="true"></i><span><?php the_author(); ?></span></a>
			<?php unisco_post_meta(); ?>
        </h6>
		<?php
        endif;
		// if default blog page, category page or any archive page
		// then display excerpt else whole content
		// is_home() || is_category() || is_archive()
		the_content( sprintf(
			/* translators: %s: Name of current post. */
			__( 'Read more %s', 'unisco' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'unisco' ),
			'after'  => '</div>',
		) );
		?>
    </div><!-- .entry-content -->

	<?php
	if( $hide_footer_meta == 'no' && !is_page() ){
		get_template_part( 'template-parts/content', 'footer' );
	}
	unisco_entry_bottom();
	?>
</article><!-- #post-## -->

<?php unisco_entry_after(); ?>
