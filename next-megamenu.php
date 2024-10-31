<?php
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );
/**
 * Plugin Name: Next MegaMenu
 * Description: The most Advanced MegaMenu for Elementor. 
 * Plugin URI: http://products.themedev.net/next-megamenu/
 * Author: ThemeDev
 * Version: 1.0.2
 * Author URI: http://themedev.net/
 *
 * Text Domain: next-megamenu
 *
 * @package NextMenu 
 * @category Free
 * Domain Path: /languages/
 * License: GPL2+
 */
/**
 * Defining static values as global constants
 * @since 1.0.0
 */
define( 'NEXT_MEGA_VERSION', '1.0.2' );
define( 'NEXT_MEGA_PREVIOUS_STABLE_VERSION', '1.0.1' );

define( 'NEXT_MEGA_KEY', 'next-megamenu' );

define( 'NEXT_MEGA_DOMAIN', 'next-megamenu' );

define( 'NEXT_MEGA_FILE_', __FILE__ );
define( "NEXT_MEGA_PLUGIN_PATH", plugin_dir_path( NEXT_MEGA_FILE_ ) );
define( 'NEXT_MEGA_PLUGIN_URL', plugin_dir_url( NEXT_MEGA_FILE_ ) );

// initiate actions
add_action( 'plugins_loaded', 'themedev_mega_load_plugin_textdomain' );
/**
 * Load eBay Search textdomain.
 * @since 1.0.0
 * @return void
 */
function themedev_mega_load_plugin_textdomain() {
	load_plugin_textdomain( 'next-megamenu', false, basename( dirname( __FILE__ ) ) . '/languages'  );

	// add action page hook
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'themedev_mega_action_links' );
	/**
	 * Load Next Review Loader main page.
	 * @since 1.0.0
	 * @return plugin output
	 */
	require_once(NEXT_MEGA_PLUGIN_PATH.'init.php');
	new \themeDevMega\Init();

}

// added custom link
function themedev_mega_action_links($links){
	$links[] = '<a href="' . admin_url( 'admin.php?page=next-mega' ).'"> '. __('Settings', 'next-megamenu').'</a>';
	return $links;
}

