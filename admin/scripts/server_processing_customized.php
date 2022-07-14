<?php
session_start();
if(!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
    header("location: ../login.php");
    exit();
}
if(isset($_GET['action'])){
		/*
		* DataTables example server-side processing script.
		*
		* Please note that this script is intentionally extremely simply to show how
		* server-side processing can be implemented, and probably shouldn't be used as
		* the basis for a large complex system. It is suitable for simple use cases as
		* for learning.
		*
		* See http://datatables.net/usage/server-side for full details on the server-
		* side processing requirements of DataTables.
		*
		* @license MIT - http://datatables.net/license_mit
		*/

		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		* Easy set variables
		*/
		if($_GET['action']=="product_list"){
			// DB table to use
			$table = 'product_info';

			// Table's primary key
			$primaryKey = 'product_id';

			// Array of database columns which should be read and sent back to DataTables.
			// The `db` parameter represents the column name in the database, while the `dt`
			// parameter represents the DataTables column identifier. In this case simple
			// indexes
			$columns = array(
				array( 
					'db' => '`pi`.`product_id`', 
					'dt' => 0, 
					'field' => 'product_id' , 
					'formatter' => function( $d, $row ) {
						return $d;
				}),
				array( 'db' => '`pi`.`product_name`', 'dt' => 1, 'field' => 'product_name' ),
				array( 'db' => '`pi`.`original_price`', 'dt' => 2, 'field' => 'original_price'),
				array( 'db' => '`pi`.`current_price`', 'dt' => 3, 'field' => 'current_price' ),
				array( 'db' => '`pi`.`max_purchase_perday`', 'dt' => 4, 'field' => 'max_purchase_perday' ),
				array(
					'db' => "SUM(pes.order_id='null')",
					'dt' => 6, 
					'field' => "SUM(pes.order_id='null')", 
					'formatter' => function( $d, $row ) {
						if($d == null){
							return 0;
						}else{
							return $d;
						}
				}),
				array(
					'db' => '`pi`.`product_type`',
					'dt' => 5, 
					'field' => 'product_type'),
				array(
					'db'  => '`pi`.`product_status`',
					'dt' => 7, 
					'field' => 'product_status', 
					'formatter' => function( $d, $row ) {
						if($d == 'available'){
							return true;
						}else{
							return false;
						}
				}),
				array(
					'db' => '`pi`.`start_date_post`',
					'dt' => 8, 
					'field' => 'start_date_post', 
					'formatter' => function( $d, $row ) {
						$date = date("Y-m-d H:i:s");
						if($d <= $date){
							return true;
						}else{
							return false;
						}
				}),
				array(
					'db' => '`pi`.`end_date_post`',
					'dt' => 9, 
					'field' => 'end_date_post', 
					'formatter' => function( $d, $row ) {
						$date = date("Y-m-d H:i:s");
						if($d >= $date ){
							return true;
						}else{
							return false;
						}
				})
			);

			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
			* If you just want to use the basic configuration for DataTables with PHP
			* server-side, there is no need to edit below this line.
			*/

			$joinQuery = "FROM `product_info` AS `pi` LEFT  JOIN `product_evoucher_stock` AS `pes` ON (`pi`.`product_id` = `pes`.`product_id`)";
			$extraWhere = "";
			$groupBy = "`pi`.`product_id`";
			//$having = "`u`.`salary` >= 140000";
		}else if($_GET['action']=="users_list"){
			// DB table to use
			$table = 'user_info';

			// Table's primary key
			$primaryKey = 'user_id';

			$columns = array(
				array( 
					'db' => '`ui`.`user_id`', 
					'dt' => 0, 
					'field' => 'user_id'),
				array( 'db' => '`ui`.`fname`', 'dt' => 1, 'field' => 'fname' ),
				array( 'db' => '`ui`.`lname`', 'dt' => 2, 'field' => 'lname' ),
				array( 
					'db' => '`li`.`last_active`', 
					'dt' => 3, 
					'field' => 'last_active',
					'formatter' => function( $d, $row ) {
						return date( 'M. d, Y h:i a', strtotime($d));
					})
			);

			$joinQuery = "FROM `user_info` AS `ui` LEFT  JOIN `login_info` AS `li` ON (`ui`.`user_id` = `li`.`user_id`)";
			$extraWhere = "";
			$groupBy = "`ui`.`user_id`";

		}

		// require( 'ssp.class.php' );
		require('ssp.class.customized.php' );
		require('../../assets/db_conn.php');

		// SQL server connection information
		$sql_details = array(
			'user' => $db_user,
			'pass' => $db_pass,
			'db'   => $db_name,
			'host' => $db_host
		);

		echo json_encode(
			SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy )
		);
	
}else{

    header('HTTP/1.1 404 Not Found');

}