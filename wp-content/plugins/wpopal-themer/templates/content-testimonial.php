<?php
    $link = get_post_meta( get_the_ID(), 'testimonials_link', true );
    $job = get_post_meta( get_the_ID(), 'testimonials_job', true );
    $excerpt = explode(' ', strip_tags(get_the_content( )), 15);
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);

?>
<div class="testimonials">
    <div class="testimonials-body">
        <p class="testimonials-description"><?php echo trim( $excerpt ); ?></p>                            
        <ul class="testimonials-avatar list-unstyled">
            <li class="active">
                 <div class="radius-x"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?></div>
            </li>                       
        </ul>                        
        <h5 class="testimonials-name">
            <?php the_title(); ?>
        </h5>  
        <p class="text-muted testimonials-position">
            <a href="<?php echo empty($link) ? '#' : esc_url( $link ); ?>">
                <?php echo empty($job) ? '' : trim( $job ); ?>
            </a>
        </p>  
    </div>                      
</div>