<?php

if (isset($conn)) {
    if (isset($_POST['search_query'])) {
        $search_query = $_POST['search_query'];

        $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_name LIKE '%$search_query%' OR res_desc LIKE '%$search_query%'");
        $fetch_count = mysqli_num_rows($query);

        if ($fetch_count > 0) {

            $resources_array = array();
            while ($fetch = mysqli_fetch_array($query)) {

                $resources["id"] = $fetch['res_id'];
                $resources["name"] = $fetch['res_name'];
                $resources["rating"] = $fetch['res_ratings'];
                $resources["rated_user"] = resources_rateUser_count($resources["id"]);

                /*
            $image_array = array();
            $image_json = json_decode($fetch['res_photos']);
            for($i=0;$i<count($image_json);$i++){
                array_push($image_array, $base_url."/image/resources/".$resources["id"]."_".$image_json[$i]."?id=".rand());
            }
            $resources["image"] = $image_array;
            */

                $image_json = json_decode($fetch['res_photos']);
                for ($i = 0; $i < 1; $i++) {
                    $resources["image"] = $base_url."/app/img_resources.php?filename=".$resources["id"]."_".$image_json[$i]."&id=".rand();
                }

                array_push($resources_array, $resources);
            }

            $json["success"] = true;
            $json["data"] = $resources_array;
        } else {
            $json["success"] = false;
            $json["error"] = "no_resources";
            $json["error_desc"] = "No resources Found.";
        }
    } else {
        $json["success"] = false;
        $json["error_desc"] = "Search Query Error";
    }
} else {
    header("HTTP/1.1 404 Not Found");
}
