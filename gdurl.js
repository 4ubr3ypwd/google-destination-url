jQuery( document ).ready( function() {

	// Bind the input.
	jQuery( '.link-search-field' ).bind(

		// Bind on these.
		'change keyup',

		// Our function that performs the search.
		function() {

				// Kill the last search.
				if( typeof gdurl_search_ajax !== 'undefined' ) {
					gdurl_search_ajax.abort();
				}

				// Start a new search.
				gdurl_search_ajax = jQuery.post(
					
					// The URL.
					ajaxurl,
					
					// Data.
					{
						action: 'gdurl_googapi_put_panel_results',
						
						// Search input.
						search: jQuery('.link-search-field').val()
					}, 

					// Complete.
					function( html_result ) {

						jQuery( '#search-results' ).bind( 

								// When the DOM is modified
								// (When WordPress updates the DIV)
								'DOMNodeInserted.gdurl',

								// Override it with our HTML.
								function(e) {

									// Kill the DOM Modifier bind 
									// so we don't loop to death.
									jQuery( '#search-results' ).unbind(
										'DOMNodeInserted.gdurl'
									);

									// Update the HTML with Google results 
									// and WordPress results.
									jQuery( '.query-results ul' )
										.html( html_result );

								}
						);
					}
				);
		}
	);
});
