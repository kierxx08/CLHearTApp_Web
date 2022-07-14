<?php

if (isset($conn)) {

    $query = mysqli_query($conn, "SELECT * FROM `announcement` WHERE announce_posted='true' ORDER BY announce_date");
    $fetch_count = mysqli_num_rows($query);
    up_LastActive($user_id);
    if ($fetch_count > 0) {

        $announcement_array = array();
        while ($fetch = mysqli_fetch_array($query)) {

            $announcement["id"] = $fetch['announce_id'];
            $announcement["title"] = $fetch['announce_title'];
            $announcement["image"] = $base_url."/image/announcement/".$fetch['announce_id'].".png?id=".rand();
            array_push($announcement_array, $announcement);
        }

        $json["success"] = true;
        $json["data"] = $announcement_array;
    } else {
        
        $announcement_array = array();
        
        $announcement["id"] = "0";
        $announcement["title"] = "No Announcement";
        $announcement["image"] = $base_url."/image/announcement/no_announcement.png?id=".rand();
        array_push($announcement_array, $announcement);


        $json["success"] = true;
        $json["data"] = $announcement_array;
    }
} else {
    header("HTTP/1.1 404 Not Found");
}
