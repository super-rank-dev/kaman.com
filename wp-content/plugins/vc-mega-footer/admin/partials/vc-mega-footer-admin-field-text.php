<?php

/**
 * Provides the markup for any text field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    VC_Mega_Footer
 * @subpackage VC_Mega_Footer/admin/partials
 */

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'vc-mega-footer' ); ?>: </label><?php

}

?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" /><?php

if ( ! empty( $atts['description'] ) ) {

	?><span class="description"><?php esc_html_e( $atts['description'], 'vc-mega-footer' ); ?></span><?php

}