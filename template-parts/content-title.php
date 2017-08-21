<?php
if ( is_singular() && !is_front_page() ): ?>
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php elseif ( is_search() ): ?>
    <h1 class="entry-title">
        <?php
        /* translators: %s: search query. */
        printf( esc_html__( 'Search Results for: %s', 'unisco' ), '<span>' . get_search_query() . '</span>' );
        ?>
    </h1>
<?php elseif ( is_404() ): ?>
    <h1 class="entry-title">
        <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'unisco' ); ?>
    </h1>
<?php
    // if it is a blog page display page title
    elseif ( is_home() && !is_front_page() ): ?>
    <h1 class="entry-title">
        <?php single_post_title(); ?>
    </h1>
<?php endif;
if ( is_archive() ): ?>
    <?php
    the_archive_title( '<h1 class="entry-title">', '</h1>' );
    the_archive_description( '<div class="archive-description">', '</div>' );
    ?>
<?php endif; ?>