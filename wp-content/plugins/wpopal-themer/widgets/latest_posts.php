<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

class Wpopal_Themer_Latest_Posts extends Wpopal_Themer_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'wpopal_latest_posts',
            // Widget name will appear in UI
            __('Opal Latest Post Widget', 'wpopal-themer'),
            // Widget description
            array( 'description' => __( 'Show list of latest posts', 'wpopal-themer' ), )
        );
        $this->widgetName = 'latest_posts';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );
        $title = apply_filters( 'widget_title', $title );
         echo ($before_widget);
            require($this->renderLayout( 'default'));
        echo ($after_widget);
    }
// Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'Latest news', 'wpopal-themer' );
        }

        if(isset($instance[ 'number_post' ])){
            $number_post = $instance[ 'number_post' ];
        }else{
            $number_post = 5;
        }

        if(isset($instance[ 'number_rows' ])){
            $number_rows = $instance[ 'number_rows' ];
        }else{
            $number_rows = 1;
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'wpopal-themer' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>"><?php _e( 'Number Posts:', 'wpopal-themer' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_post' )); ?>" type="text" value="<?php echo  esc_attr( $number_post ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number_rows' )); ?>"><?php _e( 'Number Rows:', 'wpopal-themer' ); ?></label>
            <select name="<?php echo esc_attr($this->get_field_name( 'number_rows' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'number_rows' )); ?>">
                <?php for ($_count=1; $_count <=5; $_count++): ?>
                    <option value="<?php echo esc_attr( $_count ); ?>" <?php selected( $number_rows, $_count ); ?>><?php echo esc_html( $_count ); ?></option>
                <?php endfor; ?>
            </select>
        </p>

<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'Latest News';
        $instance['number_post'] = ( ! empty( $new_instance['number_post'] ) ) ? strip_tags( $new_instance['number_post'] ) : 5;
        $instance['number_rows'] = ( ! empty( $new_instance['number_rows'] ) ) ? strip_tags( $new_instance['number_rows'] ) : 1;
        return $instance;

    }
}

register_widget( 'Wpopal_Themer_Latest_Posts' );