<?php

if (isset($conn)) {
    if (isset($_POST['resource_id']) && isset($_POST['curLad']) && isset($_POST['curLong']) && check_input("text02", $_POST['resource_id'])) {
        $resource_id = $_POST['resource_id'];
        $curLad = $_POST['curLad'];
        $curLong = $_POST['curLong'];
        $query = mysqli_query($conn, "SELECT *, IF(resources_rating.res_id IS NULL, FALSE, TRUE) AS isRated FROM `resources_info`
        LEFT JOIN resources_rating ON (resources_info.res_id = resources_rating.res_id AND resources_rating.user_id='$user_id')
        WHERE resources_info.res_id='$resource_id'");
        $fetch = mysqli_fetch_array($query);
        $fetch_count = mysqli_num_rows($query);

        if ($fetch_count == 1) {
            $type = $fetch['res_type'];

            $json["success"] = true;
            $json["id"] = $resource_id;
            $json["name"] = $fetch['res_name'];
            $json["description"] = $fetch['res_desc'];
            $json["type"] = $type;
            $json["rating"] = $fetch['res_ratings'];
            $json["rated_user"] = resources_rateUser_count($resource_id);
            $json["latitude"] = $fetch['res_lat'];
            $json["longitude"] = $fetch['res_long'];
            $distance = getDistanceBetweenPointsNew($fetch['res_lat'], $fetch['res_long'], $curLad, $curLong);
            if($distance>1000){
                $json["distance"] = (round($distance/1000,2)) . " km";
            }else{
                $json["distance"] = $distance . " m";
                if($_POST['isVisit']=="true" && $type!="exhibit"){
                    in_VisitPlace($user_id,$resource_id);
                }
            }

            if($fetch['isRated']==0 && $distance<1000){
                $json["rateOn"] = true;
            }else{
                $json["rateOn"] = false;
            }
            

            $image_array = array();
            $image_json = json_decode($fetch['res_photos']);
            for ($i = 0; $i < count($image_json); $i++) {
                array_push($image_array, $base_url . "/app/img_resources.php?filename=" . $resource_id . "_" . $image_json[$i] . "&id=" . rand());
            }
            $json["image"] = $image_array;

        } else {
            $json["success"] = false;
            $json["error"] = "no_resources";
            $json["error_desc"] = "No resources Found.";
        }
    } else {
        $json["success"] = false;
        $json["error"] = "missing_params";
        $json["error_desc"] = "Missing Parameter.";
    }
} else {
    header("HTTP/1.1 404 Not Found");
}
