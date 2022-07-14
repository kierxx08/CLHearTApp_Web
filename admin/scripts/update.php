<?php
function up_LastActive($conn,$user_id)
{
    $date = date("Y-m-d H:i:s");
    $query = mysqli_query($conn, "UPDATE `login_info` SET `last_active`='$date' WHERE user_id='$user_id'");

}

?>
