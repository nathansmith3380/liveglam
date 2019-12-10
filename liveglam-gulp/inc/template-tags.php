<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'liveglam_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function liveglam_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'liveglam_gulp' ),
		'<i class="fas fa-calendar"></i><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'liveglam_gulp' ),
		'<span class="author vcard"><i class="fas fa-user"></i><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	
/*$postcats = get_the_category();
$total = count($postcats);
$counter=0;
if ($postcats) {
	
	echo '<i class="fas fa-folder-open"></i>';
	foreach($postcats as $cat) {
		$counter++;

		echo '<a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a>';
		if ($counter < $total){echo ", ";}

	}
}*/

/*$posttags = get_the_tags();
$total = count($posttags);
$counter=0;
if ($posttags) {
	
	echo '<i class="fas fa-tags"></i>';
	foreach($posttags as $tag) {
		$counter++;

		echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
		if ($counter < $total){echo ", ";}

	}
}
*/

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<i class="fas fa-comment"></i><span class="comments-link">';
		comments_popup_link( esc_html__( '0 Comments', 'liveglam_gulp' ), esc_html__( '1 Comment', 'liveglam_gulp' ), esc_html__( '% Comments', 'liveglam_gulp' ) );
		echo '</span>';
	}


}

endif;

if ( ! function_exists( 'liveglam_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function liveglam_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'liveglam_gulp' ) );
		if ( $categories_list && liveglam_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'liveglam_gulp' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'liveglam_gulp' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'liveglam_gulp' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'liveglam_gulp' ), esc_html__( '1 Comment', 'liveglam_gulp' ), esc_html__( '% Comments', 'liveglam_gulp' ) );
		echo '</span>';
	}

	edit_post_link(
		//sprintf(
			/* translators: %s: Name of current post */
			//esc_html__( 'Edit %s', 'liveglam_gulp' ),
			//the_title( '<span class="screen-reader-text">"', '"</span>', false )
		//),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function liveglam_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'liveglam_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'liveglam_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so liveglam_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so liveglam_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in liveglam_categorized_blog.
 */
function liveglam_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'liveglam_categories' );
}
add_action( 'edit_category', 'liveglam_category_transient_flusher' );
add_action( 'save_post',     'liveglam_category_transient_flusher' );
