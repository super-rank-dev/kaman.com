<?php



/**

 * Public-facing functionality of the plugin

 *

 *

 * @link       http://happyrobotstudio.com

 * @since      1.0.0

 *

 * @package    VC_Mega_Footer

 * @subpackage VC_Mega_Footer/public

 */





/**

 *

 * @package    VC_Mega_Footer

 * @subpackage VC_Mega_Footer/public

 * @author     Happyrobotstudio <happyrobotstudio@gmail.com>

 */

class VC_Mega_Footer_Public {



	/**

	 * @since 		1.0.0

	 * @access 		private

	 * @var 		string 	$options    Plugin options

	 */

	private $options;



	/**

	 * @since    1.0.0

	 * @access   private

	 * @var      string    $plugin_name    	The unique identifier of the plugin

	 */

	private $plugin_name;



	/**

	 * @since    1.0.0

	 * @access   private

	 * @var      string    $version    		Plugin version

	 */

	private $version;



	/**

	 * @since	1.0.0

	 * @param	string    $plugin_name     	The unique identifier of the plugin

	 * @param	string    $version    		Plugin version

	 */

	public function __construct( $plugin_name, $version ) {



		$this->plugin_name = $plugin_name;

		$this->version = $version;



		$this->set_options();

	}





	/**

	 * Stylesheets for the public-facing side of the plugin

	 *

	 * @since    1.0.0

	 */

	public function enqueue_styles() {



		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vc-mega-footer-public.css', array(), $this->version, 'all' );



	}





	/**

	 * JavaScript for the public-facing side of the plugin

	 *

	 * @since    1.0.0

	 */

	public function enqueue_scripts() {



		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vc-mega-footer-public.js', array( 'jquery' ), $this->version, false );



	}





	/**

	 * Sets the class variable $options

	 */

	private function set_options() {



		$this->options = get_option( $this->plugin_name . '-options' );



	} // set_options()





	/**

	 * Gets the meta

	 */

	public function get_meta( $postobj ) {



		if ( empty( $postobj ) ) { return; }

		if ( 'vcmegafooter' != $postobj->post_type ) { return; }



		return get_post_custom( $postobj->ID );



	} // set_meta()





	/**

	 * Adds a default single view template for a vcmegafooter

	 *

	 * @param 	string 		$template 		The name of the template

	 * @return 	mixed 					The single template

	 */

	public function single_cpt_template( $template ) {



		global $post;



		$return = $template;



	    	if ( $post->post_type == 'vcmegafooter' ) {

			$return = "";

		}



		return $return;



	} // single_cpt_template()































	/**

	 * Ensure visual composer stylesheet is output at the correct time

	 *

	 * visual composer usually only runs on pages where VC is active, however,

	 * with our footer being active all the time, we want the VC styles to always output

	 *

	 * @param 	null

	 * @return 	null

	 */

	public function js_composer_front_load() {

		if( is_plugin_active('js_composer/js_composer.php') ) {

			wp_enqueue_style('js_composer_front');

		}

	}



















	/**

	 * Output all our vcmegafooter posts

	 *

	 * @param 	string 		$template 		The name of the template

	 * @return 	mixed 						The single template

	 */

