<?php 

// Setup scripts.
function gdurl_enqueue( $hook ) {

	// These are the admin pages we want 
	// this to work on.
	$hooks = array(
		'edit.php',
		'post-new.php',
		'post.php'
	);

	// Want to add, hook into gdurl_enqueue_$hooks
	add_filter(
		__FUNCTION__.'_$hooks', 
		$hooks
	);

	// Makes sure and exit if this is not a 
	// hook that we want.
	$good_hook = false;

	foreach( $hooks as $_hook ) {
		if( $hook == $_hook ) {
			// We have a good hook, continue;
			$good_hook = true;
		}
	}

	// We have a bad hook stop.
	if( ! $good_hook ) {
		return;
	}

	// Make sure the JS is loaded
	wp_enqueue_script(
		'gdurl_js', 
		plugins_url( 
			'gdurl.js', 
			___FILE___
		), 
		array(), 
		'3.9', 
		false 
	);

	// Add the CSS.
	wp_enqueue_style( 
		'gdurl_style', 
		plugins_url( 
			'gdurl.css', 
			___FILE___
		), 
		array(), 
		'3.9', 
		'all' 
	);

}

add_action(
	'admin_enqueue_scripts',
	'gdurl_enqueue'
);

// Adds the extra panel to the link modal
function gdurl_panel_html() {
	include "gdurl-panel.html.php";
	exit;
}

add_action(
	'wp_ajax_'.'gdurl_panel_html',
	'gdurl_panel_html'
);

// Performs the search and puts it in the new
// panel.
function gdurl_googapi_put_panel_results() {

	// What they typed.
	$s = $_POST['search'];

	// Google's Results
	$google_results = gdurl_googapi_cache( $s );

	// WordPress
	require(ABSPATH . WPINC . '/class-wp-editor.php');

	// Get WordPress's results.
	$wordpress_results = _WP_Editors::wp_link_query( 
		array(
			's' => wp_unslash( $s )
		)
	);

	// Output HTML.
	include "gdurl-panel-results.html.php";
	exit;
}

add_action(
	'wp_ajax_'.'gdurl_googapi_put_panel_results', 
	'gdurl_googapi_put_panel_results'
);

// Differentiate whether we need to load from
// cache or get live results.
function gdurl_googapi_cache( $s ) {
	// First see if we have cached data (15 seconds?)
	$gdurl_transient = get_transient( 'gdurl_googapi_cache' );

	if( isset( $gdurl_transient[$s] ) ) {
		return apply_filters(
			__FUNCTION__, 
			$gdurl_transient[$s]
		);
	}else{
		return apply_filters(
			__FUNCTION__, 
			gdurl_googapi_set_cache( $s ) 
		);
	}
}

// Sets the transient cache up by storing the results
// of the search in a multi-array.
function gdurl_googapi_set_cache( $s ) {

	// Get current transient data
	$googapi_cache = get_transient( 'gdurl_googapi_cache' );

	// Sanitize the results
	if( !is_array( $googapi_cache ) ) {
		
		// If it's been changed, make sure and
		// setup a new array so we can continue.
		$googapi_cache = array();
	}

	// Add this search
	$googapi_cache[$s] = gdurl_googapi( $s );

	// Set the cache
	set_transient( 
		'gdurl_googapi_cache',
		$googapi_cache, 
		HOUR_IN_SECONDS
	);

	// Return the results
	return apply_filters(
		__FUNCTION__, 
		$googapi_cache[$s]
	);
}

?>