<?php

// Performs that actually does the Web API pull from Google. 
// https://developers.google.com/web-search/docs/#fonje_snippets_php
function gdurl_googapi($s){

	// The Web API URL
	$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
		. "q=".urlencode($s)."&userip=".$_SERVER['SERVER_ADDR'];

	// Use curl to pull the API results.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 20);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
	$body = curl_exec($ch);
	curl_close($ch);

	// Convert the response to JSON
	$json = json_decode($body);	

	return apply_filters(__FUNCTION__,$json);
}

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
			'gdurl_cached_search_result_reset', 
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