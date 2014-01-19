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

?>