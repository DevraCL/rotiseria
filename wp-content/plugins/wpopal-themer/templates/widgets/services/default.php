<div class="box-top hidden-sm hidden-xs">
    <div class="box-service-top">
        <div class="box-content media">
            <div class="icon pull-left">
                <i class="fa fa-phone-square">&nbsp;</i>
            </div>
            <div class="description  media-body">
                <h5 class="title">
                    <?php _e('Helpline', 'wpopal-themer') ?>:
                </h5>
                <span>
                    <?php echo $instance['helpline'] ?>
                </span>
            </div>
        </div>
    </div>

    <div class="box-service-top hidden-md">
        <div class="box-content media">
            <div class="icon pull-left">
                <i class="fa fa-envelope-o">&nbsp;</i>
            </div>
            <div class="description  media-body">
                <h5 class="title">
                    <?php _e('Any question, email us', 'wpopal-themer') ?>:
                </h5>
                <span>
                    <?php echo $instance['email'] ?>
                </span>
            </div>
        </div>
    </div>
    <div class="box-service-top">
        <div class="box-content media">
            <div class="icon pull-left">
                <i class="fa fa-clock-o">&nbsp;</i>
            </div>
            <div class="description media-body">
                <h5 class="title">
                    <?php _e('Working days', 'wpopal-themer') ?>:
                </h5>
                <span>
                    <?php echo $instance['workingdays'] ?>
                </span>
            </div>
        </div>
    </div>
    <div class="box-service-top">
        <div class="box-content">
            <a href="<?php echo esc_url( $instance['donatelink'] );  ?>" class="btn btn-default"><?php _e('Click here', 'wpopal-themer') ?></a>
        </div>
    </div>

</div>