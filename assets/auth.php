<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) {
		$redirect = basename($_SERVER['REQUEST_URI']);
		header("location: authCookieSessionValidate.php?redirect=$redirect");
		exit();
	}
?>