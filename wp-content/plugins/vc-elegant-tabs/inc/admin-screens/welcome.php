<div class="wrap about-wrap elegant-tabs-wrap">

	<?php Elegant_Tabs_VC_Admin::header(); ?>
	<div class="elegant-tabs-important-notice">
		<p class="about-description">
			<?php esc_html_e( 'The Elegant Tabs plugin is an add-on for the popular page builder plugin -  WPBakery Page Builder. It will add a new tab element to the  WPBakery Page Builder\'s library and extend the functionality. It provides more than 12 different tab styles to use on your website with unlimited variations and customization capabilities.', 'elegant-tabs' ); ?>
			<br/>
		</p>
	</div>

	<div id="elegant-tabs-product-registration" class="elegant-tabs-registration-form">
		<?php infi_elegant_tabs_vc()->registration->the_form(); ?>
	</div>
	<?php Elegant_Tabs_VC_Admin::footer(); ?>
</div>
