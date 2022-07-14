<?php
session_start();
if (isset($_POST['action'])) {

    include('../../assets/db_conn.php');
    include('get.php');
    include('check.php');
    include('generate.php');
    include('update.php');
    $get_device=1;
    include('../../assets/get_device_info.php');

    if($_POST['action']=="login"){
        $myObj = new \stdClass();
        if(isset($_POST['username'])&&isset($_POST['password'])){
            
            if(check_input("text01",$_POST['username']) && check_input("password",$_POST['password'])){
                $username = $_POST['username'];
                $password = password_encrypt($_POST['password']);
                $remember = $_POST['remember'];

                $query = mysqli_query($conn,"SELECT * FROM `login_info` WHERE user_name='$username' AND user_pass='$password' ");
                $fetch = mysqli_fetch_array($query);
                if(mysqli_num_rows($query)==1){
                    $date = addslashes(date("Y-m-d H:i:s"));
                    if(isset($_COOKIE['DI']) && $_COOKIE['DI']!="" && check_deviceid($conn,$_COOKIE['DI'])){
                        $device_id = $_COOKIE['DI'];
                    }else{
                        $key = random_str(20);
                        mysqli_query($conn,"INSERT INTO `device_info` (`device_id`, `unique_id`, `brand`, `model`, `name`, `app_version`, `last_update`, `detected_date`) VALUES ('$key','$key','$web_brand','$web_version','$device_fullname','1.0','$date','$date')");
                        setcookie('DI', $key, time() + ( 365 * 24 * 60 * 60), "/"); // where ( 365 * 24 * 60 * 60) is total of a year.
                        $device_id = $key;
                    }

                    $user_id = $fetch['user_id'];

                    if($remember=="true"){
                        $gen_token = random_str(64);
                        $sql_session = "INSERT INTO `login_session`(`login_token`, `user_id`, `device_id`, `platform`, `session_status`, `created_date`) VALUES ('$gen_token','$user_id','$device_id','web','active','$date')";
                        if(mysqli_query($conn,$sql_session)){
                            setcookie('LS', $gen_token, time() + ( 365 * 24 * 60 * 60), "/");
                            $_SESSION['user_id'] = $user_id;
                            $myObj->statusCode = 200;
                        }else{
                            $myObj->error = "other";
                            $myObj->error_dec = "error in db";
                        }
                    }else{
                        $_SESSION['user_id'] = $user_id;
                        $myObj->statusCode = 200;
                    }
                    up_LastActive($conn,$user_id);
                }else{
                    $myObj->error = "incorrect";
                    $myObj->password = $password;
                }
            }else{
                $myObj->error = "invalid";
                if(!check_input("text01",$_POST['username'])){
                    $myObj->error_username = true;
                }
                if(!check_input("password",$_POST['password'])){
                    $myObj->error_password = true;
                }
            }
        }else{
            $myObj->error = "other";
        }
        echo json_encode($myObj);
    }else{
        echo json_encode(array("statusCode"=>404));
    }
    
}else{
    echo json_encode(array("statusCode"=>404));
}
?>