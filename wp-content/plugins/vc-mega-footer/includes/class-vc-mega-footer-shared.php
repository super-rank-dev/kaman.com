<?php

/**
 * The public-facing & admin-facing shared functionality of the plugin
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 */

/**
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class VC_Mega_Footer_Shared {

	/**
	 * The unique identifier of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The unique identifier of the plugin
	 */
	private $plugin_name;

	/**
	 * Plugin version
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$VC_Mega_Footer 		The name of this plugin.
	 * @param 		string 			$version 			Plugin version
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}







} // class
