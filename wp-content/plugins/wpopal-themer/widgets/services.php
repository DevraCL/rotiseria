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
if( !class_exists( "Wpopal_Themer_Services_Widget" ) ){
    class Wpopal_Themer_Services_Widget extends Wpopal_Themer_Widget {
        public function __construct() {
            parent::__construct(
                // Base ID of your widget
                'wpopal_services_widget',
                // Widget name will appear in UI
                __('Opal Services', 'wpopal-themer'),
                // Widget description
                array( 'description' => __( 'Services', 'wpopal-themer' ), )
            );
            $this->widgetName = 'services';
        }

        /**
         * The main widget output function.
         * @param array $args
         * @param array $instance
         * @return string The widget output (html).
         */
        public function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            extract( $instance, EXTR_SKIP );

            $title = apply_filters( 'widget_title', $title );

            echo $before_widget;
                require($this->renderLayout('default'));
            echo $after_widget;
        }

        /**
         * The function for saving widget updates in the admin section.
         * @param array $new_instance
         * @param array $old_instance
         * @return array The new widget settings.
         */
         
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $new_instance = $this->default_instance_args( $new_instance );

            /* Strip tags (if needed) and update the widget settings. */
            $instance['title']   = strip_tags( $new_instance['title'] );
            $instance['helpline'] = $new_instance['helpline'];
            $instance['email'] = $new_instance['email'];
            $instance['workingdays'] = $new_instance['workingdays'];
            $instance['donatelink'] = $new_instance['donatelink'];

            return $instance;
        }

        /**
         * Output the admin form for the widget.
         * @param array $instance
         * @return string The output for the admin widget form.
         */
        public function form( $instance ) {
            $instance  = $this->default_instance_args( $instance );
            
        ?>
        <div class="wpopal_recentpost">
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpopal-themer' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'helpline' ) ); ?>"><?php esc_html_e( 'Helpline:', 'wpopal-themer' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'helpline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'helpline' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['helpline'] ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email:', 'wpopal-themer' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['email'] ); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'workingdays' ) ); ?>"><?php esc_html_e( 'Working days:', 'wpopal-themer' ); ?></label>
                <textarea rows="8" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'workingdays' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'workingdays' ) ); ?>"><?php echo esc_attr( $instance['workingdays'] ); ?></textarea>

            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'donatelink' ) ); ?>"><?php esc_html_e( 'Button link:', 'wpopal-themer' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'donatelink' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'donatelink' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['donatelink'] ); ?>" />
            </p>
        </div>
    <?php
        }

        /**
         * Accepts and returns the widget's instance array - ensuring any missing
         * elements are generated and set to their default value.
         * @param array $instance
         * @return array
         */
        protected function default_instance_args( array $instance ) {
            return wp_parse_args( $instance, array(
                'title'   => esc_html__( 'Services', 'wpopal-themer' ),
                'helpline'  => '',
                'email'  => '',
                'workingdays'  => '',
                'donatelink' => ''
            ) );
        }
    }

    register_widget( 'Wpopal_Themer_Services_Widget' );
}