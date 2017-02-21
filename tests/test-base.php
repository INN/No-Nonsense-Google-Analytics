<?php

class BaseTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'No_Nonsense_Google_Analytics') );
	}
	
	function test_get_instance() {
		$this->assertTrue( no_nonsense_google_analytics() instanceof No_Nonsense_Google_Analytics );
	}
}
