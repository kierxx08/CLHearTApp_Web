<?php

$base_url = "https://www.kierasis.me/tanauan";
//$base_url = "http://192.168.254.2/tanauan";
function db()
{
    require "../assets/db_conn.php";
    return $conn;
}

function check_input($type, $string)
{

    if ($type == "text01") {
        if (!preg_match("#^[a-zA-Z0-9=_-]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "text02") {
        if (!preg_match("#^[a-zA-Z0-9_-]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else  if ($type == "alphanumeric") {
        if (!preg_match("#^[a-zA-Z0-9]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "alphanumeric02") {
        if (!preg_match("#^[a-zA-Z0-9 ]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "password") {
        if (!preg_match("#^[a-zA-Z0-9\&!+$=]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "integer") {
        if (!preg_match("#^[0-9]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "float") {
        if ($string && intval($string) != $string) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "date") {
        if (!preg_match("#^[0-9-: ]+$#", $string)) {
            return false;
        } else {
            return true;
        }
    } else if ($type == "email") {
        if (!preg_match("/^([a-zA-Z0-9_\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/", $string)) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function gen_userid()
{
    $conn = db();
    $i = 1;
    while ($i == 1) {
        $id = random_str(20);
        $query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE BINARY user_id='$id'");
        if (mysqli_num_rows($query) == 1) {
            $i = 1;
        } else {
            $i = 0;
        }
    }
    return $id;
}

function deviceid_exist($deviceid)
{
    $conn = db();
    $query = mysqli_query($conn, "SELECT * FROM `device_info` WHERE BINARY device_id='$deviceid'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}

function resourceid_exist($res_id)
{
    $conn = db();
    $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE BINARY res_id='$res_id'");
    if (mysqli_num_rows($query) == 1) {
        return true;
    } else {
        return false;
    }
}

function get_tag($get, $value)
{
    $conn = db();
    if ($get == "id") {
        $value = strtolower($value);
        $query = mysqli_query($conn, "SELECT * FROM `tag_info` WHERE BINARY tag_name='$value'");
        $fetch = mysqli_fetch_array($query);
        if (mysqli_num_rows($query) == 1) {
            return $fetch['tag_id'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_rateAverage($res_id)
{
    $conn = db();
    $query = mysqli_query($conn, "SELECT AVG(user_rating) AS average FROM resources_rating WHERE res_id='$res_id';");
    $fetch = mysqli_fetch_array($query);
    return $fetch['average'];
}

function interest_count($user_id)
{
    $conn = db();
    $query = mysqli_query($conn, "SELECT * FROM `user_interest` WHERE BINARY user_id='$user_id'");
    $count = mysqli_num_rows($query);
    return $count;
}

function resources_rateUser_count($res_id)
{
    $conn = db();
    $query = mysqli_query($conn, "SELECT * FROM `resources_rating` WHERE BINARY res_id='$res_id'");
    $count = mysqli_num_rows($query);
    return $count;
}

function up_LastActive($user_id)
{
    $conn = db();
    $date = date("Y-m-d H:i:s");
    $query = mysqli_query($conn, "UPDATE `login_info` SET `last_active`='$date' WHERE user_id='$user_id'");
}

function in_VisitPlace($user_id,$res_id)
{
    $conn = db();
    $date = date("Y-m-d");
    $query = mysqli_query($conn, "SELECT * FROM `user_visit` WHERE user_id='$user_id' AND res_id='$res_id' AND visit_date>='$date 00:00:00' AND visit_date<='$date 23:59:59'");
    if(mysqli_num_rows($query)==0){
        $date_time = date("Y-m-d H:i:s");
        $visit_id = random_str(20);
        $query = mysqli_query($conn, "INSERT INTO `user_visit`(`visit_id`, `user_id`, `res_id`, `visit_date`) VALUES ('$visit_id','$user_id','$res_id','$date_time')");
    }
}

function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'meters')
{
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;
    switch ($unit) {
        case 'miles':
            break;
        case 'meters':
            $distance = ($distance * 1.609344) * 1000;
            break;
        case 'kilometers':
            $distance = $distance * 1.609344;
    }
    return (round($distance, 2));
}

function password_encrypt($password)
{

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $encryption_iv = '1234567891011121';
    $encryption_key = "S3XR3TP@$$";

    $encryption = openssl_encrypt(
        $password,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    return $encryption;
}

function qr_decrypt($text)
{

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    $decryption_iv = '1234567891011121';

    $decryption_key = "QRS3XR3TP@$$";

    $decryption = openssl_decrypt(
        $text,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );

    return $decryption;
}

function random_str(
    int $length,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {

    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }

    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;

    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[random_int(0, $max)];
    }

    return implode('', $pieces);
}
