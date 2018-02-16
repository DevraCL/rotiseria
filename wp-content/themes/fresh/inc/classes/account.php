<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
class Fresh_OPAL_User_Account{

	/**
	 * @var boolean $ispopup
	 */
	private $ispopup = true;

	/**
	 * Constructor
	 */
	public function __construct(){

		add_action('init', array($this,'setup'), 1000);
		add_action( 'wp_ajax_nopriv_opalajaxlogin',  array($this,'ajaxDoLogin') );
		add_action( 'wp_ajax_nopriv_opalajaxlostpass',  array($this,'doForgotPassword') );
		add_action( 'wp_ajax_nopriv_opalajaxregister',  array($this,'ajaxDoRegister') );
	}


	/**
	 * process login function with ajax request
	 *
 	 * ouput Json Data with messsage and login status
	 */
	public function ajaxDoLogin(){
		// First check the nonce, if it fails the function will break
   		check_ajax_referer( 'ajax-opal-login-nonce', 'security_login' );
   		$result = $this->doLogin($_POST['wpopal_username'], $_POST['wpopal_password'],  isset($_POST['remember']) );

   		echo trim($result);
   		die();
	}


	/**
	 * process user login with username/password
	 *
	 * return Json Data with messsage and login status
	 */
	public function doLogin( $username, $password, $remember=false ){
		$info = array();

   		$info['user_login'] = $username;
	    $info['user_password'] = $password;
	    $info['remember'] = $remember;

		$user_signon = wp_signon( $info, false );
	    if ( is_wp_error($user_signon) ){
			return json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password. Please try again!!!', 'fresh')));
	    } else {
			wp_set_current_user($user_signon->ID);
	        return json_encode(array('loggedin'=>true, 'message'=>esc_html__('Signin successful, redirecting...', 'fresh')));
	    }
	}

	public function registration_validation( $firstname, $lastname, $username, $email, $password, $confirmpassword )  {
		global $reg_errors;
		$reg_errors = new WP_Error;
		if ( empty($firstname) || empty( $username ) || empty( $password ) || empty( $email ) || empty( $confirmpassword ) ) {
		    $reg_errors->add('field', esc_html__( 'Required form field is missing', 'fresh' ) );
		}

		if ( 4 > strlen( $username ) ) {
		    $reg_errors->add( 'username_length', esc_html__( 'Username too short. At least 4 characters is required', 'fresh' ) );
		}

		if ( username_exists( $username ) ) {
	    	$reg_errors->add('user_name', esc_html__( 'Sorry, that username already exists!', 'fresh' ) );
		}

		if ( ! validate_username( $username ) ) {
		    $reg_errors->add( 'username_invalid', esc_html__( 'Sorry, the username you entered is not valid', 'fresh' ) );
		}

		if ( 5 > strlen( $password ) ) {
	        $reg_errors->add( 'password', esc_html__( 'Password length must be greater than 5', 'fresh' ) );
	    }

	    if ( $password != $confirmpassword ) {
	        $reg_errors->add( 'password', esc_html__( 'Password must be equal Confirm Password', 'fresh' ) );
	    }

	    if ( !is_email( $email ) ) {
		    $reg_errors->add( 'email_invalid', esc_html__( 'Email is not valid', 'fresh' ) );
		}

		if ( email_exists( $email ) ) {
		    $reg_errors->add( 'email', esc_html__( 'Email Already in use', 'fresh' ) );
		}

	}

	public function complete_registration($username, $password, $email) {
        $userdata = array(
	        'user_login'    =>   $username,
	        'user_email'    =>   $email,
	        'user_pass'     =>   $password,
        );
        return wp_insert_user( $userdata );

	}