	public function output_all_footers() {


		$rvr = ""; // return var


		// get details of the current page

		$current_id = get_the_ID();

		$current_posttype = get_post_type( $current_id );





		// gather all our vcmegafooter footer blocks

		$args = array(

			'sort_order' => 'ASC',

			'sort_column' => 'menu_order',

			'exclude_tree' => '',

			'number' => '',

			'offset' => 0,

			'post_type' => 'vcmegafooter',

			'post_status' => 'publish'

		);

		$allposts = get_pages($args);







		// loop through footer blocks

		$posts_selections = array();

		if ( $allposts ) {

			foreach ( $allposts as $ap ) {





				$thismeta = $this->get_meta( $ap );



				// vcmegafooter post type meta vars

				//

				// vcmegafooter-enabled

				// vcmegafooter-showonpages

				// vcmegafooter-showonposts

				// vcmegafooter-showonpostcategories

				// vcmegafooter-showonposttags





				// enabled/disabled

				if( !$thismeta['vcmegafooter-enabled'][0] ) {   continue;   }



				// check for _show on pages_ condition

				if( $thismeta['vcmegafooter-showonpages'][0] ) {

					$show_on_pages = explode( ',', $thismeta['vcmegafooter-showonpages'][0] );

					if( $current_posttype == 'page' ) {

						if( !in_array( $current_id, $show_on_pages) || in_array( 'hideall', $show_on_pages) ) {

							continue;

						}

					}

				}



				// check for _show on posts_ condition

				if( $thismeta['vcmegafooter-showonposts'][0] ) {

					$show_on_posts = explode( ',', $thismeta['vcmegafooter-showonposts'][0] );

					if( $current_posttype == 'post' ) {

						if( !in_array( $current_id, $show_on_posts) || in_array( 'hideall', $show_on_posts) ) {

							continue;

						}

					}

				}















				//

				// THE_CONTENT

				//

				//

				$rvr .= "<div class='vcmega-main-wrap' id='vcmega-main-wrap-{$ap->ID}'>";

				$rvr .= "<div class='vcmega-inner-wrap' id='vcmega-inner-wrap-{$ap->ID}'>";





				$content = $ap->post_content;

				if ( $content ) {



					 $mgft_the_content = apply_filters( 'the_content', $content );



					 // let's perform some manipulation of the the_content DOM with phpQuery

					 //

					 $document = phpQuery::newDocumentHTML( $mgft_the_content );



					 // add our own container element to vc_row

					 $document->children('.vc_row')->not('.vc_row[data-vc-stretch-content="true"]')->addClass('vcmega-vcrow')->wrapInner('<div class="vcmega-container"></div>');



					 // hide extra elements that are hooked into 'the_content'

					 $document->children()->attr('style','display:none;');



					 // output our phpQuery'ified DOM

				     $rvr .= phpQuery::getDocument( $document->getDocumentID() );



				}



				$rvr .= "</div>";

				$rvr .= "</div>";





















				// there is extra CSS per row from Visual Composer, we will include that

				//

				// from: public function addPageCustomCss() js_composer/include/classes/code/class-vc-base.php

				$post_custom_css = get_post_meta( $ap->ID, '_wpb_post_custom_css', true );

				if ( ! empty( $post_custom_css ) ) {

					$rvr .= '<style type="text/css" data-type="vc_custom-css">';

					$rvr .= $post_custom_css;

					$rvr .= '</style>';

				}



				$shortcodes_custom_css = get_post_meta( $ap->ID, '_wpb_shortcodes_custom_css', true );

				if ( ! empty( $shortcodes_custom_css ) ) {

					$rvr .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';

					$rvr .= $shortcodes_custom_css;

					$rvr .= '</style>';

				}











			} /* foreach ( $allposts ) */





		} /* if ( $allposts ) */















		////////////////////////

		// INTERNAL CONTAINER //

		////////////////////////



		// we are applying a user supplied inner width for the VC boostrap containers

		$internal_footer_column_width = '1170';

		if( !empty($this->options["vc-mega-footer-internal-column-width"]) ) {

			$internal_footer_column_width = $this->options["vc-mega-footer-internal-column-width"];

		}



		$rvr .= "<style type='text/css' data-type='vc_custom-css'>

			.vcmega-main-wrap .vcmega-container {

				width:100%;";

				if( $this->options["vc-mega-footer-internal-column-width-enable"] ) {

					$rvr .= "max-width: ".$internal_footer_column_width."px;";

				}

				$rvr .= "

				margin: 0px auto;

				position: relative;

			}

		</style>";













		//////////////////////////

		// SELECTABLE CSS FIXES //

		//////////////////////////



		$rvr .= "<style type='text/css'>

			.vcmega-main-wrap .vc_row,

			.vcmega-main-wrap .vc_section {

		";



			if( $this->options["vc-mega-footer-vcrow-zero-padding"] == 1 ) :

					$rvr .= "padding:0 !important;";

			endif;

			if( $this->options["vc-mega-footer-vcrow-zero-margin"] == 1 ) :

					$rvr .= "margin:0 !important;";

			endif;

			if( $this->options["vc-mega-footer-vcrow-zero-leftright"] == 1 ) :

					$rvr .= "left:0 !important; right:0 !important;";

			endif;

			if( $this->options["vc-mega-footer-vcrow-zero-width"] == 1 ) :

					$rvr .= "width:100% !important;";

			endif;



		$rvr .= "

			}



			footer {

		";

			if( $this->options["vc-mega-footer-footertag-nopaddingmargin"] == 1 ) :

					$rvr .= "margin:0 !important; padding:0 !important;";

			endif;

			if( $this->options["vc-mega-footer-footertag-hidecompletely"] == 1 ) :

					$rvr .= "display:none !important;";

			endif;



		$rvr .= "

			}

		 	</style>";









		return $rvr;


	} // output_all_footers()









