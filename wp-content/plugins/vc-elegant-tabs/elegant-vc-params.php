<?php
if ( function_exists( 'add_shortcode_param' ) ) {
	if ( defined( 'WPB_VC_VERSION' ) && version_compare( '5.0', WPB_VC_VERSION, '>=' ) ) {
		add_shortcode_param( 'iw_icon', 'iw_icon_render_param' );
		add_shortcode_param( 'iw_number', 'iw_number_render_param' );
	}
}

if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'iw_icon', 'iw_icon_render_param' );
	vc_add_shortcode_param( 'iw_number', 'iw_number_render_param' );
}

// Create icon style attribute.
if ( ! function_exists( 'iw_icon_render_param' ) ) {
	function iw_icon_render_param( $settings, $value ) {
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$class      = isset( $settings['class'] ) ? $settings['class'] : '';

		include 'fonts/icons.php';

		$output  = '<input type="hidden" name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" value="' . $value . '" id="trace"/>';
		$output .= '<input class="search" type="text" placeholder="Search" />';
		$output .= '<div class="icon-preview"><i class=" fa fa-' . $value . '"></i></div>';
		$output .= '<div id="icon-dropdown" >';
		$output .= '<ul class="icon-list">';
		$n       = 1;
		foreach ( $icons as $icon ) {
			$selected = ( $icon == $value ) ? 'class="selected"' : '';
			$id       = 'icon-' . $n;
			$output  .= '<li ' . $selected . ' data-icon="' . $icon . '"><i class="iw_icon fa fa-' . $icon . '"></i><label class="icon">' . $icon . '</label></li>';
			$n++;
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".search").keyup(function(){

						// Retrieve the input field text and reset the count to zero
						var filter = jQuery(this).val(), count = 0;

						// Loop through the icon list
						jQuery(".icon-list li").each(function(){

							// If the list item does not contain the text phrase fade it out
							if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
								jQuery(this).fadeOut();
							} else {
								jQuery(this).show();
								count++;
							}
						});
					});
				});

				jQuery("#icon-dropdown li").click(function() {
					jQuery(this).attr("class","selected").siblings().removeAttr("class");
					var icon = jQuery(this).attr("data-icon");
					jQuery("#trace").val(icon);
					jQuery(".icon-preview").html("<i class=\'fa fa-"+icon+"\'></i>");
				});
		</script>';
		return $output;
	}
}

// Function generate param type "number".
if ( ! function_exists( 'iw_number_render_param' ) ) {
	function iw_number_render_param( $settings, $value ) {
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$min        = isset( $settings['min'] ) ? $settings['min'] : '';
		$max        = isset( $settings['max'] ) ? $settings['max'] : '';
		$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
		$class      = isset( $settings['class'] ) ? $settings['class'] : '';
		$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:100px; margin-right: 10px;" />' . $suffix;
		return $output;
	}
}
