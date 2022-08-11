jQuery(document).ready(function () {
	
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	jQuery('.smartagegate-color-picker').iris({
		// or in the data-default-color attribute on the input
		defaultColor: true,
		// a callback to fire whenever the color changes to a valid color
		change: function (event, ui) { },
		// a callback to fire when the input is emptied or an invalid color
		clear: function () { },
		// hide the color picker controls on load
		hide: true,
		// show a group of common colors beneath the square
		palettes: true
	});
	jQuery('input[name="smartagegate_settings_options[smartagegate_background_color_or_image]"]').on(
		'click',
		function () {
			jQuery('.smartagegate_background_color, .custom-media-uploader').toggle();
		}
	);
	/*custom media uploader function */
	jQuery('body').on('click', '.custom-upload-button', function (e) {
		e.preventDefault();
		var upload_button = jQuery(this),
			custom_media_uploader = wp.media({
				title: 'Insert image',
				library: {
					type: 'image'
				},
				button: {
					text: 'Use this image'
				},
				multiple: false
			}).on('select', function () {
				var attachment = custom_media_uploader.state().get('selection').first().toJSON();
				upload_button.html('<img src="' + attachment.url + '" width="20%">');
				jQuery('.custom-upload-remove').show().next().val(attachment.url);
			}).open();

	});

	// remove function
	jQuery('body').on('click', '.custom-upload-remove', function (e) {
		e.preventDefault();
		var upload_button = jQuery(this);
		upload_button.next().val('');
		upload_button.hide().prev().html('Upload image');
	});

})
