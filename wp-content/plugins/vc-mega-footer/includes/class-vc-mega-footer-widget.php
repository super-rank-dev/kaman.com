<?php

/**
 * The widget functionality of the plugin
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 */

/**
 * The widget functionality of the plugin
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class VC_Mega_Footer_Widget extends WP_Widget {

	/**
	 * The unique identifier of the plugin
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The unique identifier of the plugin
	 */
	private $plugin_name;

	/**
	 * Register widget .
	 */
	function __construct() {

		$this->plugin_name 			= 'vc-mega-footer';

		$name 					= esc_html__( 'VC Mega Footer', 'vc-mega-footer' );
		$opts['classname'] 		= '';
		$opts['description'] 	= esc_html__( 'Display vcmegafooter postings on a sidebar', 'vc-mega-footer' );
		$control				= array( 'width' => '', 'height' => '' );

		parent::__construct( false, $name, $opts, $control );

	} // __construct()

	/**
	 * Back-end widget form.
	 *
	 * @see		WP_Widget::form()
	 *
	 * @uses	wp_parse_args
	 * @uses	esc_attr
	 * @uses	get_field_id
	 * @uses	get_field_name
	 * @uses	checked
	 *
	 * @param	array	$instance	Previously saved values from database.
	 */
	function form( $instance ) {

		$defaults['title'] = '';
		$instance 			= wp_parse_args( (array) $instance, $defaults );

		$field_text = 'title'; // This is the name of the textfield
		$id 		= $this->get_field_id( $field_text );
		$name 		= $this->get_field_name( $field_text );
		$value 		= esc_attr( $instance[$field_text] );

		echo '<p><label for="' . $id . '">' . esc_html__( ucwords( $field_text ) ) . ': <input class="widefat" id="' . $id . '" name="' . $name . '" type="text" value="' . $value . '" /></label>';

	} // form()

	/**
	 * Front-end display of widget.
	 *
	 * @see		WP_Widget::widget()
	 *
	 * @uses	apply_filters
	 * @uses	get_widget_layout
	 *
	 * @param	array	$args		Widget arguments.
	 * @param 	array	$instance	Saved values from database.
	 */
	function widget( $args, $instance ) {

		$cache = wp_cache_get( $this->plugin_name, 'widget' );

		if ( ! is_array( $cache ) ) {

			$cache = array();

		}

		if ( ! isset ( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->plugin_name;

		}

		if ( isset ( $cache[ $args['widget_id'] ] ) ) {

			return print $cache[ $args['widget_id'] ];

		}

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// Manipulate widget's values based on their input fields here

		ob_start();

		include( plugin_dir_path( __FILE__ ) . 'partials/vc-mega-footer-display-widget.php' );

		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->plugin_name, $cache, 'widget' );

		print $widget_string;

	} // widget()

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see		WP_Widget::update()
	 *
	 * @param	array	$new_instance	Values just sent to be saved.
	 * @param	array	$old_instance	Previously saved values from database.
	 *
	 * @return 	array	$instance		Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;

	} // update()

} // class
