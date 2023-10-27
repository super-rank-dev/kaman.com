<?php

/**
 * Provide the view for a metabox
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	VC_Mega_Footer
 * @subpackage 	VC_Mega_Footer/admin/partials
 */


wp_nonce_field( $this->plugin_name, 'vcmegafooter_additional_info' );

?>





<div class='vc-mega-footer-field vc-mega-footer-checkbox'>

	<div class='vcmgf-buffer' style='height:10px;'></div>


	<?php
	$atts 					= array();
	$atts['class'] 			= 'widefat';
	$atts['description'] 	= '';
	$atts['id'] 			= 'vcmegafooter-enabled';
	$atts['description'] 			= 'Hide/Show this footer block';
	$atts['name'] 			= 'vcmegafooter-enabled';
	$atts['placeholder'] 	= '';
	$atts['type'] 			= 'checkbox';
	$atts['value'] 			= '';



	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-checkbox.php' );

	?></p>

</div>





<div class='vc-mega-footer-field vc-mega-footer-multiselect'>

	<h3 style='margin-top:30px;'>Show on specific areas</h3>


	<span class="description">Pages</span>
	<?php


	$args = array(
	'sort_order' => 'asc',
	'sort_column' => 'menu_order',
	'hierarchical' => 1,
	'exclude' => '',
	'include' => '',
	'meta_key' => '',
	'meta_value' => '',
	'authors' => '',
	'child_of' => 0,
	'parent' => -1,
	'exclude_tree' => '',
	'number' => '',
	'offset' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
	);
	$allpages = get_pages($args);

	$pages_selections = array();
	if($allpages) {
		foreach($allpages as $ap) {
			$pages_selections[]  = array('label' => $ap->post_title, 'value' => $ap->ID);
		}
	}

	$atts 					= array();
	$atts['class'] 			= 'widefat';
	$atts['description'] 	= '';
	$atts['id'] 			= 'vcmegafooter-showonpages';
	$atts['label'] 			= '';
	$atts['name'] 			= 'vcmegafooter-showonpages';
	$atts['placeholder'] 	= '';
	$atts['type'] 			= 'select';
	$atts['value'] 			= '';
	$atts['selections'] 			= $pages_selections;
	$atts['hideall'] 			=	'Dont show on pages';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-select.php' );

	?></p>

</div>



<div class='vc-mega-footer-field vc-mega-footer-multiselect'>
	<span class="description">Posts</span>
	<?php


	$args = array(
	'sort_order' => 'asc',
	'sort_column' => 'menu_order',
	'hierarchical' => 1,
	'exclude' => '',
	'include' => '',
	'meta_key' => '',
	'meta_value' => '',
	'authors' => '',
	'child_of' => 0,
	'parent' => -1,
	'exclude_tree' => '',
	'number' => '',
	'offset' => 0,
	'post_type' => 'post',
	'post_status' => 'publish'
	);
	$allposts = get_posts($args);

	$posts_selections = array();
	if($allposts) {
		foreach($allposts as $ap) {
			$posts_selections[]  = array('label' => $ap->post_title, 'value' => $ap->ID);
		}
	}

	$atts 					= array();
	$atts['class'] 			= 'widefat';
	$atts['description'] 	= '';
	$atts['id'] 			= 'vcmegafooter-showonposts';
	$atts['label'] 			= '';
	$atts['name'] 			= 'vcmegafooter-showonposts';
	$atts['placeholder'] 	= '';
	$atts['type'] 			= 'select';
	$atts['value'] 			= '';
	$atts['selections'] 			= $posts_selections;
	$atts['hideall'] 			=	'Dont show on posts';

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-select.php' );

	?></p>

</div>








<!--



<div class='vc-mega-footer-field vc-mega-footer-multiselect'>
	<span class="description">Post Categories</span>
	<?php


	$args = array(
		'type' => 'post',
		'orderby' => 'menu_order',
		'hide_empty' => 0,
		'parent'  => 0
	);
	$allcategories = get_categories( $args );


	$categories_selections = array();
	if($allcategories) {
		foreach($allcategories as $ac) {
			$categories_selections[]  = array('label' => $ac->name, 'value' => $ac->term_id);
		}
	}

	$atts 					= array();
	$atts['class'] 			= 'widefat';
	$atts['description'] 	= '';
	$atts['id'] 			= 'vcmegafooter-showonpostcategories';
	$atts['label'] 			= '';
	$atts['name'] 			= 'vcmegafooter-showonpostcategories';
	$atts['placeholder'] 	= '';
	$atts['type'] 			= 'select';
	$atts['value'] 			= '';
	$atts['selections'] 			= $categories_selections;

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-select.php' );

	?></p>

</div>












<div class='vc-mega-footer-field vc-mega-footer-multiselect'>
	<span class="description">Post Tags</span>
	<?php

	$args = array(
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'hide_empty' => 0
	);
	$alltags = get_tags( $args );

	$tags_selections = array();
	if($alltags) {
		foreach($alltags as $at) {
			$tags_selections[]  = array('label' => $at->name, 'value' => $at->term_id);
		}
	}

	$atts 					= array();
	$atts['class'] 			= 'widefat';
	$atts['description'] 	= '';
	$atts['id'] 			= 'vcmegafooter-showonposttags';
	$atts['label'] 			= '';
	$atts['name'] 			= 'vcmegafooter-showonposttags';
	$atts['placeholder'] 	= '';
	$atts['type'] 			= 'select';
	$atts['value'] 			= '';
	$atts['selections'] 			= $tags_selections;

	if ( ! empty( $this->meta[$atts['id']][0] ) ) {

		$atts['value'] = $this->meta[$atts['id']][0];

	}

	apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

	?><p><?php

	include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-select.php' );

	?></p>

</div>



 -->














<?php
