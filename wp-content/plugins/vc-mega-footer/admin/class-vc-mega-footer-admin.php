<?php

/**
 * The dashboard-specific functionality of the plugin
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/admin
 */

/**
 * The dashboard-specific functionality of the plugin
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/admin
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class VC_Mega_Footer_Admin {

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

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

		$this->set_options();

	}

	/**
     * Adds notices for the admin to display.
     * Saves them in a temporary plugin option.
     * This method is called on plugin activation, so its needs to be static.
     */
    public static function add_admin_notices() {

    	$notices 	= get_option( 'vc_mega_footer_deferred_admin_notices', array() );
  		//$notices[] 	= array( 'class' => 'updated', 'notice' => esc_html__( 'VC Mega Footer: Custom Activation Message', 'vc-mega-footer' ) );
  		//$notices[] 	= array( 'class' => 'error', 'notice' => esc_html__( 'VC Mega Footer: Problem Activation Message', 'vc-mega-footer' ) );

  		apply_filters( 'vc_mega_footer_admin_notices', $notices );
  		update_option( 'vc_mega_footer_deferred_admin_notices', $notices );

    } // add_admin_notices

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

		add_submenu_page(
			'edit.php?post_type=vcmegafooter',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'VC Mega Footer Settings', 'vc-mega-footer' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'vc-mega-footer' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_options' )
		);

		// add_submenu_page(
		// 	'edit.php?post_type=vcmegafooter',
		// 	apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'VC Mega Footer Help', 'vc-mega-footer' ) ),
		// 	apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Help', 'vc-mega-footer' ) ),
		// 	'manage_options',
		// 	$this->plugin_name . '-help',
		// 	array( $this, 'page_help' )
		// );



		// removing menu items for custom post type categories .. not needed, but will break some wordpress features if not turned on
		global $submenu;

		unset($submenu["edit.php?post_type=vcmegafooter"][15]); // Remove Footer Types    edit-tags.php?taxonomy=vcmegafooter_type&post_type=vcmegafooter






	} // add_menu()

	/**
     * Manages any updates or upgrades needed before displaying notices.
     * Checks plugin version against version required for displaying
     * notices.
     */
	public function admin_notices_init() {

        //
		// if ( $this->version !== $current_version ) {
        //
		// 	// Do whatever upgrades needed here.
        //
		// 	update_option('my_plugin_version', $current_version);
        //
		// 	//$this->add_notices_and_upgrade();
		//
		// 	  // undefined function left spare for any upgrade tasks and notices
		// 	  // called upon 'admin_init' action in wordpress
        //
		// }

	} // admin_notices_init()

	/**
	 * Displays admin notices
	 *
	 * @return 	string 			Admin notices
	 */
	public function display_admin_notices() {

		$notices = get_option( 'vc_mega_footer_deferred_admin_notices' );

		if ( empty( $notices ) ) { return; }

		foreach ( $notices as $notice ) {

			echo '<div class="' . esc_attr( $notice['class'] ) . '"><p>' . $notice['notice'] . '</p></div>';

		}

		delete_option( 'vc_mega_footer_deferred_admin_notices' );

    } // display_admin_notices()






	/**
	 * Displays admin notice regarding Visual Composer
	 *
	 * @return 	null
	 */
	public function visual_composer_admin_notices() {

		// check for visual composer enabled
		if ( !is_plugin_active( 'js_composer/js_composer.php' ) ) {
		 	// add_action( 'admin_notices', array($this, 'visual_composer_admin_notices_vc_not_installed') );
		}


    } // visual_composer_admin_notices()






	/**
	 * Visual Composer not installed
	 *
	 * @return 	null
	 */
	public function visual_composer_admin_notices_vc_not_installed() {

			echo '<div class="error"><p>Visual Composer is not installed, VC Mega Footer requires an active VIsual Composer installation.</p></div>';

    } // visual_composer_admin_notices_vc_not_installed()


	/**
	 * Visual Composer Roles are not correct
	 *
	 * @return 	null
	 */
	public function visual_composer_admin_notices_vc_roles_no_permissions() {

			echo '<div class="error"><p>Visual Composer Roles are not enabled for VC Mega Footer<br/>Please go to<strong> Visual Composer -> Role Manager -> Post types</strong><br/>-> Select Custom<br/>-> Ensure \'vcmegafooter\' is ticked</p></div>';

    } // visual_composer_admin_notices_vc_not_installed()





	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vc-mega-footer-admin.css', array(), $this->version, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		global $post_type;

		$screen = get_current_screen();



		//echo  "<h1>".$screen->id."</h1>";    //echo "|"; echo $hook_suffix; die();

		if ( 'vcmegafooter' == $post_type  &&  ($hook_suffix == 'post-new.php' || $hook_suffix == 'post.php') ) {   //|| $screen->id === $hook_suffix

			wp_enqueue_script( $this->plugin_name . '-fileuploader', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-file-uploader.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-repeater', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-repeater.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-multiselect', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-multiselect.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-admin.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'jquery-ui-datepicker' );

			$localize['repeatertitle'] = __( 'File Name', 'vc-mega-footer' );

			wp_localize_script( 'vc-mega-footer', 'nhdata', $localize );


		}

	} // enqueue_scripts()




	/**
	 * Check for Visual Composer Roles
	 *
	 * @since 		1.0.2
	 * @return 		void
	 */
	public function ensure_visual_composer_hasthe_vcmegafooter_posttype() {


		global $vc_manager;
		if( $vc_manager ) {

			// Lets ensure visual composer will accept 'vcmegafooter' post type in Roles
			$existing_vc_post_types = $vc_manager->editorPostTypes();

			$existing_vc_post_types[] = 'vcmegafooter';

			$vc_manager->setEditorDefaultPostTypes( $existing_vc_post_types );
			$vc_manager->setEditorPostTypes( $existing_vc_post_types ); //this is required after VC update (probably from vc 4.5 version)
		}

	} // ensure_visual_composer_hasthe_vcmegafooter_posttype()









	/*  BEGIN METABOX FIELDS */

	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-checkbox-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-checkbox.php' );

	} // field_checkbox()

	/**
	 * Creates an editor field
	 *
	 * NOTE: ID must only be lowercase letter, no spaces, dashes, or underscores.
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_editor( $args ) {

		$defaults['description'] 	= '';
		$defaults['settings'] 		= array( 'textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']' );
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-editor-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-editor.php' );

	} // field_editor()

	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-radios-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-radios.php' );

	} // field_radios()

	public function field_repeater( $args ) {

		$defaults['class'] 			= 'repeater';
		$defaults['fields'] 		= array();
		$defaults['id'] 			= '';
		$defaults['label-add'] 		= 'Add Item';
		$defaults['label-edit'] 	= 'Edit Item';
		$defaults['label-header'] 	= 'Item Name';
		$defaults['label-remove'] 	= 'Remove Item';
		$defaults['title-field'] 	= '';

/*
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
*/
		apply_filters( $this->plugin_name . '-field-repeater-options-defaults', $defaults );

		$setatts 	= wp_parse_args( $args, $defaults );
		$count 		= 1;
		$repeater 	= array();

		if ( ! empty( $this->options[$setatts['id']] ) ) {

			$repeater = maybe_unserialize( $this->options[$setatts['id']][0] );

		}

		if ( ! empty( $repeater ) ) {

			$count = count( $repeater );

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-repeater.php' );

	} // field_repeater()

	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= 'widefat';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

			var_dump($atts['value']);

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-select.php' );

	} // field_select()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );

	} // field_text()


	/**
	 * Creates a number field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_number( $args ) {

		$defaults['class'] 			= 'number';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'number';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-number-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-number.php' );

	} // field_number()

	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {

		$defaults['class'] 			= 'large-text';
		$defaults['cols'] 			= 50;
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['rows'] 			= 10;
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-textarea-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-textarea.php' );

	} // field_textarea()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		$options[] = array( 'vc-mega-footer-append-via-hook', 'checkbox', '0' );
		$options[] = array( 'vc-mega-footer-append-via-hook-proper', 'text', 'wp_footer' );

		$options[] = array( 'vc-mega-footer-internal-column-width', 'number', '1170' );
		$options[] = array( 'vc-mega-footer-internal-column-width-enable', 'checkbox', '0' );

		$options[] = array( 'vc-mega-footer-vcrow-zero-padding', 'checkbox', '0' );
		$options[] = array( 'vc-mega-footer-vcrow-zero-margin', 'checkbox', '0' );
		$options[] = array( 'vc-mega-footer-vcrow-zero-leftright', 'checkbox', '0' );
		$options[] = array( 'vc-mega-footer-vcrow-zero-width', 'checkbox', '0' );

		$options[] = array( 'vc-mega-footer-footertag-nopaddingmargin', 'checkbox', '0' );
		$options[] = array( 'vc-mega-footer-footertag-hidecompletely', 'checkbox', '0' );


		// $options[] = array( 'message-no-openings', 'text', 'Thank you for your interest! There are no vcmegafooter openings at this time.' );
		// $options[] = array( 'howtoapply', 'editor', '' );
		// $options[] = array( 'repeat-test', 'repeater', array( array( 'test1', 'text' ), array( 'test2', 'text' ), array( 'test3', 'text' ) ) );

		return $options;

	} // get_options_list()

	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 * @return 		array 					The modified array of row links
	 */
	public function link_row( $links, $file ) {

		if ( VC_MEGA_FOOTERFILE === $file ) {

			// add a link in the plugin install area
			//   $links[] = '<a href="http://twitter.com/">Twitter</a>';

		}

		return $links;

	} // link_row()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'edit.php?post_type=vcmegafooter&page=' . $this->plugin_name . '-settings' ) ), esc_html__( 'Settings', 'vc-mega-footer' ) );

		return $links;

	} // link_settings()

	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_vcmegafooter() {

		$cap_type = 'post';
		$menu_name = 'Mega Footer';
		$plural = 'Footer Blocks';
		$single = 'Footer Block';
		$cpt_name = 'vcmegafooter';

		$opts['can_export']							= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']						= TRUE;
		$opts['has_archive']							= TRUE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']							= 	plugin_dir_url( __FILE__ ) . '/assets/vc16.png';
		$opts['menu_position']							= 77;
		$opts['public']								= TRUE; //TRUE;
		$opts['publicly_querable']						= FALSE; //TRUE;
		$opts['query_var']							= TRUE;
		$opts['register_meta_box_cb']						= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'page-attributes'  ); //, 'editor', 'thumbnail' );
		$opts['taxonomies']							= array( 'vcmegafooter_type' );

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'vc-mega-footer' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'vc-mega-footer' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'vc-mega-footer' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'vc-mega-footer' );
		$opts['labels']['menu_name']					= esc_html__( $menu_name, 'vc-mega-footer' );
		$opts['labels']['name']							= esc_html__( $plural, 'vc-mega-footer' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'vc-mega-footer' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'vc-mega-footer' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'vc-mega-footer' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'vc-mega-footer' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'vc-mega-footer' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'vc-mega-footer' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'vc-mega-footer' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'vc-mega-footer' );
		//
		// $opts['rewrite']['ep_mask']						= EP_PERMALINK;
		// $opts['rewrite']['feeds']						= FALSE;
		// $opts['rewrite']['pages']						= TRUE;
		// $opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'vc-mega-footer' );
		// $opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'vc-mega-footer-cpt-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_vcmegafooter()

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_type() {


		$plural 	= 'Footer Types';
		$single 	= 'Footer Type';
		$tax_name 	= 'vcmegafooter_type';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']								= TRUE;
		$opts['query_var']							= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 								= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'vc-mega-footer' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'vc-mega-footer' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'vc-mega-footer' );
		$opts['labels']['choose_from_most_used'] 			= esc_html__( "Choose from most used {$plural}", 'vc-mega-footer' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'vc-mega-footer');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'vc-mega-footer' );
		$opts['labels']['name'] 					= esc_html__( $plural, 'vc-mega-footer' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'vc-mega-footer' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'vc-mega-footer' );
		$opts['labels']['parent_item'] 				= esc_html__( "Parent {$single}", 'vc-mega-footer' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'vc-mega-footer' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'vc-mega-footer' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'vc-mega-footer' );
		$opts['labels']['separate_items_with_commas'] 		= esc_html__( "Separate {$plural} with commas", 'vc-mega-footer' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'vc-mega-footer' );
		$opts['labels']['update_item'] 				= esc_html__( "Update {$single}", 'vc-mega-footer' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'vc-mega-footer' );

		// $opts['rewrite']['ep_mask']				= EP_NONE;
		// $opts['rewrite']['hierarchical']				= FALSE;
		// $opts['rewrite']['slug']					= esc_html__( strtolower( $tax_name ), 'vc-mega-footer' );
		// $opts['rewrite']['with_front']				= FALSE;

		$opts = apply_filters( 'vc-mega-footer-taxonomy-options', $opts );

		register_taxonomy( $tax_name, 'vcmegafooter', $opts );

	} // new_taxonomy_type()

	/**
	 * Creates the help page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_help() {

		include( plugin_dir_path( __FILE__ ) . 'partials/vc-mega-footer-admin-page-help.php' );

	} // page_help()

	/**
	 * Creates the options page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_options() {

		include( plugin_dir_path( __FILE__ ) . 'partials/vc-mega-footer-admin-page-settings.php' );

	} // page_options()






	/**
	 * Registers settings fields
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );







		// Append via Hook
		 add_settings_field(
			'vc-mega-footer-append-via-hook',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-append-via-hook', esc_html__( 'Append via hook', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> '',
				'id' 			=> 'vc-mega-footer-append-via-hook',
				'value' 		=> '',
			)
		);
		add_settings_field(
			'vc-mega-footer-append-via-hook-proper',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-append-via-hook-proper', esc_html__( '', 'vc-mega-footer' ) ),
			array( $this, 'field_text' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'wp_footer is the default hook where Megafooter will run. You can create a custom hook using the code --- do_action("vc_mega_footer_placement_hook"); --- in your theme or child theme, and then set this field to "vc_mega_footer_placement_hook" to have the footer placed more precisely',
				'id' 			=> 'vc-mega-footer-append-via-hook-proper',
				'value' 		=> '',
			)
		);







		// Internal Column Width
		add_settings_field(
			'vc-mega-footer-internal-column-width',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-internal-column-width', esc_html__( 'Footer Internal Column Width', 'vc-mega-footer' ) ),
			array( $this, 'field_number' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'units' 		=> 'px',
				'description' 	=> 'For Stretch Row without Stretch Content in Visual Composer, sometimes the internal column width is not output correctly in the footer, we can set the max width here if required',
				'id' 			=> 'vc-mega-footer-internal-column-width',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'vc-mega-footer-internal-column-width-enable',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-internal-column-width-enable', esc_html__( 'Enable Internal Column Width', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> '',
				'id' 			=> 'vc-mega-footer-internal-column-width-enable',
				'value' 		=> '',
			)
		);









		// CSS Fixes to vc_row
		add_settings_field(
			'vc-mega-footer-vcrow-zero-padding',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-vcrow-zero-padding', esc_html__( 'Padding Fix', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets .vc_row padding to 0',
				'id' 			=> 'vc-mega-footer-vcrow-zero-padding',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'vc-mega-footer-vcrow-zero-margin',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-vcrow-zero-margin', esc_html__( 'Margin Fix', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets .vc_row margin to 0',
				'id' 			=> 'vc-mega-footer-vcrow-zero-margin',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'vc-mega-footer-vcrow-zero-width',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-vcrow-zero-width', esc_html__( 'Width Fix', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets .vc_row width to 100%',
				'id' 			=> 'vc-mega-footer-vcrow-zero-width',
				'value' 		=> '',
			)
		);



		add_settings_field(
			'vc-mega-footer-vcrow-zero-leftright',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-vcrow-zero-leftright', esc_html__( 'Left/Right Fix', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets .vc_row left and right to 0',
				'id' 			=> 'vc-mega-footer-vcrow-zero-leftright',
				'value' 		=> '',
			)
		);


		// CSS Fixes to Footer tag
		add_settings_field(
			'vc-mega-footer-footertag-nopaddingmargin',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-footertag-nopaddingmargin', esc_html__( 'Zero padding/margin on Footer tag', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets padding 0 and margin 0 for the footer tag',
				'id' 			=> 'vc-mega-footer-footertag-nopaddingmargin',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'vc-mega-footer-footertag-hidecompletely',
			apply_filters( $this->plugin_name . 'label-vc-mega-footer-footertag-hidecompletely', esc_html__( 'Hide original site footer', 'vc-mega-footer' ) ),
			array( $this, 'field_checkbox' ),
			$this->plugin_name,
			$this->plugin_name . '-messages',
			array(
				'description' 	=> 'Sets display:none for the footer tag',
				'id' 			=> 'vc-mega-footer-footertag-hidecompletely',
				'value' 		=> '',
			)
		);





	} // register_fields()

	/**
	 * Registers settings sections
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-messages',
			apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( '', 'vc-mega-footer' ) ),
			array( $this, 'section_messages' ),
			$this->plugin_name
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

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
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function section_messages( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/vc-mega-footer-admin-section-messages.php' );

	} // section_messages()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		//wp_die( print_r( $input ) );

		$valid 		= array();
		$options 	= $this->get_options_list();


		foreach ( $options as $option ) {

			$name = $option[0];
			$type = $option[1];


			if ( 'repeater' === $type && is_array( $option[2] ) ) {

				$clean = array();

				foreach ( $option[2] as $field ) {

					foreach ( $input[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count = vc_mega_footer_get_max( $clean );

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$valid[$option[0]][$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			} else {

				$valid[$option[0]] = $this->sanitizer( $type, $input[$name] );

			}

			/*if ( ! isset( $input[$option[0]] ) ) { continue; }

			$sanitizer = new VC_Mega_Footer_Sanitize();

			$sanitizer->set_data( $input[$option[0]] );
			$sanitizer->set_type( $option[1] );

			$valid[$option[0]] = $sanitizer->clean();

			if ( $valid[$option[0]] != $input[$option[0]] ) {

				add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'vc-mega-footer' ), 'error' );

			}

			unset( $sanitizer );*/

		}

		return $valid;

	} // validate_options()

} // class