	/**

	 * Output all our vcmegafooter posts

	 *

	 * @param 	string 		$template 		The name of the template

	 * @return 	mixed 						The single template

	 */

	public function output_all_footers_verbose() {



		$footer_content = $this->output_all_footers();





		echo $footer_content;



	} // output_all_footers_verbose()































































	//////////////////////

	// ULTIMATE ADDONS  //

	//////////////////////







	/**

	 * Re-create the Ultimate Addons scripts and styles per Footer Block Post

	 *

	 * This is a fix to manually import the scripts and styles when using Ultimate Addons

	 *

	 * the function Ultimate_VC_Addons::check_our_element_on_page() runs only once,

	 * this checks only the 'primary post' for matching Ultimate Addons elements

	 *

	 * We want to check _all_ the posts, including the vcmegafooter ones we have output in the footer,

	 * to see whether or not to run ultimate addons

	 *

	 * The method here is to simply import the function itself from the ultimate addons code

	 * and apply a fix to the various paths

	 *

	 * @return 	void

	 */



	public function ultimate_addons_active() {



		if( is_plugin_active( 'Ultimate_VC_Addons/Ultimate_VC_Addons.php' ) ) {



			//echo ULTIMATE_VERSION.' '.__ULTIMATE_ROOT__ . 'Ultimate_VC_Addons active';



            $args = array(

                'sort_order' => 'ASC',

                'sort_column' => 'menu_order',

                'exclude_tree' => '',

                'number' => '',

                'offset' => 0,

                'post_type' => 'vcmegafooter',

                'post_status' => 'publish'

            );

		    $allposts = get_pages($args);



			// loop through footer blocks

			$posts_selections = array();

			if ( $allposts ) {

			    foreach ( $allposts as $ap ) {

					// lets run our Ultimate Addons checks for each Footer Block

					$this->mgft_aio_front_scripts( $ap );

				}

			}





		}



	}



	public function mgft_check_our_element_on_page($post_content) {

		// check for background

		$found_ultimate_backgrounds = false;

		if(stripos( $post_content, 'bg_type=')) {

			preg_match('/bg_type="(.*?)"/', $post_content, $output);

			if(

				$output[1] === 'bg_color'

				|| $output[1] === 'grad'

				|| $output[1] === 'image'

				|| $output[1] === 'u_iframe'

				|| $output[1] === 'video'

			) {

				$found_ultimate_backgrounds = true;

			}

		}

		if(

				stripos( $post_content, '[ultimate_spacer')

				|| stripos( $post_content, '[ult_buttons')

				|| stripos( $post_content, '[ultimate_icon_list')

				|| stripos( $post_content, '[just_icon')

				|| stripos( $post_content, '[ult_animation_block')

				|| stripos( $post_content, '[icon_counter')

				|| stripos( $post_content, '[ultimate_google_map')

				|| stripos( $post_content, '[icon_timeline')

				|| stripos( $post_content, '[bsf-info-box')

				|| stripos( $post_content, '[info_list')

				|| stripos( $post_content, '[ultimate_info_table')

				|| stripos( $post_content, '[interactive_banner_2')

				|| stripos( $post_content, '[interactive_banner')

				|| stripos( $post_content, '[ultimate_pricing')

				|| stripos( $post_content, '[ultimate_icons')

				|| stripos( $post_content, '[ultimate_heading')

				|| stripos( $post_content, '[ultimate_carousel')

				|| stripos( $post_content, '[ult_countdown')

				|| stripos( $post_content, '[ultimate_info_banner')

				|| stripos( $post_content, '[swatch_container')

				|| stripos( $post_content, '[ult_ihover')

				|| stripos( $post_content, '[ult_hotspot')

				|| stripos( $post_content, '[ult_content_box')

				|| stripos( $post_content, '[ultimate_ctation')

				|| stripos( $post_content, '[stat_counter')

				|| stripos( $post_content, '[ultimate_video_banner')

				|| stripos( $post_content, '[ult_dualbutton')

				|| stripos( $post_content, '[ult_createlink')

				|| stripos( $post_content, '[ultimate_img_separator')

				|| stripos( $post_content, '[ult_tab_element')

				|| stripos( $post_content, '[ultimate_exp_section')

				|| stripos( $post_content, '[info_circle')

				|| stripos( $post_content, '[ultimate_modal')



				|| stripos( $post_content, '[ult_sticky_section')



				|| stripos( $post_content, '[ult_team')

				|| stripos( $post_content, '[ultimate_fancytext')

				|| stripos( $post_content, '[ult_range_slider')

				|| $found_ultimate_backgrounds

			) {

			return true;

		}

		else {

			return false;

		}

	}



