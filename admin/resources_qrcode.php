<?php

include('../assets/db_conn.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .qr_div {
            width: 25%;
            float: left;
            text-align: center;
            margin-bottom: 10px;
        }

        .qr_img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            height: 200px;
            width: 149px;
        }

        .qr_name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 10px;
            margin-left: 14px;
            margin-right: 14px;
        }


        @media (max-width: 576px) {
            .qr_img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                height: 150px;
                width: 112px;
            }
        }

        @media (max-width: 992px) {
            .qr_img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                height: 100px;
                width: 75px;
            }
        }

        @media print {
            .qr_img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                height: 200px;
                width: 149px;
            }
        }
    </style>
</head>

<body>
    <!--<div class="divFooter">UNCLASSIFIED</div>-->
    <?php
    $query = mysqli_query($conn, "SELECT * FROM `resources_info` ORDER BY res_name");
    while ($fetch = mysqli_fetch_array($query)) {
    ?>
        <div class="qr_div">
            <img class="qr_img" src="assets/qrcode_with_holder.php?id=<?php echo $fetch['res_id'] . "&token=" . rand() ?>" alt="QR Code">
            <div class="qr_name"><?php echo $fetch['res_name'] ?></div>
        </div>
    <?php
    }
    ?>
</body>

</html>