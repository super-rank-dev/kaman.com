<?php
/*
Plugin Name: Image Hotspot With Tooltip For WPBakery Page Builder
Plugin URI: https://codenpy.com/item/image-hotspot-with-tooltip-for-wpbakery-page-builder-formerly-visual-composer/
Description: This plugin will add awesome hotspots with unlimited tooltips for a single image.
Author: themebon
Author URI: http://codenpy.com/
License: GPLv2 or later
Text Domain: ihwt
Version: 1.2.0
*/

// Don't load directly
if (!defined('ABSPATH')){die('-1');}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ){
    
/* Constants */
if ( ! function_exists( 'Image_Hotspot_WordPressCheckup' ) ) {
    function Image_Hotspot_WordPressCheckup( $version = '3.8' ) {
        global $wp_version;
        if ( version_compare( $wp_version, $version, '>=' ) ) {
            return "true";
        } else {
            return "false";
        }
    }
}

// Admin Style CSS
function ihwt_admin_enqeue() {
    
    wp_enqueue_style( 'ihwt_admin_css', plugins_url( 'admin/admin.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'ihwt_admin_enqeue' );


// Calling addon
require_once( 'hotspot.php' );


    }
// Check If VC is activate
else {
    function ihwt_required_plugin() {
        if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'js_composer/js_composer.php' ) ) {
            add_action( 'admin_notices', 'ihwt_required_plugin_notice' );

            deactivate_plugins( plugin_basename( __FILE__ ) ); 

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }

    }
add_action( 'admin_init', 'ihwt_required_plugin' );

    function ihwt_required_plugin_notice(){
        ?><div class="error"><p>Error! you need to install or activate the <a target="_blank" href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=themebonwp">WPBakery Page Builder for WordPress (formerly Visual Composer)</a> plugin to run "<span style="font-weight: bold;">Image Hotspot With Tooltip For WPBakery Page Builder</span>" plugin.</p></div><?php
    }
}
?>