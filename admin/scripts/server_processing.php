<?php

//session_start();
//if(!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
//    header("location: ../login.php");
//    exit();
//}
if(isset($_GET['action'])){
    //if($_SESSION['user_id']=="WkfP8SYsHcGjBKN6uX41"){
    /*
    * DataTables example server-side processing script.
    *
    * Please note that this script is intentionally extremely simple to show how
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
    
    $table = '';
    $primaryKey = '';
    $columns = '';
    if($_GET['action']=="acode"){
    // DB table to use
    $table = 'authorization';
    
    // Table's primary key
    $primaryKey = 'code';
    
    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
        $columns = array(
            array( 'db' => 'code', 'dt' => "uid" ),
            array( 'db' => 'status', 'dt' => "status" ),
            array(
                'db'        => 'date',
                'dt'        => "date",
                'formatter' => function( $d, $row ) {
                    return date( 'M, d Y h:i:s', strtotime($d));
                }
            ),
        );

    }else if($_GET['action']=="announcement"){
        // DB table to use
        $table = 'announcement';
        
        // Table's primary key
        $primaryKey = 'announce_id';
        
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'announce_id', 'dt' => 0 ),
            array( 'db' => 'announce_title', 'dt' => 1 ),
            array( 'db' => 'announce_posted', 'dt' => 2 ),
            array(
                'db'        => 'announce_date',
                'dt'        => 3,
                'formatter' => function( $d, $row ) {
                    return date( 'M. d, Y h:i:s a', strtotime($d));
                }
            ),
        );
    
    }else if($_GET['action']=="resources"){
        // DB table to use
        $table = 'resources_info';
        
        // Table's primary key
        $primaryKey = 'res_id';
        
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'res_id', 'dt' => 0 ),
            array( 'db' => 'res_name', 'dt' => 1 ),
            array( 'db' => 'res_type', 'dt' => 2 ),
            array(
                'db'        => 'res_ratings',
                'dt'        => 3
            ),
        );
    
    }
        
    // SQL server connection information
	require('../../assets/db_conn.php');
    $sql_details = array(
		'user' => $db_user,
		'pass' => $db_pass,
		'db'   => $db_name,
		'host' => $db_host
    );
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * If you just want to use the basic configuration for DataTables with PHP
    * server-side, there is no need to edit below this line.
    */
    
    require( 'ssp.class.php' );
    
    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    );

//}else{

    //header('HTTP/1.1 403 Forbidden');

//}
}else{

    header('HTTP/1.1 404 Not Found');

}


?>