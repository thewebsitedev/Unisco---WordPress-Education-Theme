<?php
if ( is_singular() && !is_front_page() ): ?>
    <div class="row">
        <div class="col-md-12">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </div>
    </div>
<?php elseif ( is_search() ): ?>
    <div class="row">
        <div class="col-md-12">
            <header class="page-header">
                <h1 class="entry-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'unisco' ), '<span>' . get_search_query() . '</span>' );
					?>
                </h1>
            </header><!-- header -->
        </div>
    </div>
<?php elseif ( is_404() ): ?>
    <div class="row">
        <div class="col-md-12">
            <header class="page-header">
                <h1 class="entry-title">
					<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'unisco' ); ?>
                </h1>
            </header><!-- header -->
        </div>
    </div>
<?php
    // if it is a blog page display page title
    elseif ( is_home() && !is_front_page() ): ?>
    <div class="row">
        <div class="col-md-12">
            <header class="page-header">
                <h1 class="entry-title">
	                <?php single_post_title(); ?>
                </h1>
            </header><!-- header -->
        </div>
    </div>
<?php endif;
if ( is_archive() ): ?>
    <div class="row">
        <div class="col-md-12">
            <header class="page-header">
				<?php
				the_archive_title( '<h1 class="entry-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
            </header><!-- header -->
        </div>
    </div>
<?php endif; ?>