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

class Wpopal_Themer_Menu_Vertical extends Wpopal_Themer_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'wpopal_menu_vertical',
            // Widget name will appear in UI
            __('Opal Menu Vertical Widget', 'wpopal-themer'),
            // Widget description
            array( 'description' => __( 'Show Menu Vertical', 'wpopal-themer' ), )
        );
        $this->widgetName = 'menu_vertical';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $title = apply_filters( 'widget_title', $title );
        echo str_replace('widget_wpopal_menu_vertical', 'widget_wpopal_menu_vertical '.$layout, $before_widget);
            require($this->renderLayout( 'default'));
        echo    $after_widget;
    }
    // Widget Backend
    public function form( $instance ) {
        $d = array(
            'menu' => '',
            'position' => ''
        );
        $instance  = $this->default_instance_args( $instance );
        $instance = array_merge( $d, $instance );

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( '', 'wpopal-themer' );
        }
        
        if ( isset( $instance[ 'menu' ] ) ) {
            $wpopal_menu = $instance[ 'menu' ];
        }else {
            $wpopal_menu = array();
        }
        
        // Widget admin form        
        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
        foreach ($menus as $menu) {
            $option_menu[$menu->slug]=$menu->name;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'wpopal-themer' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'menu' )); ?>">Menu:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'menu' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'menu' )); ?>">
                <option value="" <?php selected( $wpopal_menu, $menu->term_id ); ?>> <?php _e('---Select Menu---', 'wpopal-themer'); ?></option>
                <?php foreach ($menus as $key => $menu): ?>
                    <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $instance['menu'], $menu->term_id ); ?>><?php echo esc_html( $menu->name ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'position' )); ?>">Position:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'position' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'position' )); ?>">
                <option value="left" <?php selected( $instance['position'], 'left' ); ?>><?php _e( 'Left:', 'wpopal-themer' ); ?></option>
                <option value="right" <?php selected( $instance['position'], 'right' ); ?>><?php _e( 'Right:', 'wpopal-themer' ); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>">Template Style:</label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>">
                <?php foreach ($this->selectLayout() as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['layout'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
<?php
    }

    public function selectLayout() {
        $args = array(
            'style_1'=>'Style 1',
            'style_2'=>'Style 2',
            'style_3'=>'Style 3'
        );
        $layouts = apply_filters('wpopal_filter_widget_layout_option',$args);
        return $layouts;
    }

    public function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['menu'] = $new_instance['menu'];
        $instance['position'] = $new_instance['position'];
        $instance['layout'] = $new_instance['layout'];

        return $instance;

    }

    /**
     * Accepts and returns the widget's instance array - ensuring any missing
     * elements are generated and set to their default value.
     * @param array $instance
     * @return array
     */
    protected function default_instance_args( array $instance ) {
        return wp_parse_args( $instance, array(
            'title'   => esc_html__( 'Vertical Menu', 'wpopal-themer' ),
            'layout'   => 'style_1',
        ) );
    }
}

register_widget( 'Wpopal_Themer_Menu_Vertical' );