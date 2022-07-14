<?php

if (isset($conn)) {
    $query = mysqli_query($conn, "SELECT * FROM `resources_info`");
    $fetch_count = mysqli_num_rows($query);

    if ($fetch_count > 0) {

        $resources_array = array();
        while ($fetch = mysqli_fetch_array($query)) {

            $resources["id"] = $fetch['res_id'];
            $resources["name"] = $fetch['res_name'];
            $resources["type"] = $fetch['res_type'];
            $resources["lat"] = $fetch['res_lat'];
            $resources["long"] = $fetch['res_long'];

        
            array_push($resources_array, $resources);
        }

        $json["success"] = true;
        $json["data"] = $resources_array;

    }else{
        $json["success"] = false;
        $json["error"] = "no_resources";
        $json["error_desc"] = "No resources Found.";
    }
}else {
    header("HTTP/1.1 404 Not Found");
}

?>