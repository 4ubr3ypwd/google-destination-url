<?php 

function gdesturl_js($hook){

	// These are the admin pages we want 
	// this to work on.
	$hooks = array(
		'edit.php',
		'post-new.php',
		'post.php'
	);

	// Want to add?
	add_filter('gdesturl_js_hooks', $hooks);

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
			'google-destination-url.js', 
			___FILE___
		), 
		array(), 
		'', 
		false 
	);

	// Send some PHP stuff JS's way!
	wp_localize_script( 
		__FUNCTION__, 
		__FUNCTION__, 
		array(
			'placeholder_lang'=>__('Go ahead and search for anything or paste a URL'),
			'goog_ajax_url'=>plugins_url( 
				'google-desination-url-googapi.php?gdesturl_googapi_find=', 
				___FILE___ 
			)
		)
	);
}

add_action('admin_enqueue_scripts','gdesturl_js');

?>