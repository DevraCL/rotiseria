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
if(!class_exists('Wpopal_User_Account')){
	class Wpopal_User_Account{

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
				return json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password. Please try again!!!', 'wpopal-themer')));
		    } else {
				wp_set_current_user($user_signon->ID); 
		        return json_encode(array('loggedin'=>true, 'message'=>esc_html__('Signin successful, redirecting...', 'wpopal-themer')));
		    }
		}

		public function registration_validation( $firstname, $lastname, $username, $email, $password, $confirmpassword )  {
			global $reg_errors;
			$reg_errors = new WP_Error;
			if ( empty($firstname) || empty( $username ) || empty( $password ) || empty( $email ) || empty( $confirmpassword ) ) {
			    $reg_errors->add('field', esc_html__( 'Required form field is missing', 'wpopal-themer' ) );
			}

			if ( 4 > strlen( $username ) ) {
			    $reg_errors->add( 'username_length', esc_html__( 'Username too short. At least 4 characters is required', 'wpopal-themer' ) );
			}

			if ( username_exists( $username ) ) {
		    	$reg_errors->add('user_name', esc_html__( 'Sorry, that username already exists!', 'wpopal-themer' ) );
			}

			if ( ! validate_username( $username ) ) {
			    $reg_errors->add( 'username_invalid', esc_html__( 'Sorry, the username you entered is not valid', 'wpopal-themer' ) );
			}

			if ( 5 > strlen( $password ) ) {
		        $reg_errors->add( 'password', esc_html__( 'Password length must be greater than 5', 'wpopal-themer' ) );
		    }

		    if ( $password != $confirmpassword ) {
		        $reg_errors->add( 'password', esc_html__( 'Password must be equal Confirm Password', 'wpopal-themer' ) );
		    }

		    if ( !is_email( $email ) ) {
			    $reg_errors->add( 'email_invalid', esc_html__( 'Email is not valid', 'wpopal-themer' ) );
			}

			if ( email_exists( $email ) ) {
			    $reg_errors->add( 'email', esc_html__( 'Email Already in use', 'wpopal-themer' ) );
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

		        	$jsondata = array('status' => '1', 'msg' => esc_html__( 'You have registered, redirecting ...', 'wpopal-themer' ) );
		        	$info['user_login'] = $username;
				    $info['user_password'] = $password;
				    $info['remember'] = 1;
					
					wp_signon( $info, false );
		        } else {
			        $jsondata = array('status' => '0', 'msg' => esc_html__( 'Register user error!', 'wpopal-themer' ) );
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
				$error = esc_html__( 'Enter an username or e-mail address.', 'wpopal-themer' );
			} else {
				if(is_email( $account )) {
					if( email_exists($account) ) 
						$get_by = 'email';
					else	
						$error = esc_html__( 'There is no user registered with that email address.', 'wpopal-themer' );			
				}
				else if (validate_username( $account )) {
					if( username_exists($account) ) 
						$get_by = 'login';
					else	
						$error = esc_html__( 'There is no user registered with that username.', 'wpopal-themer' );				
				}
				else
					$error = esc_html__(  'Invalid username or e-mail address.', 'wpopal-themer' );		
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
					$subject = esc_html__( 'Your new password', 'wpopal-themer' );
					$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
					
					$message = esc_html__( 'Your new password is: ', 'wpopal-themer' ) .$random_password;
						
					$headers[] = 'MIME-Version: 1.0' . "\r\n";
					$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers[] = "X-Mailer: PHP \r\n";
					$headers[] = $sender;
						
					$mail = wp_mail( $to, $subject, $message, $headers );
					if( $mail ) 
						$success = esc_html__( 'Check your email address for you new password.', 'wpopal-themer' );
					else
						$error = esc_html__( 'System is unable to send you mail containg your new password.', 'wpopal-themer' );						
				} else {
					$error =  esc_html__( 'Oops! Something went wrong while updating your account.', 'wpopal-themer' );
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
				echo '<ul class="account-links dropdown">';
					echo '<li><a href="#"  data-toggle="modal" data-target="#modalLoginForm" class="opal-user-login"><span class="fa fa-user"></span> '.esc_html__('Login', 'wpopal-themer').'</a></li>';
					if(class_exists('WooCommerce')){
						echo '<li><a href="'.esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ).'" class="opal-user-register"><span class="fa fa-pencil"></span> '.esc_html__('Register', 'wpopal-themer').'</a></li>';
					}else{
						echo '<li><a href="#"  data-toggle="modal" data-target="#modalRegisterForm" class="pbr-user-register"><span class="fa fa-pencil"></span>' .esc_html__('Register', 'wpopal-themer' ).'</a></li>';
					}
				echo '</ul>';
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
			printf('Greeting %s (%s)', $current_user->user_nicename, '<a href="'.( $link ).'" title="'.esc_html__( 'Logout', 'wpopal-themer' ).'">'.esc_html__( 'Logout', 'wpopal-themer' ).'</a>' );
		}

		public function greetingContext(){ 
			$profile_link = get_edit_user_link();
			$logout_link = wp_logout_url( home_url() );

			echo 
				'<ul class="account-links dropdown">
					<li>
						<a href="'.esc_url($profile_link).'">
							<span class="fa fa-user"></span> '.esc_html__( ' Edit profile', 'wpopal-themer') .'
						</a>
					</li>
					<li>
						<a href="'.esc_url($logout_link ).'" title="'.esc_html__( 'Logout', 'wpopal-themer' ).'">
							<span class="fa fa-sign-out"></span>'.esc_html__( ' Logout', 'wpopal-themer' ).
						'</a>
					</li>
				</ul>';

		}

		/**
		 * render login form
		 */
		public function form(){


			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
			if (has_custom_logo()){
				$link = $image[0];
			}else{
				$link = get_template_directory_uri().'/images/logo.png';
			}
			
			    echo '
				    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
					      <div class="modal-dialog" role="document">
							<div class="modal-content">
							
							<div class="modal-body">';
				
				echo 		'	<div class="inner">
									<button type="button" class="close btn btn-sm btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
						    		<a href="'.esc_url(get_site_url()).'">
											<img class="img-responsive center-image" src="'.esc_url($link).'" alt="" >
									</a>
							   <div id="opalloginform" class="form-wrapper"> <form class="login-form" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
							     
							    	<p class="lead">'.esc_html__("Hello, Welcome Back!", 'wpopal-themer').'</p>
								    <div class="form-group">
									    <input autocomplete="off" type="text" name="wpopal_username" class="required form-control"  placeholder="'.esc_html__("Username",'wpopal-themer').'" />
								    </div>
								    <div class="form-group">
									    <input autocomplete="off" type="password" class="password required form-control" placeholder="'.esc_html__("Password",'wpopal-themer').'" name="wpopal_password" >
								    </div>
								     <div class="form-group">
								   	 	<label for="opal-user-remember" ><input type="checkbox" name="remember" id="opal-user-remember" value="true"> '.esc_html__("Remember Me",'wpopal-themer').'</label>
								    </div>
								    <div class="form-group">
								    	<input type="submit" class="btn btn-primary" name="submit" value="'.esc_html__("Log In",'wpopal-themer').'"/>
								    	<input type="button" class="btn btn-default btn-cancel" name="cancel" value="'.esc_html__("Cancel",'wpopal-themer').'"/>
								    </div>
						';
						    echo '<p><a href="#opallostpasswordform" class="toggle-links" title="'.esc_html__("Forgot Password",'wpopal-themer').'">'.esc_html__("Lost Your Password?",'wpopal-themer').'</a></p>';	
						    if(get_option('register_page_id')){ 
						    	echo "<p>".esc_html__('Dont not have an account?', 'wpopal-themer' )." <a href='".esc_url(get_permalink( get_option('register_page_id') ))."' title='".esc_html__('Sign Up','wpopal-themer')."'>".esc_html__('Sign Up', 'wpopal-themer')."</a></p>";	
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
								esc_html__('Reset Password', 'wpopal-themer'),
								esc_html__('Username or E-mail:', 'wpopal-themer')
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
								esc_html__('Get New Password', 'wpopal-themer'),
								esc_html__('Cancel', 'wpopal-themer')
								 
								
							);
							$output .= '
						</p>
						</div>
	 					<div class="lostpassword-link"><a href="#opalloginform" class="toggle-links">'.esc_html__('Back To Login', 'wpopal-themer').'</a></div>
					</form>';

			return $output;
		}

		public function registerForm(){
		?>
		
	<div class="container-form">
	  
	            <?php
	            $opalrgt_settings = get_option('opalrgt_settings');
	            $form_heading = empty($opalrgt_settings['opalrgt_signup_heading']) ? esc_html__('Register', 'wpopal-themer') : $opalrgt_settings['opalrgt_signup_heading'];

	            // check if the user already login
	           
	                ?>
	                
	                <form name="opalrgtRegisterForm" id="opalrgtRegisterForm" method="post">
	                	<button type="button" class="close btn btn-sm btn-primary pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
	                    <h3><?php echo trim( $form_heading ); ?></h3>

	                    <div id="opalrgt-reg-loader-info" class="opalrgt-loader" style="display:none;">
	              
	                        <span><?php esc_html_e('Please wait ...', 'wpopal-themer'); ?></span>
	                    </div>
	                    <div id="opalrgt-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
	                    <div id="opalrgt-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
	                    <?php   if( isset($token_verification) && $token_verification ): ?>
	                    <div class="alert alert-info" role="alert"><?php esc_html_e('Your account has been activated, you can login now.', 'wpopal-themer'); ?></div>
	                    <?php endif; ?>
	                    <div class="form-group">
	                        <label for="opalrgt_fname"><?php esc_html_e('First name', 'wpopal-themer'); ?></label>
	                        <sup class="opalrgt-required-asterisk">*</sup>
	                        <input type="text" class="form-control" name="opalrgt_fname" id="opalrgt_fname" placeholder="<?php esc_html_e('First name', 'wpopal-themer'); ?>">
	                    </div>
	                    <div class="form-group">
	                        <label for="opalrgt_lname"><?php esc_html_e('Last name', 'wpopal-themer'); ?></label>
	                        <input type="text" class="form-control" name="opalrgt_lname" id="opalrgt_lname" placeholder="<?php esc_html_e('Last name', 'wpopal-themer'); ?>">
	                    </div>
	                    <div class="form-group">
	                        <label for="opalrgt_username"><?php esc_html_e('Username', 'wpopal-themer'); ?></label>
	                        <sup class="opalrgt-required-asterisk">*</sup>
	                        <input type="text" class="form-control" name="opalrgt_username" id="opalrgt_username" placeholder="<?php esc_html_e('Username', 'wpopal-themer'); ?>">
	                    </div>
	                    <div class="form-group">
	                        <label for="opalrgt_email"><?php esc_html_e('Email', 'wpopal-themer'); ?></label>
	                        <sup class="opalrgt-required-asterisk">*</sup>
	                        <input type="text" class="form-control" name="opalrgt_email" id="opalrgt_email" placeholder="<?php esc_html_e('Email', 'wpopal-themer'); ?>">
	                    </div>
	                    <div class="form-group">
	                        <label for="opalrgt_password"><?php esc_html_e('Password', 'wpopal-themer'); ?></label>
	                        <sup class="opalrgt-required-asterisk">*</sup>
	                        <input type="password" class="form-control" name="opalrgt_password" id="opalrgt_password" placeholder="<?php esc_html_e('Password', 'wpopal-themer'); ?>" >
	                    </div>
	                    <div class="form-group">
	                        <label for="opalrgt_password2"><?php esc_html_e('Confirm Password', 'wpopal-themer'); ?></label>
	                        <sup class="opalrgt-required-asterisk">*</sup>
	                        <input type="password" class="form-control" name="opalrgt_password2" id="opalrgt_password2" placeholder="<?php esc_html_e('Confirm Password', 'wpopal-themer'); ?>" >
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
	                        $submit_button_text = empty($opalrgt_settings['opalrgt_signup_button_text']) ? esc_html__('Register', 'wpopal-themer') : $opalrgt_settings['opalrgt_signup_button_text'];
	                        echo trim( $submit_button_text );

	                        ?></button>
	                </form>
	                <?php
	         
	            ?>
	</div>
		<?php } 
	}
}