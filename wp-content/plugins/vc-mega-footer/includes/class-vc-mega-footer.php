<?php

/**
 * Core plugin class
 *
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 */


/**
 *
 * @since 		1.0.0
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class VC_Mega_Footer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks for the plugin
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		VC_Mega_Footer_Loader 		$loader 		Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$plugin_name 		The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Sanitizer for cleaning user input
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      VC_Mega_Footer_Sanitize    $sanitizer    Sanitizes data
	 */
	private $sanitizer;

	/**
	 * Plugin version
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$version 		Plugin version
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the plugin
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'vc-mega-footer';
		$this->version = '1.1.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->define_shared_hooks();

		$this->define_metabox_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - VC_Mega_Footer_Loader. Orchestrates the hooks of the plugin
	 * - VC_Mega_Footer_i18n. Defines internationalization functionality.
	 * - VC_Mega_Footer_Admin. Defines all hooks for the dashboard.
	 * - VC_Mega_Footer_Public. Defines all hooks for the public side of the plugin
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * .
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vc-mega-footer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vc-mega-footer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vc-mega-footer-admin.php';

		/**
		 * The class responsible for defining all actions relating to metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vc-mega-footer-admin-metaboxes.php';

		/**
		 * phpQuery class is included to enable jQuery like manipulation of the DOM using php
		 */
		if( !class_exists('phpQuery') ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/vendor/phpQuery/phpQuery.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the plugin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-vc-mega-footer-public.php';


		/**
		 * The class responsible for all global functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/vc-mega-footer-global-functions.php';

		/**
		 * The class responsible for defining all actions shared by the Dashboard and public-facing sides.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vc-mega-footer-shared.php';

		/**
		 * The class responsible for sanitizing user input
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vc-mega-footer-sanitize.php';

		$this->loader = new VC_Mega_Footer_Loader();
		$this->sanitizer = new VC_Mega_Footer_Sanitize();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the VC_Mega_Footer_i18n class in order to set the domain and to register the hook
	 * .
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function set_locale() {

		$plugin_i18n = new VC_Mega_Footer_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new VC_Mega_Footer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_vcmegafooter' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_taxonomy_type' );
		$this->loader->add_filter( 'plugin_action_links_' . VC_MEGA_FOOTERFILE, $plugin_admin, 'link_settings' );
		$this->loader->add_action( 'plugin_row_meta', $plugin_admin, 'link_row', 10, 2 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_fields' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_admin_notices' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_notices_init' );

		$this->loader->add_action( 'vc_after_init_vc', $plugin_admin, 'visual_composer_admin_notices' );

		$this->loader->add_action( 'init', $plugin_admin, 'ensure_visual_composer_hasthe_vcmegafooter_posttype', 60 );





	} // define_admin_hooks()






	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_public_hooks() {

		$plugin_public = new VC_Mega_Footer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', $this->get_version(), TRUE );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', $this->get_version(), TRUE );


		/* ULTIMATE ADDONS CHECK */
		$this->loader->add_action('wp_enqueue_scripts',  $plugin_public,  'ultimate_addons_active', 20);

		/* INITIATE OUR FOOTER */
		$mgft_options = get_option( 'vc-mega-footer' . '-options' );






		// use the selected method to insert our Megafooter
		//
		// using hook
		// 		best, but sometimes there is no good hook within the theme
		if( $mgft_options["vc-mega-footer-append-via-hook"] == 1 ) {

			$specified_hook = $mgft_options["vc-mega-footer-append-via-hook-proper"];

			if( has_action( $specified_hook ) ) {
				$this->loader->add_action( $specified_hook,  $plugin_public,  'output_all_footers_verbose', 1);
			}
			else {
				// the specified hook does not exist
			}

		}
		// using output buffer
		// 		works when no other plugins or themes are conflicting ..
		// 		places the footer precicsely using a preg replace on the whole site content
		// 		.. an easier solution than using a hook, and produces nice results,
		// 		but quite slow and high probability of conflicts ..
		else if( 	$mgft_options["vc-mega-footer-hide-original-footer"] == 1 ||
					$mgft_options["vc-mega-footer-above-original-footer"] == 1 ||
					$mgft_options["vc-mega-footer-below-original-footer"] == 1 ) {

			$this->loader->add_action('wp_head',  $plugin_public,  'start_footer_ob', 0);

			$this->loader->add_action('wp_footer',  $plugin_public,  'end_footer_ob', 0);
		}


		//$this->loader->add_filter( 'single_template', $plugin_public, 'single_cpt_template' );



		// ensure  visual composer stylesheet is output at the correct time
		$this->loader->add_action('wp_enqueue_scripts',  $plugin_public, 'js_composer_front_load');


	} // define_public_hooks()







	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shared_hooks() {

		$plugin_shared = new VC_Mega_Footer_Shared( $this->get_plugin_name(), $this->get_version() );



	} // define_shared_hooks()


	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$plugin_metaboxes = new VC_Mega_Footer_Admin_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'add_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_vcmegafooter', $plugin_metaboxes, 'set_meta' );
		$this->loader->add_action( 'save_post_vcmegafooter', $plugin_metaboxes, 'validate_meta', 10, 2 );


	} // define_metabox_hooks()


	/**
	 * Run the loader to execute all of the hooks
	 *
	 * @since 		1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The unique identifier of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since 		1.0.0
	 * @return 		string 					The unique identifier of the plugin
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 		1.0.0
	 * @return 		VC_Mega_Footer_Loader 			Orchestrates the hooks of the plugin
	 */
	public function get_loader() {
		return $this->loader;
	}


	/**
	 * Retrieve the version number of the plugin
	 *
	 * @since 		1.0.0
	 * @return 		string 					The version number of the plugin
	 */
	public function get_version() {
		return $this->version;
	}






}