	public function mgft_bsf_get_option($request = false) {

		$bsf_options = get_option('bsf_options');

		if(!$request)

			return $bsf_options;

		else

			return (isset($bsf_options[$request])) ? $bsf_options[$request] : false;

	}



	/**

	 * Re-create the Ultimate Addons scripts and styles loader

	 *

	 * @return 	void

	 */

	public function mgft_aio_front_scripts($post)

	{



		// this is the same function from Ultimate_VC_Addons,

		// but we are using the following var to make sure the paths are correct

		// and including the $post variable specifically as a param,

		// so we can run this on each footer block post



		//echo "<h1>mgft_aio_front_scripts ({$post->ID})</h1>";

		$mgft_ultimate_folder_name = 'Ultimate_VC_Addons';



		$isAjax = false;

		$ultimate_ajax_theme = get_option('ultimate_ajax_theme');

		if($ultimate_ajax_theme == 'enable')

			$isAjax = true;

		$dependancy = array('jquery');



		$bsf_dev_mode = $this->mgft_bsf_get_option('dev_mode');

		if($bsf_dev_mode === 'enable') {

			$js_path = 'assets/js/';

			$css_path = 'assets/css/';

			$ext = '';

		}

		else {

			$js_path = 'assets/min-js/';

			$css_path = 'assets/min-css/';

			$ext = '.min';

		}



		$ultimate_smooth_scroll_compatible = get_option('ultimate_smooth_scroll_compatible');





		// register js

		wp_register_script('ultimate-script',plugins_url($mgft_ultimate_folder_name.'/'.'assets/min-js/ultimate.min.js'),array('jquery', 'jquery-ui-core' ), ULTIMATE_VERSION, false);

		wp_register_script('ultimate-appear',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'jquery-appear'.$ext.'.js'),array('jquery'), ULTIMATE_VERSION);

