<?php
// Shortcode [mgt_timeline_wp]
function mgt_shortcode_timeline_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'title' => 'Timeline title',
		'title_color' => '',
		'timeline_image' => '',
		'date_year' => '2018',
		'date_month' => 'December',
		'year_color' => '',
		'month_color' => '',
		'text_color' => '',
		'text_bg_color' => '',
		'align' => 'left',
		'fontweight' => 'bold',
		'textblockstyle' => 'solid',
		'textblockborderstyle' => 'squared',
		'dots_position' => 'none',
		'date_position' => 'right',
		'url' => 'https://google.com/',
		'url_blank' => false,
		'line_color' => '',
		'pointer_style' => 'triangle',
		'icon_disable' => false,
		'timeline_icon_type' => 'fontawesome',
		'timeline_icon_fontawesome' => 'fa fa-adjust',
		'timeline_icon_pe7stroke' => 'pe-7s-album',
		'timeline_icon_openiconic' => 'vc-oi vc-oi-dial',
		'timeline_icon_typicons' => 'typcn typcn-adjust-brightness',
		'timeline_icon_entypo' => 'entypo-icon entypo-icon-note',
		'timeline_icon_linecons' => 'vc_li vc_li-heart',
		'timeline_icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'timeline_icon_material' => 'vc-material vc-material-cake',
		'icon_size' => '',
		'icon_color' => '',
		'icon_color_bg' => '',
		'border_style' => 'circle',
		'block_shadow_effect' => false,
		'css_animation' => 'none'
	), $atts));

	ob_start();

	$mgt_custom_css = '';

	// Default font-weight
	if($fontweight == 'bold') {
		$fontweight = 'default';
	}

	// Process icon
	// Load VC icons libraries

	vc_iconpicker_editor_jscss();

	switch($timeline_icon_type) {
		case 'fontawesome':
	        $timeline_icon_html = '<i class="'.$timeline_icon_fontawesome.'"></i>';
	    break;
	    case 'openiconic':
	        $timeline_icon_html = '<i class="'.$timeline_icon_openiconic.'"></i>';
	    break;
	    case 'typicons':
	        $timeline_icon_html = '<i class="'.$timeline_icon_typicons.'"></i>';
	    break;
	    case 'entypo':
	        $timeline_icon_html = '<i class="'.$timeline_icon_entypo.'"></i>';
	    break;
	    case 'linecons':
	        $timeline_icon_html = '<i class="'.$timeline_icon_linecons.'"></i>';
	    break;
	    case 'monosocial':
	        $timeline_icon_html = '<i class="'.$timeline_icon_monosocial.'"></i>';
	    break;
	    case 'material':
	        $timeline_icon_html = '<i class="'.$timeline_icon_material.'"></i>';
	    break;
	   case 'pe7stroke':
	        $timeline_icon_html = '<i class="'.$timeline_icon_pe7stroke.'"></i>';
	    break;
	}

	if($icon_disable) {
		$icon_html = '<div class="mgt-timeline-icon-wrapper mgt-timeline-icon-disable"><div class="mgt-timeline-icon"></div></div>';
	} else {
		if($url !== '' && $timeline_icon_html !== '') {
			$icon_html = '<div class="mgt-timeline-icon-wrapper"><a href="'.esc_url($url).'" '.esc_attr($link_target_html).'><div class="mgt-timeline-icon">'.$timeline_icon_html.'</div></a></div>';
		} else {
			$icon_html = '<div class="mgt-timeline-icon-wrapper"><div class="mgt-timeline-icon">'.$timeline_icon_html.'</div></div>';
		}
	}

	// CSS Animation
	if($css_animation !== 'none') {

		// Code from /wp-content/plugins/js_composer/include/classes/shortcodes/shortcodes.php:640, public function getCSSAnimation( $css_animation )
		$animation_css_class = ' wpb_animate_when_almost_visible wpb_'.$css_animation.' '.$css_animation;

		// Load animation JS
		wp_enqueue_script( 'waypoints' );
		wp_enqueue_style( 'animate-css' );

	} else {
		$animation_css_class = '';
	}

	// Block shadow effect
	if($block_shadow_effect) {
		$block_shadow_class = ' mgt-timeline-shadow';
	} else {
		$block_shadow_class = '';
	}

	// Custom CSS
	$unique_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-timeline-'.$unique_id;

    if($icon_color_bg !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper {
		        background-color: $icon_color_bg!important;
		    }
		";
    }

    if($title_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper h5.mgt-timeline-title {
		        color: $title_color!important;
		    }
		";
    }

    if($icon_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper .mgt-timeline-icon,
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper a,
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper a:visited,
			.$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper a:focus {
		        color: $icon_color!important;
		    }
		";
    }

    if($line_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper:before {
		        background-color: $line_color!important;
		    }
		    .$unique_class_name.mgt-timeline-wrapper.mgt-timeline-pointer-style-line .mgt-timeline-details-pointer,
			.$unique_class_name.mgt-timeline-wrapper.mgt-timeline-pointer-style-dottedline .mgt-timeline-details-pointer,
			.$unique_class_name.mgt-timeline-wrapper.mgt-timeline-pointer-style-dashedline .mgt-timeline-details-pointer {
		    	border-color: $line_color!important;
		    }
		";
    }

    if($text_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-text {
		        color: $text_color!important;
		    }
		";
    }

    if($text_bg_color !== '') {
    	$mgt_custom_css .= "
    		.$unique_class_name.mgt-timeline-wrapper .mgt-timeline-details {
		        background-color: $text_bg_color!important;
		    }
		    .$unique_class_name.mgt-timeline-wrapper.mgt-timeline-style-bordered .mgt-timeline-details,
		    .$unique_class_name.mgt-timeline-wrapper.mgt-timeline-style-doublebordered .mgt-timeline-details {
		    	background-color: transparent!important;
		    	border-color: $text_bg_color;
		    }
		    .$unique_class_name.mgt-timeline-wrapper.mgt-timeline-date-left .mgt-timeline-details-pointer {
			    border-right: 10px solid $text_bg_color;
			}
			.$unique_class_name.mgt-timeline-wrapper.mgt-timeline-date-right .mgt-timeline-details-pointer {
			    border-left: 10px solid $text_bg_color;
			}
		";
    }

    if($icon_size !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-icon-wrapper {
		        font-size: ".$icon_size."px!important;
		    }
		";
    }

    if($year_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-date .mgt-timeline-date-year {
		        color: $year_color!important;
		    }
		";
    }

    if($month_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-timeline-wrapper .mgt-timeline-date .mgt-timeline-date-month {
		        color: $month_color!important;
		    }
		";
    }

    // Url target
	if($url_blank) {
		$link_target_html = ' target="_blank"';
	} else {
		$link_target_html = '';
	}

	// Image
	$image_data = wp_get_attachment_image_src( $timeline_image, 'source' );

	if(trim($image_data[0]) !== '') {
		$image_html = '<div class="mgt-timeline-image"><img src="'.esc_url($image_data[0]).'" alt="'.esc_attr($title).'"/></div>';
	} else {
		$image_html = '';
	}

	if($icon_disable) {
		$add_class = ' mgt-timeline-icon-disable';
	} else {
		$add_class = '';
	}

    // Render element
	echo '<div class="mgt-timeline-wrapper '.esc_attr($unique_class_name).esc_attr($add_class).' mgt-timeline-border-'.$border_style.' mgt-timeline-dots-'.$dots_position.' mgt-timeline-date-'.$date_position.' mgt-timeline-border-style-'.esc_attr($textblockborderstyle).' mgt-timeline-style-'.esc_attr($textblockstyle).' mgt-timeline-pointer-style-'.esc_attr($pointer_style).' wpb_content_element text-'.esc_attr($text_color).' text-'.esc_attr($align).esc_attr($animation_css_class).$block_shadow_class.'">';

	echo '<div class="mgt-timeline-details-wrapper">';
	echo '<div class="mgt-timeline-details">';

	if(trim($title) !== '') {
		$title = '<h5 class="mgt-timeline-title text-font-weight-'.esc_attr($fontweight).' ">'.wp_kses_post($title).'</h5>';
	}

	if($url !== '' && $title !== '') {
		$title = '<a href="'.esc_url($url).'" '.esc_attr($link_target_html).'>'.$title.'</a>';
	}

	echo $title;

	if(trim($sc_content) !== '') {
		echo '<div class="mgt-timeline-text">'.($sc_content).'</div>';
	}

	echo $image_html;

	echo '<div class="mgt-timeline-details-pointer"></div>';
	echo '</div>'; // end .mgt-timeline-details
	echo '</div>'; // end .mgt-timeline-details-wrapper

	echo wp_kses_post($icon_html);

	echo '<div class="mgt-timeline-date">';

	echo '<div class="mgt-timeline-date-month">'.wp_kses_post($date_month).'</div>';
	echo '<div class="mgt-timeline-date-year">'.wp_kses_post($date_year).'</div>';

	echo '</div>'; // end .mgt-timeline-date

	echo '</div>'; // end .mgt-timeline-wrapper

	// Custom CSS display
    if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_timeline_wp", "mgt_shortcode_timeline_wp");
