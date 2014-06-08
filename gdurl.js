var gdurl_saved_wpLink;

jQuery(document).ready(function(){

	// Save the current wpLink object.
	gdurl_saved_wpLink = wpLink;

	// Bind the input.
	jQuery('.link-search-field').bind(

		// Bind on these.
		'change keyup',

		// Our function that performs the search.
		function(){

			// Perform search when they type "google ...".
			if( 
				jQuery( '.link-search-field' ).val().indexOf("Google") > -1
				|| jQuery( '.link-search-field' ).val().indexOf("google") > -1
			) {

				// Kill the last search.
				if(typeof gdurl_search_ajax !== 'undefined'){
					gdurl_search_ajax.abort();
				}

				// Disable wpLink.
				gdurl_disable_wpLink();

				// Start a new search.
				gdurl_search_ajax = jQuery.post(
					
					// The URL.
					ajaxurl,
					
					// Data.
					{
						action: 'gdurl_googapi_put_panel_results',
						search: jQuery('.link-search-field').val()
					}, 

					// Complete.
					function(html_result){

						// Update the HTML with Google results.
						jQuery( '.query-results ul' )
							.html( html_result );

					}
				);

				// Make sure we re-instate wpLink.
				gdurl_maybe_reset_wpLink();

			}

		}
		
	);

});

function gdurl_maybe_reset_wpLink() {

	// If this function is disabled, reset it.
	if( ! wpLink.searchInternalLinks.call ) {
		wpLink.searchInternalLinks.call 
			= gdurl_saved_wpLink.searchInternalLinks.call;
	}
}

function gdurl_disable_wpLink() {

	// Disable this function in wpLink.
	wpLink = {
		searchInternalLinks: {
			call: function() {
				return false;
			}
		}
	};

}