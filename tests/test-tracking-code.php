<?php

class NNGA_Tracking_Code_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'NNGA_Tracking_Code') );
	}

	function test_class_access() {
		$this->assertTrue( no_nonsense_google_analytics()->tracking-code instanceof NNGA_Tracking_Code );
	}
}
