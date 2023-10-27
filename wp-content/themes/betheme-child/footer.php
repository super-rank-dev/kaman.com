<!-- Footer Code -->
<div class="footer">
	<div class="section the_content has_content">
		<div class="section_wrapper">
			<div class="the_content_wrapper">
				<div class="footer-content">
					<div class="footer-copyright">&copy; <?php echo date("Y"); ?> Kaman Corporation. All Rights Reserved.</div>
					<div class="footer-nav">
						<ul>
							<li><a href="/terms-of-use/">Terms of Use</a></li> 
							<li><a href="/privacy-policy/">Privacy Policy</a> </li> 
							<li><a href="/legal/">Legal</a></li>
							<li><a href="/vulnerability-reporting/">Vulnerability Reporting</a></li>  
							<li><a href="http://external_secure.ethicspoint.com/domain/media/en/gui/58818/index.html" target="_blank" rel="noopener">Ethics Reporting Hotline</a></li> 
						</ul>
					</div>
					<div class="footer-social">
						<ul>
							<li><a href="http://external_www.facebook.com/kamancorp/" target="_blank"><img alt="Kaman Facebook" src="/wp-content/uploads/2020/12/facebook.svg"></a></li>
							<li><a href="http://external_www.instagram.com/kaman/?hl=en" target="_blank"><img alt="Kaman Instagram" src="/wp-content/uploads/2020/12/instagram.svg"></a></li>
							<li><a href="http://external_www.linkedin.com/company/kaman-corporation/" target="_blank"><img alt="Kaman LinkedIn" src="/wp-content/uploads/2020/12/linkedin.svg"></a></li>
							<li><a href="http://external_twitter.com/kaman?lang=en" target="_blank"><img alt="Kaman Twitter" src="/wp-content/uploads/2020/12/twitter.svg"></a></li>
							<li><a href="http://external_vimeo.com/kamancorp" target="_blank"><img alt="Kaman Vimeo" src="/wp-content/uploads/2021/07/vimeo-v-brands.svg"></a></li>
						</ul>
					</div>
				</div>
	
			</div>
		</div>
	</div>
</div>



<!-- <div href="#popup-maker-open-popup-2710" onclick="PUM.open(2710); return false;" id="minimized-contact"><img src="http://www.kamanwp.sfadev.com/wp-content/uploads/2021/04/icon-cta.svg" /></div> -->
<script async defer src="https://tools.luckyorange.com/core/lo.js?site-id=88e84706"></script>

<!-- Form submission tracking  -->
<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
  ga('send', 'event', 'Contact Form', 'submit');
}, false );
</script>

<script>
// KARGO Prevent tab default action

jQuery(document).ready(function() {
	if(jQuery('.vc_tta-tabs-list').length) {
		jQuery('.vc_tta-tabs-list .vc_tta-tab a').click(function() {
			jQuery('.vc_tta-tabs-list .vc_tta-tab').removeClass('vc_active');
			jQuery(this).parent().addClass('vc_active');

			jQuery('.vc_tta-panel').removeClass('vc_active');
			console.log(jQuery(this).data('tab'));
			jQuery(jQuery(this).data('tab')).addClass('vc_active');

		});
	}
});
</script>

<script>
jQuery(document).ready(function() {
	jQuery('#footer-year').text('<?php echo Date('Y') ?>');
});
</script>

<script>console.log(<?php echo Date('Y') ?>)</script>

<script>
/* Brands Toggle */
jQuery(document).ready(function() {
	jQuery('.mega-kaman-brands-mega-menu ul.menu > li.menu-item-has-children').prepend('<span class="toggle-mobile-nav"></span>');
});
	
jQuery('.responsive-menu-toggle i').click(function() {
	jQuery('.mega-kaman-brands-mega-menu ul.menu > li.menu-item-has-children').removeClass('active');
});
	
jQuery('.mega-kaman-brands-mega-menu ul.menu > li.menu-item-has-children').on('click', '.toggle-mobile-nav', function() { //.click(function() {
	jQuery('.mega-kaman-brands-mega-menu ul.menu > li.menu-item-has-children').removeClass('active');
	jQuery(this).parent().addClass('active');
});

