/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		3.7.0
*/

(function($) {

	'use strict';

	/*
	Contact Form: Basic
	*/
	$('#contactForm:not([data-type=advanced])').validate({
		submitHandler: function(form) {
			//Definir información a enviar en el formulario:
			var $form = $(form),
				$messageSuccess = $('#contactSuccess'),
				$messageError = $('#contactError'),
				$submitButton = $(this.submitButton);
			var PAGE_NAME = 'Proximamente';
			var SUBSCRIBE_TEXT = 'Me gustaría ser informado cuando liberen el siguiente sitio web: '
			var SUBSCRIBE_PAGE = window.location.hash.substring(1);
			$submitButton.button('loading');

			// Ajax Submit para enviar la información al formulario
			$.ajax({
				type: 'POST',
				url: 'php/contact-form-google-form.php',
				data: {
					name: PAGE_NAME,
					email: $form.find('#email').val(),
					subject: SUBSCRIBE_TEXT,
					message: SUBSCRIBE_PAGE
				},
				dataType: 'json',
				complete: function(data) {
				
					if (typeof data.responseJSON === 'object') {
						if (data.responseJSON.response == 'success') {

							$messageSuccess.removeClass('hidden');
							$messageError.addClass('hidden');

							// Reset Form
							$form.find('.form-control')
								.val('')
								.blur()
								.parent()
								.removeClass('has-success')
								.removeClass('has-error')
								.find('label.error')
								.remove();

							if (($messageSuccess.offset().top - 80) < $(window).scrollTop()) {
								$('html, body').animate({
									scrollTop: $messageSuccess.offset().top - 80
								}, 300);
							}

							$submitButton.button('reset');
							
							return;

						}
					}

					$messageError.removeClass('hidden');
					$messageSuccess.addClass('hidden');

					if (($messageError.offset().top - 80) < $(window).scrollTop()) {
						$('html, body').animate({
							scrollTop: $messageError.offset().top - 80
						}, 300);
					}

					$form.find('.has-success')
						.removeClass('has-success');
						
					$submitButton.button('reset');

				}
			});
		}
	});

	/*
	Contact Form: Advanced
	*/
	$('#contactFormAdvanced, #contactForm[data-type=advanced]').validate({
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		rules: {
			'captcha': {
				captcha: true
			},
			'checkboxes[]': {
				required: true
			},
			'radios': {
				required: true
			}
		}
	});

}).apply(this, [jQuery]);