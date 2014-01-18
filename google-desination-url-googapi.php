<?php

function gdurl_googapi($s){

	// https://developers.google.com/web-search/docs/#fonje_snippets_php

	$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
		. "q=".urlencode($s)."&userip=".$_SERVER['SERVER_ADDR'];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 20);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
	$body = curl_exec($ch);
	curl_close($ch);

	$json = json_decode($body);	
	return $json;
}

function gdurl_googapi_load($s){	
	$result_data = gdurl_googapi_cache($s);
	include "google-destination-url-snippet.html.php";
}

function gdurl_googapi_cache($s){
	// First see if we have cached data (15 seconds?)
	$diff_results = get_transient( 'gdurl_googapi_cache' );

	if( isset($diff_results[$s]) ){
		return $diff_results[$s];
	}else{
		return gdurl_googapi_set_cache($s);
	}
}

function gdurl_googapi_set_cache($s){

	// Get current transient data
	$googapi_cache = get_transient( 'gdurl_googapi_cache' );

	// Add this search
	$googapi_cache[$s] = gdurl_googapi($s);

	// Set the cache
	set_transient( 
		'gdurl_googapi_cache', 
		$googapi_cache, 
		2
	);

	// Return the results
	return apply_filters(__FUNCTION__, $googapi_cache[$s]);

}

?>