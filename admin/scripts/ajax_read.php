<?php

header('Content-Type: application/json; Charset=UTF-8');
if (isset($_POST['action'])) {

    include('../../assets/db_conn.php');

    if ($_POST['action'] == "announcement_details" && isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = mysqli_query($conn, "SELECT * FROM `announcement` WHERE announce_id = '$id'");
        $fetch = mysqli_fetch_array($query);
        if(mysqli_num_rows($query)==1){
            $json["response"] = "success";
            $json["id"] = $fetch['announce_id'];
            $json["title"] = $fetch['announce_title'];
            $json["status"] = $fetch['announce_posted'];
            if (file_exists("../../image/announcement/".$id.".png")) {
                $json["image"] = "../image/announcement/".$id.".png";
            }else{
                $json["image"] = "../image/announcement/no_announcement.png";
            }
        }else{
            $json["response"] = "error";
            $json["error_desc"] = "Announcement not Found";
        }

    }else if ($_POST['action'] == "resources_details" && isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_id = '$id'");
        $fetch = mysqli_fetch_array($query);
        if(mysqli_num_rows($query)==1){
            $json["response"] = "success";
            $json["name"] = $fetch['res_name'];
            $json["desc"] = $fetch['res_desc'];
            $json["type"] = $fetch['res_type'];
            $json["lat"] = $fetch['res_lat'];
            $json["long"] = $fetch['res_long'];
            $image_array = array();
            $image_json = json_decode($fetch['res_photos']);
            for ($i = 0; $i < count($image_json); $i++) {
                $image_data["id"] = $i+1;
                $image_data["src"] = $base_url . "/image/resources/" . $id . "_" . $image_json[$i];
                array_push($image_array, $image_data);
            }
            $json["image"] = $image_array;

            $tag_array = array();
            $query2 = mysqli_query($conn, "SELECT * FROM `resources_tag` tt, `tag_info` ti WHERE tt.tag_id = ti.tag_id AND tt.res_id = '$id'");
            while($fetch = mysqli_fetch_array($query2)){
                array_push($tag_array, $fetch['tag_name']);
            }
            $json["tag"] = $tag_array;
        
            
        }else{
            $json["response"] = "error";
            $json["error_desc"] = "User not Found";
        }

    }else if ($_POST['action'] == "users_details" && isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = mysqli_query($conn, "SELECT * FROM `user_info`,`login_info` WHERE user_info.user_id=login_info.user_id AND user_info.user_id = '$id'");
        $fetch = mysqli_fetch_array($query);
        if(mysqli_num_rows($query)==1){
            $json["response"] = "success";
            $json["username"] = $fetch['user_name'];
            $json["fullname"] = $fetch['fname']." ".$fetch['lname'];
            $json["address"] = $fetch['user_brgy'].", ".$fetch['user_city'].", ".$fetch['user_prov'];
            $json["phone_number"] = $fetch['number'];
            $json["email"] = $fetch['email'];

            $interest_array = array();
            $query2 = mysqli_query($conn, "SELECT * FROM `user_interest`, `tag_info` WHERE user_interest.tag_id = tag_info.tag_id AND user_interest.user_id='$id'");
            while($fetch = mysqli_fetch_array($query2)){
                array_push($interest_array, $fetch['tag_name']);
            }
            $json["interest"] = $interest_array;
            
        }else{
            $json["response"] = "error";
            $json["error_desc"] = "User not Found";
        }

    }else if ($_POST['action'] == "app_details") {
        
        $SettingFile = file_get_contents('../../app/assets/app_settings.json');
        $data = json_decode($SettingFile);

        $json["response"] = "success";
        $json["latest_version"] = $data->latest_version;
        $json["newup"] = $data->latest_description;

    }else if ($_POST['action'] == "server_info") {
        
        $SettingFile = file_get_contents('../../app/assets/app_settings.json');
        $data = json_decode($SettingFile);

        $json["response"] = "success";
        $json["state"] = $data->maintenance;

    } else if ($_POST['action'] == "interest_data") {
        $query = mysqli_query($conn, "SELECT tag_info.tag_name, COUNT(tag_info.tag_id) AS Total FROM `tag_info` INNER JOIN user_interest ON (user_interest.tag_id = tag_info.tag_id) GROUP BY tag_info.tag_id ORDER BY `Total` DESC");
        $count = mysqli_num_rows($query);
        $label_array = array();
        $value_array = array();
        $i=1;
        $others = 0;
        while($fetch = mysqli_fetch_array($query)){
            if($i<=10){
                $label_data = ucwords($fetch['tag_name']);
                $value_data = $fetch['Total'];
                array_push($label_array, $label_data);
                array_push($value_array, $value_data);
            }else if($i<$count){
                $others+=$fetch['Total'];
            }else{
                $label_data = "Others";
                $value_data = $others+=$fetch['Total'];
                array_push($label_array, $label_data);
                array_push($value_array, $value_data);
            }
            $i++;
        }
    
        $json["response"] = "success";
        $json["data"] = array("label" => $label_array, "value" => $value_array);
    }else if ($_POST['action'] == "most_visited_data") {
        $query = mysqli_query($conn, "SELECT resources_info.res_name, COUNT(resources_info.res_id) AS Total FROM `resources_info` INNER JOIN user_visit ON (user_visit.res_id = resources_info.res_id) GROUP BY resources_info.res_id ORDER BY `Total` DESC, res_name ASC LIMIT 5;");
        $count = mysqli_num_rows($query);
        $label_array = array();
        $value_array = array();
        $i=1;
        $others = 0;
        if($count!=0){
            while($fetch = mysqli_fetch_array($query)){
                if($i<=5){
                    $label_data = ucwords($fetch['res_name']);
                    $value_data = $fetch['Total'];
                    array_push($label_array, $label_data);
                    array_push($value_array, $value_data);
                }
                $i++;
            }
        }else{
            array_push($label_array, "No Data");
            array_push($value_array, 0);
        }
    
        $json["response"] = "success";
        $json["data"] = array("label" => $label_array, "value" => $value_array);
    }else if ($_POST['action'] == "top_rated_data") {
        $query = mysqli_query($conn, "SELECT resources_info.res_name, AVG(resources_rating.user_rating) AS averageRating, COUNT(resources_info.res_id) AS TotalUserRate FROM `resources_info` INNER JOIN resources_rating ON (resources_rating.res_id = resources_info.res_id) GROUP BY resources_info.res_id ORDER BY `averageRating` DESC, `TotalUserRate` DESC, res_name ASC LIMIT 5;");
        $count = mysqli_num_rows($query);
        $label_array = array();
        $value_array = array();
        $user_array = array();
        $i=1;
        $others = 0;
        if($count!=0){
            while($fetch = mysqli_fetch_array($query)){
                if($i<=5){
                    $label_data = ucwords($fetch['res_name']);
                    $value_data = number_format($fetch['averageRating'], 2);
                    $user_data = $fetch['TotalUserRate'];
                    array_push($label_array, $label_data);
                    array_push($value_array, $value_data);
                    array_push($user_array, $user_data);
                }
                $i++;
            }
        }else{
            array_push($label_array, "No Data");
            array_push($value_array, 0);
            array_push($user_array, 0);
        }
    
        $json["response"] = "success";
        $json["data"] = array("label" => $label_array, "value" => $value_array, "user" => $user_array);
    }else{
        $json["statusCode"] = 404;
    }

    echo json_encode($json);
}else {
    header("HTTP/1.1 404 Not Found");
}
