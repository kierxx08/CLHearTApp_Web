<?php

if (isset($conn)) {
    if(isset($_POST['interest'])){
        $interest = json_decode($_POST['interest']);
        if ($interest){
            $error = 0;
            for($i=0;$i<count($interest);$i++){
                if(get_tag("id",$interest[$i])==false){
                    $error+=1;
                }
            }
            
            
            if($error==0){
                for($i=0;$i<count($interest);$i++){
                    $tag_id = get_tag("id",$interest[$i]);
                    $sql = "INSERT INTO `user_interest`(`user_id`, `tag_id`) VALUES ('$user_id','$tag_id')";
                    if(!mysqli_query($conn,$sql)){
                        $error+=1;
                    }
                }
                if($error==0){
                    $json["success"] = true;
                }else{
                    $json["success"] = false;
                    $json["error_desc"] = $error ." unexpexted error.";
                }
            }else{
                $json["success"] = false;
                $json["error_desc"] = $error ." interest error.";
            }
            

        }else{
            $json["success"] = false;
            $json["error_desc"] = "Interest is not JSON";
        }
    }else{
        $json["success"] = false;
        $json["error_desc"] = "Missing Parameter";
    }


} else {
    header("HTTP/1.1 404 Not Found");
}
?>