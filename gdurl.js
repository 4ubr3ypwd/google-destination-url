jQuery(document).ready(function(){

	wp_link_search_toggle_html = jQuery( '#wp-link-search-toggle' ).html();
	gdurl_saved_wpLink = wpLink;

	jQuery('.link-search-field').bind(
		'change keyup',

		// Our function that performs
		// the search.
		function(){

			wpLink = gdurl_saved_wpLink;

			if( 
				jQuery( '.link-search-field' ).val().indexOf("Google") > -1
				|| jQuery( '.link-search-field' ).val().indexOf("google") > -1
			) {

				// Kill the last search
				if(typeof gdurl_search_ajax !== 'undefined'){
					gdurl_search_ajax.abort();
				}

				// Disable WP wpLink.
				wpLink = {
					searchInternalLinks: {
						call: function() {
							return;
						}
					}
				};

				// Start a new search
				gdurl_search_ajax = jQuery.post(
					
					ajaxurl,
					
					{
						action: 'gdurl_googapi_put_panel_results',
						search: jQuery('.link-search-field').val()
					}, 

					// Complete
					function(html_result){

						// Update the HTML with Google results.
						jQuery( '.query-results ul' )
							.html( html_result );
						
					
					}
				);


			} else {

			}

		}
		
	);



});

// Used as an onclick when the link is selected from
// the search results. Puts the link in the inputs.
function gdurl_put_link_input( link, title ){
	jQuery('#url-field').val( link );
	jQuery('#link-title-field').val( title );
}