	/**
	 *
	 */
	function ajaxDoRegister() {

		global $reg_errors;
        $this->registration_validation( $_POST['opalrgt_fname'], $_POST['opalrgt_lname'], $_POST['opalrgt_username'], $_POST['opalrgt_email'], $_POST['opalrgt_password'], $_POST['opalrgt_password2'] );
        if ( 1 > count( $reg_errors->get_error_messages() ) ) {
	        $username = sanitize_user( $_POST['opalrgt_username'] );
	        $email = sanitize_email( $_POST['opalrgt_email'] );
	        $password = esc_attr( $_POST['opalrgt_password'] );

	        $res = $this->complete_registration( $username, $password, $email);

	        if ( ! is_wp_error( $res ) ) {

	        	add_user_meta( $res, 'first_name', esc_html($_POST['opalrgt_fname']) );
	        	add_user_meta( $res, 'last_name', esc_html($_POST['opalrgt_lname']) );

	        	$jsondata = array('status' => '1', 'msg' => esc_html__( 'You have registered, redirecting ...', 'fresh' ) );
	        	$info['user_login'] = $username;
			    $info['user_password'] = $password;
			    $info['remember'] = 1;

				wp_signon( $info, false );
	        } else {
		        $jsondata = array('status' => '0', 'msg' => esc_html__( 'Register user error!', 'fresh' ) );
		    }
	    } else {
	    	$jsondata = array('status' => '0', 'msg' => implode(', <br>', $reg_errors->get_error_messages()) );
	    }
	    echo json_encode($jsondata);
	    exit;
	}

