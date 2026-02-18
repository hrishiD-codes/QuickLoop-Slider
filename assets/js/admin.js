/**
 * QuickLoop Carousel Admin JavaScript
 * 
 * @package QuickLoop_Carousel
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		
		/**
		 * Reset to defaults button
		 */
		$('#qlc-reset-defaults').on('click', function(e) {
			e.preventDefault();
			
			if (!confirm(qlcAdmin.resetConfirm)) {
				return;
			}

			// Reset all fields to default values
			$('#enable_loop').prop('checked', true);
			$('#show_arrows').prop('checked', true);
			$('#enable_autoplay').prop('checked', true);
			$('#autoplay_delay').val('3000');
			$('#transition_speed').val('300');
			$('#animation_effect').val('slide');

			// Show a notice
			showNotice('Settings reset to defaults. Click "Save Changes" to confirm.', 'info');
		});

		/**
		 * Show admin notice
		 *
		 * @param {string} message Notice message
		 * @param {string} type Notice type (success, error, warning, info)
		 */
		function showNotice(message, type) {
			type = type || 'success';
			
			var $notice = $('<div class="notice notice-' + type + ' is-dismissible"><p>' + message + '</p></div>');
			
			$('.qlc-settings-wrap h1').after($notice);
			
			// Auto-dismiss after 5 seconds
			setTimeout(function() {
				$notice.fadeOut(function() {
					$(this).remove();
				});
			}, 5000);
		}

		/**
		 * Form validation
		 */
		$('form').on('submit', function(e) {
			var autoplayDelay = parseInt($('#autoplay_delay').val());
			var transitionSpeed = parseInt($('#transition_speed').val());

			// Validate autoplay delay range
			if (autoplayDelay < 1000 || autoplayDelay > 10000) {
				e.preventDefault();
				alert('Autoplay delay must be between 1000 and 10000 milliseconds.');
				$('#autoplay_delay').focus();
				return false;
			}

			// Validate transition speed range
			if (transitionSpeed < 100 || transitionSpeed > 2000) {
				e.preventDefault();
				alert('Transition speed must be between 100 and 2000 milliseconds.');
				$('#transition_speed').focus();
				return false;
			}
		});

	});

})(jQuery);
