<?php

if (isset($conn)) {
    if(isset($_POST['type']) && isset($_POST['start'])) {
        $type = $_POST['type'];

        $start = $_POST['start'];
        $end = $start+20;

        if($type == "all"){
            $query = mysqli_query($conn, "SELECT * FROM `resources_info` ORDER BY res_name ASC LIMIT $start, 20");
        }else{
            $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_type='$type' ORDER BY res_name ASC LIMIT $start, 20");
        }
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
                    $resources["image"] = $base_url."/app/img_resources.php?filename=".$resources["id"]."_".$image_json[$i]."&size=small&id=".rand();
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

    }else if(isset($_POST['type']) && isset($_POST['total'])){
        $type = $_POST['type'];
        if($type == "all"){
            $query = mysqli_query($conn, "SELECT * FROM `resources_info`  ");
        }else{
            $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_type='$type' ");
        }
        $num = mysqli_num_rows($query);
        
        $json["success"] = true;
        $json["total"] = $num;
    }else{
        $json["success"] = false;
        $json["error"] = "missing_params";
        $json["error_desc"] = "Missing Parameter.";
    }
}else{
    header("HTTP/1.1 404 Not Found");
}

?>