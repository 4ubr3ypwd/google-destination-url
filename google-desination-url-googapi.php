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
	$result_data = gdurl_googapi($s);
	include "google-destination-url-snippet.html.php";
}

?>