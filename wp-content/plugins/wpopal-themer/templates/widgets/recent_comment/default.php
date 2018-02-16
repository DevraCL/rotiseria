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
?>

<div class="comment-widget widget-content">
    <?php
    $number = $instance['number_comment'];
    $all_comments=get_comments( array('status' => 'approve', 'number'=>$number) );
    if(is_array( $all_comments)){
        foreach($all_comments as $comment) { ?>
        <article class="clearfix">
            <div class="avatar-comment-widget">
                <?php echo get_avatar($comment, '70'); ?>
            </div>
            <div class="content-comment-widget">
                <h6>
                    <?php echo strip_tags($comment->comment_author); ?> <?php esc_html__('says', 'wpopal-themer' ); ?>:
                </h6>
                <div class="comment-text-side">
                    <?php echo wpopal_themer_string_limit_words(strip_tags($comment->comment_content), 30); ?>
                </div>
            </div>
        </article>
    <?php } 
    } ?>
</div>