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


class Wpopal_Themer_Popupnewsletter_Widget extends Wpopal_Themer_Widget{

    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'popupnewsletter',
            // Widget name will appear in UI
            __('Opal Popup Newsletter Widget', 'wpopal-themer'),
            // Widget description
            array( 'description' => __( 'Adds support Popup To Show Newsletter. ', 'wpopal-themer' ), )
        );

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));

        $this->widgetName = 'popupnewsletter';
    }

    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('upload_media_widget', plugin_dir_url(__FILE__) . '../assets/js/upload-media.js', array('jquery'));

        wp_enqueue_style('thickbox');
    }


    public function widget( $args, $instance ) {
        
        add_action('wp_enqueue_scripts', array( $this, 'initScripts' ));
        
      
          extract( $args );
          extract( $instance );
        $tpl =  'default' ;
         echo ($before_widget);
        //Display the name
        require($this->renderLayout($tpl));
        echo ($after_widget);
    }

    //Update the widget
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['description'] = $new_instance['description'];
        $instance['title'] = $new_instance['title'];
        $instance['image'] = $new_instance['image'];
        return $instance;
    }


    public function form( $instance ) {
        //Set up some default widget settings.
        $defaults = array('title' => 'Newsletter', 'description' => "Put your content here", 'image' => '');
        $instance = wp_parse_args( (array) $instance, $defaults );  ?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php _e('Title:', 'wpopal-themer');?></strong></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr( $instance['title'] ) ; ?>" class="widefat" />
        </p>
                

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'description' )); ?>"><?php _e( 'Description:', 'wpopal-themer' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id( 'description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'description' )); ?>"  cols="20" rows="3"><?php echo trim( $instance['description'] ) ; ?></textarea>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Image background:', 'wpopal-themer' ); ?></label>
            <input name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $instance['image'] ); ?>" />
            <input class="upload_image_button button button-primary" type="button" value="Upload Image" />
        </p>
      
        <?php
    }

    public function initScripts(){
   
    }
}

register_widget( 'Wpopal_Themer_Popupnewsletter_Widget' );

?>