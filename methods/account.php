<?php

class Stripe_API_Account extends Stripe_API {
	
	public function __construct() { }

	public function get( $params = array() ) {
		
		echo "get this account";

		return parent::retrieve( 'account', $params );

	}

}