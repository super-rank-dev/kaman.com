<?php
/*
Plugin Name: Ultimate RoadMap Timeline for WPBakery Page Builder (formerly Visual Composer)
Description: Roadmap timeline element for WPBakery Page Builder
Author: MagniumThemes
Version: 1.0.1
Author URI: http://magniumthemes.com/
Text Domain: mgurt
*/

// Allow to use plugin only by admin
if (! class_exists( 'UltimateRoadmapTimeline' ) ) :

class UltimateRoadmapTimeline {
	/**
	 * The class constructor.
	 * contains Action/Filter Hooks
	 */
	public function __construct() {

		/* Load text domain */
		add_action( 'init', array( $this, 'load_text_domain' ));

		/* Load assets */
		add_action( 'admin_init', array( $this, 'load_backend_assets' ) );
		add_action( 'init', array( $this, 'load_frontend_assets' ) );

		/* Init */
		add_action( 'init', array( $this, 'init' ));
	}

	/*
	 * Load text domain
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'mgurt', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Load assets
	 */
	public function load_backend_assets() {
		wp_enqueue_script( 'mgurt-script-admin', plugin_dir_url( '' ) . basename( dirname( __FILE__ ) ) . '/assets/admin.js', array(), false, true );
		wp_enqueue_style( 'mgurt-style-admin', plugin_dir_url( '' ) . basename( dirname( __FILE__ ) ) . '/assets/admin.css' );
	}

	public function load_frontend_assets() {
		wp_enqueue_script( 'mgurt-script-frontend', plugin_dir_url( '' ) . basename( dirname( __FILE__ ) ) . '/assets/frontend.js', array(), false, true );
		wp_enqueue_style( 'mgurt-style-frontend', plugin_dir_url( '' ) . basename( dirname( __FILE__ ) ) . '/assets/frontend.css' );

	}

	public function admin_notice_vc_required() {
	    ?>
	    <div class="notice notice-error">
	        <p><?php _e( '<strong>WPBakery Page Builder (formely Visual Composer) plugin must be installed and activated for Ultimate RoadMap Timeline plugin.</strong>', 'mgurt' ); ?></p>
	    </div>
	    <?php
	}

	/*
	 * Init
	 */
	public function init() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if(is_plugin_active('js_composer/js_composer.php')) {
			add_action( 'wp_loaded', array( $this, 'vc_custom_init' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'admin_notice_vc_required' ));
		}
	}

	/* Load VC shortcodes */
	public function vc_custom_init() {

		// Animation CSS media fix for VC
		wp_deregister_style( 'animate-css' );
		wp_register_style( 'animate-css', vc_asset_url( 'lib/bower/animate-css/animate.min.css' ), false, WPB_VC_VERSION, 'screen' );

		// Adding new Param Types for VC
		vc_add_shortcode_param( 'mgt_separator', array( $this, 'mgt_separator_settings' ) );

		// Add new WP shortcodes to VC
		include_once('shortcodes/visual-composer/mgt-timeline.php');
		include_once('shortcodes/wp/mgt-timeline-wp.php');

	}

	/* VC Separator element */
	public function mgt_separator_settings( $settings, $value ) {
	    return '<div class="mgt_separator_block">'
             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
             esc_attr( $settings['param_name'] ) . ' ' .
             esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
             '</div>'; // This is html markup that will be outputted in content elements edit form
	}

}

// Generate separator ID
if(!function_exists('generate_separator_name')):
function generate_separator_name() {

	global $separator_id;

	$separator_id++;

	return 'mgt_sep_'.$separator_id;
}
endif;

// Instantiate the class
$UltimateRoadmapTimeline = new UltimateRoadmapTimeline();

// End if for class_exists
endif;
