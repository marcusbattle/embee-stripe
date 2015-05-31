<?php

class Stripe_API_Charges extends Stripe_API {

	public $api_endpoint = 'https://api.stripe.com/v1/charges';

	public function __construct() {
		parent::__construct();
	}
	
}
