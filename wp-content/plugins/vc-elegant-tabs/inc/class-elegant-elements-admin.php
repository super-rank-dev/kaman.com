<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elegant_Tabs_VC_Admin {
	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 1 );
		add_action( 'admin_head', array( $this, 'admin_head' ) );

		add_filter( 'whitelist_options', array( $this, 'whitelist_options' ) );
	}

	/**
	 * Admin Head.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function admin_head() {
		$menu_image = ELEGANT_TABS_VC_PLUGIN_URL . 'img/icon.png';
		$admin_icon = ELEGANT_TABS_VC_PLUGIN_URL . 'img/icon.svg';
		echo '<style type="text/css">.dashicons-elegant-tabs:before {
			content: "";
			background: url( ' . esc_attr( $menu_image ) . ' ) no-repeat center center;
			background-size: contain;
		}
		.elegant-tabs-logo {
			background-image: url( ' . esc_attr( $admin_icon ) . ' ) !important;
			background-color: #fff;
		}
		.elegant-tabs-version {
			background: #000000;
			box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
			color: #ffffff;
			display: block;
			margin-top: 5px;
			padding: 10px 0;
			text-align: center;
		}
		.elegant-tabs-thanks {
			margin: 30px 0;
		}
		.elegant-tabs-important-notice {
			padding: 15px 26px;
			background: #fff;
			margin: 30px 0px 0px;
		}
		</style>';
	}

	/**
	 * Admin Menu.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function admin_menu() {
		global $submenu;

		$welcome = add_menu_page( esc_attr__( 'Elegant Tabs for WPBakery Page Builder', 'elegant-tabs' ), esc_attr__( 'Elegant Tabs', 'elegant-tabs' ), 'manage_options', 'elegant-tabs-options', array( $this, 'welcome' ), 'dashicons-elegant-tabs', '4.222222' );
		$support = add_submenu_page( 'elegant-tabs-options', esc_attr__( 'Support', 'elegant-tabs' ), esc_attr__( 'Support', 'elegant-tabs' ), 'manage_options', 'elegant-tabs-support', array( $this, 'support_tab' ) );

		if ( current_user_can( 'edit_theme_options' ) ) {
			$submenu['elegant-tabs-options'][0][0] = esc_attr__( 'Welcome', 'elegant-tabs' ); // phpcs:ignore
		}
	}

	/**
	 * Loads the welcome page template.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function welcome() {
		require_once wp_normalize_path( dirname( __FILE__ ) . '/admin-screens/welcome.php' );
	}

	/**
	 * Loads the support page template.
	 *
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public function support_tab() {
		require_once wp_normalize_path( dirname( __FILE__ ) . '/admin-screens/support.php' );
	}

	/**
	 * Set the admin page tabs.
	 *
	 * @static
	 * @access protected
	 * @since 3.5.0
	 * @param string $title The title.
	 * @param string $page  The page slug.
	 */
	protected static function admin_tab( $title, $page ) {

		if ( isset( $_GET['page'] ) ) {
			$active_page = $_GET['page'];
		}

		if ( $active_page == $page ) {
			$link       = 'javascript:void(0);';
			$active_tab = ' nav-tab-active';
		} else {
			$link       = 'admin.php?page=' . $page;
			$active_tab = '';
		}

		echo '<a href="' . $link . '" class="nav-tab' . $active_tab . '">' . $title . '</a>'; // phpcs:ignore.

	}

	/**
	 * Adds the footer.
	 *
	 * @static
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public static function footer() {
		?>
		<div class="elegant-tabs-thanks">
			<p class="description"><?php esc_html_e( 'Thank you for choosing Elegant Tabs for WPBakery Page Builder. We are honored and are fully dedicated to making your experience perfect.', 'elegant-tabs' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Adds the header.
	 *
	 * @static
	 * @access public
	 * @since 3.5.0
	 * @return void
	 */
	public static function header() {
		?>
		<h1><?php esc_html_e( 'Welcome to Elegant Tabs!', 'elegant-tabs' ); ?></h1>
		<div class="updated registration-notice-1" style="display: none;">
			<p><strong><?php esc_attr_e( 'Thanks for registering your purchase. You will now receive the automatic updates.', 'elegant-tabs' ); ?></strong></p>
		</div>
		<div class="updated error registration-notice-2" style="display: none;">
			<p><strong><?php esc_attr_e( 'Please provide all the three details for registering your copy of Elegant Tabs for WPBakery Page Builder.', 'elegant-tabs' ); ?>.</strong></p>
		</div>
		<div class="updated error registration-notice-3" style="display: none;">
			<p><strong><?php esc_attr_e( 'Something went wrong. Please verify your details and try again.', 'elegant-tabs' ); ?></strong></p>
		</div>
			<div class="about-text">
					<?php esc_attr_e( 'Elegant Tabs for WPBakery Page Builder is now installed and ready to use! Get ready to build something beautiful. Please register your purchase on welcome tab to receive automatic updates and support. We hope you enjoy it!', 'elegant-tabs' ); ?>
			</div>
		<div class="elegant-tabs-logo wp-badge">
			<span class="elegant-tabs-version">
				<?php printf( esc_attr__( 'Version %s', 'elegant-tabs' ), esc_attr( ELEGANT_TABS_VC_VERSION ) ); ?>
			</span>
		</div>
		<h2 class="nav-tab-wrapper">
			<?php
				self::admin_tab( esc_attr__( 'Welcome', 'elegant-tabs' ), 'elegant-tabs-options' );
				self::admin_tab( esc_attr__( 'Support', 'elegant-tabs' ), 'elegant-tabs-support' );
			?>
		</h2>
		<?php
	}

	/**
	 * Whitelist options.
	 *
	 * @access public
	 * @since 3.5.0
	 * @param array $options The whitelisted options.
	 * @return array
	 */
	public function whitelist_options( $options ) {

		$added = array(
			'elegant_tabs_registration' => array(
				'elegant_tabs_registration',
			),
		);

		$options = add_option_whitelist( $added, $options );

		return $options;
	}
}

new Elegant_Tabs_VC_Admin();
