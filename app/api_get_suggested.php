<?php

if (isset($conn)) {
    $query = mysqli_query($conn, "SELECT resources_info.res_id, resources_info.res_name,  resources_info.res_photos,resources_info.res_ratings, COUNT(resources_info.res_name) AS Total, IF(resources_rating.res_id IS NULL, FALSE, TRUE) as isRated FROM tag_info
    INNER JOIN user_interest ON (user_interest.tag_id = tag_info.tag_id)
    INNER JOIN resources_tag ON (resources_tag.tag_id = tag_info.tag_id)
    INNER JOIN user_info ON (user_info.user_id = user_interest.user_id)
    INNER JOIN resources_info ON (resources_info.res_id = resources_tag.res_id)
    LEFT JOIN resources_rating ON (resources_info.res_id = resources_rating.res_id AND resources_rating.user_id = '$user_id')
    WHERE user_info.user_id = '$user_id'
    
    GROUP BY resources_info.res_name
    
    UNION ALL
    
    SELECT resources_info.res_id, resources_info.res_name, resources_info.res_photos, resources_info.res_ratings, '0' AS Total, IF(resources_rating.res_id IS NULL, FALSE, TRUE) as isRated FROM tag_info
    INNER JOIN resources_tag ON (resources_tag.tag_id = tag_info.tag_id)
    INNER JOIN resources_info ON (resources_info.res_id = resources_tag.res_id)
    LEFT JOIN resources_rating ON (resources_info.res_id = resources_rating.res_id AND resources_rating.user_id = '$user_id')
    
    WHERE resources_info.res_id NOT IN(SELECT resources_info.res_id FROM tag_info
    INNER JOIN user_interest ON (user_interest.tag_id = tag_info.tag_id)
    INNER JOIN resources_tag ON (resources_tag.tag_id = tag_info.tag_id)
    INNER JOIN user_info ON (user_info.user_id = user_interest.user_id)
    INNER JOIN resources_info ON (resources_info.res_id = resources_tag.res_id)
                                       
    WHERE user_info.user_id = '$user_id') GROUP BY resources_info.res_name  
    ORDER BY isRated ASC,`Total`  DESC, res_ratings DESC LIMIT 20");
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
            for($i=0;$i<1;$i++){
                $resources["image"] = $base_url."/app/img_resources.php?filename=".$resources["id"]."_".$image_json[$i]."&id=".rand();
            }

            array_push($resources_array, $resources);
        }

        $json["success"] = true;
        $json["data"] = $resources_array;

    }else{
        $json["success"] = false;
        $json["error"] = "no_resources";
        $json["error_desc"] = "No resources Found.";
    }

} else {
    header("HTTP/1.1 404 Not Found");
}
?>