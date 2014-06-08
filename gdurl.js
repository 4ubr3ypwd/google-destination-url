jQuery(document).ready(function(){

	wp_link_search_toggle_html = jQuery( '#wp-link-search-toggle' ).html();

	jQuery('.link-search-field').bind(
		'change keyup',

		// Our function that performs
		// the search.
		function(){


			if( 
				jQuery( '.link-search-field' ).val().indexOf("Google") > -1
				|| jQuery( '.link-search-field' ).val().indexOf("google") > -1
			) {

						// Kill the last search
						if(typeof gdurl_search_ajax !== 'undefined'){
							gdurl_search_ajax.abort();
						}
						// Start a new search
						gdurl_search_ajax = jQuery.post(ajaxurl,{
							action: 'gdurl_googapi_put_panel_results',
							search: jQuery('.link-search-field').val()
						}, function(html_result){

							if( html_result != '' ) {

								// Put a cool message that let's them know we are searching...
								jQuery( '#wp-link-search-toggle' ).html(
									'<span style="color:blue">G</span><span style="color:red">o</span><span style="color:orange">o</span><span style="color:blue">g</span><span style="color:green">l</span><span style="color:red">i</span><span style="color:blue">n</span><span style="color:red">g</span>'
								);

								// Kill the time out
								if(typeof gdurl_search_updater !== 'undefined'){
									gdurl_search_updater = null;
								}

								gdurl_search_updater = setTimeout( function() {

									// Update the HTML with Google results.
									jQuery('.query-results ul')
										.html(html_result);
									
									// Set the message back.
									jQuery( '#wp-link-search-toggle' ).html( wp_link_search_toggle_html );

									// Do the update after 3 seconds (which should come when WordPress is done)
								}, 3000 );

							}
						
						});
			}else{
				console.log("Bad google?");
			}

		}
		
	);



});

// Used as an onclick when the link is selected from
// the search results. Puts the link in the inputs.
function gdurl_put_link_input(link,title){
	jQuery('#url-field').val(link);
	jQuery('#link-title-field').val(title);
}
