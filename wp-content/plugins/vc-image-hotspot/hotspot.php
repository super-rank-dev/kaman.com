<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once ('hotspot_param.php');


class WPBakeryShortCode_ihwt_Hotspot extends WPBakeryShortCode {}

vc_map(
    array(
       'name' => esc_html__('Image Hotspot','ihwt'),
       'base' => 'ihwt_hotspot',
       'class' => '',
       'icon'    => 'ihwt_hotspot_icon',
       'admin_enqueue_js' => array( plugins_url( '/admin/jquery.hotspot.js', __FILE__ )),
       'admin_enqueue_css' => array( plugins_url( '/admin/hotspot.css', __FILE__ )),
       "category" =>array( esc_attr__('Image Hotspot', 'ihwt'),esc_attr__('Content', 'ihwt')),
       'description' => esc_html__('Display single image with markers and tooltips','ihwt'),
       'params' => array(
              
                    
                           
            array(
                'type'                => 'attach_image',
                'param_name'        => 'image',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Select image from media library', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Image', 'ihwt'),
                'edit_field_class'    => 'vc_column vc_col-sm-12',
            ),
            array(
                'type'                => 'ihwt_hotspot_param',
                'heading'            => '',
                'param_name'        => 'hotspot_data',
                'edit_field_class'    => 'vc_column vc_col-sm-12',
            ),
            array(
                'type'                => 'dropdown',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Define the action at which the hotspot tooltip will be displayed on.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Tooltips display', 'ihwt'),
                'param_name'        => 'hotspot_action',
                'edit_field_class'    => 'vc_column vc_col-sm-12',
                'default'                => 'hover',
                'value'            => array(
                    
                    esc_html__('On Hover','ihwt')    => 'hover',
                    esc_html__('Allways','ihwt')     => 'allways',
                    esc_html__('On Click','ihwt')    => 'click',
                ),
            ),
            array(
                'type'                => 'textfield',
                'heading'            => esc_html__('Custom CSS Class', 'ihwt'),
                'param_name'        => 'el_class',
            ),
            array(
                'type'                => 'dropdown',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Select marker style. You can leave default style or upload your own image.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Marker style (pro only)', 'ihwt'),
                'param_name'        => 'marker_style',
                'default'                => 'default',
                'value'            => array(
                    esc_html__('Default', 'ihwt')            => 'default',
                    esc_html__('Image', 'ihwt')            => 'image',
                ),
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
            ),
            array(
                'type'                => 'colorpicker',
                'param_name'        => 'marker_bg',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Change the background of hotspot markers.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Marker background', 'ihwt'),
                'edit_field_class'    => 'vc_column vc_col-sm-6',
                'value'                => '#ff3368',
                'dependency'        => array('element' => 'marker_style', 'value_not_equal_to' => 'image'),
                'group'                => esc_html__('Markers settings', 'ihwt'),
            ),
            array(
                'type'                => 'colorpicker',
                'param_name'        => 'marker_inner_bg',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Change the background of the hotspot marker inner dot', 'ihwt').'" data-balloon-pos="left"><span></span></span>'.esc_html__('Marker inner background', 'ihwt'),
                'edit_field_class'    => 'vc_column vc_col-sm-6',
                'value'                => '#ffffff',
                'dependency'        => array('element' => 'marker_style', 'value_not_equal_to' => 'image'),
                'group'                => esc_html__('Markers settings', 'ihwt'),
            ),
            array(
                'type'                => 'attach_image',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Choose the image to use as marker.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Image', 'ihwt'),
                'param_name'        => 'marker_image',
                'dependency'        => array('element' => 'marker_style', 'value' => 'image'),
                'edit_field_class'    => 'vc_column vc_col-sm-12',
                'group'                => esc_html__('Markers settings', 'ihwt'),
            ),
            
                    array(
                        "type" => "hvc_notice",
                        "class" => "",
                        'heading' => __('<h3 class="hvc_notice" align="center">To get all features working, please buy the pro version here <a target="_blank" href="https://codenpy.com/item/image-hotspot-with-tooltip-for-wpbakery-page-builder-pro/">Image Hotspot With Tooltip For WPBakery Page Builder Pro</a> for only $8</h3>', 'hvc'),
                        "param_name" => "hvc_notice_param_1",
                        "value" => '',
                        'group' => esc_html__('Tooltips settings', 'ihwt'),
                    ),            
            
            array(
                'type'                => 'dropdown',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Select the tooltip position relative to the marker.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Tooltip position (pro only)', 'ihwt'),
                'param_name'        => 'tooltip_position',
                'default'                => 'top',
                'value'            => array(
                    esc_html__('Top', 'ihwt')            => 'top',
                    esc_html__('Bottom', 'ihwt')            => 'bottom',
                    esc_html__('Left', 'ihwt')            => 'left',
                    esc_html__('Right', 'ihwt')            => 'right',
                    esc_html__('Top Left', 'ihwt')        => 'top-left',
                    esc_html__('Top Right', 'ihwt')        => 'top-right',
                    esc_html__('Bottom Left', 'ihwt')    => 'bottom-left',
                    esc_html__('Bottom Right', 'ihwt')    => 'bottom-right',
                ),
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
                'edit_field_class'    => 'vc_column vc_col-sm-12',
            ),
            array(
                'type'                => 'dropdown',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Set the tooltip text alignment.', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Tooltip content alignment (pro only)', 'ihwt'),
                'param_name'        => 'tooltip_content_align',
                'default'                => 'left',
                'value'            => array(
                    esc_html__('Left', 'ihwt')            => 'left',
                    esc_html__('Right', 'ihwt')            => 'right',
                    esc_html__('Center', 'ihwt')            => 'center',
                ),
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
                'edit_field_class'    => 'vc_column vc_col-sm-6',
            ),
            array(
                'type'                => 'textfield',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Set the minimal width of item tooltip .', 'ihwt').'" data-balloon-pos="left"><span></span></span>'.esc_html__('Tooltip min width (pro only)', 'ihwt'),
                'param_name'        => 'tooltip_width',
                "value" => 300,
                'edit_field_class'    => 'vc_column vc_col-sm-6',
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
            ),
            array(
                'type'                => 'colorpicker',
                'param_name'        => 'tooltip_bg_color',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Choose the color for the tooltip\'s background. The default value is #fff (pro only).', 'ihwt').'" data-balloon-pos="right"><span></span></span>'.esc_html__('Tooltip Background Color (pro only)', 'ihwt'),
                'default'            => '#fff',
                'edit_field_class'    => 'vc_column vc_col-sm-6',
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
            ),
            array(
                'type'                => 'colorpicker',
                'param_name'        => 'tooltip_text_color',
                'heading'            => '<span class="ihwt-vc-tip" data-balloon-length="medium" data-balloon="'.esc_html__('Choose the color for the tooltip\'s text. The default value is #555 (pro only).', 'ihwt').'" data-balloon-pos="left"><span></span></span>'.esc_html__('Tooltip Text Color (pro only)', 'ihwt'),
                'default'            => '#555',
                'edit_field_class'    => 'vc_column vc_col-sm-6',
                'group'                => esc_html__('Tooltips settings', 'ihwt'),
            )
        ),
    )
);


