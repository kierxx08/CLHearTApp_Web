<?php
include('../assets/db_conn.php');
include('../assets/get.php');
    session_start();
    session_destroy();
    if (isset($_COOKIE['LS'])) {
        $token = $_COOKIE['LS'];
        if(check_session($conn,$token)){
            mysqli_query($conn,"UPDATE `login_session` SET `session_status`='logout' WHERE login_token='$token'");
        }
        unset($_COOKIE['LS']); 
        setcookie('LS', null, -1, '/'); 
        return true;
    }
    echo "<script>window.location = 'login.php';</script>";
?>