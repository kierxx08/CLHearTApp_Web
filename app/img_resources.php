<?php

if (isset($_GET['filename'])) {
    require "assets/functions.php";

    $filename = $_GET['filename'];
    $target_file = '../image/resources/' . $filename;

    if (file_exists($target_file)) {
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if($imageFileType == "png"){
            $im = imagecreatefrompng($base_url . '/image/resources/' . $filename);
        }else if($imageFileType == "jpg" || $imageFileType == "jpeg"){
            $im = imagecreatefromjpeg($base_url . '/image/resources/' . $filename);
        }
    } else {
        $im = imagecreatefrompng($base_url . '/image/resources/no_image_available.png');
    }

    if (isset($_GET['size']) && $_GET['size'] == "small") {
        $img_height = 77;
        $img_width = 150;
    } else {
        $img_height = 154;
        $img_width = 300;
    }

    $im = imagescale($im, $img_width, $img_height);


    // Output and free memory
    header('Content-type: image/png');
    if($imageFileType == "png"){
        imagepng($im);
    }else if($imageFileType == "jpg"){
        imagejpeg($im);
    }
    imagepng($im);
    imagedestroy($im);
} else {
    header("HTTP/1.1 404 Not Found");
}
