<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php fresh_fnc_post_thumbnail(); ?>

	<header class="entry-header">

		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;
		?>

		<div class="entry-meta">
			<?php
				if ( 'post' == get_post_type() )
					fresh_fnc_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'fresh' ), esc_html__( '1 Comment', 'fresh' ), esc_html__( '% Comments', 'fresh' ) ); ?></span>
			<?php
				endif;

				edit_post_link( esc_html__( 'Edit', 'fresh' ), '<span class="edit-link">', '</span>' );
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			if(is_single()){
				the_content( sprintf(
					esc_html__( 'Continue reading %s', 'fresh').'<span class="meta-nav">&rarr;</span>',
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
			}else{
				the_excerpt();
			}

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'fresh' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

</article><!-- #post-## -->
