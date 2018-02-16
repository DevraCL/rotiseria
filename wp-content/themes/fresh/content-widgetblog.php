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

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-v1 '); ?>> 
        <div class="image">   
        <?php the_post_thumbnail('thumbnail'); ?>
        </div>
        <div class="content-widget">
            <div class="entry-content">
                <header class="entry-header">
                    <?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && fresh_fnc_categorized_blog() ) : ?>

                    <?php
                        endif;
                            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                    ?>
                </header><!-- .entry-header -->
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
                    <span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'comment', 'fresh' ), esc_html__( '1 Comment', 'fresh' ), esc_html__( '% Comments', 'fresh' ) ); ?></span>
                    <?php endif; ?>
                    
                    <?php
                        edit_post_link( esc_html__( 'Edit', 'fresh' ), '<span class="edit-link">', '</span>' );
                    ?>
                    <div class="author"><i class="fa fa-heart-o text-primary" aria-hidden="true"></i> <?php the_author_posts_link(); ?></div>
                </div><!-- .entry-meta -->

                <?php
                    /* translators: %s: Name of current post */
                    //echo fresh_fnc_excerpt( 24, '...' );
                ?>
                
            </div>
            <div class="readmore">
                <a class="btn btn-outline btn-default" href="<?php echo esc_url( get_permalink( ) ); ?>"><?php esc_html_e('Read more', 'fresh') ?></a>
            </div>
        </div>
    <!-- .entry-content -->
</article><!-- #post-## -->