	/**
	 * process user doForgotPassword with username/password
	 *
	 * return Json Data with messsage and login status
	 */
	public function doForgotPassword(){

		// First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-opal-lostpassword-nonce', 'security' );

		global $wpdb;

		$account = $_POST['user_login'];

		if( empty( $account ) ) {
			$error = esc_html__( 'Enter an username or e-mail address.', 'fresh' );
		} else {
			if(is_email( $account )) {
				if( email_exists($account) )
					$get_by = 'email';
				else
					$error = esc_html__( 'There is no user registered with that email address.', 'fresh' );
			}
			else if (validate_username( $account )) {
				if( username_exists($account) )
					$get_by = 'login';
				else
					$error = esc_html__( 'There is no user registered with that username.', 'fresh' );
			}
			else
				$error = esc_html__(  'Invalid username or e-mail address.', 'fresh' );
		}

		if(empty ($error)) {
			$random_password = wp_generate_password();

			$user = get_user_by( $get_by, $account );

			$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );

			if( $update_user ) {

				$from = get_option('admin_email'); // Set whatever you want like mail@yourdomain.com

				if(!(isset($from) && is_email($from))) {
					$sitename = strtolower( $_SERVER['SERVER_NAME'] );
					if ( substr( $sitename, 0, 4 ) == 'www.' ) {
						$sitename = substr( $sitename, 4 );
					}
					$from = 'do-not-reply@'.$sitename;
				}

				$to = $user->user_email;
				$subject = esc_html__( 'Your new password', 'fresh' );
				$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";

				$message = esc_html__( 'Your new password is: ', 'fresh' ) .$random_password;

				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;

				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail )
					$success = esc_html__( 'Check your email address for you new password.', 'fresh' );
				else
					$error = esc_html__( 'System is unable to send you mail containg your new password.', 'fresh' );
			} else {
				$error =  esc_html__( 'Oops! Something went wrong while updating your account.', 'fresh' );
			}
		}

		if( ! empty( $error ) )
			echo json_encode(array('loggedin'=>false, 'message'=> ($error)));

		if( ! empty( $success ) )
			echo json_encode(array('loggedin'=>false, 'message'=> $success ));
		die();
	}


	/**
	 * add all actions will be called when user login.
	 */
	public function setup(){


		if ( !is_user_logged_in() ) {
			add_action('wp_footer', array( $this,'signin') );
		}
		add_action( 'opal-account-buttons', array( $this, 'button' ) );

	}

	/**
	 * render link login or show greeting when user logined in
	 *
	 * @return String.
	 */
	public function button(){
		if ( !is_user_logged_in() ) {
			echo '<li><a href="#"  data-toggle="modal" data-target="#modalLoginForm" class="opal-user-login">'.esc_html__('Login', 'fresh').'</a></li>';
			echo '<li><a href="'.esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ).'" class="opal-user-register">'.esc_html__('Register', 'fresh').'</a></li>';
		}else {
			return $this->greetingContext();
		}
	}

	/**
	 * check if user not login that showing the form
	 */
	public function signin(){
		if ( !is_user_logged_in() ) {
 			return $this->form();
		}
	}

	/**
	 * Display greeting words
	 */
	public function greeting(){
		$current_user = wp_get_current_user();
		$link = esc_url(wp_logout_url( home_url() ));
		printf('Greeting %s (%s)', $current_user->user_nicename, '<a href="'.( $link ).'" title="'.esc_html__( 'Logout', 'fresh' ).'">'.esc_html__( 'Logout', 'fresh' ).'</a>' );
	}

	/**
	 *
	 */
	public function greetingContext(){
		$current_user = wp_get_current_user();
		$link = esc_url(wp_logout_url( home_url() ));

		echo ' <div class="account-links dropdown">
				  <a href="#" class="dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				    '.esc_html__( 'Howdy', 'fresh').', '.$current_user->user_nicename.'
				    <span class="caret"></span>
				  </a>
				 <a class="signout" href="'.( $link ).'" title="'.esc_html__( 'Logout', 'fresh' ).'">'.esc_html__( 'Logout', 'fresh' ).'</a>

				</div>';

	}

	/**
	 * render login form
	 */
	public function form(){
		    echo '
			    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
				      <div class="modal-dialog" role="document">
						<div class="modal-content">

						<div class="modal-body">';

			echo 		'	<div class="inner">
								<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
					    		<a href="'.esc_url(get_site_url()).'">
										<img class="img-responsive center-image" src="'.get_template_directory_uri().'/images/logo.png" alt="" >
								</a>
						   <div id="opalloginform" class="form-wrapper"> <form class="login-form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">

						    	<p class="lead">'.esc_html__("Hello, Welcome Back!", 'fresh').'</p>
							    <div class="form-group">
								    <input autocomplete="off" type="text" name="wpopal_username" class="required form-control"  placeholder="'.esc_html__("Username",'fresh').'" />
							    </div>
							    <div class="form-group">
								    <input autocomplete="off" type="password" class="password required form-control" placeholder="'.esc_html__("Password",'fresh').'" name="wpopal_password" >
							    </div>
							     <div class="form-group">
							   	 	<label for="opal-user-remember" ><input type="checkbox" name="remember" id="opal-user-remember" value="true"> '.esc_html__("Remember Me",'fresh').'</label>
							    </div>
							    <div class="form-group">
							    	<input type="submit" class="btn btn-primary" name="submit" value="'.esc_html__("Log In",'fresh').'"/>
							    	<input type="button" class="btn btn-default btn-cancel" name="cancel" value="'.esc_html__("Cancel",'fresh').'"/>
							    </div>
					';
					    echo '<p><a href="#opallostpasswordform" class="toggle-links" title="'.esc_html__("Forgot Password",'fresh').'">'.esc_html__("Lost Your Password?",'fresh').'</a></p>';
					    if(get_option('register_page_id')){
					    	echo "<p>".esc_html__('Dont not have an account?', 'fresh' )." <a href='".esc_url(get_permalink( get_option('register_page_id') ))."' title='".esc_html__('Sign Up','fresh')."'>".esc_html__('Sign Up', 'fresh')."</a></p>";
					    }
						    do_action('login_form');
						    wp_nonce_field('ajax-opal-login-nonce', 'security_login');
		    echo '</form></div>';
		  	/// reset form ///
		    echo '<div id="opallostpasswordform" class="form-wrapper">';
		    print $this->resetForm();
		   	echo '</div>';


		   	///
		    echo '		</div></div></div>
					</div>
				</div>';

			 if (!is_user_logged_in()) :
			    echo '
			    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
				      <div class="modal-dialog" role="document">
						<div class="modal-content"><div class="modal-body">';
							/// register form
					   	echo '<div id="opalregisterform" class="form-wrapper">';
					   	print $this->registerForm();
			 			echo '</div>';

		  		echo '	</div></div>
					</div>
				</div>';
			endif;

	}

 	public function resetForm() {
		$output = sprintf('
				<form name="lostpasswordform" id="lostpasswordform" class="lostpassword-form" action="%s" method="post">

					<p class="lead">%s</p>
					<div class="lostpassword-fields">
					<p class="form-group">
						<label>%s<br />
						<input type="text" name="user_login" class="user_login form-control" value="" size="20" tabindex="10" /></label>
					</p>',
							site_url('wp-login.php?action=lostpassword', 'login_post'),
							esc_html__('Reset Password', 'fresh'),
							esc_html__('Username or E-mail:', 'fresh')
						);

						ob_start();
						do_action('lostpassword_form');

						wp_nonce_field('ajax-opal-lostpassword-nonce', 'security');
						$output .= ob_get_clean();

						$output .= sprintf('
					<p class="submit">
						<input type="submit" class="btn btn-primary" name="wp-submit" value="%s" tabindex="100" />
						<input type="button" class="btn btn-default btn-cancel" value="%s" tabindex="101" />
					</p>
					<p class="nav">
						',
							esc_html__('Get New Password', 'fresh'),
							esc_html__('Cancel', 'fresh')


						);
						$output .= '
					</p>
					</div>
 					<div class="lostpassword-link"><a href="#opalloginform" class="toggle-links">'.esc_html__('Back To Login', 'fresh').'</a></div>
				</form>';

		return $output;
	}

	public function registerForm(){
	?>

<div class="container-form">

            <?php
            $opalrgt_settings = get_option('opalrgt_settings');
            $form_heading = empty($opalrgt_settings['opalrgt_signup_heading']) ? esc_html__('Register', 'fresh') : $opalrgt_settings['opalrgt_signup_heading'];

            // check if the user already login

                ?>

                <form name="opalrgtRegisterForm" id="opalrgtRegisterForm" method="post">
                	<button type="button" class="close btn btn-sm btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <h3><?php echo trim( $form_heading ); ?></h3>

                    <div id="opalrgt-reg-loader-info" class="opalrgt-loader" style="display:none;">

                        <span><?php esc_html_e('Please wait ...', 'fresh'); ?></span>
                    </div>
                    <div id="opalrgt-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
                    <div id="opalrgt-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
                    <?php   if( isset($token_verification) && $token_verification ): ?>
                    <div class="alert alert-info" role="alert"><?php esc_html_e('Your account has been activated, you can login now.', 'fresh'); ?></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="opalrgt_fname"><?php esc_html_e('First name', 'fresh'); ?></label>
                        <sup class="opalrgt-required-asterisk">*</sup>
                        <input type="text" class="form-control" name="opalrgt_fname" id="opalrgt_fname" placeholder="<?php esc_html_e('First name', 'fresh'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="opalrgt_lname"><?php esc_html_e('Last name', 'fresh'); ?></label>
                        <input type="text" class="form-control" name="opalrgt_lname" id="opalrgt_lname" placeholder="<?php esc_html_e('Last name', 'fresh'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="opalrgt_username"><?php esc_html_e('Username', 'fresh'); ?></label>
                        <sup class="opalrgt-required-asterisk">*</sup>
                        <input type="text" class="form-control" name="opalrgt_username" id="opalrgt_username" placeholder="<?php esc_html_e('Username', 'fresh'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="opalrgt_email"><?php esc_html_e('Email', 'fresh'); ?></label>
                        <sup class="opalrgt-required-asterisk">*</sup>
                        <input type="text" class="form-control" name="opalrgt_email" id="opalrgt_email" placeholder="<?php esc_html_e('Email', 'fresh'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="opalrgt_password"><?php esc_html_e('Password', 'fresh'); ?></label>
                        <sup class="opalrgt-required-asterisk">*</sup>
                        <input type="password" class="form-control" name="opalrgt_password" id="opalrgt_password" placeholder="<?php esc_html_e('Password', 'fresh'); ?>" >
                    </div>
                    <div class="form-group">
                        <label for="opalrgt_password2"><?php esc_html_e('Confirm Password', 'fresh'); ?></label>
                        <sup class="opalrgt-required-asterisk">*</sup>
                        <input type="password" class="form-control" name="opalrgt_password2" id="opalrgt_password2" placeholder="<?php esc_html_e('Confirm Password', 'fresh'); ?>" >
                    </div>

                    <input type="hidden" name="opalrgt_current_url" id="opalrgt_current_url" value="<?php echo esc_attr( get_permalink() ); ?>" />
                    <input type="hidden" name="redirection_url" id="redirection_url" value="<?php echo esc_attr( get_permalink() ); ?>" />

                    <?php
                    // this prevent automated script for unwanted spam
                    if (function_exists('wp_nonce_field'))
                        wp_nonce_field('opalrgt_register_action', 'opalrgt_register_nonce');

                    ?>
                    <button type="submit" class="btn btn-primary">
                        <?php
                        $submit_button_text = empty($opalrgt_settings['opalrgt_signup_button_text']) ? esc_html__('Register', 'fresh') : $opalrgt_settings['opalrgt_signup_button_text'];
                        echo trim( $submit_button_text );

                        ?></button>
                </form>
                <?php

            ?>
</div>

	<?php }


}

new Fresh_OPAL_User_Account();
?>