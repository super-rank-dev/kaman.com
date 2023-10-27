(function ($) {
	vc.atts.ihwt_hotspot_param = {
		init: function (param, $field) {
			if(!$field.prev().data('vc-shortcode-param-name') || !$field.prev().data('vc-shortcode-param-name') == 'image') {
				return false;
			}
			
			var imgSrc = '',
				$imgInput = $field.prev().find('input[name="image"]'),
				previewImage = function() {
					if($field.prev().find('img').length > 0) {
						var id = $field.find('.ihwt_hotspot_var').attr('id');
						imgSrc = $field.prev().find('img').attr('src');
						imgSrc = imgSrc.replace('-150x150', '', imgSrc);
						if($field.find('img.ihwt-hotspot-image').length > 0) {
							$field.find('img.ihwt-hotspot-image').attr('src', imgSrc);
						} else {
							$field.find('.ihwt-hotspot-image-holder').append('<img src="'+imgSrc+'" alt="Preview image" class="ihwt-hotspot-image" />');
						}
						$field.find('.ihwt-hotspot-image-holder').hotspot({
							mode:			'admin',
							LS_Variable:	'#'+id,
							popupTitle:		$field.find('.ihwt-hotspot-image-holder').data('popup-title') ? $field.find('.ihwt-hotspot-image-holder').data('popup-title') : 'Save',
							saveText:		$field.find('.ihwt-hotspot-image-holder').data('save-text') ? $field.find('.ihwt-hotspot-image-holder').data('save-text') : 'Save',
							closeText:		$field.find('.ihwt-hotspot-image-holder').data('close-text') ? $field.find('.ihwt-hotspot-image-holder').data('close-text') : 'Close',
							dataStuff: [
								{
									'property': 'Title',
									'default': 'Tooltip title'
								},
								{
									'property': 'Message',
									'default': 'Tooltip content goes here'
								}
							]
						});
					}
				};
				
			previewImage();
			$imgInput.change(function() {
				previewImage();
			});
		},
	};
})(window.jQuery);