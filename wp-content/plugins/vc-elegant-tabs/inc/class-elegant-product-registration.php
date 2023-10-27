<?php
/**
 * Registration handler.
 *
 * @package Elegant Tabs for WPBakery Page Builder
 * @since 3.5.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * A class to handle everything related to product registration
 *
 * @since 3.5.0
 */
class Elegant_Tabs_VC_Product_Registration {

	/**
	 * The option group name.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var string
	 */
	private $option_group_slug = 'elegant_tabs_registration';

	/**
	 * The option name.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var string
	 */
	private $option_name = 'elegant_tabs_registration';

	/**
	 * The option array.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var array
	 */
	private $option;

	/**
	 * The Envato token.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var string
	 */
	private $token;

	/**
	 * Whether the token is valid and for the specified product or not.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var array
	 */
	private $registered = array();

	/**
	 * The arguments that are used in the constructor.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var array
	 */
	private $args = array();

	/**
	 * The product-name converted to ID.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var string
	 */
	private $product_id = '';

	/**
	 * Updater
	 *
	 * @access private
	 * @since 3.5.0
	 * @var null|object Elegant_Tabs_VC_Updater.
	 */
	private $updater = null;

	/**
	 * An instance of the Elegant_Tabs_VC_Envato_API class.
	 *
	 * @access private
	 * @since 3.5.0
	 * @var null|object Elegant_Tabs_VC_Envato_API.
	 */
	private $envato_api = null;

	/**
	 * The class constructor.
	 *
	 * @since 3.5.0
	 * @access public
	 * @param array $args An array of our arguments [string "type", string "name"].
	 */
	public function __construct( $args = array() ) {

		$this->args       = $args;
		$this->product_id = sanitize_key( $args['name'] );

		self::init_globals();

		// Register the settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Instantiate the updater.
		if ( null === $this->updater ) {
			$this->updater = new Elegant_Tabs_VC_Updater( $this );
		}

	}

	/**
	 * Initialize the variables.
	 *
	 * @access private
	 * @since 3.5.0
	 * @return void
	 */
	private function init_globals() {

		$this->token  = false;
		$this->option = get_option( $this->option_name );
		if ( isset( $this->option[ $this->product_id ] ) && isset( $this->option[ $this->product_id ]['token'] ) ) {
			$this->token = $this->option[ $this->product_id ]['token'];
		}
		$this->registered = get_option( 'elegant_tabs_vc_registered' );

	}

	/**
	 * Returns the option name.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return string The option name.
	 */
	public function get_option_name() {

		return $this->option_name;

	}

	/**
	 * Returns the option group name.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return string The option group name.
	 */
	public function get_option_group_slug() {

		return $this->option_group_slug;

	}

	/**
	 * Sets a new token.
	 *
	 * @access public
	 * @since 3.5.0
	 * @param string $token A new token.
	 * @return void
	 */
	public function set_token( $token ) {

		$this->token = $token;

	}

	/**
	 * Returns the current token.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return string The current token.
	 */
	public function get_token() {

		if ( null === $this->token || ! $this->token ) {
			if ( ! empty( $this->option ) && is_array( $this->option ) && isset( $this->option[ $this->product_id ] ) && isset( $this->option[ $this->product_id ]['token'] ) ) {
				return $this->option[ $this->product_id ]['token'];
			}
		}
		return $this->token;

	}

	/**
	 * Gets the arguments.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return array
	 */
	public function get_args() {

		return $this->args;

	}

	/**
	 * Registers the setting field(s) for the registration form.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function register_settings() {

		// Setting.
		register_setting(
			$this->get_option_group_slug(),
			$this->option_name,
			array( $this, 'check_registration' )
		);

		// Token setting.
		add_settings_field(
			'token',
			esc_attr__( 'Token', 'elegant-tabs' ),
			array( $this, 'render_token_setting_callback' ),
			$this->get_option_group_slug()
		);

	}

	/**
	 * Renders the token settings field.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function render_token_setting_callback() {
		?>
		<input type="text" name="<?php esc_attr( "{$this->option_name}[{$this->product_id}][token]" ); ?>" class="widefat" value="<?php echo esc_html( $this->get_token() ); ?>" autocomplete="off">
		<?php

	}

	/**
	 * Envato API class.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return Elegant_Tabs_VC_Envato_API
	 */
	public function envato_api() {

		if ( null === $this->envato_api ) {
			$this->envato_api = new Elegant_Tabs_VC_Envato_API( $this );
		}
		return $this->envato_api;

	}

