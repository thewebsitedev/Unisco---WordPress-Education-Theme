<footer class="entry-footer">
	<div class="blog-icons">
        <div class="blog-share_block">
            <?php if( !is_page() ) : ?>
            <a href="<?php the_permalink(); ?>" class="entry-date pull-left">
		        <?php unisco_posted_date(); ?>
            </a>
	        <?php endif; do_action('unisco_post_footer'); ?>
        </div>
	</div>
</footer><!-- .entry-footer -->