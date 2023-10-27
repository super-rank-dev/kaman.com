<?php

/**
 * Plugin bootstrap file
 *
 *
 * @author 				Happyrobotstudio
 * @link 				http://happyrobotstudio.com
 * @since 				1.0.0
 * @package 			VC_Mega_Footer
 *
 *
 * @wordpress-plugin
 * Plugin Name: 			WPBakery Page Builder - Mega Footer
 * Plugin URI: 				http://happyrobotstudio.com/
 * Description: 			Make your footer mega, with Mega Footer for WPBakery Page Builder
 * Version: 				1.1.0
 * Author: 					Happyrobotstudio
 * Author URI: 				http://happyrobotstudio.com/
 * License: 				Regular Licence
 * License URI: 			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 			vc-mega-footer
 * Domain Path: 			/languages
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


function enqueueJs() {
        if ( wp_script_is( 'yoast-seo-post-scraper' ) ) {
                wp_enqueue_script( 'vc_vendor_yoast_js', vc_asset_url( 'js/vendors/yoast.js' ), array( 'yoast-seo-post-scraper' ), WPB_VC_VERSION, true );
        }
}




// Used for referring to the plugin file or basename
if ( ! defined( 'VC_MEGA_FOOTERFILE' ) ) {
	define( 'VC_MEGA_FOOTERFILE', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation
 * This action is documented in includes/class-vc-mega-footer-activator.php
 */
function activate_VC_Mega_Footer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vc-mega-footer-activator.php';
	VC_Mega_Footer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation
 * This action is documented in includes/class-vc-mega-footer-deactivator.php
 */
function deactivate_VC_Mega_Footer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vc-mega-footer-deactivator.php';
	VC_Mega_Footer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_VC_Mega_Footer' );
register_deactivation_hook( __FILE__, 'deactivate_VC_Mega_Footer' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vc-mega-footer.php';

/**
 * Begins execution of the plugin
 *
 * Since everything within the plugin is registered via hooks
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle
 *
 * @since 		1.0.0
 */
function run_VC_Mega_Footer() {

	$plugin = new VC_Mega_Footer();
	$plugin->run();

}
run_VC_Mega_Footer();
