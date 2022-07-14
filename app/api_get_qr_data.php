<?php

if (isset($conn)) {
    if (isset($_POST['QRData']) && check_input("text01", $_POST['QRData'])) {
        $QRData = qr_decrypt($_POST['QRData']);

        $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_id='$QRData'");
        $fetch = mysqli_fetch_array($query);
        $fetch_count = mysqli_num_rows($query);
        if($fetch_count==1){
            $json["success"] = true;
            $json["id"] = $fetch['res_id'];
        }else{
            $json["success"] = false;
            $json["error"] = "not_found";
        }

    }else{
        $json["success"] = false;
        $json["error"] = "missing_params";
        $json["error_desc"] = "Missing Parameter.";
    }
} else {
    header("HTTP/1.1 404 Not Found");
}
?>