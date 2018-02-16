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
        <div class="post-preview clearfix">        
            <?php the_post_thumbnail('full'); ?>
            <div class="meta">
                <span class="author"><?php esc_html_e('by', 'fresh'); the_author_posts_link(); ?></span>
                <div class="entry-category">
                    <?php esc_html_e('in', 'fresh'); the_category(); ?>
                </div>
            </div>
        </div>        
        <?php if(has_post_thumbnail()): ?>
        	<div class="blog-content clearfix">
        <?php endif;?>
            <div class="entry-content">
        		<header class="entry-header">
        			<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && fresh_fnc_categorized_blog() ) : ?>

        			<?php
        				endif;
        					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
        			?>
                    <div class="entry-meta">                        
                        <span class="date">
                            <?php
                                if ( 'post' == get_post_type() )
                                    fresh_fnc_posted_on();
                                if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
                                    endif;
                            ?>
                        </span>
                        <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                        <span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'Leave a comment', 'fresh' ), esc_html__( '1 Comment', 'fresh' ), esc_html__( '% Comments', 'fresh' ) ); ?></span>
                        <?php endif; ?>
                        <?php
                            edit_post_link( esc_html__( 'Edit', 'fresh' ), '<span class="edit-link">', '</span>' );
                             ?>
                    </div><!-- .entry-meta -->
        		</header><!-- .entry-header -->        		

        		<div class="excerpt">
                    <?php
                        /* translators: %s: Name of current post */
                        
                         the_excerpt();
                         
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'fresh' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        ) );
                    ?>
                </div><!-- .entry-content -->
    		</div>
        <?php if(has_post_thumbnail()): ?>
            </div>
        <?php endif;?>
	<!-- .entry-content -->
</article><!-- #post-## -->
