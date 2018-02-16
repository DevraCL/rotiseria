<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wordpress Opal Team <opalwordpress@gmail.com >
 * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
// Display the widget title
if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}

$query = new WP_Query( array( 'posts_per_page' => $instance[ 'number_post' ] ) );
$_count = 0;

if($query->have_posts()){
?>
	<div class="blog-post">
	<?php while ( $query->have_posts() ): $query->the_post(); ?>
		<?php if($_count%$instance[ 'number_rows' ] ==0): ?>
				<div class="item">
		<?php endif; ?>
			<div class="image-thumnail">
				<div class="post-thumbnail">
					<?php if(has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="bottom-blog">
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					echo wpopal_themer_fnc_excerpt( 10, '...' );
				?>
				</div><!-- .entry-content -->
				<div class="entry-date">
		        <span><?php the_time( 'd' ); ?></span>&nbsp;<?php the_time( 'M' ); ?>&nbsp;<?php the_time( 'Y' ); ?>
		    </div>
			</div>
		<?php if($_count%$instance[ 'number_rows' ] == $instance[ 'number_rows' ]-1 || $_count==$query->post_count()-1): ?>
				</div>
		<?php endif; ?>
		<?php $_count++; ?>
	<?php endwhile; ?>
	</div>
<?php } ?>
<?php wp_reset_postdata(); ?>