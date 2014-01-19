<?php 

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


?>