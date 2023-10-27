<?php

/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    VC_Mega_Footer
 * @subpackage VC_Mega_Footer/admin/partials
 */

//echo '<pre>'; print_r( $repeater ); echo '</pre>';

?><ul class="repeaters"><?php

	for ( $i = 0; $i <= $count; $i++ ) {

		if ( $i === $count ) {

			$setatts['class'] .= ' hidden';

		}

		if ( ! empty( $repeater[$i][$setatts['title-field']] ) ) {

			$setatts['label-header'] = $repeater[$i][$setatts['title-field']];

		}

		?><li class="<?php echo esc_attr( $setatts['class'] ); ?>">
			<div class="handle">
				<span class="title-repeater"><?php echo esc_html( $setatts['label-header'], 'vc-mega-footer' ); ?></span>
				<button aria-expanded="true" class="btn-edit" type="button">
					<span class="screen-reader-text"><?php echo esc_html( $setatts['label-edit'], 'vc-mega-footer' ); ?></span>
					<span class="toggle-arrow"></span>
				</button>
			</div><!-- .handle -->
			<div class="repeater-content">
				<div class="wrap-fields"><?php

					foreach ( $setatts['fields'] as $fieldcount => $field ) {

						foreach ( $field as $type => $atts ) {

							if ( ! empty( $repeater ) && ! empty( $repeater[$i][$atts['id']] ) ) {

								$atts['value'] = $repeater[$i][$atts['id']];

							}

							$atts['id'] 	.= '[]';
							$atts['name'] 	.= '[]';

							?><p class="wrap-field"><?php

							include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-' . $type . '.php' );

							?></p><?php

						}

					} // $fieldset foreach

				?></div>
				<div>
					<a class="link-remove" href="#">
						<span><?php

							echo esc_html( apply_filters( $this->plugin_name . '-repeater-remove-link-label', $setatts['label-remove'] ), 'vc-mega-footer' );

						?></span>
					</a>
				</div>
			</div>
		</li><!-- .repeater --><?php

	} // for

	?><div class="repeater-more">
		<span id="status"></span>
		<a class="button" href="#" id="add-repeater"><?php

			echo esc_html( apply_filters( $this->plugin_name . '-repeater-more-link-label', $setatts['label-add'] ), 'vc-mega-footer' );

		?></a>
	</div><!-- .repeater-more -->
</ul><!-- repeater -->
