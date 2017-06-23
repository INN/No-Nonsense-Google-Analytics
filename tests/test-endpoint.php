<?php
/**
 * endpoint Tests.
 *
 * @since   1.2.0
 * @package No_Nonsense_Google_Analytics
 */
class NNGA_Endpoint_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		global $wp_rest_server;
		$this->server = $wp_rest_server = new WP_REST_Server;
		do_action( 'rest_api_init' );

		$this->subscriber = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		$this->administrator = $this->factory->user->create( array( 'role' => 'administrator' ) );
	}

	/**
	 * Test if our class exists.
	 *
	 * @since  1.2.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'NNGA_Endpoint' ) );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  1.2.0
	 */
	function test_class_access() {
		$this->assertTrue( no_nonsense_google_analytics()->endpoint instanceof NNGA_Endpoint );
	}

	/**
	 * Test get request.
	 *
	 * @since  1.2.0
	 */
	public function test_get() {
		$request = new WP_REST_Request( 'GET', '/no-nonsense-google-analytics/v1/tracking-code' );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 200, $response );
	}

	/**
	 * Test unauthorized update request.
	 *
	 * @since  1.2.0
	 */
	public function test_unauthorized_update() {
		wp_set_current_user( 0 );

		$request = new WP_REST_Request( 'POST', '/no-nonsense-google-analytics/v1/tracking-code' );
		$request->set_param( 'code', 'UA-12345, UA-678910' );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 403, $response );
	}

	/**
	 * Test authorized update request.
	 *
	 * @since  1.2.0
	 */
	public function test_authorized_update() {
		wp_set_current_user( $this->administrator );

		$request = new WP_REST_Request( 'POST', '/no-nonsense-google-analytics/v1/tracking-code' );
		$request->set_param( 'code', 'UA-12345, UA-678910' );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 200, $response );
		$this->assertEquals( 'UA-12345, UA-678910', get_option( 'no_nonsense_google_analytics' ) );
	}

	/**
	 * Test unauthorized delete request.
	 *
	 * @since  1.2.0
	 */
	public function test_unauthorized_delete() {
		wp_set_current_user( 0 );

		$request = new WP_REST_Request( 'POST', '/no-nonsense-google-analytics/v1/tracking-code' );
		$request->set_param( 'force', true );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 403, $response );
	}

	/**
	 * Test authorized delete request.
	 *
	 * @since  1.2.0
	 */
	public function test_authorized_delete() {
		wp_set_current_user( $this->administrator );

		$request = new WP_REST_Request( 'POST', '/no-nonsense-google-analytics/v1/tracking-code' );
		$request->set_param( 'force', true );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 200, $response );
		$this->assertResponseData( array(
			'code' => null,
		), $response );
		$this->assertEquals( false, get_option( 'no_nonsense_google_analytics' ) );
	}

	/**
	 * Test response status for API request.
	 *
	 * @since  1.2.0
	 */
	protected function assertResponseStatus( $status, $response, $error_code = '', $debug = false ) {
         if ( $debug ) {
             error_log( '$response->get_data(): '. print_r( $response->get_data(), true ) );
         }
         $this->assertEquals( $status, $response->get_status() );

         if ( $error_code ) {
             $this->assertResponseErrorCode( $error_code, $response );
         }
     }

	 /**
 	 * Test response error code for API request.
 	 *
 	 * @since  1.2.0
 	 */
     protected function assertResponseErrorCode( $error_code, $response ) {
         $response_data = $response->get_data();
         $this->assertEquals( $error_code, $response_data['code'] );
     }

	 /**
 	 * Test response data for API request.
 	 *
 	 * @since  1.2.0
 	 */
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

	 /**
 	 * Turn off Rest server.
 	 *
 	 * @since  1.2.0
 	 */
	public function tearDown() {
		parent::tearDown();

		global $wp_rest_server;
		$wp_rest_server = null;
	}
}
