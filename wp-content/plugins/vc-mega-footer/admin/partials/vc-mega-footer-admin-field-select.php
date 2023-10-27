<?php

/**
 * Provides the markup for a select field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    VC_Mega_Footer
 * @subpackage VC_Mega_Footer/admin/partials
 */

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], vc-mega-footer ); ?>: </label><?php

}

// multiselect is stored as comma separated values
// lets explode that, and re-make our array of selections
if ( ! empty( $atts['value'] ) ) {
	$attvals = explode(',', $atts['value']);
}
else {
	$attvals = array();
}



?><select
	aria-label="<?php esc_attr( _e( $atts['aria'], 'vc-mega-footer' ) ); ?>"
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>[]"
	multiple="multiple"><?php

if ( ! empty( $atts['blank'] ) ) {

	?><option value><?php esc_html_e( $atts['blank'], 'vc-mega-footer' ); ?></option><?php

}

if ( ! empty( $atts['hideall'] ) ) {

	?><option value="hideall" onclick="alert('aaa');"
	<?php if($attvals) { foreach($attvals as $attval) { selected( $attval, 'hideall' ); }  } ?>
	><?php esc_html_e( $atts['hideall'], 'vc-mega-footer' ); ?></option><?php

}


foreach ( $atts['selections'] as $selection ) {

	if ( is_array( $selection ) ) {

		$label = $selection['label'];
		$value = $selection['value'];

	} else {

		$label = strtolower( $selection );
		$value = strtolower( $selection );

	}

	?><option
		value="<?php echo esc_attr( $value ); ?>" <?php
		if($attvals) { foreach($attvals as $attval) { selected( $attval, $value ); }  } ?>><?php

		esc_html_e( $label, 'vc-mega-footer' );

	?></option><?php

} // foreach

?></select>
<span class="description"><?php esc_html_e( $atts['description'], 'vc-mega-footer' ); ?></span>
</label>