/* About Toggle */
jQuery(document).ready(function() {
	jQuery('.mega-kaman-about-mega-menu ul.menu > li.menu-item-has-children').prepend('<span class="toggle-mobile-nav"></span>');
});

jQuery('.responsive-menu-toggle i').click(function() {
	console.log('test222');
	jQuery('.mega-kaman-about-mega-menu ul.menu > li.menu-item-has-children').removeClass('active');
});

jQuery('.mega-kaman-about-mega-menu ul.menu > li.menu-item-has-children').on('click', '.toggle-mobile-nav', function() { //.click(function() {
	jQuery('.mega-kaman-about-mega-menu ul.menu > li.menu-item-has-children').removeClass('active');
	jQuery(this).parent().addClass('active');
});
</script>

<script>
/**
 *
 * Half on-screen function
 *
 **/

function isHalfScrolledIntoView(elem)
{
  var docViewTop = jQuery(window).scrollTop();
  var docViewBottom = docViewTop + jQuery(window).height();
  var docHalfHeight = (docViewTop - docViewBottom) / 2;

  var elemTop = jQuery(elem).offset().top;

  return (elemTop <= (docViewTop - docHalfHeight));
}

/**
 *
 * Window Resize Functions
 *
 **/

jQuery(window).resize(function() {

  /*----------  Off Canvas Menu Hide  ----------*/
  var windowWidth = jQuery(window).width();

  if (windowWidth >= 620) {
    jQuery('.hover_box').removeClass('active');
  }
	
});
	
/**
 *
 * Window Scroll Function
 *
 **/

jQuery(window).scroll(function() {

  jQuery('.hover_box').stop().each(function() {
    if ((jQuery(window).width() < 620) && (isHalfScrolledIntoView(jQuery(this)) == true)) {
      jQuery(this).addClass('active');
    } else {
      jQuery(this).removeClass('active');
    }
  });

});

jQuery(window).scroll(function() {
  var sticky = jQuery('#Top_bar'),
    scroll = jQuery(window).scrollTop();
   
  if (scroll >= 20) { 
    sticky.addClass('sticky'); }
  else { 
   sticky.removeClass('sticky');

}
});

</script>

<?php if(is_front_page()): ?>
<!-- On the homepage use the color logo -->
<script>
jQuery(document).ready(function() {
	console.log('front page v2');
	
		
	jQuery('#Header .logo-main').attr('style', 'filter: none !important');
	
	var scroll = jQuery(window).scrollTop();
	if (scroll <= 20) {
		jQuery('#Header .logo-main').attr('src', '/wp-content/uploads/2022/09/kaman-logo-color-white.svg');
		jQuery('#Header .logo-main').attr('data-retina', '/wp-content/uploads/2022/09/kaman-logo-color-white.svg');
	} else {
		jQuery('#Header .logo-main').attr('src', '/wp-content/uploads/2022/09/kaman-logo-color-black.svg');
		jQuery('#Header .logo-main').attr('data-retina', '/wp-content/uploads/2022/09/kaman-logo-color-black.svg');
	}
});
	
jQuery(window).scroll(function () {
    var scroll = jQuery(window).scrollTop();
	console.log(scroll);
	if (scroll <= 20) {
		jQuery('#Header .logo-main').attr('src', '/wp-content/uploads/2022/09/kaman-logo-color-white.svg');
		jQuery('#Header .logo-main').attr('data-retina', '/wp-content/uploads/2022/09/kaman-logo-color-white.svg');
	} else {
		jQuery('#Header .logo-main').attr('src', '/wp-content/uploads/2022/09/kaman-logo-color-black.svg');
		jQuery('#Header .logo-main').attr('data-retina', '/wp-content/uploads/2022/09/kaman-logo-color-black.svg');
	}
});
</script>
<?php endif ?>

