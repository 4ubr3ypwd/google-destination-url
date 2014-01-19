jQuery(document).ready(function(){

	// Add a div around the already present search panel
	// so we can add things to it.
	jQuery('#search-panel').wrapAll('<div id="search-panels"/>');
	
	// Perform an ajax call to get the new HTML
	// to append.
	jQuery.post(ajaxurl, {
		action: 'gdurl_panel_html'
	}, function(panel_html){

		// Append the html for the new panel
		jQuery('#search-panels').append(panel_html);
	
		// Bind our input so when they type something
		// something happens.
		jQuery('#search-field-gdurl').bind(
			'change keyup',

			// Our function that performs
			// the search.
			function(){

				// Kill the last search
				if(typeof gdurl_search_ajax !== 'undefined'){
					gdurl_search_ajax.abort();
				}

				// Start a new search
				gdurl_search_ajax = jQuery.post(ajaxurl,{
					action: 'gdurl_googapi_put_panel_results',
					search: jQuery('#search-field-gdurl').val()
				}, function(html_result){
					jQuery('#search-restults-gdurl-ul')
						.html(html_result);
				});
			}
		);
	});

});

// Used as an onclick when the link is selected from
// the search results. Puts the link in the inputs.
function gdurl_put_link_input(link,title){
	jQuery('#url-field').val(link);
	jQuery('#link-title-field').val(title);
}
