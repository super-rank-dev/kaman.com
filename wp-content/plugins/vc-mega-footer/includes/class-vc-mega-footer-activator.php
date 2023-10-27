<?php

/**
 * Fired during plugin activation
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class VC_Mega_Footer_Activator {

	/**
	 * Declare custom post types, taxonomies, and plugin settings
	 * Flushes rewrite rules afterwards
	 *
	 * @since 		1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vc-mega-footer-admin.php';

		VC_Mega_Footer_Admin::new_cpt_vcmegafooter();
		VC_Mega_Footer_Admin::new_taxonomy_type();

		flush_rewrite_rules();

		$opts 		= array();
		$options 	= VC_Mega_Footer_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'vc-mega-footer-options', $opts );

		VC_Mega_Footer_Admin::add_admin_notices();

	} // activate()
} // class
