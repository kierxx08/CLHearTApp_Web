<?php

if (isset($conn)) {
    if (isset($_POST['resource_id']) && isset($_POST['rating_number'])){
        $res_id = $_POST['resource_id'];
        $rating_number = $_POST['rating_number'];
        if(resourceid_exist($res_id)){
            if(check_input("float", $rating_number)){
                $rating_id = random_str(10);

                $query = "INSERT INTO `resources_rating`(`rating_id`, `user_id`, `res_id`, `user_rating`, `rating_date`) VALUES ('$rating_id','$user_id','$res_id','$rating_number','$date')";
                if ((mysqli_query($conn, $query))) {
                    $average_rating = get_rateAverage($res_id);
                    $query2 = "UPDATE `resources_info` SET `res_ratings`='$average_rating' WHERE res_id='$res_id'";
                    if ((mysqli_query($conn, $query2))) {
                        $json["success"] = true;
                        $json["rating"] = $average_rating;
                        $json["rated_user"] = resources_rateUser_count($res_id);
                    }else{
                        $json["success"] = true;
                        $json["error_desc"] = "Sorry, We're experiencing an error updating data in the database. Please try again.";
                    }
                
                } else {
                    $json["success"] = true;
                    $json["error_desc"] = "Sorry, We're experiencing an error inserting data in the database. Please try again.";
                }

            }else{
                $json["success"] = false;
                $json["error_desc"] = $rating_number ."Rating Error";
            }

        }else{
            $json["success"] = false;
            $json["error"] = "no_resources";
            $json["error_desc"] = "No resources Found.";
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