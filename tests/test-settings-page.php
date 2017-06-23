<?php

class NNGA_Settings_Page_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'NNGA_Settings_Page') );
	}

	function test_class_access() {
		$this->assertTrue( no_nonsense_google_analytics()->settings_page instanceof NNGA_Settings_Page );
	}
}
