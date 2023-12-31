<?php
/**
 * Admin setup for the plugin
 *
 * @since 1.3
 * @function	iaff_add_menu_links()		Add admin menu pages
 * @function	iaff_register_settings()	Register Settings
 * @function	iaff_get_settings()			Set global default values for settings
 * @function	iaff_enqueue_js_and_css()	Load Admin Side Js and CSS
 */


// Exit if accessed directly
if ( !defined('ABSPATH') ) exit;
 
 
/**
 * Add admin menu pages
 *
 * @since 	1.0
 * @refer	https://developer.wordpress.org/plugins/administration-menus/
 */
function iaff_add_menu_links() {
	
	if ( iaff_is_pro() ) {
		$iaff_plugin_title 	= 'Image Attributes Pro';
		$iaff_menu_title 	= 'Image Attributes Pro';
	} else {
		$iaff_plugin_title 	= 'Auto Image Attributes';
		$iaff_menu_title 	= 'Image Attributes';
	}
	
	add_options_page( $iaff_plugin_title, $iaff_menu_title, 'manage_options', 'image-attributes-from-filename','iaff_admin_interface_render'  );
}
add_action( 'admin_menu', 'iaff_add_menu_links' );


/**
 * Register Settings
 *
 * @since 	1.0
 */
function iaff_register_settings() {

	// Register Setting
	register_setting( 
		'iaff_settings_group', 	// Group Name
		'iaff_settings', 		// Setting Name = HTML form <input> name on settings form
		'iaff_settings_validater_and_sanitizer'
	);
	
	// Register Basic Settings Section
    add_settings_section(
        'iaff_basic_settings_section_id',			// ID
        __('Basic Settings','auto-image-attributes-from-filename-with-bulk-updater'),			// Title
        '__return_false',							// Callback Function
        'iaff_basic_settings_section'				// Page slug
    );
		
		// General Settings
		add_settings_field(
			'iaff_general_settings',					// ID
			__( 'General Settings<p class="iaff-description">Select image attributes that should be automatically generated when you upload a new image.</p>', 'auto-image-attributes-from-filename-with-bulk-updater' ),		// Title
			'iaff_general_settings_callback',			// Callback function
			'iaff_basic_settings_section',				// Page slug
			'iaff_basic_settings_section_id'			// Settings Section ID
		);
		
		// Filter Settings
		add_settings_field(
			'iaff_filter_settings',						// ID
			__( 'Filter Settings<p class="iaff-description">Selected characters will be removed from filename text before using them as image attributes.</p>', 'auto-image-attributes-from-filename-with-bulk-updater' ),		// Title
			'iaff_filter_settings_callback',			// Callback function
			'iaff_basic_settings_section',				// Page slug
			'iaff_basic_settings_section_id'			// Settings Section ID
		);
		
		// Basic SEO Settings
		add_settings_field(
			'iaff_basic_seo_settings',					// ID
			__('Basic SEO Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
			'iaff_basic_seo_settings_callback',			// Callback function
			'iaff_basic_settings_section',				// Page slug
			'iaff_basic_settings_section_id'			// Settings Section ID
		);
		
		// Preview Pro Features
		if ( ! iaff_is_pro() ) {
			
			add_settings_field(
				'iaff_preview_pro_settings',				// ID
				__('Preview Pro Features', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
				'iaff_preview_pro_settings_callback',		// Callback function
				'iaff_basic_settings_section',				// Page slug
				'iaff_basic_settings_section_id'			// Settings Section ID
			);
		}
	
	// Register Advanced Settings Section
    add_settings_section(
        'iaff_advanced_settings_section_id',		// ID
        __('Advanced Settings','auto-image-attributes-from-filename-with-bulk-updater'),		// Title
        '__return_false',							// Callback Function
        'iaff_advanced_settings_section'			// Page slug
    );
	
		// Advanced Filter
		add_settings_field(
			'iaff_advanced_filter_settings',			// ID
			__( 'Advanced Filter<p class="iaff-description">Selected characters will be removed from filename text before using them as image attributes.</p>', 'auto-image-attributes-from-filename-with-bulk-updater' ),		// Title
			'iaff_advanced_filter_callback',			// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Custom Filter
		add_settings_field(
			'iaff_custom_filter_settings',				// ID
			__('Custom Filter', 'auto-image-attributes-from-filename-with-bulk-updater'),			// Title
			'iaff_custom_filter_callback',				// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Capitalization Settings
		add_settings_field(
			'iaff_capitalization_settings',				// ID
			__('Capitalization Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_capitalization_callback',				// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Image Title Settings
		add_settings_field(
			'iaff_image_title_settings',				// ID
			__('Image Title Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
			'iaff_advanced_image_title_callback',		// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Image Alt Text Settings
		add_settings_field(
			'iaff_image_alt_text_settings',				// ID
			__('Image Alt Text Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_advanced_image_alt_text_callback',	// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Image Caption Settings
		add_settings_field(
			'iaff_image_caption_settings',				// ID
			__('Image Caption Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_advanced_image_caption_callback',		// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Image Description Settings
		add_settings_field(
			'iaff_image_description_settings',			// ID
			__('Image Description Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_advanced_image_description_callback',	// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
		
		// Miscellaneous Settings
		add_settings_field(
			'iaff_miscellaneous_settings',				// ID
			__('Miscellaneous Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_miscellaneous_callback',				// Callback function
			'iaff_advanced_settings_section',			// Page slug
			'iaff_advanced_settings_section_id'			// Settings Section ID
		);
	
	// Register Bulk Updater Settings Section
    add_settings_section(
        'iaff_bu_settings_section_id',				// ID
        __('Bulk Updater Settings','auto-image-attributes-from-filename-with-bulk-updater'),	// Title
        '__return_false',							// Callback Function
        'iaff_bu_settings_section'					// Page slug
    );
	
		// General Settings
		add_settings_field(
			'iaff_bu_general_settings',						// ID
			__( 'General Settings<p class="iaff-description">Select image attributes that should be updated when you run the Bulk Updater.</p>', 'auto-image-attributes-from-filename-with-bulk-updater' ),			// Title
			'iaff_bu_general_settings_callback',			// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Filter Settings
		add_settings_field(
			'iaff_bu_filter_settings',						// ID
			__( 'Filter Settings<p class="iaff-description">Selected characters will be removed from filename text before using them as image attributes.</p>', 'auto-image-attributes-from-filename-with-bulk-updater' ),			// Title
			'iaff_bu_filter_settings_callback',				// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Custom Filter
		add_settings_field(
			'iaff_bu_custom_filter_settings',				// ID
			__('Custom Filter', 'auto-image-attributes-from-filename-with-bulk-updater'),				// Title
			'iaff_bu_custom_filter_callback',				// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Capitalization Settings
		add_settings_field(
			'iaff_bu_capitalization_settings',				// ID
			__('Capitalization Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
			'iaff_bu_capitalization_settings_callback',		// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Image Title Settings
		add_settings_field(
			'iaff_bu_image_title_settings',					// ID
			__('Image Title Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),		// Title
			'iaff_bu_image_title_settings_callback',		// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Image Alt Text Settings
		add_settings_field(
			'iaff_bu_alt_text_settings',					// ID
			__('Image Alt Text Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
			'iaff_bu_alt_text_settings_callback',			// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Image Caption Settings
		add_settings_field(
			'iaff_bu_image_caption_settings',				// ID
			__('Image Caption Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),	// Title
			'iaff_bu_image_caption_settings_callback',		// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);
		
		// Image Description Settings
		add_settings_field(
			'iaff_bu_image_description_settings',				// ID
			__('Image Description Settings', 'auto-image-attributes-from-filename-with-bulk-updater'),// Title
			'iaff_bu_image_description_settings_callback',	// Callback function
			'iaff_bu_settings_section',						// Page slug
			'iaff_bu_settings_section_id'					// Settings Section ID
		);

}
add_action( 'admin_init', 'iaff_register_settings' );

/**
 * Input validator and sanitizer
 *
 * @since 1.4
 * 
 * @param Array	$settings An array that contains all the settings
 * 
 * @return Array Array containing all the settings
 */
function iaff_settings_validater_and_sanitizer( $settings ) {
	
	// Sanitize Custom Filter
	$settings['custom_filter']	= sanitize_text_field( $settings['custom_filter'] );
	$settings['bu_custom_filter']	= sanitize_text_field( $settings['bu_custom_filter'] );
	
	// Sanitize Custom Attributes
	$settings['custom_attribute_title'] 			= iaff_sanitize_text_field( $settings['custom_attribute_title'] );
	$settings['custom_attribute_bu_title'] 			= iaff_sanitize_text_field( $settings['custom_attribute_bu_title'] );
	$settings['custom_attribute_alt_text'] 			= iaff_sanitize_text_field( $settings['custom_attribute_alt_text'] );
	$settings['custom_attribute_bu_alt_text'] 		= iaff_sanitize_text_field( $settings['custom_attribute_bu_alt_text'] );
	$settings['custom_attribute_caption'] 			= iaff_sanitize_text_field( $settings['custom_attribute_caption'] );
	$settings['custom_attribute_bu_caption'] 		= iaff_sanitize_text_field( $settings['custom_attribute_bu_caption'] );
	$settings['custom_attribute_description'] 		= iaff_sanitize_text_field( $settings['custom_attribute_description'] );
	$settings['custom_attribute_bu_description'] 	= iaff_sanitize_text_field( $settings['custom_attribute_bu_description'] );
	
	// Validating Regex
	if( @preg_match( $settings['regex_filter'], null ) === false ) {
		unset( $settings['regex_filter'] );
	}
	
	// Validating Bulk Updater Regex
	if( @preg_match( $settings['bu_regex_filter'], null ) === false ) {
		unset( $settings['bu_regex_filter'] );
	}
	
	return $settings;
}

/**
 * Extend sanitize_text_field() to preserve %category% custom attribute tag.
 * 
 * sanitize_text_field() converts %category% to tegory%.
 * Here %category% is replaced with IAFF_CATEGORY_CUSTOM_TAG keyword before sanitization. 
 * Then IAFF_CATEGORY_CUSTOM_TAG is replaced with %category% after sanitization. 
 * 
 * @since 3.1
 * 
 * @param (String) $str String to be sanitized.
 * 
 * @return (String) Sanitized string with %category% preserved. 
 */
function iaff_sanitize_text_field( $str ) {

	$str = str_replace( '%category%', 'IAFF_CATEGORY_CUSTOM_TAG', $str );
	$str = sanitize_text_field( $str );
	$str = str_replace( 'IAFF_CATEGORY_CUSTOM_TAG', '%category%', $str );

	return $str;
}

/**
 * Set global default values for settings
 *
 * @since 	1.4
 * @return	Array	A merged array of default and settings saved in database. 
 */
function iaff_get_settings() {

	$iaff_defaults = array(
		'image_title' 			=> '1',
		'image_caption' 		=> '1',
		'image_description' 		=> '1',
		'image_alttext' 		=> '1',
		'image_title_to_html' 		=> '1',
		'preview_pro'			=> '0',
		'hyphens' 			=> '1',
		'under_score' 			=> '1',
		'capitalization'		=> '0',
		'title_source'			=> '0',
		'alt_text_source'		=> '0',
		'caption_source'		=> '0',
		'description_source'		=> '0',
		'clean_filename'		=> '1',
		'bu_image_title' 		=> '1',
		'bu_image_caption' 		=> '1',
		'bu_image_description' 		=> '1',
		'bu_image_alttext' 		=> '1',
		'bu_capitalization'		=> '0',
		'bu_title_source'		=> '0',
		'bu_titles_in_post'		=> '2',
		'bu_alt_text_source'		=> '0',
		'bu_alt_text_in_post'		=> '2',
		'bu_caption_source'		=> '0',
		'bu_caption_behaviour'		=> '1',
		'bu_description_source'		=> '0',
		'bu_description_behaviour'	=> '1',
	);

	$settings = get_option('iaff_settings', $iaff_defaults);
	
	return $settings;
}

/**
 * Load Admin Side Js and CSS
 *
 * Used for styling the plugin pages and bulk updater.
 * @since	1.3
 */
function iaff_enqueue_js_and_css() {
	
	// Load files only on plugin screens
	$screen = get_current_screen();
	if ( $screen->id !== "settings_page_image-attributes-from-filename" ) {
		return;
	}
	
	// Custom IAFF Styling
    wp_enqueue_style( 'iaff-style', plugins_url( '/css/iaff-style.css', __FILE__ ), '', IAFF_VERSION_NUM );
	
	// Custom IAFF JS
	wp_enqueue_script( 'iaff-js', plugins_url('/js/iaff-js.js', __FILE__), array( 'jquery', 'jquery-ui-dialog' ), IAFF_VERSION_NUM, true );
	
	// jQuery Dialog CSS
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	
	// Google Fonts
	wp_enqueue_style('iaff-google-font', 'https://fonts.googleapis.com/css?family=Patua+One', array(), null, 'all');
}
add_action( 'admin_enqueue_scripts', 'iaff_enqueue_js_and_css' );

/**
 * Tags for custom attribute
 * 
 * @since 2.1
 */
function iaff_custom_attribute_tags() {
	
	$available_tags = array(
		'filename'		=> __( 'Image filename', 'auto-image-attributes-from-filename-with-bulk-updater' ),
		'posttitle'		=> __( 'Title of the post, page or product where the image is used', 'auto-image-attributes-from-filename-with-bulk-updater' ),
		'sitetitle'		=> __( 'Site Title defined in WordPress General Settings', 'auto-image-attributes-from-filename-with-bulk-updater' ),
		'category'		=> __( 'Post or product Category', 'auto-image-attributes-from-filename-with-bulk-updater' ),
		'tag'			=> __( 'Post or product Tag', 'auto-image-attributes-from-filename-with-bulk-updater' ),
		'excerpt'		=> __( 'Excerpt or product short description', 'auto-image-attributes-from-filename-with-bulk-updater' ),
	);
	
	/**
	 * Filter the custom attribute tags. 
	 * Used by Image Attributes Pro to add custom tags like %yoastfocuskw% and %rankmathfocuskw% dynamically. 
	 * 
	 * @since 3.1
	 * 
	 * @param $available_tags (array) Array containing all custom attribute tags.
	 */
	return apply_filters( 'iaff_custom_attribute_tags', $available_tags );
}