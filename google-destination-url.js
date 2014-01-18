// global a few vars
var gdesturl_js_search_panel_html = '';
var url_field = null;

jQuery(document).ready(function(){

	// Lets bind our google query when someone
	// starts typing something on our input.
	
	// the url field selector (DRY, though I do)
	url_field = '#url-field';

	// Only if the field is there
	// (just in case).
	if( jQuery(url_field) ){

		// Make the url_field do majix
		jQuery(url_field)

			// New placeholder
			.attr(
				'placeholder',
				gdesturl_js.placeholder_lang
			);

			// Set the value to nothing using a setInterval
			// because we don't know when the damn thing will show up.
			url_field_interval = setInterval(function(){
				if( jQuery(url_field).val() == 'http://' ){
					jQuery(url_field).val('');
				}
			}, 300);

		//Google Voodo
		jQuery(url_field).bind('keyup', function(){
			if(jQuery(url_field).val()!=''){
				jQuery.ajax({
					method: 'get',
					dataType: 'html',

					// gdesturl_js = wp_localize
					url: gdesturl_js.goog_ajax_url

						// Pass the fields val
						+jQuery(url_field).val(),

					success: function(the_html,status,xhr){

						// Make sure we haven't already saved the old
						// html (once, the initial render)
						if(gdesturl_js_search_panel_html==''){
							gdesturl_js_search_panel_html 
								= jQuery('#search-panel').html();						
						}

						// Apply the HTML response to the div.
						jQuery('#search-panel').html(the_html);
					},

					// Errors. Need !todo that
					error: function(result){
					}
				});

			// If the val is empty, just act like it never happened.
			}else{
				gdesturl_js_setback(
					gdesturl_js_search_panel_html
				);
			}

		});

	}
	
});

// This function sets the HTML for #search-panel
// back to what WP made it be before we changed it.
function gdesturl_js_setback(
	gdesturl_js_search_panel_html
){
	jQuery('#search-panel').html(gdesturl_js_search_panel_html);
}