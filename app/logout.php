<?php
if (isset($_POST['device_id']) && isset($_POST['user_id']) && isset($_POST['login_token'])) {
    header('Content-Type: application/json; Charset=UTF-8');
    require "../assets/db_conn.php";
    require "assets/functions.php";
    $date = date("Y-m-d H:i:s");

    $device_id = $_POST['device_id'];
    $user_id = $_POST['user_id'];
    $login_token = $_POST['login_token'];

    if (check_input("alphanumeric", $device_id) && check_input("alphanumeric", $user_id) && check_input("alphanumeric", $login_token)) {
        $query = mysqli_query($conn, "SELECT * FROM `device_info`, `login_session`, `login_info` WHERE device_info.device_id = login_session.device_id AND login_session.user_id = login_info.user_id AND BINARY device_info.device_id = '$device_id' AND BINARY login_info.user_id='$user_id' AND BINARY login_session.login_token='$login_token'");
        $fetch = mysqli_fetch_array($query);
        if (mysqli_num_rows($query) == 1) {

            $SettingFile = file_get_contents('assets/app_settings.json');
            $data = json_decode($SettingFile);

            $maintenance = $data->maintenance;

            if (!$maintenance) {

                $latest_version =  $data->latest_version;

                if ($fetch['app_version'] == $latest_version) {

                    $query = mysqli_query($conn, "UPDATE `login_session` SET `session_status`='logout' WHERE platform='android_app' AND user_id='$user_id' AND device_id='$device_id' AND login_token='$login_token'");
                    if (mysqli_affected_rows($conn) > 0) {
                        $json["success"] = true;
                    } else {
                        $json["success"] = false;
                        $json["error_desc"] = "Error in logging out your account";
                    }
                } else {
                    $json["success"] = false;
                    $json["error"] = "app_update";
                    $json["error_desc"] = "Please update your app.";
                }
            } else {

                $json["success"] = false;
                $json["error"] = "app_maintenance";
                $json["error_desc"] = $data->maintenance_desc;
            }
        } else if (mysqli_num_rows($query) > 1) {
            $json["success"] = false;
            $json["error_desc"] = "The parameter connected " . mysqli_num_rows($query) . " times";
        } else {
            $json["success"] = true;
            $json["error_desc"] = "The parameter connection not found.";
        }
    } else {
        $json["success"] = false;
        $json["error_desc"] = "Parameters not satisfied.";
    }

    //echo json_encode(mb_convert_encoding($json, "UTF-8", "HTML-ENTITIES"));
    echo json_encode($json);
} else {
    header("HTTP/1.1 404 Not Found");
}