add_shortcode('ihwt_hotspot', 'ihwt_hotspot_shortcode');

function ihwt_hotspot_shortcode( $atts, $content = null ) {
    
    $atts = vc_map_get_attributes( 'ihwt_hotspot', $atts );
        extract( $atts );
        
$output = $id = $el_class = $custom_el_css = $data_atts = '';        
        
if(isset($image) && !empty($image)) {
    
    $id = uniqid('ihwt-hotspoted-image');
    
    
        wp_enqueue_style('ihwt-hotspot', plugins_url( '/css/hotspot.css',  __FILE__));


        wp_register_script('ihwt-hotspot-js', plugins_url('/js/jquery.hotspot.js', __FILE__), array('jquery'), '', true );

        wp_enqueue_script('ihwt-hotspot-js');    
        
        wp_register_script('ihwt-hotspot-active', plugins_url('/js/active.js', __FILE__), array('jquery'), '', true );

        wp_enqueue_script('ihwt-hotspot-active');            


    /*Data attributes*/
    if(!empty($module_animation)) {
        $data_atts .= ' data-animate="1"  data-animate-type="'.esc_attr($module_animation).'" ';
    }
    
    if(!empty($hotspot_data)) {
        $data_atts .= ' data-hotspot-content="'.esc_attr($hotspot_data).'" ';
    }
    
    if(!empty($hotspot_action)) {
        $el_class .= ' ihwt-action-'.$hotspot_action;
        $data_atts .= ' data-action="'.esc_attr($hotspot_action).'" ';
    }
    $custom_el_css = '<div class="bruno-custom-inline-css">';
    
    /*Marker CSS*/
    
    if(isset($marker_style) && $marker_style == 'image' && isset($marker_image) && !empty($marker_image)) {
        $data_atts .= ' data-hotspot-class="HotspotPlugin_Hotspot ihwtHotspotImageMarker" ';
        $marker_img_src = wp_get_attachment_image_src($marker_image, 'full');
        $custom_el_css .= '<style>#'.esc_js($id).' .ihwt-hotspot-wrapper .HotspotPlugin_Hotspot.ihwtHotspotImageMarker {'
                            . 'width: '.esc_js($marker_img_src[1]).'px;'
                            . 'height: '.esc_js($marker_img_src[2]).'px;'
                            . 'margin-left: -'.esc_js($marker_img_src[1] / 2).'px;'
                            . 'margin-top: -'.esc_js($marker_img_src[2] / 2).'px;'
                            . 'background-image: url('.esc_url($marker_img_src[0]).');'
                    . '}</style>';
    }
    
    
    if(isset($marker_inner_bg) && $marker_inner_bg != '') {
        $custom_el_css .= '<style>#'.esc_js($id).' .ihwt-hotspot-wrapper .HotspotPlugin_Hotspot:not(.ihwtHotspotImageMarker):after { background: '.esc_js($marker_inner_bg).';}</style>';
    }
    $custom_el_css .= '</div>';
    
    
    
    $img_src = wp_get_attachment_image_src($image, 'full');
    
    

    $img_html = '<img src="'.esc_attr($img_src[0]).'" width="'.esc_attr($img_src[1]).'" height="'.esc_attr($img_src[2]).'"/>';
    
    $output .= '<div id="'.esc_attr($id).'" class="ihwt-hotspot-wrapper-wrapper">';
        $output .= '<div class="ihwt-hotspot-wrapper" '.$data_atts.'>';
            $output .= '<div class="ihwt-hotspot-image-cover '.esc_attr($el_class).'">';
                $output .= $img_html;
            $output .= '</div>';
        $output .= '</div>';
                
    $output .= '</div>';
    
}

return $custom_el_css.$output;

}