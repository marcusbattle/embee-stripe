<?php

class Stripe_Object_Table extends WP_List_Table {
  
	public $stripe_data = array();
	public $columns = array();

	public function __construct( $table_data = array() ) {

		$this->columns = isset( $table_data['columns'] ) ? $table_data['columns'] : array();
		$this->stripe_data = isset( $table_data['data'] ) ? $table_data['data'] : array();

		// echo "<pre>";
		// print_r( $this->stripe_data );
		// echo "</pre>";

	}

  	public function get_columns() {

		return $this->columns;

  	}

	public function get_sortable_columns() {

		$sortable_columns = array();

		return $sortable_columns;

	}

	public function prepare_items() {

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items = $this->stripe_data;

	}

	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			
			case 'amount':
				$amount = $item->$column_name / 100;
				echo '$' . number_format( $amount, 2 );
				break;
			
			case 'created':
				echo date('Y-m-d H:i:s', $item->$column_name );
				break;

			case 'refunded':
				echo ( $item->$column_name ) ? 'Yes' : 'No' ;
				break;

			default:
				echo ( $item->$column_name ) ? $item->$column_name : '--';
				break;

		}
		

	}

}