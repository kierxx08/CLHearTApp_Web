<?php

session_start();
include('../assets/db_conn.php');
include('scripts/get.php');
include('scripts/check.php');
include('scripts/update.php');

if (isset($_GET['redirect']) && (trim($_GET['redirect']) != '')) {
    $redirect = $_GET['redirect'];
} else {
    $redirect = false;
}
if (isset($_COOKIE['DI']) && $_COOKIE['DI'] != "" && check_deviceid($conn, $_COOKIE['DI'])) {
    if (isset($_COOKIE['LS']) && $_COOKIE['LS'] != "") {
        $token = $_COOKIE['LS'];
        if (check_session($conn, $token)) {
            $user_id = get_SessionUser($conn, "user_id", $token);
            $_SESSION['user_id'] = $user_id;
            echo "<script>window.location = '$redirect';</script>";
            up_LastActive($conn, $user_id);
        } else {
            echo "<script>window.location = 'login.php?redirect=$redirect';</script>";
        }
    } else {
        echo "<script>window.location = 'login.php?redirect=$redirect';</script>";
    }
} else {
    echo "<script>window.location = 'login.php?redirect=$redirect';</script>";
}
