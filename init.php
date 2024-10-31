<?php
namespace themeDevMega;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Class Name : Init - This main class for ebay plugin
 * Class Type : Normal class
 *
 * initiate all necessary classes, hooks, configs
 *
 * @since 1.0.0
 * @access Public
 */

Class Init{
     
    
	 /**
     * Construct the plugin object
     * @since 1.0.0
     * @access public
     */
	public function __construct(){
		$this->mega_autoloder();
         new Apps\Settings();
         new Apps\Nav();
        
	}
	
	
	/**
     * Review aws_autoloder.
     * xs_review autoloader loads all the classes needed to run the plugin.
     * @since 1.0.0
     * @access private
     */
	
	private function mega_autoloder(){
		require_once NEXT_MEGA_PLUGIN_PATH . '/loader.php';
        Loader::run_plugin_social();
	}
	 
}