<?php
/**
 * The template for displaying the footer.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

// footer classes

$footer_options = mfn_opts_get('footer-options');
$footer_classes = [];

if( ! empty( $footer_options['full-width'] ) ){
	$footer_classes[] = 'full-width';
}

$footer_classes = implode( ' ', $footer_classes );

// back_to_top classes

$back_to_top_class = mfn_opts_get('back-top-top');

if ($back_to_top_class == 'hide') {
	$back_to_top_position = false;
} elseif (strpos($back_to_top_class, 'sticky') !== false) {
	$back_to_top_position = 'body';
} elseif (mfn_opts_get('footer-hide') == 1) {
	$back_to_top_position = 'footer';
} else {
	$back_to_top_position = 'copyright';
}
?>

<?php do_action('mfn_hook_content_after'); ?>

<?php if ('hide' != mfn_opts_get('footer-style')): ?>

	<footer id="Footer" class="clearfix <?php echo $footer_classes; ?>">

		<?php if ($footer_call_to_action = mfn_opts_get('footer-call-to-action')): ?>
		<div class="footer_action">
			<div class="container">
				<div class="column one column_column">
					<?php echo do_shortcode($footer_call_to_action); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php
			$sidebars_count = 0;
			for ($i = 1; $i <= 5; $i++) {
				if (is_active_sidebar('footer-area-'. $i)) {
					$sidebars_count++;
				}
			}

			if ($sidebars_count > 0) {

				$align = mfn_opts_get('footer-align');

				echo '<div class="widgets_wrapper '. $align .'">';
					echo '<div class="container">';

						if ($footer_layout = mfn_opts_get('footer-layout')) {

							// Theme Options

							$footer_layout 	= explode(';', $footer_layout);
							$footer_cols = $footer_layout[0];

							for ($i = 1; $i <= $footer_cols; $i++) {
								if (is_active_sidebar('footer-area-'. $i)) {
									echo '<div class="column '. esc_attr($footer_layout[$i]) .'">';
										dynamic_sidebar('footer-area-'. $i);
									echo '</div>';
								}
							}

						} else {

							// default with equal width

							$sidebar_class = '';
							switch ($sidebars_count) {
								case 2: $sidebar_class = 'one-second'; break;
								case 3: $sidebar_class = 'one-third'; break;
								case 4: $sidebar_class = 'one-fourth'; break;
								case 5: $sidebar_class = 'one-fifth'; break;
								default: $sidebar_class = 'one';
							}

							for ($i = 1; $i <= 5; $i++) {
								if (is_active_sidebar('footer-area-'. $i)) {
									echo '<div class="column '. esc_attr($sidebar_class) .'">';
										dynamic_sidebar('footer-area-'. $i);
									echo '</div>';
								}
							}

						}

					echo '</div>';
				echo '</div>';
			}
		?>

		<?php if (mfn_opts_get('footer-hide') != 1): ?>

			<div class="footer_copy">
				<div class="container">
					<div class="column one">

						<?php
							if ($back_to_top_position == 'copyright') {
								echo '<a id="back_to_top" class="footer_button" href=""><i class="icon-up-open-big"></i></a>';
							}
						?>

						<div class="copyright">
							<?php
								if (mfn_opts_get('footer-copy')) {
									echo do_shortcode(mfn_opts_get('footer-copy'));
								} else {
									echo '&copy; '. esc_html(date('Y')) .' '. esc_html(get_bloginfo('name')) .'. All Rights Reserved. <a target="_blank" rel="nofollow" href="https://muffingroup.com">Muffin group</a>';
								}
							?>
						</div>

						<?php
							if (has_nav_menu('social-menu-bottom')) {
								mfn_wp_social_menu_bottom();
							} else {
								get_template_part('includes/include', 'social');
							}
						?>

					</div>
				</div>
			</div>

		<?php endif; ?>

		<?php
			if ($back_to_top_position == 'footer') {
				echo '<a id="back_to_top" class="footer_button in_footer" href=""><i class="icon-up-open-big"></i></a>';
			}
		?>

	</footer>
<?php endif; ?>

</div>

<?php
	// side slide menu
	if (mfn_opts_get('responsive-mobile-menu')) {
		get_template_part('includes/header', 'side-slide');
	}
?>

<?php
	if ($back_to_top_position == 'body') {
		echo '<a id="back_to_top" class="footer_button '. esc_attr($back_to_top_class) .'" href=""><i class="icon-up-open-big"></i></a>';
	}
?>

<?php if (mfn_opts_get('popup-contact-form')): ?>
	<div id="popup_contact">
		<a class="footer_button" href="#"><i class="<?php echo esc_attr(mfn_opts_get('popup-contact-form-icon', 'icon-mail-line')); ?>"></i></a>
		<div class="popup_contact_wrapper">
			<?php echo do_shortcode(mfn_opts_get('popup-contact-form')); ?>
			<span class="arrow"></span>
		</div>
	</div>
<?php endif; ?>

<?php do_action('mfn_hook_bottom'); ?>

<?php wp_footer(); ?>

<!-- <a href="#" class="button-outline inverted" data-bind="
		attr: { href: ($data.href ? $data.href() : ''), target: ($data.target ? $data.target() : '') },
		actionHref: $data.actions,	click : getEventEmitter(BlockEvent.CLICK, null, ($data.target ? true : false)),	css: ($data.extraClassName ? $data.extraClassName() : '') +
			($data.hasDownState &amp;&amp; $data.hasDownState() ? ' has-down-state' : '') +
			($data.inverted &amp;&amp; $data.inverted() ? ' inverted' : '') +
			($data.fullWidth &amp;&amp; $data.fullWidth() ? ' full-width' : '')
		" target=""><span class="button-outline-copy" data-bind="css: { 'small-padding': $data.smallPadding, 'small-copy': $data.smallCopy }"><span data-bind="css: {'not-visible': $data.isLoading}" class=""><span class="button-text-wrapper">Download</span></span></span><span class="button-outline-bottom"></span>
	</a> -->
<script type="text/javascript">
	if( jQuery( window ).width() <= 1239 ){
	    jQuery(document).on('click','.kaman-brand-mega-menu .menu-item-has-children', function(){
	        jQuery('.kaman-brand-mega-menu .menu-item-has-children').removeClass( 'active' );
	        jQuery(this).addClass('active');
	    });
	}
</script>

<script type="text/javascript">
	
	var scrollTop;
	var fixedSubnav;
	
	jQuery(document).ready(function() {
		setTimeout(function() {
			jQuery('.banner-arrows').addClass('animate-in');
		}, 500);
		
		scrollTop = jQuery(window).scrollTop();
		fixedSubnav = jQuery('.banner-arrows').height() - jQuery('#Top_bar').height();
		
		checkFixedSubnav();
		
		// Handle external links
		jQuery('a[href*="http://external"]').each(function() {
			jQuery(this).click(function(event) {
				//console.log(jQuery(this).attr('href'));
				event.preventDefault();
				
				var newUrl = jQuery(this).attr('href');
				//newUrl = newUrl.replace('http://external_', '');
				
				jQuery('#external-site-title').text(newUrl);
				//jQuery('#external-site-link').attr('href', 'https://' + newUrl);
				jQuery('#external-site-link').attr('href', newUrl);
				
				PUM.open(2825);
			});
			
			jQuery(this).attr('href', 'https://' + jQuery(this).attr('href').replace('http://external_', ''));
		});
		
	});
	
	jQuery(window).scroll(function() {
		//console.log("Scroll top: " + jQuery(window).scrollTop());
		//console.log("Banner arrows height: " + jQuery('.banner-arrows').height());
		//console.log("Breadcrumbs height: " + jQuery('.breadcrumbs-section').height());
		//console.log("Top bar height: " + jQuery('#Top_bar').height());
		//console.log("Calc flip: " + (jQuery('.banner-arrows').height() - jQuery('#Top_bar').height()));
		
		scrollTop = jQuery(window).scrollTop();
		fixedSubnav = jQuery('.banner-arrows').height() - jQuery('#Top_bar').height();
		
		checkFixedSubnav();
	});
	
	jQuery(window).resize(function() {
		checkFixedSubnav();
	});
	
	function checkFixedSubnav() {
		if(jQuery('.breadcrumbs-section').length) {
			if (jQuery(window).width() > 1240) {
				if (scrollTop > fixedSubnav) {
					jQuery('.breadcrumbs-section').addClass('breadcrumbs-fixed');
					jQuery('.entry-content').addClass('breadcrumbs-padding');
				} else {
					jQuery('.breadcrumbs-section').removeClass('breadcrumbs-fixed');
					jQuery('.entry-content').removeClass('breadcrumbs-padding');
				}
			} else {
				jQuery('.breadcrumbs-section').removeClass('breadcrumbs-fixed');
				jQuery('.entry-content').removeClass('breadcrumbs-padding');
			}
		}
	}
</script>

</body>
</html>
