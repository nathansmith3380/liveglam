<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
  return;
}
?>

<div id="comments" class="comments-area comments">
  <?php

  $commenter = wp_get_current_commenter();
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  $fields =  array(
    'author' => '<div class="third"><p class="comment-form-author">' . '<input id="author" placeholder="' . esc_html__( 'Name', 'liveglam_gulp' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' /></p></div>',
    'email' => '<div class="third"><p class="comment-form-email">'.'<input id="email" name="email" placeholder="' . esc_html__( 'Email', 'liveglam_gulp' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' /></p></div>',
    //'url' => '<div class="third"><p class="comment-form-url">' . '<input id="url" name="url" placeholder = "' . esc_html__( 'Website', 'liveglam_gulp' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  /></p></div>',
  );
  $comments_args = array(

    'comment_field' => '<p class="comment-form-comment"><br /><textarea id="comment" name="comment" rows="5" placeholder="' . esc_html_x( 'Message', 'noun', 'liveglam_gulp' ) . '" aria-required="true"></textarea></p>',
    //'comment_field' => '<input class="form-control" placeholder="Add a Comment…" type="text" name="comment" id="comment">',

    'fields' => apply_filters( 'comment_form_default_fields', $fields),
    'label_submit' => 'submit',
    'submit_button' => '<button name="submit" type="submit" id="submit" class="submit btn-primary" value="submit">Submit</button>',
  );

  comment_form($comments_args);

  ?>

  <?php if ( have_comments() ) : ?>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
          <nav id="comment-nav-above" class="navigation comment-navigation">
              <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'liveglam_gulp' ); ?></h2>
              <div class="nav-links">

                  <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'liveglam_gulp' ) ); ?></div>
                  <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'liveglam_gulp' ) ); ?></div>

              </div><!-- .nav-links -->
          </nav><!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation. ?>
    <p class="commentlist-title">Share your thoughts</p>

      <ul class="commentlist">
        <?php wp_list_comments( 'type=comment&callback=mytheme_comment' ); ?>
      </ul>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
          <nav id="comment-nav-below" class="navigation comment-navigation">
              <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'liveglam_gulp' ); ?></h2>
              <div class="nav-links">

                  <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'liveglam_gulp' ) ); ?></div>
                  <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'liveglam_gulp' ) ); ?></div>

              </div><!-- .nav-links -->
          </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>

  <?php endif; // Check for have_comments(). ?>

  <?php
  // If comments are closed and there are comments, let's leave a little note, shall we?
  if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
      <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'liveglam_gulp' ); ?></p>
  <?php endif; ?>

</div><!-- #comments -->
<style>
    img.avatar.avatar-55.photo {
        width: 55px !important;
        height: 55px !important;
    }
</style>