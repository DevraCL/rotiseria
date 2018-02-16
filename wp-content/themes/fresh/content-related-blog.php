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
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <?php the_post_thumbnail('full'); ?>
        </div>
        <?php if(has_post_thumbnail()): ?>
            <div class="col-lg-8 col-md-12 content clearfix">
        <?php endif;?>
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
                <span class="comments-link"><span class="fa fa-comment-o"></span> <?php comments_popup_link( esc_html__( 'comment', 'fresh' ), esc_html__( '1 Comment', 'fresh' ), esc_html__( '% Comments', 'fresh' ) ); ?></span>
                <?php endif; ?>
               
            </div><!-- .entry-meta -->
        <?php if(has_post_thumbnail()): ?>
            </div>
        <?php endif;?>
    </div>
        
</article><!-- #post-## -->
