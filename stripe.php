<?php
/*
Plugin Name: Stripe API
Plugin URI: http://marcusbattle.com
Description: This utility allows developers to extend Stripe Payments into any plugin or theme they choose
Author: Marcus Battle
Version: 0.1.0
Author URI: http://marcusbattle.com
*/

class Embee_Stripe {

	public $api;

	public function __construct() {

		// Load WP List Table
	    if( ! class_exists( 'WP_List_Table' ) ) {
	        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	    }

	    include_once plugin_dir_path( __FILE__ ) . 'stripe-table.php';

	    // Load Stripe Objects
		include_once plugin_dir_path( __FILE__ ) . 'api.php';
		include_once plugin_dir_path( __FILE__ ) . 'methods/account.php';
		include_once plugin_dir_path( __FILE__ ) . 'methods/charges.php';
		include_once plugin_dir_path( __FILE__ ) . 'methods/customers.php';

		// Instantiate objects
		$this->charges = new Stripe_API_Charges();
		$this->customers = new Stripe_API_Customers();

		add_action( 'admin_menu', array( $this, 'stripe_admin_menu' ) );
		add_action( 'admin_post_save_stripe_settings', array( $this, 'save_stripe_settings' ) );

	}

	public function stripe_admin_menu() {

		add_menu_page( 'Stripe', 'Stripe', 'manage_options', 'stripe-api', array( $this, 'admin_page_dashboard' ), '', '100.5' );
		add_submenu_page( 'stripe-api', 'Payments', 'Payments', 'manage_options', 'stripe-payments', array( $this, 'admin_page_payments' ) );
		add_submenu_page( 'stripe-api', 'Settings', 'Settings', 'manage_options', 'stripe-settings', array( $this, 'admin_page_settings' ) );

	}

	public function admin_page_dashboard() {
		$this->show_page('dashboard');
	}

	public function admin_page_payments() {

		$data = $this->charges->list_all()->data;
		
		$columns = array(
			'amount' => __('Amount'),
			'created' => __('Date Charged'),
			'receipt_email' => __('Receipt Email'),
			'refunded' => __('Refunded?'),
		);

		$table_data = array(
			'columns' => $columns,
			'data' => $data
		);

		$this->show_page( 'table', $table_data );
	}

	public function admin_page_settings() {
		$this->show_page('settings');
	}

	/**
	 * Displays an admin page
	 *
	 * @since 0.1.0
	 * @param $page_name | string | The page name you want to display w/o the 
	 */
	public function show_page( $page_name = '', $data = array() ) {

		if ( ! $page_name ) {
			echo "<div class=\"wrap\">You have to define a page to display</div>";
			exit;
		}

		if ( ! file_exists( plugin_dir_path( __FILE__ ) . "pages/{$page_name}.php" ) ) {
			echo "<div class=\"wrap\">The page you requested doesn't exist</div>";
			exit;
		}

		// Display page
		ob_start();
		include plugin_dir_path( __FILE__ ) . "pages/{$page_name}.php";
		$page = ob_get_contents();
		ob_end_clean();

		echo $page;

	}

	/**
	 * Saves the Stripe Settings to the options table
	 *
	 * @since 0.1.0
	 */
	public function save_stripe_settings() {

		$stripe_settings = isset( $_POST['stripe_settings'] ) ? $_POST['stripe_settings'] : array();

		$settings_updated = update_option( 'stripe_settings', $stripe_settings );

		wp_safe_redirect( wp_get_referer() );

	}

}

$stripe = new Embee_Stripe();

