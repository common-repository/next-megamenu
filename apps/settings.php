<?php
namespace themeDevMega\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

class Settings{
	
	 /**
     * Custom post type
     * Method Description: Set custom post type
     * @since 1.0.0
     * @access public
     */
	const POST_TYPE = 'next-megamenu';

	
    // general option key
	public static $general_key = '__next_megamenu_general_data';
	
	

	public function __construct($load = true){
		if($load){
			
            add_action('init', [ $this, 'next_posttype' ]);
            add_action('admin_menu', [ $this, 'themeDev_mail_admin_menu' ]);
			
			// Load script file for settings page
			add_action( 'admin_enqueue_scripts', [$this, 'themedev_script_loader_admin' ] );
			
            add_action( 'wp_enqueue_scripts', [$this, 'themedev_script_loader_public' ] );
            
            add_action( 'save_post', array( $this, '_template_save' ), 1, 2  );
           

		}
	}
	
	
	 /**
     * Public Static method : post_type
     * Method Description: Get custom post type
     * @since 1.0.0
     * @access public
     */
	public static function post_type(){
		return self::POST_TYPE;
	}
	/**
     * Public method : themeDev_add_custom_post
     * Method Description: Create custom post type
     * @since 1.0.0
     * @access public
     */
	public function themeDev_mail_admin_menu(){
        add_menu_page(
            esc_html__( 'Next Mega', 'next-megamenu' ),
            esc_html__( 'Next Mega', 'next-megamenu' ),
            'manage_options',
            'next-mega',
            [ $this ,'themedev_next_mail_settings'],
            'dashicons-list-view',
            6
        );
		
		add_submenu_page('next-mega', esc_html__('My Menus', 'next-megamenu'), esc_html__('My Menus', 'next-megamenu'), 'manage_options', 'edit.php?post_type='.self::post_type());
		add_submenu_page( 'next-mega', esc_html__( 'Support', 'next-megamenu' ), esc_html__( 'Support', 'next-megamenu' ), 'manage_options', 'next-mega-support', [ $this ,'themedev_next_mail_settings_supports'], 11); 
        
    }
    /**
     * Public method : next_posttype
     * Method Description: Create custom post type
     * @since 1.0.0
     * @access public
     */
    public function next_posttype(){
		$args = $this->post_type_data();
        register_post_type( self::post_type(), $args );

		flush_rewrite_rules();
		
    }
    
    public function _template_save( $post_id, $post ){
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return $post_id;
        }
  
