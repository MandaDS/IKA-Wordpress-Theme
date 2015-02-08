<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments">
    <?php if ( have_comments() ) : ?>
    <h2>
        <?php
        printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'ikaink' ),
                number_format_i18n( get_comments_number() ), get_the_title() );
        ?>
    </h2>

    <!-- comment-list -->
    <div class="comment-list">
        <ul>
            <?php wp_list_comments( 'type=comment&callback=ikaink_comment' ); ?>
        </ul>
    </div>
    <!-- comment-list -->

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav class="comment-nav">
            <?php previous_comments_link( __( '<button type="button" class="nav-previous btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> More Comments</button>', 'ikaink' ) ); ?>
            <?php next_comments_link( __( '<button type="button" class="nav-next btn btn-default">More Comments <span class="glyphicon glyphicon-chevron-right"></span> </button>', 'ikaink' ) ); ?>
    </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>

    <?php if ( ! comments_open() ) : ?>
    <h3 class="no-comments"><?php _e( 'Comments are closed.', 'ikaink' ); ?></h3>
    <?php endif; ?>
    <?php endif; // have_comments() ?>

    <!-- comment-form -->
    <?php 
    $args = array(
     'comment_notes_after' => '<p class="form-allowed-tags">' .
      sprintf(
      __( 'You may use <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
      ' <code>' . allowed_tags() . '</code>') . '</p>'  
    );
    comment_form($args);
    ?>
    <!-- comment-form -->
</div>
<!-- #comments -->