<?php
/**
 * The Header for our theme.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */
?><!DOCTYPE html>
<?php
	if ($_GET && key_exists('mfn-rtl', $_GET)):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html <?php language_attributes(); ?> class="no-js <?php echo esc_attr(mfn_html_classes()); ?>"<?php mfn_tag_schema(); ?> >
<?php endif; ?>

<head>

<meta charset="<?php bloginfo('charset'); ?>" />
	
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5S4SX7S');</script>
<!-- End Google Tag Manager -->
	
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5S4SX7S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	
	<?php do_action('mfn_hook_top'); ?>

	<?php get_template_part('includes/header', 'sliding-area'); ?>

	<?php
		if (mfn_header_style(true) == 'header-creative') {
			get_template_part('includes/header', 'creative');
		}
	?>

	<div id="Wrapper">

		<?php
			if (mfn_header_style(true) == 'header-below') {
				echo mfn_slider();
			}

			// $header_tmp_id = mfn_header_ID();
			$header_tmp_id = false;

			if( $header_tmp_id ){
				get_template_part( 'includes/header', 'template', array('id' => $header_tmp_id) );
			}else{
				get_template_part( 'includes/header', 'classic' );
			}

			if ( 'intro' == get_post_meta( mfn_ID(), 'mfn-post-template', true ) ) {
				get_template_part( 'includes/header', 'single-intro' );
			}
		?>

		<?php do_action( 'mfn_hook_content_before' );