		wp_register_script('ultimate-custom',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'custom'.$ext.'.js'),array('jquery'), ULTIMATE_VERSION);

		wp_register_script('ultimate-vc-params',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'ultimate-params'.$ext.'.js'),array('jquery'), ULTIMATE_VERSION);

		if($ultimate_smooth_scroll_compatible === 'enable') {

			$smoothScroll = 'SmoothScroll-compatible.min.js';

		}

		else {

			$smoothScroll = 'SmoothScroll.min.js';

		}

		wp_register_script('ultimate-smooth-scroll',plugins_url($mgft_ultimate_folder_name.'/'.'assets/min-js/'.$smoothScroll),array('jquery'),ULTIMATE_VERSION,true);

		wp_register_script("ultimate-modernizr",plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'modernizr-custom'.$ext.'.js'),array('jquery'),ULTIMATE_VERSION);

		wp_register_script("ultimate-tooltip",plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'tooltip'.$ext.'.js'),array('jquery'),ULTIMATE_VERSION);



		// register css

		wp_register_style('ultimate-animate',plugins_url($mgft_ultimate_folder_name.'/'.$css_path.'animate'.$ext.'.css'),array(),ULTIMATE_VERSION);

		wp_register_style('ultimate-style',plugins_url($mgft_ultimate_folder_name.'/'.$css_path.'style'.$ext.'.css'),array(),ULTIMATE_VERSION);

		wp_register_style('ultimate-style-min',plugins_url($mgft_ultimate_folder_name.'/'.'assets/min-css/ultimate.min.css'),array(),ULTIMATE_VERSION);

		wp_register_style('ultimate-tooltip',plugins_url($mgft_ultimate_folder_name.'/'.$css_path.'tooltip'.$ext.'.css'),array(),ULTIMATE_VERSION);



		$ultimate_smooth_scroll = get_option('ultimate_smooth_scroll');

		if($ultimate_smooth_scroll == "enable" || $ultimate_smooth_scroll_compatible === 'enable') {

			wp_enqueue_script('ultimate-smooth-scroll');

		}



		if(function_exists('vc_is_editor')){

			if(vc_is_editor()){

				wp_enqueue_style('vc-fronteditor',plugins_url($mgft_ultimate_folder_name.'/'.'assets/min-css/vc-fronteditor.min.css'));

			}

		}

		$fonts = get_option('smile_fonts');

		if(is_array($fonts))

		{

			foreach($fonts as $font => $info)

			{

				$style_url = $info['style'];

				if(strpos($style_url, 'http://' ) !== false) {

					wp_enqueue_style('bsf-'.$font,$info['style']);

				} else {

					$up_dir = wp_upload_dir();

					$up_dir = $up_dir['baseurl'];



					wp_enqueue_style('bsf-'.$font,trailingslashit($up_dir.'/smile_fonts'/*$this->paths['fonturl']*/).$info['style']);

				}

			}

		}



		//$ultimate_global_scripts = $this->mgft_bsf_get_option('ultimate_global_scripts');

		if( true ) { //}$ultimate_global_scripts === 'enable') {

			wp_enqueue_script('ultimate-modernizr');

			wp_enqueue_script('jquery_ui');

			wp_enqueue_script('masonry');

			if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))

				$load_map_api = false;

			else

				$load_map_api = true;

			if($load_map_api)

				wp_enqueue_script('googleapis');

			/* Range Slider Dependecy */

			wp_enqueue_script('jquery-ui-mouse');

			wp_enqueue_script('jquery-ui-widget');

			wp_enqueue_script('jquery-ui-slider');

			wp_enqueue_script('ult_range_tick');

			/* Range Slider Dependecy */

			wp_enqueue_script('ultimate-script');

			wp_enqueue_script('ultimate-modal-all');

			wp_enqueue_script('jquery.shake',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'jparallax'.$ext.'.js'));

			wp_enqueue_script('jquery.vhparallax',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'vhparallax'.$ext.'.js'));



			wp_enqueue_style('ultimate-style-min');

			wp_enqueue_style("ult-icons");

			wp_enqueue_style('ultimate-vidcons',plugins_url($mgft_ultimate_folder_name.'/'.'assets/fonts/vidcons.css'));

			wp_enqueue_script('jquery.ytplayer',plugins_url($mgft_ultimate_folder_name.'/'.$js_path.'mb-YTPlayer'.$ext.'.js'));



			//$Ultimate_Google_Font_Manager = new Ultimate_Google_Font_Manager;
			$Ultimate_Google_Font_Manager = new Ultimate_VC_Addons_Google_Font_Manager;

			$Ultimate_Google_Font_Manager->enqueue_selected_ultimate_google_fonts();



			//return false;

		}



		// if(!is_404() && !is_search()){



			// global $post;







			if(!$post) return false;



			$post_content = $post->post_content;



			$is_element_on_page = $this->mgft_check_our_element_on_page($post_content);



			if(stripos($post_content, 'font_call:'))

			{

				preg_match_all('/font_call:(.*?)"/',$post_content, $display);

				enquque_ultimate_google_fonts_optimzed($display[1]);

			}



			if(!$is_element_on_page)

				return false;



			$ultimate_js = get_option('ultimate_js');



			if(($ultimate_js == 'enable' || $isAjax == true) && ($bsf_dev_mode != 'enable') )

			{

				if(

						stripos( $post_content, '[swatch_container')

						|| stripos( $post_content, '[ultimate_modal')

				)

				{

					wp_enqueue_script('ultimate-modernizr');

				}



				if( stripos( $post_content, '[ultimate_exp_section') ||

					stripos( $post_content, '[info_circle') ) {

					wp_enqueue_script('jquery_ui');

				}



				if( stripos( $post_content, '[icon_timeline') ) {

					wp_enqueue_script('masonry');

				}



				if($isAjax == true) { // if ajax site load all js

					wp_enqueue_script('masonry');

				}



				if( stripos( $post_content, '[ultimate_google_map') ) {

					if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))

						$load_map_api = false;

					else

						$load_map_api = true;

					if($load_map_api)

						wp_enqueue_script('googleapis');

				}



				if( stripos( $post_content, '[ult_range_slider') ) {

					wp_enqueue_script('jquery-ui-mouse');

					wp_enqueue_script('jquery-ui-widget');

					wp_enqueue_script('jquery-ui-slider');

					wp_enqueue_script('ult_range_tick');

					wp_enqueue_script('ult_ui_touch_punch');

				}



				wp_enqueue_script('ultimate-script');



				if( stripos( $post_content, '[ultimate_modal') ) {

					//$modal_fixer = get_option('ultimate_modal_fixer');

					//if($modal_fixer === 'enable')

						//wp_enqueue_script('ultimate-modal-all-switched');

					//else

						wp_enqueue_script('ultimate-modal-all');

				}

			}

			else if($ultimate_js == 'disable')

			{

				wp_enqueue_script('ultimate-vc-params');



				if(

					stripos( $post_content, '[ultimate_spacer')

					|| stripos( $post_content, '[ult_buttons')

					|| stripos( $post_content, '[ult_team')

					|| stripos( $post_content, '[ultimate_icon_list')



				) {

					wp_enqueue_script('ultimate-custom');

				}

				if(

					stripos( $post_content, '[just_icon')

					|| stripos( $post_content, '[ult_animation_block')

					|| stripos( $post_content, '[icon_counter')

					|| stripos( $post_content, '[ultimate_google_map')

					|| stripos( $post_content, '[icon_timeline')

					|| stripos( $post_content, '[bsf-info-box')

					|| stripos( $post_content, '[info_list')

					|| stripos( $post_content, '[ultimate_info_table')

					|| stripos( $post_content, '[interactive_banner_2')

					|| stripos( $post_content, '[interactive_banner')

					|| stripos( $post_content, '[ultimate_pricing')

					|| stripos( $post_content, '[ultimate_icons')

				) {

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('ultimate-custom');

				}

				if( stripos( $post_content, '[ultimate_heading') ) {

					wp_enqueue_script("ultimate-headings-script");

				}

				if( stripos( $post_content, '[ultimate_carousel') ) {

					wp_enqueue_script('ult-slick');

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('ult-slick-custom');

				}

				if( stripos( $post_content, '[ult_countdown') ) {

					wp_enqueue_script('jquery.timecircle');

					wp_enqueue_script('jquery.countdown');

				}

				if( stripos( $post_content, '[icon_timeline') ) {

					wp_enqueue_script('masonry');

				}

				if( stripos( $post_content, '[ultimate_info_banner') ) {

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('utl-info-banner-script');

				}

				if( stripos( $post_content, '[ultimate_google_map') ) {

					if(defined('DISABLE_ULTIMATE_GOOGLE_MAP_API') && (DISABLE_ULTIMATE_GOOGLE_MAP_API == true || DISABLE_ULTIMATE_GOOGLE_MAP_API == 'true'))

						$load_map_api = false;

					else

						$load_map_api = true;

					if($load_map_api)

						wp_enqueue_script('googleapis');

				}

				if( stripos( $post_content, '[swatch_container') ) {

					wp_enqueue_script('ultimate-modernizr');

					wp_enqueue_script('swatchbook-js');

				}

				if( stripos( $post_content, '[ult_ihover') ) {

					wp_enqueue_script('ult_ihover_js');

				}

				if( stripos( $post_content, '[ult_hotspot') ) {

					wp_enqueue_script('ult_hotspot_tooltipster_js');

					wp_enqueue_script('ult_hotspot_js');

				}

				if( stripos( $post_content, '[ult_content_box') ) {

					wp_enqueue_script('ult_content_box_js');

				}

				if( stripos( $post_content, '[bsf-info-box') ) {

					wp_enqueue_script('info_box_js');

				}

				if( stripos( $post_content, '[icon_counter') ) {

					wp_enqueue_script('flip_box_js');

				}

				if( stripos( $post_content, '[ultimate_ctation') ) {

					wp_enqueue_script('utl-ctaction-script');

				}

				if( stripos( $post_content, '[stat_counter') ) {

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('ult-stats-counter-js');

					//wp_enqueue_script('ult-slick-custom');

					wp_enqueue_script('ultimate-custom');

					array_push($dependancy,'stats-counter-js');

				}

				if( stripos( $post_content, '[ultimate_video_banner') ) {

					wp_enqueue_script('ultimate-video-banner-script');

				}

				if( stripos( $post_content, '[ult_dualbutton') ) {

					wp_enqueue_script('jquery.dualbtn');



				}

				if( stripos( $post_content, '[ult_createlink') ) {

					wp_enqueue_script('jquery.ult_cllink');

				}

				if( stripos( $post_content, '[ultimate_img_separator') ) {

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('ult-easy-separator-script');

					wp_enqueue_script('ultimate-custom');

				}



				if( stripos( $post_content, '[ult_tab_element') ) {

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('ult_tabs_rotate');

					wp_enqueue_script('ult_tabs_acordian_js');

				}

				if( stripos( $post_content, '[ultimate_exp_section') ) {

					wp_enqueue_script('jquery_ui');

					wp_enqueue_script('jquery_ultimate_expsection');

				}



				if( stripos( $post_content, '[info_circle') ) {

					wp_enqueue_script('jquery_ui');

					wp_enqueue_script('ultimate-appear');

					wp_enqueue_script('info-circle');

					//wp_enqueue_script('info-circle-ui-effect');

				}



				if( stripos( $post_content, '[ultimate_modal') ) {

					wp_enqueue_script('ultimate-modernizr');

					//$modal_fixer = get_option('ultimate_modal_fixer');

					//if($modal_fixer === 'enable')

						//wp_enqueue_script('ultimate-modal-all-switched');

					//else

					if($bsf_dev_mode == true || $bsf_dev_mode == 'true') {

						wp_enqueue_script('ultimate-modal-customizer');

						wp_enqueue_script('ultimate-modal-classie');

						wp_enqueue_script('ultimate-modal-froogaloop2');

						wp_enqueue_script('ultimate-modal-snap-svg');

						wp_enqueue_script('ultimate-modal');

					} else {

						wp_enqueue_script('ultimate-modal-all');

					}

				}



				if( stripos( $post_content, '[ult_sticky_section') ) {

					wp_enqueue_script('ult_sticky_js');

					wp_enqueue_script('ult_sticky_section_js');

				}



				if( stripos( $post_content, '[ult_team') ) {

					wp_enqueue_script('ultimate-team');

				}



				if( stripos( $post_content, '[ult_range_slider') ) {

					wp_enqueue_script('jquery-ui-mouse');

					wp_enqueue_script('jquery-ui-widget');

					wp_enqueue_script('jquery-ui-slider');

					wp_enqueue_script('ult_range_tick');

					wp_enqueue_script('ult_range_slider_js');

					wp_enqueue_script('ult_ui_touch_punch');

				}

			}



			$ultimate_css = get_option('ultimate_css');



			if($ultimate_css == "enable"){

				wp_enqueue_style('ultimate-style-min');

				if( stripos( $post_content, '[ultimate_carousel') ) {

					wp_enqueue_style("ult-icons");

				}

			} else {



				$ib_2_found = $ib_found = false;



				wp_enqueue_style('ultimate-style');



				if( stripos( $post_content, '[ult_animation_block') ) {

					wp_enqueue_style('ultimate-animate');

				}

				if( stripos( $post_content, '[icon_counter') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ult-flip-style');

				}

				if( stripos( $post_content, '[ult_countdown') ) {

					wp_enqueue_style('ult-countdown');

				}

				if( stripos( $post_content, '[ultimate_icon_list') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ultimate-tooltip');

				}

				if( stripos( $post_content, '[ultimate_carousel') ) {

					wp_enqueue_style("ult-slick");

					wp_enqueue_style("ult-icons");

					wp_enqueue_style("ultimate-animate");

				}

				if( stripos( $post_content, '[ultimate_fancytext') ) {

					wp_enqueue_style('ultimate-fancytext-style');

				}

				if( stripos( $post_content, '[ultimate_ctation') ) {

					wp_enqueue_style('utl-ctaction-style');

				}

				if( stripos( $post_content, '[ult_buttons') ) {

					wp_enqueue_style( 'ult-btn' );

				}

				if( stripos( $post_content, '[ultimate_heading') ) {

					wp_enqueue_style("ultimate-headings-style");

				}

				if( stripos( $post_content, '[ultimate_icons') || stripos( $post_content, '[single_icon')) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ultimate-tooltip');

				}

				if( stripos( $post_content, '[ult_ihover') ) {

					 wp_enqueue_style( 'ult_ihover_css' );

				}

				if( stripos( $post_content, '[ult_hotspot') ) {

					wp_enqueue_style( 'ult_hotspot_css' );

					wp_enqueue_style( 'ult_hotspot_tooltipster_css' );

				}

				if( stripos( $post_content, '[ult_content_box') ) {

					wp_enqueue_style('ult_content_box_css');

				}

				if( stripos( $post_content, '[bsf-info-box') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('info-box-style');

				}

				if( stripos( $post_content, '[info_circle') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('info-circle');

				}

				if( stripos( $post_content, '[ultimate_info_banner') ) {

					wp_enqueue_style('utl-info-banner-style');

					wp_enqueue_style('ultimate-animate');

				}

				if( stripos( $post_content, '[icon_timeline') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ultimate-timeline-style');

				}

				if( stripos( $post_content, '[just_icon') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ultimate-tooltip');

				}



				if( stripos( $post_content, '[interactive_banner_2') ) {

					$ib_2_found = true;

				}

				if(stripos( $post_content, '[interactive_banner') && !stripos( $post_content, '[interactive_banner_2')) {

					$ib_found = true;

				}

				if(stripos( $post_content, '[interactive_banner ') && stripos( $post_content, '[interactive_banner_2')) {

					$ib_found = true;

					$ib_2_found = true;

				}



				if( $ib_found && !$ib_2_found ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ult-interactive-banner');

				}

				else if( !$ib_found && $ib_2_found ) {

					wp_enqueue_style('ult-ib2-style');

				}

				else if($ib_found && $ib_2_found) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ult-interactive-banner');

					wp_enqueue_style('ult-ib2-style');

				}



				if( stripos( $post_content, '[info_list') ) {

					wp_enqueue_style('ultimate-animate');

				}

				if( stripos( $post_content, '[ultimate_modal') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ultimate-modal');

				}

				if( stripos( $post_content, '[ultimate_info_table') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style("ultimate-pricing");

				}

				if( stripos( $post_content, '[ultimate_pricing') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style("ultimate-pricing");

				}

				if( stripos( $post_content, '[swatch_container') ) {

					wp_enqueue_style('swatchbook-css');

				}

				if( stripos( $post_content, '[stat_counter') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ult-stats-counter-style');

				}

				if( stripos( $post_content, '[ultimate_video_banner') ) {

					wp_enqueue_style('ultimate-video-banner-style');

				}

				if( stripos( $post_content, '[ult_dualbutton') ) {

					wp_enqueue_style('ult-dualbutton');

				}

				if( stripos( $post_content, '[ult_createlink') ) {

					wp_enqueue_style('ult_cllink');

				}

				if( stripos( $post_content, '[ultimate_img_separator') ) {

					wp_enqueue_style('ultimate-animate');

					wp_enqueue_style('ult-easy-separator-style');

				}

				if( stripos( $post_content, '[ult_tab_element') ) {

					wp_enqueue_style('ult_tabs');

					wp_enqueue_style('ult_tabs_acordian');

				}

				if( stripos( $post_content, '[ultimate_exp_section') ) {

					wp_enqueue_style('style_ultimate_expsection');

				}

				if( stripos( $post_content, '[ult_sticky_section') ) {

					wp_enqueue_style('ult_sticky_section_css');

				}

				if( stripos( $post_content, '[ult_team') ) {

					wp_enqueue_style('ultimate-team');

				}

				if( stripos( $post_content, '[ult_range_slider') ) {

					wp_enqueue_style('ult_range_slider_css');

				}

			}

		// }

	}// end mgft_aio_front_scripts

























}

