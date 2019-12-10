<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Liveglam
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php 
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			?>
			<div class="date-box">
        
        	<div class="day">
            	<?php echo date("M", strtotime($post->post_date)).'&nbsp;/'; ?>
            </div>

           
            <div class="month">
            	<?php echo date("d", strtotime($post->post_date)); ?>
            </div>
        
        </div>
        <?php
			the_post_thumbnail('large');
		} 
		?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php liveglam_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_excerpt( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'liveglam_gulp' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'liveglam_gulp' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

		<a class="theme-button" href="<?php the_permalink();?>"> <?php echo esc_html__( 'Read More', 'liveglam_gulp' ); ?> </a>

	<footer class="entry-footer">
		<?php liveglam_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

