<?php

class Stripe_API {
	
	public $stripe_settings;
	public $api_endpoint = '';
	public $secret_key = '';

	public function __construct() { 

		$this->stripe_settings = get_option( 'stripe_settings', false );

		// Set the secret key based on processing mode
		if ( isset( $this->stripe_settings['mode'] ) ) {
			$this->secret_key = $this->stripe_settings[ $this->stripe_settings['mode'] . '_secret_key' ];
		}

	}

	/**
	 * Returns a defined list of created stripe objects
	 *
	 * @since 0.1.0
	 * @param $args | array
	 */
	public function list_all( $args = array() ) { 

		$results = $this->request( 'get', $this->api_endpoint, $args );

		return $results;

	}

	/**
	 * Creates a new object in Stripe (i.e charge, customer, etc)
	 * 
	 * @since 0.1.0
	 * @param array $create_args Data to send to Stripe to create new object
	 */
	public function create( $create_args = array() ) {

		$stripe_response = $this->request( 'post', $this->api_endpoint, $create_args );
		
		if ( isset( $stripe_response->id ) ) {
			return $stripe_response->id;
		}

		return false;

	}

	public function request( $method = 'get', $endpoint = '', $args = array() ) {

		$api_args = array(
			'headers' => array( 
				'Authorization' => 'Basic '. base64_encode("{$this->secret_key}:") 
			),
			'body' => $args
		);

		$request_method = 'wp_remote_' . $method;
		$stripe_response = $request_method( $endpoint, $api_args );

		$response = isset( $stripe_response['body'] ) ? json_decode( $stripe_response['body'] ) : array();

		return $response;

	}

}