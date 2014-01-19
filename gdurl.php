<?php 

// Setup the JS
function gdurl_js_enqueue($hook){

	// These are the admin pages we want 
	// this to work on.
	$hooks = array(
		'edit.php',
		'post-new.php',
		'post.php'
	);

	// Want to add, hook into gdurl_js_enqueue_$hooks
	add_filter(__FUNCTION__.'_$hooks', $hooks);

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

add_action('admin_enqueue_scripts','gdurl_js_enqueue');

// Adds the extra panel to the link modal
function gdurl_panel_html(){
	include "gdurl-panel.html.php";
	exit;
}

add_action(
	'wp_ajax_'.'gdurl_panel_html',
	'gdurl_panel_html'
);

// Performs the search and puts it in the new
// panel.
function gdurl_googapi_put_panel_results(){
	$result_data = gdurl_googapi_cache($_POST['search']);
	include "gdurl-snippet.html.php";
	exit;
}

add_action(
	'wp_ajax_'.'gdurl_googapi_put_panel_results', 
	'gdurl_googapi_put_panel_results'
);

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
	return apply_filters(
		__FUNCTION__, 
		$googapi_cache[$s]
	);
}

?>