<?php 
	/**
	 * Class Wpopal_Themer_Kingcomposer_pagebuilder
	 */
	class  Wpopal_Themer_Kingcomposer_pagebuilder{
		
		public function __construct(){
			add_action('init', array( $this, "enableContentBulider") , 99 );	 
			add_action('init', array( $this, "setTemplatePath") , 99 );	 

			$this->_includes();
		}

		public function _includes(){
			if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){		
				require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'vendors/kingcomposer/woocommerce.php'  );
			}	
			require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'vendors/kingcomposer/elements.php'  );
			require_once( WPOPAL_THEMER_PLUGIN_THEMER_DIR .'vendors/kingcomposer/posttypes.php'  );
		}
 
		/**
		 *
		 */
		public function setTemplatePath(){
			global $kc;  
			

			$kc->set_template_path( WPOPAL_THEMER_PLUGIN_THEMER_DIR.'templates/kingcomposer/' );
			$kc->set_template_path( get_template_directory().'/kingcomposer/' );
		}

		/**
		 * Enable content builder for megamenu and footer content.
		 */
		public function enableContentBulider(){
			global $kc;
			if( isset($kc) ){
			     $kc->verify('q570vsfz-frde-mt51-9n7s-atc6-rpmizgkwb0f4');
			
		    	$kc->add_content_type( 'megamenu_profile' );	
		    	$kc->add_content_type( 'footer' );	
		    	$kc->add_content_type( 'producttab' );	
			}
		}

		 
	}

	new Wpopal_Themer_Kingcomposer_pagebuilder();
?>