(function( $ ) {
	'use strict';

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
	$(document).ready(function () {
		function openTab(evt, tabName) {
			// Hide all tab content
			$(".user-post-tab-content").hide();
			// Remove active class from all tabs
			$(".user-post-tab").removeClass("active");
			// Show the current tab content
			$("#" + tabName).show();
			// Add active class to the current tab
			$(evt.currentTarget).addClass("active");
		}
	
		// Attach the click event handler to all tab buttons
		$(".user-post-tab").on("click", function (event) {
			var tabName = $(this).attr("id").replace("_setting", "");
			openTab(event, tabName);
		});
	
		// Trigger click on the default tab to show it on page load
		$("#General_setting").trigger("click");
	});

	$(document).ready(function() {
        $(".layout-image-outer").on("click", function() {
			$(".layout-image-outer").removeClass("active");
			$(this).addClass("active");
            var value = $(this).data("value");
			$('.layout_no').val(value);
		
        });
		var displayLayout =$('.layout_no').val();
		$(".layout-image-outer").each(function() {
			var dataValue = $(this).data("value");
			if (dataValue ===displayLayout) {
				$(this).addClass("active");
			}
		});
		});


	jQuery(document).ready(function($) {
		$('.shortcode-copy-btn').on('click', function(event) {
			event.preventDefault(); // Prevent default form submission
	
			var shortcode = $(this).data('shortcode');
			copyToClipboard(shortcode, $(this));
		});
	
		function copyToClipboard(text, button) {
			var textarea = document.createElement('textarea');
			textarea.value = text;
			textarea.style.position = 'fixed';
			textarea.style.opacity = 0;
			document.body.appendChild(textarea);
			textarea.focus();
			textarea.select();
			document.execCommand('copy');
			document.body.removeChild(textarea);
	
			// Change button text and style after copy
			button.text('Copied');
			button.addClass('copied');
	
			// Reset button after 2 seconds
			setTimeout(function() {
				button.text('Copy');
				button.removeClass('copied');
			}, 2000);
		}
	});


})( jQuery );
