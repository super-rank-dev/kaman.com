<?php

/**
 * Provides the markup for any textarea field
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

?><textarea
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	cols="<?php echo esc_attr( $atts['cols'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	rows="<?php echo esc_attr( $atts['rows'] ); ?>"><?php

	echo esc_textarea( $atts['value'] );

?></textarea>
<span class="description"><?php esc_html_e( $atts['description'], 'vc-mega-footer' ); ?></span>