        if(  in_array($post->post_type, ['next-megamenu']) ):
            update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );
        endif;
      }
  

	 /**
     * Public method : post_type
     * Method Description:  Set Post Type Data
     * @since 1.0.0
     * @access public
     */

	public function post_type_data()
    {
        $labels = array(
            'name'                  => esc_html_x( 'Next Mega', 'Next Mega Menu', 'next-megamenu' ),
            'singular_name'         => esc_html_x( 'Next Mega', 'Post Type Singular Name', 'next-megamenu' ),
            'menu_name'             => esc_html__( 'Next Mega', 'next-megamenu' ),
            'name_admin_bar'        => esc_html__( 'Menu', 'next-megamenu' ),
            'archives'              => esc_html__( 'Menu Archives', 'next-megamenu' ),
            'attributes'            => esc_html__( 'Menu Attributes', 'next-megamenu' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'next-megamenu' ),
            'all_items'             => esc_html__( 'Menus', 'next-megamenu' ),
            'add_new_item'          => esc_html__( 'Add New Menu', 'next-megamenu' ),
            'add_new'               => esc_html__( 'Add New', 'next-megamenu' ),
            'new_item'              => esc_html__( 'New Menu', 'next-megamenu' ),
            'edit_item'             => esc_html__( 'Edit Menu', 'next-megamenu' ),
            'update_item'           => esc_html__( 'Update Menu', 'next-megamenu' ),
            'view_item'             => esc_html__( 'View Menu', 'next-megamenu' ),
            'view_items'            => esc_html__( 'View Menus', 'next-megamenu' ),
            'search_items'          => esc_html__( 'Search Menus', 'next-megamenu' ),
            'not_found'             => esc_html__( 'Not found', 'next-megamenu' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'next-megamenu' ),
            'featured_image'        => esc_html__( 'Featured Image', 'next-megamenu' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'next-megamenu' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'next-megamenu' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'next-megamenu' ),
            'insert_into_item'      => esc_html__( 'Insert into Menu', 'next-megamenu' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this Menu', 'next-megamenu' ),
            'items_list'            => esc_html__( 'Menus list', 'next-megamenu' ),
            'items_list_navigation' => esc_html__( 'Menus list navigation', 'next-megamenu' ),
            'filter_items_list'     => esc_html__( 'Filter froms list', 'next-megamenu' ),
        );
        $rewrite = array(
            'slug'                  => 'next-megamenu',
            'with_front'            => true,
            'pages'                 => false,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => esc_html__( 'Next Menus', 'next-megamenu' ),
            'description'           => esc_html__( 'Next MegaMenu', 'next-megamenu' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'elementor', 'permalink' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'next-megamenu',
            'menu_icon'             => 'dashicons-list-view',
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'rewrite'               => $rewrite,
            'query_var'             => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true, // enable guttenbarg editor
            'rest_base'             => self::post_type(),
            'show_in_nav_menus'     => true,
        );

        return $args;

    }
	/**
	 * Method Name: themedev_next_mail_settings
	 * Description: Next Settings
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_mail_settings(){
		$message_status = 'No';
		$message_text = '';
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
		
		if($active_tab == 'general'){
			// general options
			if(isset($_POST['themedev-mail-general'])){
				$options = isset($_POST['themedev']) ? self::sanitize($_POST['themedev']) : [];
				
				if(update_option( self::$general_key, $options)){
					$message_status = 'yes';
					$message_text = __('Successfully save general data.', 'next-megamenu');
				}
			}
			
			
		}
        $getGeneral = get_option( self::$general_key, '');	

		include ( NEXT_MEGA_PLUGIN_PATH.'/views/admin/settings.php');
	}
   

	/**
	 * Method Name: themedev_next_mail_settings_supports
	 * Description: Next Support Page
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function themedev_next_mail_settings_supports(){
		include ( NEXT_MEGA_PLUGIN_PATH.'/views/admin/supports.php');
	}
	/**
     * Public method : sanitize
     * Method Description: Sanitize for Review
     * @since 1.0.0
     * @access public
     */
	public static function sanitize($value, $senitize_func = 'sanitize_text_field'){
        $senitize_func = (in_array($senitize_func, [
                'sanitize_email', 
                'sanitize_file_name', 
                'sanitize_hex_color', 
                'sanitize_hex_color_no_hash', 
                'sanitize_html_class', 
                'sanitize_key', 
                'sanitize_meta', 
                'sanitize_mime_type',
                'sanitize_sql_orderby',
                'sanitize_option',
                'sanitize_text_field',
                'sanitize_title',
                'sanitize_title_for_query',
                'sanitize_title_with_dashes',
                'sanitize_user',
                'esc_url_raw',
                'wp_filter_nohtml_kses',
            ])) ? $senitize_func : 'sanitize_text_field';
        
        if(!is_array($value)){
            return $senitize_func($value);
        }else{
            return array_map(function($inner_value) use ($senitize_func){
                return self::sanitize($inner_value, $senitize_func);
            }, $value);
        }
	}
	
	/**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themedev_script_loader_public(){
        wp_register_script( 'themedev_mega_settings_script', NEXT_MEGA_PLUGIN_URL. 'assets/public/script/public-script.js', array( 'jquery' ), NEXT_MEGA_VERSION, false);
        
		wp_register_style( 'themedev_mega_settings_css_public', NEXT_MEGA_PLUGIN_URL. 'assets/public/css/public-style.css', false, NEXT_MEGA_VERSION);
        wp_enqueue_style( 'themedev_mega_settings_css_public' );

     }
	 
	 /**
     *  ebay_settings_script_loader .
     * Method Description: Settings Script Loader
     * @since 1.0.0
     * @access public
     */
    public function themedev_script_loader_admin(){
        wp_register_script( 'themedev_mega_settings_script_admin', NEXT_MEGA_PLUGIN_URL. 'assets/admin/scripts/admin-settings.js', array( 'jquery' ), NEXT_MEGA_VERSION, false);
        wp_enqueue_script( 'themedev_mega_settings_script_admin' );
		
		wp_register_style( 'themedev_mega_settings_css_admin', NEXT_MEGA_PLUGIN_URL. 'assets/admin/css/admin-style.css', false, NEXT_MEGA_VERSION);
        wp_enqueue_style( 'themedev_mega_settings_css_admin' );

     }
	
	 
}