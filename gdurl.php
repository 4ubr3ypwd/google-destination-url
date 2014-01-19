<?php 

// Setup the JS
function gdurl_js($hook){

	// These are the admin pages we want 
	// this to work on.
	$hooks = array(
		'edit.php',
		'post-new.php',
		'post.php'
	);

	// Want to add?
	add_filter('gdurl_js_hooks', $hooks);

	// Makes sure and exit if this is not a 
	// hook that we want.
	$good_hook = false;
	foreach($hooks as $_hook){
		if($hook == $_hook){
			// We have a good hook, continue;
			$good_hook = true;
		}
	}

	// We have a bad hook stop.
	if(!$good_hook) return;

	// Make sure the JS is loaded
	wp_enqueue_script(
		__FUNCTION__, 
		plugins_url( 
			'gdurl.js', 
			___FILE___
		), 
		array(), 
		'', 
		false 
	);

}

add_action('admin_enqueue_scripts','gdurl_js');

// Adds the extra panel to the link modal
function google_destination_url_panel_html(){
	include "gdurl-panel.html.php";
	exit;
}

add_action(
	'wp_ajax_google_destination_url_panel_html', 
	'google_destination_url_panel_html'
);

// Performs the search and puts it in the new
// panel.
function gdest_url_googapi(){
	gdurl_googapi_load_results($_POST['search']);
	exit;
}

add_action(
	'wp_ajax_gdest_url_googapi', 
	'gdest_url_googapi'
);

// Called from our Ajax part to load the results.
function gdurl_googapi_load_results($s){	
	$result_data = gdurl_googapi_cache($s);
	include "gdurl-snippet.html.php";
}

// Differentiate whether we need to load from
// cache or get live results.
function gdurl_googapi_cache($s){
	// First see if we have cached data (15 seconds?)
	$diff_results = get_transient( 'gdurl_googapi_cache' );

	if( isset($diff_results[$s]) ){
		return apply_filters(
			__FUNCTION__, 
			$diff_results[$s]
		);
	}else{
		return apply_filters(
			__FUNCTION__, 
			gdurl_googapi_set_cache($s) 
		);
	}
}

// Sets the transient cache up by storing the results
// of the search in a multi-array.
function gdurl_googapi_set_cache($s){

	// Get current transient data
	$googapi_cache = get_transient( 'gdurl_googapi_cache' );

	// Add this search
	$googapi_cache[$s] = gdurl_googapi($s);

	// Set the cache
	set_transient( 
		'gdurl_googapi_cache', 
		$googapi_cache, 
		10
	);

	// Return the results
	return apply_filters(__FUNCTION__, $googapi_cache[$s]);
}

?>