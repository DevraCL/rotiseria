<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package WpOpal
 * @subpackage Fresh
 * @since Fresh 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 	<div class="post-preview">
		<?php fresh_fnc_post_thumbnail(); ?>
        <div class="meta">
            <div class="entry-category">
                <?php esc_html_e('in', 'fresh'); the_category(); ?>
            </div>
            <span class="author"><?php esc_html_e('by', 'fresh'); the_author_posts_link(); ?></span>
        </div>
	</div>
    <?php if(has_post_thumbnail()): ?>
            <div class="blog-info">
        <?php endif;?>
    
        <div class="blog-detail">
        	<header class="entry-header">
        		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && fresh_fnc_categorized_blog() ) : ?>

        		<?php
        			endif;

        			if ( is_single() ) :
        				the_title( '<h1 class="entry-title">', '</h1>' );
        			else :
        				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
        			endif;
        		?>

        		<div class="entry-meta">
                    
        			<span class="entry-date">
                        <span><?php the_time( 'd' ); ?></span>&nbsp;<?php the_time( 'M' ); ?>
                    </span>                   

        			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
        			<span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'fresh' ), esc_html__( '1 Comment', 'fresh' ), esc_html__( '% Comments', 'fresh' ) ); ?></span>
        			<?php endif; ?>

        			<?php edit_post_link( esc_html__( 'Edit', 'fresh' ), '<span class="edit-link">', '</span>' ); ?>
        		</div><!-- .entry-meta -->
        	</header><!-- .entry-header -->

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

        	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
        </div>
    <?php if(has_post_thumbnail()): ?>
        </div>
    <?php endif;?>
</article><!-- #post-## -->
