<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single-item' ); ?>>
    <header class="entry-header">
		<?php if ( '' !== get_the_post_thumbnail() ) : ?>
            <div class="post-thumbnail blog-img_block">
				<?php the_post_thumbnail( 'unisco-featured-image', array( 'class' => 'img-fluid' ) ); ?>
                <div class="blog-date">
                    <span><?php unisco_posted_date(); ?></span>
                </div>
            </div><!-- .post-thumbnail -->
		<?php endif;
		if ( ! is_single() ) :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
    </header><!-- .entry-header -->

    <div class="entry-content blog-title_block">
        <h6>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>"><i
                        class="fa fa-user" aria-hidden="true"></i><span><?php the_author(); ?></span></a>
			<?php unisco_post_meta(); ?>
        </h6>
		<?php
		the_excerpt();
		?>
    </div><!-- .entry-summary -->

	<?php get_template_part( 'template-parts/content', 'footer' ); ?>
</article><!-- #post-## -->
