<?php

header('Content-Type: application/json; Charset=UTF-8');
if (isset($_POST['action'])) {

    include('../../assets/db_conn.php');
    include('check.php');
    include('generate.php');
    include('get.php');

    if ($_POST['action'] == "delete_announcement") {
        if (isset($_POST['id']) && check_announcement_exist($conn, $_POST['id'])) {
            $announce_id = $_POST['id'];

            $query = mysqli_query($conn, "DELETE FROM `announcement` WHERE announce_id='$announce_id'");

            $target_dir = "../../image/announcement/";
            $basename = $announce_id.".png";
            $target_file = $target_dir . $basename;

            if (file_exists($target_file)) {
                unlink($target_file);
            }
            $json["response"] = "success";
        } else {
            $json["response"] = "access_denied";
            $json["error_desc"] = "Error in deleting announcement";
        }
    } else {
        $json["statusCode"] = 404;
    }

    echo json_encode($json);
} else {
    header("HTTP/1.1 404 Not Found");
}
