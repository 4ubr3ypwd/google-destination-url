jQuery(document).ready(function(){

	// Lets bind our google query when someone
	// starts typing something on our input.
	
	url_field = '#url-field';

	if( jQuery(url_field) ){

		jQuery(url_field)

			// New placeholder
			.attr(
				'placeholder',
				google_destination_url_js.placeholder_lang
			);

			// Set the value to nothing using a setInterval
			// because we don't know when the damn thing will show up.
			url_field_interval = setInterval(function(){
				if( jQuery(url_field).val() == 'http://' ){
					jQuery(url_field).val('');
				}
			}, 300);

		//Google Voodo
		jQuery(url_field).bind('change keyup', function(){
			jQuery.ajax({
				method: 'get',
				dataType: 'json',
				url: google_destination_url_js.goog_ajax_url
					+jQuery(url_field).val(),
				success: function(google_result,status,xhr){
					var old_html = jQuery('#search-panel').html();
					console.log(google_result);
					
				}
			});
		});

	}
	
});