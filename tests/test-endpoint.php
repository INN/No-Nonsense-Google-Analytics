<?php
/**
 * endpoint Tests.
 *
 * @since   1.0.0
 * @package No_Nonsense_Google_Analytics
 */
class NNGA_Endpoint_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		global $wp_rest_server;
		$this->server = $wp_rest_server = new WP_REST_Server;
		do_action( 'rest_api_init' );
	}

	/**
	 * Test if our class exists.
	 *
	 * @since  1.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'NNGA_Endpoint' ) );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  1.0.0
	 */
	function test_class_access() {
		$this->assertTrue( no_nonsense_google_analytics()->endpoint instanceof NNGA_Endpoint );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  1.0.0
	 */
	function test_sample() {
		$this->assertTrue( true );
	}

	protected function assertResponseStatus( $status, $response, $error_code = '', $debug = false ) {
         if ( $debug ) {
             error_log( '$response->get_data(): '. print_r( $response->get_data(), true ) );
         }
         $this->assertEquals( $status, $response->get_status() );

         if ( $error_code ) {
             $this->assertResponseErrorCode( $error_code, $response );
         }
     }

     protected function assertResponseErrorCode( $error_code, $response ) {
         $response_data = $response->get_data();
         $this->assertEquals( $error_code, $response_data['code'] );
     }

     protected function assertResponseData( $data, $response ) {
         $response_data = $response->get_data();
         $tested_data = array();
         foreach( $data as $key => $value ) {
             if ( isset( $response_data[ $key ] ) ) {
                 $tested_data[ $key ] = $response_data[ $key ];
             } else {
                 $tested_data[ $key ] = null;
             }
         }
         $this->assertEquals( $data, $tested_data );
     }

	public function tearDown() {
		parent::tearDown();

		global $wp_rest_server;
		$wp_rest_server = null;
	}


}
