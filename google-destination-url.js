jQuery(document).ready(function(){

	// Add a div around the already present search panel
	// so we can add things to it.
	jQuery('#search-panel').wrapAll('<div id="search-panels"/>');
	
	// Perform an ajax call to get the new HTML
	// to append.
	jQuery.ajax({
		dataType: 'html',
		url: gdesturl_js.gdesturl_panel_html_url,
		success: function(panel_html){
			// Add the new panel.
			jQuery('#search-panels').append(panel_html);

			// Bind our input so when they type something
			// something happens.
			jQuery('#search-field-google-destination-url').bind(
				'change keyup',

				// Our function that performs
				// the search.
				function(){

					jQuery.ajax({
						dataType: 'html',
						url: gdesturl_js.goog_ajax_url
							+ jQuery('#search-field-google-destination-url').val(),
						success: function(html_result){
							jQuery('#search-restults-google-destination-url-ul')
								.html(html_result);
						},
						error: function(){
							console.log('error?'); //!todo
						}
					});

				}
			);
		},
		error: function(){
			console.log('error?'); //!todo
		}
	});

});

// Used as an onclick when the link is selected from
// the search results. Puts the link in the inputs.
function gdesturl_put(link,title){
	jQuery('#url-field').val(link);
	jQuery('#link-title-field').val(title);
}