	/**
	 * Checks if the product is part of the plugins
	 * purchased by the user belonging to the token.
	 *
	 * @access public
	 * @since 3.5.0
	 * @param string $new_value The new token to check.
	 */
	public function check_registration( $new_value ) {

		$this->init_globals();

		// Get the old value.
		$value = get_option( $this->get_option_name(), array() );

		// Check that the new value is properly formatted.
		if ( is_array( $new_value ) && isset( $new_value[ $this->product_id ]['token'] ) ) {
			// If token field is empty, copy is not registered.
			$this->registered[ $this->product_id ] = false;
			if ( ! empty( $new_value[ $this->product_id ]['token'] ) && 32 === strlen( $new_value[ $this->product_id ]['token'] ) ) {
				// Remove spaces from the beginning and end of the token.
				$new_value[ $this->product_id ]['token'] = trim( $new_value[ $this->product_id ]['token'] );
				// Check if new token is valid.
				$this->registered[ $this->product_id ] = $this->product_exists( $new_value[ $this->product_id ]['token'] );
			}
		} else {
			$new_value[ $this->product_id ] = array(
				'token' => '',
			);
		}
		$value = array_replace( $value, $new_value );

		// Check the token scopes and update the option accordingly.
		$this->registered['scopes'] = $this->envato_api()->get_token_scopes( $value[ $this->product_id ]['token'] );

		// Update the 'elegant_tabs_vc_registered' option.
		update_option( 'elegant_tabs_vc_registered', $this->registered );

		// Return the new value.
		return $value;

	}

	/**
	 * Checks if the product is part of the plugins
	 * purchased by the user belonging to the token.
	 *
	 * @access private
	 * @since 3.5.0
	 * @param string $token A token to check.
	 * @param int    $page  The page number if one is necessary.
	 * @return bool
	 */
	private function product_exists( $token = '', $page = '' ) {

		// Set the new token for the API call.
		if ( '' !== $token ) {
			$this->envato_api()->set_token( $token );
		}

		$products = $this->envato_api()->plugins( array(), $page );

		// If a WP Error object is returned we need to check if API is down.
		if ( is_wp_error( $products ) ) {
			// 401 ( unauthorized ) and 403 ( forbidden ) mean the token is invalid, apart from that Envato API is down.
			if ( 401 !== $products->get_error_code() && 403 !== $products->get_error_code() && '' !== $products->get_error_message() ) {
				set_site_transient( 'elegant_envato_api_down', true, 600 );
			}
			return false;
		}

		// Check iv product is part of the purchased plugins.
		foreach ( $products as $product ) {
			if ( isset( $product['name'] ) ) {
				if ( $this->args['name'] === $product['name'] ) {
					return true;
				}
			}
		}

		if ( 100 === count( $products ) ) {
			$page = ( ! $page ) ? 2 : $page + 1;
			return $this->product_exists( '', $page );
		}
		return false;
	}

	/**
	 * Has user associated with current token purchased this product?
	 *
	 * @access public
	 * @since 3.5.0
	 * @return bool
	 */
	public function is_registered() {

		// Is the product registered?
		if ( isset( $this->registered[ $this->product_id ] ) && true === $this->registered[ $this->product_id ] ) {
			return true;
		}
		// Is the Envato API down?
		if ( get_site_transient( 'elegant_envato_api_down' ) ) {
			return true;
		}
		// Fallback to false.
		return false;

	}

	/**
	 * Prints the registration form.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function the_form() {

		// Print styles.
		$this->form_styles();
		?>
		<div class="elegant-tabs-important-notice registration-form-container">
			<?php if ( $this->is_registered() ) : ?>
				<p class="about-description"><?php esc_attr_e( 'Congratulations! Your product is registered now.', 'elegant-tabs' ); ?></p>
			<?php else : ?>
				<p class="about-description"><?php esc_attr_e( 'Please enter your Envato token to complete registration.', 'elegant-tabs' ); ?></p>
			<?php endif; ?>
			<div class="elegant-tabs-registration-form">
				<form id="elegant-tabs_product_registration" method="post" action="options.php">
					<?php $show_form = true; ?>
					<?php
					$invalid_token = false;
					$token         = $this->get_token();
					settings_fields( $this->get_option_group_slug() );
					?>
					<?php if ( $token && ! empty( $token ) ) : ?>
						<?php if ( $this->is_registered() ) : ?>
							<span class="dashicons dashicons-yes elegant-tabs-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
						<?php else : ?>
							<?php $invalid_token = true; ?>
							<span class="dashicons dashicons-no elegant-tabs-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
						<?php endif; ?>
					<?php else : ?>
						<span class="dashicons dashicons-admin-network elegant-tabs-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
					<?php endif; ?>
					<input <?php echo ( ! $show_form ) ? 'class="toggle-hidden hidden" ' : ''; ?>type="text" name="<?php echo esc_attr( "{$this->option_name}[{$this->product_id}][token]" ); ?>" value="<?php echo esc_attr( $token ); ?>" />
					<?php
					$button_classes = array( 'primary', 'large', 'elegant-tabs-large-button', 'elegant-tabs-register' );
					if ( ! $show_form ) {
						$button_classes[] = 'toggle-hidden';
						$button_classes[] = 'hidden';
					}
					?>
					<?php submit_button( esc_attr__( 'Submit', 'elegant-tabs' ), $button_classes ); ?>
				</form>

				<?php if ( $invalid_token ) : ?>
					<p class="error-invalid-token">
						<?php if ( 36 === strlen( $token ) && 4 === substr_count( $token, '-' ) ) : ?>
							<?php esc_attr_e( 'Registration could not be completed because the value entered above is a purchase code. A token key is needed to register. Please read the directions below to find out how to create a token key to complete registration.', 'elegant-tabs' ); ?>
						<?php else : ?>
							<?php /* translators: The product name for the license. */ ?>
							<?php printf( esc_attr__( 'Invalid token, or corresponding Envato account does not have %s purchased.', 'elegant-tabs' ), esc_attr( $this->args['name'] ) ); ?>
						<?php endif; ?>
					</p>
				<?php elseif ( $token && ! empty( $token ) ) : ?>
					<?php
					// If the token scopes don't exist, make sure we create them and save them.
					if ( ! isset( $this->registered['scopes'] ) || ! is_array( $this->registered['scopes'] ) ) {
						$this->registered['scopes'] = $this->envato_api()->get_token_scopes();
						update_option( 'elegant_tabs_vc_registered', $this->registered );
					}
					$scopes_ok = $this->envato_api()->check_token_scopes( $this->registered['scopes'] );
					?>
					<?php if ( ! $scopes_ok ) : ?>
						<p class="error-invalid-token">
							<?php _e( 'Token does not have the necessary permissions. Please create a new token and make sure the following permissions are enabled for it: <strong>View Your Envato Account Username</strong>, <strong>Download Your Purchased Items</strong>, <strong>List Purchases You\'ve Made</strong>, <strong>Verify Purchases You\'ve Made</strong>.', 'elegant-tabs' ); // phpcs:ignore ?>
						</p>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( ! $this->is_registered() ) : ?>

