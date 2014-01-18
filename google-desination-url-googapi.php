<?php

function gdesturl_googapi($s){

	if( !isset($_SERVER['HTTP_REFERER']) ) return false;

	// From:
	// 
	// https://developers.google.com/web-search/docs/#fonje_snippets_php
	// ==================================

	// The request also includes the userip parameter which provides the end
	// user's IP address. Doing so will help distinguish this legitimate
	// server-side traffic from traffic which doesn't come from an end-user.
	$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
		. "q=".urlencode($s)."&userip=".$_SERVER['SERVER_ADDR'];

	// sendRequest
	// note how referer is set manually
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 20);
	curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
	$body = curl_exec($ch);
	curl_close($ch);

	// now, process the JSON string
	$json = json_decode($body);
	// now have some fun with the results...
	
	return $json;
}

if( isset($_GET['gdesturl_googapi_find']) ){
	
	$result_data = gdesturl_googapi(
		 $_GET['gdesturl_googapi_find']
	);

	include "google-destination-url-snippet.html.php";

	exit;

}

?>