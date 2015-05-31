<?php

class Stripe_API_Customers extends Stripe_API {

	public $api_endpoint = 'https://api.stripe.com/v1/customers';

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Create a new Stripe customer and add ID to WP
	 *
	 * @since 0.1.0
	 *
	 * @param 
	 *
	 * @return stirng $stripe_customer_id
	 */
	public function create( $create_args = array(), $user_id = 0 ) {
		
		if ( empty( $create_args ) ) {
			return false;
		}
		
		$stripe_customer_ID = parent::create( $create_args );
		
		if ( $stripe_customer_ID ) {

			return $stripe_customer_ID;

		}

		return false;

	}
	/**
	 * Returns the Stripe Customer ID for the WP user (or searches Stripe by email to find it as a fallback)
	 *
	 * @since 0.1.0
	 *
	 * @param string $user_email
	 *
	 * @return string $stripe_customer_ID
	 */
	public function get_ID_by_email( $user_email = '' ) {
		
		if ( empty( $user_email ) ) {
			return '';
		}
		
		$stripe_customer_ID = '';

		$search_args = array(
			'query' => $user_email,
			'count' => 10,
		);

		$stripe_response = $this->request( 'get', 'https://dashboard.stripe.com/v1/search', $search_args );

		if ( isset( $stripe_response->data ) ) {

			// Loop through all returned objects and find the match
			foreach ( $stripe_response->data as $stripe_object ) {

				if ( $stripe_object->object == 'customer' ) {

					$stripe_customer_ID = $stripe_object->id;
					continue;

				} 

			}

		}

		return $stripe_customer_ID;

	}

}
