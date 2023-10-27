<?php

namespace WPMUDEV\Snapshot4\Authentication;

class Auth {
	/**
	 * Stores the credential object.
	 *
	 * @var Credentials $credentials
	 */
	protected $credential = null;

	/**
	 * @var boolean
	 */
	protected $need_headers = false;

	/**
	 * Dummy auth constructor.
	 */
	public function __construct() {}

	/**
	 * Set the authentication credentials.
	 *
	 * @param Credentials $credentials
	 *
	 * @return \WPMUDEV\Snapshot4\Authentication\Auth
	 */
	public function setCredentials( Credentials $credentials ) {
		$this->credential = $credentials;

		return $this;
	}

	/**
	 * Check if we have credentials set.
	 *
	 * @return boolean
	 */
	public function hasCredentials() {
		return $this->credential !== null;
	}

	/**
	 * Enable the header options.
	 *
	 * @return Auth
	 */
	public function withHeaders() {
		$this->need_headers = true;

		return $this;
	}

	/**
	 * Process the response received from wp_remote_get.
	 *
	 * @param array  Response from the request.
	 *
	 * @return array
	 */
	public function process_response( $response ) {
		$response_code = wp_remote_retrieve_response_code( $response );

		$result = array();

		if ( 200 === $response_code ) {
			// Cache the result for 7 days.
			set_site_transient( 'snapshot_http_authentication_required', 'no', 7 * DAY_IN_SECONDS );
			$result['status'] = 'http_auth_not_required';
		}

		if ( 401 === $response_code || 403 === $response_code ) {
			// Cache the response for 30 minutes.
			set_site_transient( 'snapshot_http_authentication_required', 'yes', 30 * 60 );
			$result['status'] = 'http_auth_required';
		}

		return $result;
	}

	/**
	 * Validate the authentication credentials.
	 *
	 * @return void
	 */
	public function validate_credentials() {
		$permission = is_multisite() ? 'manage_network' : 'manage_options';

		if ( ! current_user_can( $permission ) ) {
			wp_send_json_error( array( 'status' => 'not_allowed' ) );
		}

		$username = sanitize_text_field( $_REQUEST['auth_username'] );
		$password = sanitize_text_field( $_REQUEST['auth_password'] );

		if ( empty( $username ) || empty( $password ) ) {
			wp_send_json_error( array( 'inputs' => __( 'Username & Password required!' ) ) );
		}

		$prepared = "{$username}:{$password}";
		$encoded  = base64_encode( $prepared );

		$response = $this->ping( array( 'Authorization' => sprintf( 'Basic %s', $encoded ) ) );

		$this->process_response( $response );
	}

	/**
	 * Build HTTP Auth headers.
	 *
	 * @return array
	 */
	public function get_headers() {
		$username = $this->credential->username();
		$password = $this->credential->password();
		$encoded  = base64_encode( "{$username}:{$password}" );

		return array( 'Authorization' => sprintf( 'Basic %s', $encoded ) );
	}

	/**
	 * Ping the site to check http authentication status.
	 *
	 * @param array $headers  List of headers as an array.
	 *
	 * @return array|WP_Error The response or WP_Error on failure.
	 */
	public function ping() {
		$args = array( 'timeout' => 10 );

		if ( $this->need_headers ) {
			$args['headers'] = $this->get_headers();
		}

		$response = wp_remote_get( esc_url( site_url() ), $args );

		return $response;
	}

	/**
	 * Check if authentication is enabled or not.
	 *
	 * @return boolean
	 */
	public function is_enabled() {
		$is_auth_required = get_site_transient( 'snapshot_http_authentication_required' );

		if ( $is_auth_required ) {
			if ( 'no' === $is_auth_required ) {
				return false;
			}

			if ( 'yes' === $is_auth_required ) {
				return true;
			}
		}

		$response = $this->ping();

		if ( is_wp_error( $response ) ) {
			// Cannot determine due to error.
			return false;
		}

		$status_code = wp_remote_retrieve_response_code( $response );

		if ( 401 === $status_code || 403 === $status_code ) {
			return true;
		}

		return false;
	}

	/**
	 * Http authentication is required or not.
	 *
	 * @return boolean
	 */
	public function is_required() {
		$checked = get_option( 'snapshot_http_auth_checked' );

		if ( $checked ) {
			$is_auth_required = get_site_transient( 'snapshot_http_authentication_required' );

			$response = array();
			if ( $is_auth_required ) {
				if ( 'no' === $is_auth_required ) {
					$response['status'] = 'http_auth_not_required';
				}

				if ( 'yes' === $is_auth_required ) {
					$response['status'] = 'http_auth_required';
				}

				wp_send_json_success( $response );
			}
		}

		update_site_option( 'snapshot_http_auth_checked', 1 );
		$response = $this->ping();

		$this->process_response( $response );
	}

	/**
	 * Parses the API response.
	 *
	 * @return
	 */
	public function parse_api_response( $response ) {

	}
}