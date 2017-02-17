<?php

class BaseTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'Google_Destination_URL') );
	}
	
	function test_get_instance() {
		$this->assertTrue( google_destination_url() instanceof Google_Destination_URL );
	}
}
