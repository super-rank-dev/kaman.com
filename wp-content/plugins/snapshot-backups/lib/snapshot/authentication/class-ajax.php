<?php
/**
 * Handles AJAX request for Authentication.
 *
 * @since    4.7.2
 * @package  Snapshot
 */

namespace WPMUDEV\Snapshot4\Authentication;

use WPMUDEV\Snapshot4\Exceptions\Invalid;
use WPMUDEV\Snapshot4\Model\Authentication;
use WPMUDEV\Snapshot4\Model\Env;

class Ajax {

	/**
	 * @var \WPMUDEV\Snapshot4\Authentication\Ajax
	 */
	protected static $instance = null;

	/**
	 * Dummy constructor.
	 */
	public function __construct() {}

	/**
	 * Creates the singleton instance of this class.
	 *
	 * @return \WPMUDEV\Snapshot4\Authentication\Ajax
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Boots the Authentication AJAX class.
	 *
	 * @return void
	 */
	public function boot() {
		add_action( 'wp_ajax_snapshot_auth_test_connection', array( $this, 'test_connection' ) );
		add_action( 'wp_ajax_snapshot_auth_check_protection', array( $this, 'check' ) );
		add_action( 'wp_ajax_snapshot_auth_retrieve', array( $this, 'retrieve' ) );
		add_action( 'wp_ajax_snapshot_auth_save', array( $this, 'store' ) );
		add_action( 'wp_ajax_snapshot_auth_delete', array( $this, 'delete' ) );
		add_action( 'wp_ajax_snapshot_auth_set_notice_seen', array( $this, 'seen' ) );
	}

	/**
	 * Verifies the nonce.
	 *
	 * @return void
	 */
	public function verify_nonce() {
		check_ajax_referer( 'snapshot-http-auth' );
	}

	/**
	 * Test the authentication connection details.
	 *
	 * @return
	 */
	public function test_connection() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', 'snapshot' ) ) );
		}

		// verify the user data.
		$username = strip_tags( $_POST['un'] );
		$password = strip_tags( $_POST['pw'] );

		$credentials = new Credentials( $username, $password );

		$is_valid = false;
		try {
			$is_valid = $credentials->validate();
		} catch ( Invalid $e ) {
			wp_send_json_error( array( 'message' => $e->getMessage() ) );
		}

		if ( ! $is_valid ) {
			wp_send_json_error( array( 'message' => __( 'Invalid authentication credentials.', 'snapshot' ) ) );
		}

		$auth     = new Auth();
		$auth     = $auth->setCredentials( $credentials );
		$response = $auth->withHeaders()->ping();

		if ( is_wp_error( $response ) ) {
			// Not sure how to handle this particular case, maybe log the error.
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );

		if ( 401 === $status_code || 403 === $status_code ) {
			// Incorrect credentials.
			wp_send_json_success( array( 'connected' => false ) );
		}

		if ( 200 === $status_code ) {
			// Correct credentials.
			wp_send_json_success( array( 'connected' => true ) );
		}
	}

	/**
	 * AJAX Handler: Test if site is password protected.
	 *
	 * @return
	 */
	public function check() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', 'snapshot' ) ) );
		}

		$notified = get_site_transient( 'snapshot_http_auth_enabled_notified' );

		$auth       = new Auth();
		$is_enabled = $auth->is_enabled();

		if ( ! $is_enabled ) {
			// Authentication is not enabled. We will ping back in 7 days.
			set_site_transient( 'snapshot_http_authentication_required', 'no', 7 * DAY_IN_SECONDS );
			wp_send_json_success( array( 'status' => 'auth_not_required' ) );
		}

		// Authentication is enabled.
		set_site_transient( 'snapshot_http_authentication_required', 'yes', 30 * 60 );
		wp_send_json_success( array( 'status' => 'auth_is_required' ) );
	}

	/**
	 * AJAX Handler: Set notice seen
	 *
	 * @return
	 */
	public function seen() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', 'snapshot' ) ) );
		}

		$is_seen = get_site_transient( 'snapshot_http_auth_enabled_notified' );

		if ( ! $is_seen ) {
			set_site_transient( 'snapshot_http_auth_enabled_notified', true, 30 * 60 );
		}

		wp_send_json_success();
	}

	/**
	 * Retrieves the authentication credentials from the API.
	 *
	 * @return
	 */
	public function retrieve() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', 'snapshot' ) ) );
		}

		$model    = new Authentication();
		$response = $model->retrieve();

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body        = wp_remote_retrieve_body( $response );

		if ( 404 === $status_code ) {
			wp_send_json_success( array( 'status' => 'creds_not_found' ) );
		}

		if ( 200 === $status_code ) {
			wp_send_json_success(
				array(
					'status' => 'creds_found',
					'creds'  => json_decode( $body, true ),
				)
			);
		}
	}

	/**
	 * Stores or updates the authentication credentials.
	 *
	 * @return
	 */
	public function store() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', 'snapshot' ) ) );
		}

		// Collect the incoming data.
		$username = strip_tags( $_POST['un'] );
		$password = strip_tags( $_POST['pw'] );
		$method   = ( isset( $_POST['method'] ) && ! empty( $auth_id ) ) ? sanitize_text_field( $_POS['method'] ) : null;

		$credentials = new Credentials( $username, $password );

		$is_valid = false;
		try {
			$is_valid = $credentials->validate();
		} catch ( Invalid $e ) {
			wp_send_json_error( array( 'message' => $e->getMessage() ) );
		}

		if ( ! $is_valid ) {
			wp_send_json_error( array( 'message' => __( 'Invalid authentication credentials.', 'snapshot' ) ) );
		}

		$auth = new Auth();
		$auth = $auth->setCredentials( $credentials );

		$model = new Authentication();

		if ( $method && 'put' === $method ) {
			$response = $model->update( $credentials );
			$type     = 'updated';
		} else {
			$response = $model->store( $credentials );
			$type     = 'stored';
		}

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body        = wp_remote_retrieve_body( $response );
		$decoded     = json_decode( $body, true );

		if ( 201 === $status_code ) {
			wp_send_json_success(
				array(
					'status' => "creds_{$type}",
					'creds'  => $decoded,
				)
			);
		}

		if ( 400 === $status_code ) {
			wp_send_json_success(
				array(
					'status'  => "not_{$type}",
					'message' => $decoded['message'],
				)
			);

		}
	}

	/**
	 * Delete the authentication credentials.
	 *
	 * @return
	 */
	public function delete() {
		$this->verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'You are not authorized to perform this action.', '' ) ) );
		}

		if ( ! Env::is_dev_mode() ) {
			wp_send_json_error( array( 'message' => __( 'Sorry, something went wrong!', 'snapshot' ) ) );
		}

		$authModel = new Authentication();
		$response  = $authModel->delete();

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );

		if ( 200 === $status_code ) {
			// Resource deleted.
			delete_site_transient( 'snapshot_http_authentication_required' );
			delete_site_transient( 'snapshot_http_authentication_checked' );
			wp_send_json_success();
		}

		wp_send_json_error( array( 'message' => __( 'Sorry, your request could not be processed at the moment! Please try again later!', 'snapshot' ) ) );
	}
}