					<div <?php echo ( ! $show_form ) ? 'class="toggle-hidden hidden" ' : ''; ?>style="font-size:17px;line-height:27px;margin-top:1em;padding-top:1em">
						<hr>

						<h3><?php esc_attr_e( 'Instructions For Generating A Token', 'elegant-tabs' ); ?></h3>
						<ol>
							<?php // @codingStandardsIgnoreStart ?>
							<li><?php printf( __( 'Click on this <a href="%1$s" target="_blank">Generate A Personal Token</a> link. <strong>IMPORTANT:</strong> You must be logged into the same Themeforest account that purchased %2$s. If you are logged in already, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'elegant-tabs' ), 'https://build.envato.com/create-token/?user:username=t&purchase:download=t&purchase:verify=t&purchase:list=t', $this->args['name'] ); ?></li>
							<li><?php _e( 'Enter a name for your token, then check the boxes for <strong>View Your Envato Account Username, Download Your Purchased Items, List Purchases You\'ve Made</strong> and <strong>Verify Purchases You\'ve Made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token button</strong>', 'elegant-tabs' ); ?></li>
							<li><?php _e( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the <strong>Submit</strong> button.', 'elegant-tabs' ); ?></li>
							<li><?php printf( __( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly. You can also view our <a %s>documentation post</a> for various fallback methods.', 'elegant-tabs' ), 'href="https://infiwebs.freshdesk.com/support/solutions/articles/5000763979-how-to-register-your-purchase-with-token-key" target="_blank"' ); ?></li>
							<?php // @codingStandardsIgnoreEnd ?>
						</ol>

					</div>

				<?php endif; ?>
			</div>
		</div>
		<?php

	}

	/**
	 * Print styles for the form.
	 *
	 * @access private
	 * @since 3.5.0
	 * @return void
	 */
	private function form_styles() {
		?>
		<style>
		.registration-form-container {
			float: left;
			width: 95%;
			margin-bottom: 0;
			padding-bottom: 40px;
		}
		.dashicons.dashicons-admin-network.elegant-tabs-icon-key {
			line-height: 30px;
			height: 30px;
			margin-right: 10px;
			width: 30px;
		}

		#elegant-tabs-product-registration {
			float: left;
			width: 100%;
			margin-bottom: 30px;
		}
		#elegant-tabs_product_registration {
			display: -webkit-flex;
			display: -ms-flexbox;
			display: flex;
			flex-wrap: wrap;

			-webkit-align-items: center;
			-ms-align-items: center;
			align-items: center;
		}

		.elegant-tabs-registration-form input[type="text"],
		.elegant-tabs-registration-form input#submit {
			margin: 0 1em;
			padding: 10px 15px;
			width: calc(100% - 2em - 180px);
			height: 40px;
		}

		.elegant-tabs-registration-form input#submit {
			margin: 0;
			width: 150px;
			line-height: 1;
		}

		#elegant-tabs_product_registration p.submit {
			margin: 0;
			padding: 0;
		}

		#elegant-tabs_product_registration .dashicons {
			margin: 0;
			color: #333333;
			width: 30px;
			height: 32px;
			line-height: 32px;
			font-size: 36px;
		}

		#elegant-tabs_product_registration .dashicons-yes {
			color: #43A047;
		}

		#elegant-tabs_product_registration .dashicons-no {
			color:#c00;
		}

		.elegant-tabs-important-notice p.error-invalid-token {
			margin: 1em 0 0 0 !important;
			padding:1em;
			color:#fff;
			background-color:#c00;
			text-align:center;
		}
		.elegant-tabs-thanks {
			margin: 30px 0;
		}
		</style>
		<?php
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
