<?php
/**
 * The metabox-specific functionality of the plugin
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/admin
 */

/**
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/admin
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class VC_Mega_Footer_Admin_Metaboxes {

	/**
	 * The post meta
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta
	 */
	private $meta;

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
	 * @var 		string 			$version 			Plugin version
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$VC_Mega_Footer 		The unique identifier of the plugin
	 * @param 		string 			$version 			Plugin version
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_meta();

	}

	/**
	 * Registers metaboxes
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

		add_meta_box(
			'vc_mega_footer_vcmegafooter_additional_info',
			apply_filters( $this->plugin_name . '-metabox-title-additional-info', esc_html__( 'Footer Block Settings', 'vc-mega-footer' ) ),
			array( $this, 'metabox' ),
			'vcmegafooter',
			'normal',
			'default',
			array(
				'file' => 'vcmegafooter-additional-info'
			)
		);





	} // add_metaboxes()


	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces 		= array();
		$nonce_check 	= 0;

		$nonces[] 		= 'vcmegafooter_additional_info';

		foreach ( $nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }

		}

		return $nonce_check;

	} // check_nonces()


	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	private function get_metabox_fields() {

		$fields = array();

		$fields[] = array( 'vcmegafooter-enabled', 'checkbox' );

		$fields[] = array( 'vcmegafooter-showonpages', 'select' );
		$fields[] = array( 'vcmegafooter-showonposts', 'select' );
		$fields[] = array( 'vcmegafooter-showonpostcategories', 'select' );
		$fields[] = array( 'vcmegafooter-showonposttags', 'select' );


		return $fields;

	} // get_metabox_fields()


	/**
	 * Calls a metabox file specified in the add_meta_box args
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {

		if ( ! is_admin() ) { return; }
		if ( 'vcmegafooter' !== $post->post_type ) { return; }

		if ( ! empty( $params['args']['classes'] ) ) {

			$classes = 'repeater ' . $params['args']['classes'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/vc-mega-footer-admin-metabox-' . $params['args']['file'] . '.php' );

	} // metabox()


	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }

		$return 	= '';
		$sanitizer 	= new VC_Mega_Footer_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	} // sanitizer()


	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'vcmegafooter' != $post->post_type ) { return; }

		//wp_die( '<pre>' . print_r( $post->ID ) . '</pre>' );

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()


	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 *  	Loops through meta fields
	 *  		Loops through submitted data
	 *  		Sanitizes each field into $clean array
	 *   	Gets max of $clean to use in FOR loop
	 *   	FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function validate_meta( $post_id, $object ) {

		//echo( '<pre>' . print_r( $_POST ) . '</pre>' ); die();

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'vcmegafooter' !== $object->post_type ) { return $post_id; }

		$nonce_check = $this->check_nonces( $_POST );

		if ( 0 < $nonce_check ) { return $post_id; }

		$metas = $this->get_metabox_fields();

		foreach ( $metas as $meta ) {

			$name = $meta[0];
			$type = $meta[1];

			if ( 'repeater' === $type && is_array( $meta[2] ) ) {

				$clean = array();

				foreach ( $meta[2] as $field ) {

					foreach ( $_POST[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count 		= vc_mega_footer_get_max( $clean );
				$new_value 	= array();

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$new_value[$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			}
			elseif ( 'select' === $type ) {
				if( empty( $_POST[$name] ) ){
					$_POST[$name] = array();
				}
				// for a multi select, lets implode the array to save
				$new_value = $this->sanitizer( $type, implode(',', $_POST[$name]) ); // we are storing the muti selects as comma separated string
			}
			else {

				$new_value = $this->sanitizer( $type, $_POST[$name] );

			}

			update_post_meta( $post_id, $name, $new_value );

		} // foreach

	} // validate_meta()


} // class
