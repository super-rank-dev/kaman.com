<?php

namespace FormVibes\Integrations;

use FormVibes\Classes\Utils;
use FormVibes\Integrations\Base;
use RGFormsModel;
use GFCommon;
use GFAPI;

/**
 * Gravity Forms plugin class
 *
 * Register the Gravity Forms plugin
 */
class GravityForms extends Base {

	/**
	 * The instance of the class.
	 * @var null|object $instance
	 *
	 */
	private static $instance = null;
	/**
	 * The forms.
	 * @var array
	 *
	 */
	public static $forms = [];
	/**
	 * The submission id
	 * @var string $submission_id
	 *
	 */
	public static $submission_id = '';

	/**
	 * Array for skipping fields or unwanted data from the form data..
	 * @var array $skip_fields
	 *
	 */
	protected $skip_fields = [];

	/**
	 * The instaciator of the class.
	 *
	 * @access public
	 * @since 1.4.4
	 * @return @var $instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * The constructor of the class.
	 *
	 * @access private
	 * @since 1.4.4
	 * @return void
	 */
	public function __construct() {
		$this->plugin_name = 'gravity-forms';

		$this->set_skip_fields();

		add_filter( 'fv_forms', [ $this, 'register_plugin' ] );
		// calls after wp forms submit the form.
		add_action( 'gform_confirmation', [ $this, 'gravity_form' ], 10, 4 );
		add_filter( "formvibes/submissions/{$this->plugin_name}/columns", [ $this, 'prepare_columns' ], 10, 3 );
	}

	/**
	 * Register the form plugin
	 *
	 * @param array $forms
	 * @access public
	 * @return array
	 */
	public function register_plugin( $forms ) {
		$forms[ $this->plugin_name ] = 'Gravity Forms';
		return $forms;
	}

	/**
	 * Set the skip fields
	 *
	 * @access protected
	 * @return void
	 */
	protected function set_skip_fields() {
		// name of all fields which should not be stored in our database.
		$this->skip_fields = [];
	}

	/**
	 * Run when the form is submitted
	 *
	 * @access public
	 * @return string|mixed
	 */
	public function gravity_form( $confirmation, $form, $lead ) {
		$form_name = $form['title'];
		$form_id   = $form['id'] . '_gravity-forms';
		// check if user wants to store/save the entry to db.
		$save_entry = true;

		$save_entry = apply_filters( 'formvibes/ninjaforms/save_record', $save_entry, $form );

		if ( ! $save_entry ) {
			return;
		}

		$data['plugin_name']  = $this->plugin_name;
		$data['id']           = $form_id;
		$data['captured']     = current_time( 'mysql', 0 );
		$data['captured_gmt'] = current_time( 'mysql', 1 );
		$data['title']        = $form_name;
		$data['url']          = $_SERVER['HTTP_REFERER'];
		$posted_data          = $this->prepare_posted_data( $form, $lead );

		$settings = get_option( 'fvSettings' );

		if ( Utils::key_exists( 'save_ip_address', $settings ) && true === $settings['save_ip_address'] ) {
			$posted_data['IP'] = $this->get_user_ip();
		}

		$data['fv_form_id']  = $form_id;
		$data['posted_data'] = $posted_data;

		self::$submission_id = $this->insert_entries( $data );
		return $confirmation;
	}

	/**
	 * Prepare the saved data
	 *
	 * @access public
	 * @return array
	 */
	private function prepare_posted_data( $form, $lead ) {
		$posted_data = [];
		$count       = 0;

		foreach ( $form['fields'] as $field ) {

			$value         = RGFormsModel::get_lead_field_value( $lead, $field );
			$display_value = GFCommon::get_lead_field_display( $field, $value, $lead['currency'], false, 'html' );
			$label         = GFCommon::get_label( $field );

			$key = 'gf_field_' . $field['id'];

			$posted_data[ $key ] = wp_filter_nohtml_kses( $display_value );

			$count++;
		}
		return $posted_data;
	}

	/**
	 * Prepare the table columns
	 *
	 * @access public
	 * @return array
	 */
	public function prepare_columns( $cols, $columns, $form_id ) {

		$form = GFAPI::get_form( $form_id );

		foreach ( $cols as $key => $value ) {
			$colKey         = $value['colKey'];
			$alias_original = $value['alias'];
			$alias          = trim( str_replace( '_', ' ', $colKey ) );

			foreach ( $form['fields'] as $gfkey => $gfvalue ) {
				$gfColKey = substr( $colKey, strripos( $colKey, '_' ) + 1, 5 );
				// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
				if ( $gfvalue['id'] == $gfColKey ) {
					$alias = $gfvalue['label'];
				}
			}

			if ( $colKey === $alias_original ) {
				$cols[ $key ]['alias'] = $alias;
			}
		}

		return $cols;
	}
}
