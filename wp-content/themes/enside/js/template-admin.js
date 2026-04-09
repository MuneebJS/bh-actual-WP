(function($){
$(document).ready(function() {

	'use strict';

	// Color picker for MegaMenu
	if(typeof window.wpColorPicker == 'function') {
		$('.edit-menu-item-badgecolor').wpColorPicker();
	}

	// Welcome message
	$('#mgt-welcome-message-show-steps').on('click', function(e){
		$('.mgt-welcome-message-show-steps').slideUp();
		$('.mgt-welcome-message-steps-wrapper').slideDown();
		$('div.mgt-welcome-message.updated').css('border-color', '#4686CC');
	});

	// Uploading files
	var file_frame;

	$('body').on('click', '.button.upload-menu-item-bg', function( event ){

	event.preventDefault();

	var clicked_button = $(this);

	// If the media frame already exists, reopen it.
	if ( file_frame ) {
	  file_frame.open();
	  return;
	}

	// Create the media frame.
	file_frame = wp.media.frames.file_frame = wp.media({
	  title: $( this ).data( 'uploader_title' ),
	  button: {
	    text: $( this ).data( 'uploader_button_text' ),
	  },
	  multiple: false  // Set to true to allow multiple files to be selected
	});

	// When an image is selected, run a callback.
	file_frame.on( 'select', function() {
	  // We set multiple to false so only get one image from the uploader
	  var attachment = file_frame.state().get('selection').first().toJSON();

	  // Do something with attachment.id and/or attachment.url here
	  clicked_button.prev().val(attachment.url);
	});

	// Finally, open the modal
	file_frame.open();
	});

	$('body').on('click', '.remove-menu-item-bg', function( event ){
		$(this).prev().prev().val('');
	});

	// Dismiss notice
	function setCookie (name, value, expires, path, domain, secure) {
	      document.cookie = name + "=" + escape(value) +
	        ((expires) ? "; expires=" + expires : "") +
	        ((path) ? "; path=" + path : "") +
	        ((domain) ? "; domain=" + domain : "") +
	        ((secure) ? "; secure" : "");
	}
	function getCookie(name) {
		var cookie = " " + document.cookie;
		var search = " " + name + "=";
		var setStr = null;
		var offset = 0;
		var end = 0;
		if (cookie.length > 0) {
			offset = cookie.indexOf(search);
			if (offset != -1) {
				offset += search.length;
				end = cookie.indexOf(";", offset)
				if (end == -1) {
					end = cookie.length;
				}
				setStr = unescape(cookie.substring(offset, end));
			}
		}
		return(setStr);
	}

});
})(jQuery);
