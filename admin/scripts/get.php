<?php


function get_userfullnamr($conn,$id)
{
    $query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE user_id='$id'");
    $fetch = mysqli_fetch_array($query);
    return $fetch['fname']." ".$fetch['lname'];
}

function get_SessionUser($conn, $type, $token)
{
    $query = mysqli_query($conn, "SELECT * FROM `login_session` AS ls,`user_info` AS ui,`device_info` AS di WHERE ls.user_id = ui.user_id AND ls.device_id = di.device_id AND ls.login_token='$token'");
    if (mysqli_num_rows($query) == 1) {
        $fetch = mysqli_fetch_array($query);
        if ($type == "device_id") {
            return $fetch['device_id'];
        } else if ($type == "user_id") {
            return $fetch['user_id'];
        } else {
            return "error";
        }
    } else {
        return "error";
    }
}

function get_tag($conn, $get, $value)
{
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

function get_TotalUSer($conn)
{
    $query = mysqli_query($conn, "SELECT * FROM `user_info`");
    $count = mysqli_num_rows($query);
    return $count;
}

function get_TotalResources($conn)
{
    $query = mysqli_query($conn, "SELECT * FROM `resources_info`");
    $count = mysqli_num_rows($query);
    return $count;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>