jQuery(document).ready(function($){

	$('#admin_ajax_form').submit(function() {

		data = {
			action: admin_ajax_var.ajax_action,
			add_nonce: admin_ajax_var.ajax_nonce,
		};

		$.post( admin_ajax_var.ajaxurl, data, function( response ) {

			$('#response').html( response );

		});


		return false;
	});

});