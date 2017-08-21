<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unisco
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	$comment_count = get_comments_number();
	$have_comments = have_comments();
	?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs blogpost-tab-wrap" role="tablist">
        <li class="nav-item blogpost-nav-tab">
            <a class="nav-link <?php echo $have_comments ? 'active' : ''; ?>" data-toggle="tab" href="#read-comments"
               role="tab">
				<?php
				/* translators: %s: Total number of comments. */
				echo sprintf( esc_html__( 'Comments (%s)', 'unisco' ), intval( $comment_count ) );
				?>
            </a>
        </li>
        <li class="nav-item blogpost-nav-tab hidden-print">
            <a class="nav-link <?php echo $have_comments ? '' : 'active'; ?>" data-toggle="tab" href="#write-comment"
               role="tab"><?php esc_html_e( 'Write a Comment', 'unisco' ); ?></a>
        </li>
    </ul>
    <div class="clearfix"></div>
    <div class="blogpost-tabs">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane <?php echo $have_comments ? 'active' : ''; ?>" id="read-comments" role="tabpanel">
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'unisco' ); ?></h2>
                        <div class="nav-links">

                            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'unisco' ) ); ?></div>
                            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'unisco' ) ); ?></div>

                        </div><!-- .nav-links -->
                    </nav><!-- #comment-nav-above -->
				<?php endif; // Check for comment navigation. ?>
				<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback'   => 'unisco_format_comment'
				) );
				?>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'unisco' ); ?></h2>
                        <div class="nav-links">

                            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'unisco' ) ); ?></div>
                            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'unisco' ) ); ?></div>

                        </div><!-- .nav-links -->
                    </nav><!-- #comment-nav-below -->
					<?php
				endif; // Check for comment navigation.
				// If comments are closed and there are comments, let's leave a little note, shall we?
				if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
                    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'unisco' ); ?></p>
				<?php endif; ?>
            </div>
            <div class="tab-pane hidden-print <?php echo $have_comments ? '' : 'active'; ?>" id="write-comment" role="tabpanel">
				<?php

				$commenter       = wp_get_current_commenter();
				$req             = get_option( 'require_name_email' );
				$aria_req        = $req ? " aria-required='true'" : '';
				$req_class       = $req ? ' has-danger' : '';
				$req_input_class = $req ? ' form-control-danger' : '';

				$fields = array(

					'author' =>
						'<div class="col-4"><div class="form-group"><label for="name">' . __( 'Full Name', 'unisco' ) . '</label><input id="name" name="author"  type="text" class="form-control" placeholder="' . __( 'Full Name', 'unisco' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . '></div><!-- // end .form-group --></div>',

					'email' =>
						'<div class="col-4"><div class="form-group"><label for="email">' . __( 'Email ID', 'unisco' ) . '</label><input id="email" name="email"  type="text" class="form-control" placeholder="' . __( 'Email ID', 'unisco' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . '></div><!-- // end .form-group --></div>',

					'url' =>
						'<div class="col-4"><div class="form-group"><label for="url">' . __( 'Website URL', 'unisco' ) . '</label><input id="url" name="url"  type="text" class="form-control" placeholder="' . __( 'Website URL', 'unisco' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '"></div><!-- // end .form-group --></div>',
				);

				$args = array(
					'id_form'           => 'commentform',
					'class_form'        => 'row comment-form',
					'id_submit'         => 'submit',
					'class_submit'      => 'btn btn-warning',
					'name_submit'       => 'submit',
					'title_reply'       => '',
					/* translators: %s: Author of the comment being replied to. */
					'title_reply_to'    => __( 'Leave a Reply to %s', 'unisco' ),
					'cancel_reply_link' => __( 'Cancel Reply', 'unisco' ),
					'label_submit'      => __( 'Submit Comment', 'unisco' ),
					'format'            => 'html5',

					'comment_field' => '<div class="col-12"><div class="form-group"><label for="">' . _x( 'Comment', 'noun', 'unisco' ) . '</label><textarea class="form-control" rows="6" maxlength="65525" ></textarea></div><!-- // end .form-group --></div>',

					'must_log_in' => '<div class="col-12"><p class="must-log-in">' .
					                 sprintf(
					                 /* translators: %s: Login URL. */
						                 __( 'You must be <a href="%s">logged in</a> to post a comment.', 'unisco' ),
						                 wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
					                 ) . '</p></div>',

					'logged_in_as' => '<div class="col-12"><p class="logged-in-as">' .
					                  sprintf(
					                  /* translators: %1$s: Logged in user's profile URL. %2$s: Logged in user's name. %3$s: Log out URL. */
						                  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'unisco' ),
						                  admin_url( 'profile.php' ),
						                  $user_identity,
						                  wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
					                  ) . '</p></div>',

					'comment_notes_before' => '',
					'comment_notes_after'  => '',

					'fields' => apply_filters( 'comment_form_default_fields', $fields ),
				);

				comment_form( $args );

				?>
            </div>
        </div>
    </div>
</div><!-- #comments -->
