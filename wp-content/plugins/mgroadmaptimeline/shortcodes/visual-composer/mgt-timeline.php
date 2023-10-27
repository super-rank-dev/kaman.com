<?php
// VC [mgt_timeline_wp]
vc_map(array(
   "name" 			=> "MGT Timeline",
   "description"	=> "Vertical Timeline element with icon, title, text and date",
   "base" 			=> "mgt_timeline_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_timeline",

   "params" 	=> array(
   		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Content settings",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Timeline item title",
			"description"	=> "",
			"param_name"	=> "title",
			"std"			=> "Timeline title",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Title color",
			"param_name"	=> "title_color",
			"std"			=> "",
		),
		array(
			"type"			=> "textarea_html",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Timeline item text",
			"param_name"	=> "content",
			"std"			=> 'Nam liber tempor cum soluta nobis eleifend option congue nihil imper per tempor doming',
		),
		array(
			"type"			=> "attach_image",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Timeline image",
			"param_name"	=> "timeline_image",
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Timeline date year",
			"description"	=> "",
			"param_name"	=> "date_year",
			"std"			=> "2018",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Timeline date month",
			"description"	=> "",
			"param_name"	=> "date_month",
			"std"			=> "December",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Year text color",
			"param_name"	=> "year_color",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Month text color",
			"param_name"	=> "month_color",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text and title align",
			"param_name"	=> "align",
			"value"			=> array(
				"Left"	=> "left",
				"Center"	=> "center",
				"Right"	=> "right",
			),
			"description"	=> "",
			"std"			=> "left",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Title font weight",
			"param_name"	=> "fontweight",
				"value"			=> array(
				"Normal"	=> "normal",
				"Bold"	=> "bold",
				"100"	=> "100",
				"200"	=> "200",
				"300"	=> "300",
				"400"	=> "400",
				"500"	=> "500",
				"600"	=> "600",
				"700"	=> "700",
				"800"	=> "800",
				"900"	=> "900"
			),
			"std"			=> "bold",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text block style",
			"param_name"	=> "textblockstyle",
			"value"			=> array(
				"Solid background"	=> "solid",
				"Bordered background"	=> "bordered",
				"Double bordered background"	=> "doublebordered",
				"Disable background"	=> "nobg"
			),
			"description"	=> "",
			"std"			=> "solid",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text block border style",
			"param_name"	=> "textblockborderstyle",
			"value"			=> array(
				"Squared"	=> "squared",
				"Rounded"	=> "rounded"
			),
			"description"	=> "",
			"std"			=> "squared",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text color",
			"param_name"	=> "text_color",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text background color",
			"param_name"	=> "text_bg_color",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Timeline vertical line position",
			"param_name"	=> "dots_position",
			"value"			=> array(
				"None"	=> "none",
				"Bottom (first item)"	=> "bottom",
				"Both (middle items)"	=> "both",
				"Top (last item)"	=> "top",
			),
			"description"	=> "Use Bottom for first timeline element in column, use Top for latest, use both for middle elements.",
			"std"			=> "none",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Date position",
			"param_name"	=> "date_position",
			"value"			=> array(
				"Right"	=> "right",
				"Left"	=> "left",
			),
			"description"	=> "Use Right to show date at the right and title at the left (for ex. odd elements) and Left for even elements or vice versa.",
			"std"			=> "right",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Timeline vertical line color",
			"param_name"	=> "line_color",
			"description"	=> "Override vertical line color.",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Pointer style",
			"param_name"	=> "pointer_style",
			"value"			=> array(
				"Triangle"	=> "triangle",
				"Line"	=> "line",
				"Dotted line"	=> "dottedline",
				"Dashed line"	=> "dashedline",
				"Disable"	=> "disable",
			),
			"description"	=> "Text block pointer style.",
			"std"			=> "triangle",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Timeline element link url (Optional)",
			"param_name"	=> "url",
			"std"			=> "https://google.com/",
			"description"	=> "Website url (link will be added to title and icon).",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Open link in a new tab',
			'param_name' => 'url_blank',
			"edit_field_class" => "vc_col-xs-6",
		),
		/* Icon */
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Icon settings",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Disable icon?',
			'param_name' => 'icon_disable',
			"description"	=> "Disable icon to show just small bullet instead of icon box.",
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Timeline icon library', 'js_composer' ),
			'value' => array(
				__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				__( 'Open Iconic', 'js_composer' ) => 'openiconic',
				__( 'Typicons', 'js_composer' ) => 'typicons',
				__( 'Entypo', 'js_composer' ) => 'entypo',
				__( 'Linecons', 'js_composer' ) => 'linecons',
				__( 'Mono Social', 'js_composer' ) => 'monosocial',
				__( 'Material', 'js_composer' ) => 'material',
			),
			'admin_label' => false,
			'param_name' => 'timeline_icon_type',
			'description' => __( 'Select icon library.', 'js_composer' ),
			"std"		=> "fontawesome",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_fontawesome',
			'value' => 'fa fa-calendar',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				'type' => 'fontawesome',
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_openiconic',
			'value' => 'vc-oi vc-oi-dial',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'openiconic',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_typicons',
			'value' => 'typcn typcn-adjust-brightness',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'typicons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_entypo',
			'value' => 'entypo-icon entypo-icon-note',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'entypo',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_linecons',
			'value' => 'vc_li vc_li-heart',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'linecons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_monosocial',
			'value' => 'vc-mono vc-mono-fivehundredpx',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'monosocial',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'monosocial',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Timeline icon', 'js_composer' ),
			'param_name' => 'timeline_icon_material',
			'value' => 'vc-material vc-material-cake',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'material',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'timeline_icon_type',
				'value' => 'material',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Icon size (px, for ex. 32)",
			"param_name"	=> "icon_size",
			"std"			=> "",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Icon color",
			"param_name"	=> "icon_color",
			"description"	=> "Override icon color.",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Icon background color",
			"param_name"	=> "icon_color_bg",
			"description"	=> "Override icon background color.",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		// Border
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Border settings",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Timeline Icon Border style",
			"param_name"	=> "border_style",
				"value"			=> array(
				"Circle"	=> "circle",
				"Rounded"	=> "rounded",
				"Square"	=> "square"
			),
			"std"			=> "circle",
		),
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Effects and animations",
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Add mouse hover shadow effect?', 'js_composer' ),
			'param_name' => 'block_shadow_effect',
			"description"	=> "Use this to add shadow to timeline icon on block hover.",
		),
		// CSS Animations
		vc_map_add_css_animation( true ),

   )

));
