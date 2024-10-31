<?php
namespace themeDevMega\Apps;
if( ! defined( 'ABSPATH' )) die( 'Forbidden' );

use \themeDevMega\Apps\Settings as Settings;

class Nav{
    private $getGeneral = [];
    
    public function __construct($load = true){
		if($load){
           add_filter( 'wp_nav_menu_objects', [ $this, 'next_megamenu_meta_box'], 999, 2);
           add_filter( 'walker_nav_menu_start_el', [ $this, 'next_modify_menu_text'], 10, 4); 
        }
        $this->getGeneral = get_option( Settings::$general_key );
    }



    public function next_megamenu_meta_box($item, $args){
       
        $items = [];
        foreach( $item as $k=>$v){
            $classs = empty( $v->classes ) ? array() : (array) $v->classes;
            $index = $k + 1;
            $item_pre = isset( $item[$index] ) ? $item[$index] : $item[$k];
            if( isset($item_pre->object) && $item_pre->object == Settings::post_type()){
                if (in_array('menu-item-has-children', $classs)) {
                   $v->classes[]   = 'nx-megamenuli-position'; 
                }
            }
            $items[$k] = $v;
        }
       
       return $items;
    }
  

    function next_modify_menu_text( $item_output, $item, $depth, $args )
    {
        if(!isset($this->getGeneral['general']['mega']['ebable'])){
            return $item_output;
        }

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $output = '';
        $menu_label = get_post_meta($item->ID, '_menu_item_label', true);
        $menu_label_bg_color = get_post_meta($item->ID, '_menu_item_label_bg_color', true);
        $menu_label_text_color = get_post_meta($item->ID, '_menu_item_label_text_color', true);
        $style_attributes = ' style="color: ' . esc_attr( $menu_label_text_color ) . '; background-color: ' . esc_attr( $menu_label_bg_color ) . '"';
        $style_border_attributes = 'style="border-left: 2.5px solid ' . esc_attr( $menu_label_bg_color ) . ';border-top: 2.5px solid ' . esc_attr( $menu_label_bg_color ) . '"';
        
        $class_names = '';
        
        if($item->object == Settings::post_type()){
            $checkEditor = get_post_meta($item->object_id, '_elementor_edit_mode', true);
            if ( $checkEditor && class_exists( '\Elementor\Plugin' ) && did_action( 'elementor/loaded' )) {
                $elementor = \Elementor\Plugin::instance();
                $output   = '<div class="next-megamenu-content next-elementor">'.$elementor->frontend->get_builder_content_for_display( $item->object_id ).'</div>';
                wp_reset_postdata();
            }else{
                $post = get_post($item->ID);
               
                if( is_object($post) && isset($post->post_content)){
                    if ( has_blocks( $post->post_content ) ) {
                      $blocks = parse_blocks( $post->post_content );
                      $output = '<div class="next-megamenu-content  next-gutenberg">';
                      foreach ( $blocks as $block ) {
                        $output .= render_block( $block );
                      }
                      $output .= '</div>';
                    }
                    
                  }
				
            }

            
        }else{
            $atts = array();
            $atts['title']  = ! empty( $item->title )   ? $item->title  : '';
            $atts['target'] = ! empty( $item->target )  ? $item->target : '';
            $atts['rel']    = ! empty( $item->xfn )     ? $item->xfn    : '';
            $atts['href']   = ! empty( $item->url )     ? $item->url    : '';
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

          
            $output .= '<a'. $attributes .' id="golap">';
            $output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            if($menu_label != ''){
                $output .= '<span class="menu-label" '.$style_attributes.'><span class="menu-label-arrow" '.$style_border_attributes.'></span>'.$menu_label.'</span>';
            }
            $output .=  '</a>';
            
            $output =  $item_output;
        }
        return $output;
    }

   

}
