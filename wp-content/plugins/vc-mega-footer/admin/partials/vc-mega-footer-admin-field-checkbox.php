<?php

/**
 * Provides the markup for any checkbox field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    VC_Mega_Footer
 * @subpackage VC_Mega_Footer/admin/partials
 */

?><label for="<?php echo esc_attr( $atts['id'] ); ?>">
	<div class="vcmgf-onoffswitch" >
		<input aria-role="checkbox"
			<?php checked( 1, $atts['value'], true ); ?>
			class="vcmgf-onoffswitch-checkbox <?php echo esc_attr( $atts['class'] ); ?>"
			id="<?php echo esc_attr( $atts['id'] ); ?>"
			name="<?php echo esc_attr( $atts['name'] ); ?>"
			type="checkbox"
			value="1" />

		<label class="vcmgf-onoffswitch-label" for="<?php echo esc_attr( $atts['id'] ); ?>"></label>
      </div>
	<span class="description"><?php esc_html_e( $atts['description'], 'vc-mega-footer' ); ?></span>
</label>
