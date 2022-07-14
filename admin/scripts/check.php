<?php

function check_session($conn,$token){
    $query = mysqli_query($conn,"SELECT * FROM `login_session` WHERE login_token='$token' AND session_status='active'");
    if(mysqli_num_rows($query)==1){
        return true;
    }else{
        return false;
    }
}

function check_deviceid($conn,$device_id){
    $query = mysqli_query($conn,"SELECT * FROM `device_info` WHERE device_id='$device_id'");
    if(mysqli_num_rows($query)==1){
        return true;
    }else{
        return false;
    }
}

function check_input($type,$string) {
    
    if($type=="text01"){
        if (!preg_match("#^[a-zA-Z0-9=_-]+$#", $string)) {
            return false;   
        }else{
            return true;
        }
    }else if($type=="password"){
        if (!preg_match("#^[a-zA-Z0-9\&!+]+$#", $string)) {
            return false;   
        }else{
            return true;
        }
    }else if($type=="alphanumeric"){
        if (!preg_match("#^[a-zA-Z0-9 ]+$#", $string)) {
            return false;   
        }else{
            return true;
        }
    }else if($type=="integer"){
        if (!preg_match("#^[0-9]+$#", $string)) {
            return false;   
        }else{
            return true;
        }
    }else if($type=="date"){
        if (!preg_match("#^[0-9-: ]+$#", $string)) {
            return false;   
        }else{
            return true;
        }
    }{
        return false;
    }
}

function check_announce_exist($conn,$id) {
    $query = mysqli_query($conn,"SELECT * FROM `announcement` WHERE announce_id='$id'");
    if(mysqli_num_rows($query)>0){
        return true;
    }else{
        return false;
    }
}

function check_image_exist_db($conn,$id,$value) {
    $found = false;
    $query = mysqli_query($conn,"SELECT * FROM `resources_info` WHERE res_id='$id' AND res_photos LIKE '%$value%'");
    if(mysqli_num_rows($query)>0){
        return true;
    }else{
        return false;
    }
}

function check_announcement_exist($conn,$id) {
    $query = mysqli_query($conn,"SELECT * FROM `announcement` WHERE announce_id='$id'");
    if(mysqli_num_rows($query)>0){
        return true;
    }else{
        return false;
    }
}

function check_resources_exist($conn,$id) {
    $query = mysqli_query($conn,"SELECT * FROM `resources_info` WHERE res_id='$id'");
    if(mysqli_num_rows($query)>0){
        return true;
    }else{
        return false;
    }
}

function check_tag($conn,$value) {
    $value = strtolower($value);
    $query = mysqli_query($conn,"SELECT * FROM `tag_info` WHERE tag_name='$value'");
    if(mysqli_num_rows($query)==1){
        return true;
    }else{
        return false;
    }
}

?>