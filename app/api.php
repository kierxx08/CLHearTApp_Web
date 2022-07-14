<?php


if (isset($_GET['action'])) {

    if (isset($_POST['device_id']) && isset($_POST['user_id']) && isset($_POST['login_token'])) {
        header('Content-Type: application/json; Charset=UTF-8');
        require "../assets/db_conn.php";
        require "assets/functions.php";
        $SettingFile = file_get_contents('assets/app_settings.json');
        $SettingJson = json_decode($SettingFile);
        $date = date("Y-m-d H:i:s");

        $device_id = $_POST['device_id'];
        $user_id = $_POST['user_id'];
        $login_token = $_POST['login_token'];

        if (check_input("alphanumeric", $device_id) && check_input("alphanumeric", $user_id) && check_input("alphanumeric", $login_token)) {
            $query = mysqli_query($conn, "SELECT * FROM `device_info`, `login_session`, `login_info` WHERE device_info.device_id = login_session.device_id AND login_session.user_id = login_info.user_id AND BINARY device_info.device_id = '$device_id' AND BINARY login_info.user_id='$user_id' AND BINARY login_session.login_token='$login_token'");
            $fetch = mysqli_fetch_array($query);
            if (mysqli_num_rows($query) == 1) {

                if (!$SettingJson->maintenance) {

                    if ($fetch['app_version'] == $SettingJson->latest_version) {

                        if ($fetch['login_status'] == 'verified') {
                            if ($fetch['session_status'] == 'active') {

                                //**ACTION START HERE**//

                                if($_GET['action']=="get_announcement"){
                                    include "api_get_announcement.php";
                                }else if($_GET['action']=="set_personalisation"){
                                    include "api_set_personalisation.php";
                                }else if($_GET['action']=="get_suggested"){
                                    include "api_get_suggested.php";
                                }else if($_GET['action']=="get_resources"){
                                    include "api_get_resources.php";
                                }else if($_GET['action']=="get_places_coordinates"){
                                    include "api_get_places_coordinates.php";
                                }else if($_GET['action']=="get_qr_data"){
                                    include "api_get_qr_data.php";
                                }else if($_GET['action']=="set_rating"){
                                    include "api_set_rating.php";
                                }else if($_GET['action']=="get_search_result"){
                                    include "api_get_search_result.php";
                                }else if($_GET['action']=="get_resource_list"){
                                    include "api_get_resources_list.php";
                                }else{
                                    $json["success"] = false;
                                    $json["error"] = "action_notfound";
                                    $json["error_desc"] = "Action not Found.";
                                }

                                //**ACTION END HERE**//

                            } else if ($fetch['session_status'] == 'expired') {
                                $json["success"] = false;
                                $json["error"] = "session_expired";
                                $json["error_desc"] = "Session Expired";
                            } else {
                                $json["success"] = false;
                                $json["error"] = "session_inactive";
                                $json["error_desc"] = "Your session is not Active";
                            }
                        } else if ($fetch['login_status'] == 'verify') {
                            $json["success"] = false;
                            $json["error"] = "user_verify";
                            $json["error_desc"] = "Your account is need to verify.\nPlease Contact the Admin.";
                        } else if ($fetch['login_status'] == 'blocked') {
                            $json["success"] = false;
                            $json["error"] = "user_blocked";
                            $json["error_desc"] = "Your account is currently Blocked.\nPlease Contact the Admin.";
                        } else {
                            $json["success"] = false;
                            $json["error_desc"] = "Your account status is not Found.";
                        }
                    } else {
                        $json["success"] = false;
                        $json["error"] = "app_update";
                        $json["error_desc"] = "Please update your app.";
                    }
                } else {

                    $json["success"] = false;
                    $json["error"] = "app_maintenance";
                    $json["error_desc"] = $SettingJson->maintenance_desc;
                }
            } else if (mysqli_num_rows($query) > 1) {
                $json["success"] = false;
                $json["error_desc"] = "The parameter connected " . mysqli_num_rows($query) . " times";
            } else {
                $json["success"] = false;
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
} else {
    header("HTTP/1.1 404 Not Found");
}
