<?php

require_once '../assets/qrcode-monkey/autoload.php';

use nguyenary\QRCodeMonkey\QRCode;

header('Content-Type: application/json; Charset=UTF-8');
if (isset($_POST['action'])) {

    include('../../assets/db_conn.php');
    include('check.php');
    include('generate.php');
    include('get.php');

    if ($_POST['action'] == "create_announcement") {
        if (
            isset($_POST['announce_id']) && isset($_POST['title']) && isset($_POST['status'])
        ) {

            $announce_id = $_POST['announce_id'];
            $title = $_POST['title'];
            $status = $_POST['status'];
            $error = 0;

            if (strlen(trim($title)) <= 0) {
                $json["title"] = "Name should not be empty";
                $error += 1;
            }
            if (strlen(trim($status)) <= 0) {
                $json["status"] = "Status should not be empty";
                $error += 1;
            } else if (($status == "true") || ($status == "false")) {
                //$status is okay
            } else {
                $json["status"] = "Select one";
                $error += 1;
            }

            if ($error == 0) {
                $gen_announce_id = gen_announce_id($conn);
                if (isset($_FILES['image']['name'])) {
                    if (strlen(trim($announce_id)) == "") {
                        $image_name = $gen_announce_id;
                    } else {
                        $image_name = $announce_id;
                    }
                    $target_dir = "../../image/announcement/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        //File is an image
                        //echo "File is an image - " . $check["mime"] . ".";
                    } else {
                        $json["image"] = "File is not an image.";
                        $error += 1;
                    }
                    if ($imageFileType != "png") {
                        $json["image"] = "Sorry, only png file is allowed.";
                        $error += 1;
                    }

                    if ($error == 0) {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image_name . ".png")) {
                            //File is uploaded.
                            //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                        } else {
                            $json["image"] = "Sorry, there was an error uploading your file.";
                            $error += 1;
                        }
                    }
                }
            }


            if ($error == 0) {
                $date = date("Y-m-d H:i:s");
                $title = addslashes($title);

                if (strlen(trim($announce_id)) == "") {

                    $query = "INSERT INTO `announcement`(`announce_id`, `announce_title`, `announce_desc`, `announce_type`, `announce_posted`, `announce_date`) 
                                VALUES ('$gen_announce_id','$title','','basic_announcement','$status','$date')";
                    //mysqli_set_charset($conn,"utf8");
                    if (mysqli_query($conn, $query)) {
                        $json["response"] = "create_success";
                    } else {
                        $json["response"] = "denied";
                        $json["error_desc"] = "Sorry, We're experiencing an error in the database. Please try again.";
                    }
                } else if (check_announce_exist($conn, $announce_id)) {
                    $query = "UPDATE `announcement` SET `announce_title`='$title',`announce_posted`='$status' WHERE announce_id='$announce_id'";
                    //mysqli_set_charset($conn,"utf8");
                    if (mysqli_query($conn, $query)) {
                        $json["response"] = "edit_success";
                    } else {
                        $json["response"] = "denied";
                        $json["error_desc"] = "Sorry, We're experiencing an error in the database. Please try again.";
                    }
                } else {
                    $json["response"] = "denied";
                    $json["error_desc"] = "Product ID not Found";
                }
            } else {
                $json["response"] = "denied";
            }
        } else {
            $json["response"] = "access_denied";
        }
    } else if ($_POST['action'] == "create_culres") {
        if (
            isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['type']) &&
            isset($_POST['tag']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['newimagecount']) && isset($_POST['oldimagecount'])
        ) {
            $res_id = $_POST['id'];
            $res_name = $_POST['name'];
            $description = $_POST['description'];
            $type = $_POST['type'];
            $tag = $_POST['tag'];
            $tag_json = json_decode($tag);
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $newimage = $_POST['newimagecount'];
            $oldimage = $_POST['oldimagecount'];
            $error = 0;


            if ((!isset($_FILES['image']['name']) && $oldimage == 0) || ($newimage == 0 && $oldimage == 0)) {
                $json["image"] = "Image should not be empty";
                $error += 1;
            }
            if (strlen(trim($res_name)) <= 0) {
                $json["name"] = "Name should not be empty";
                $error += 1;
            }
            if (strlen(trim($type)) <= 0) {
                $json["type"] = "Status should not be empty";
                $error += 1;
            } else if (($type == "cultural_place") || ($type == "commercial_establishment") || ($type == "leisure_park") || ($type == "exhibit")) {
                //$type is okay
            } else {
                $json["type"] = "Select one";
                $error += 1;
            }

            if (!$tag_json) {
                $json["tag"] = "Tag is not JSON";
                $error += 1;
            } else if (count($tag_json) <= 0) {
                $json["tag"] = "Tag should not be empty";
                $error += 1;
            }

            if ($type == "cultural_place" || $type == "commercial_establishment" || $type == "leisure_park") {
                if (strlen(trim($latitude)) <= 0) {
                    $json["latitude"] = "Latitude should not be empty";
                    $error += 1;
                } else if (!is_numeric($latitude)) {
                    $json["latitude"] = "Numeric only";
                    $error += 1;
                }
                if (strlen(trim($longitude)) <= 0) {
                    $json["longitude"] = "Longitude should not be empty";
                    $error += 1;
                } else if (!is_numeric($longitude)) {
                    $json["longitude"] = "Numeric only";
                    $error += 1;
                }
            }

            if ($newimage > 0) {

                $json["image2"] = "";
                foreach ($_FILES['image']['name'] as $i => $name) {
                    $target_dir = "../../image/cultural_resources/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"][$i]);
                    $base_name = basename($_FILES["image"]["name"][$i]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
                    if ($oldimage > 0) {
                        for ($i = 0; $i < count($_POST['oldimage']); $i++) {
                            $new_image_filename = $res_id . "_" . $base_name;
                            if (in_array($new_image_filename, $_POST['oldimage'])) {
                                $json["image"] = "Duplicate filename found.";
                                $error += 1;
                                break;
                            }
                        }
                    }
                    if ($check !== false) {
                        //File is an image
                        //echo "File is an image - " . $check["mime"] . ".";
                    } else {
                        $json["image"] = "Sorry, only image is allowed to upload.";
                        $error += 1;
                        break;
                    }
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $json["image"] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
                        $error += 1;
                        break;
                    }
                    $json["image2"] .= $base_name . ", ";
                }
            }

            if ($error == 0) {
                for ($i = 0; $i < count($tag_json); $i++) {
                    $tag_value = $tag_json[$i];
                    if (check_tag($conn, $tag_value) == false) {
                        if (gen_tag($conn, $tag_value) == false) {
                            $error += 1;
                        }
                    }
                }
            }

            if ($res_id == "" && $error == 0) {
                
                $gen_res_id = gen_res_id($conn);


                $qrcode = new QRCode(qr_encrypt($gen_res_id));

                $qrcode->setConfig([
                    'bgColor' => '#FFFFFF',
                    'body' => 'circle',
                    'bodyColor' => '#345394',
                    'brf1' => [],
                    'brf2' => [],
                    'brf3' => [],
                    'erf1' => [],
                    'erf2' => [],
                    'erf3' => [],
                    'eye' => 'frame13',
                    'eye1Color' => '#345394',
                    'eye2Color' => '#345394',
                    'eye3Color' => '#345394',
                    'eyeBall' => 'ball15',
                    'eyeBall1Color' => '#345394',
                    'eyeBall2Color' => '#345394',
                    'eyeBall3Color' => '#345394',
                    'gradientColor1' => '',
                    'gradientColor2' => '',
                    'gradientOnEyes' => 'false',
                    'gradientType' => 'linear',
                ]);

                $qrcode->setLogo('../../image/qrcode_logo.png');
                $qrcode->setFileType('png');
                $qrcode->setSize(200);

                $qrcode->create('../../image/resources_qrcode/'.$gen_res_id.'.png');

                $image_array = [];
                foreach ($_FILES['image']['name'] as $i => $name) {
                    //echo basename($_FILES['image']['name'][$i]);
                    $target_dir = "../../image/resources/";
                    $basename = basename($_FILES["image"]["name"][$i]);
                    $target_file = $target_dir . $basename;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_dir . $gen_res_id . "_" . $basename);
                    $myArray[] = $basename;
                }
                $image_json = addslashes(json_encode($myArray));
                $date = date("Y-m-d H:i:s");

                for ($i = 0; $i < count($tag_json); $i++) {
                    $tag_id = get_tag($conn, "id", $tag_json[$i]);
                    if ($tag_id != false) {
                        mysqli_query($conn, "INSERT INTO `resources_tag`(`res_id`, `tag_id`) VALUES ('$gen_res_id','$tag_id')");
                    }
                }

                $res_name = addslashes($res_name);
                $description = addslashes($description);

                $query = "INSERT INTO `resources_info`(`res_id`, `res_name`, `res_desc`, `res_lat`, `res_long`, `res_type`, `res_ratings`, `res_photos`, `res_date_added`) 
                                VALUES ('$gen_res_id','$res_name','$description','$latitude','$longitude','$type','0','$image_json','$date')";
                //mysqli_set_charset($conn, "utf8");
                if (mysqli_query($conn, $query)) {
                    $json["response"] = "create_success";
                } else {
                    $json["response"] = "create_error";
                    $json["error_desc"] = "Sorry, We're experiencing an error in the database. Please try again.";
                }
            } else if ($error == 0) {
                if (check_resources_exist($conn, $res_id)) {
                    // Delete image if image change //
                    if ($oldimage > 0) {
                        $query = mysqli_query($conn, "SELECT * FROM `resources_info` WHERE res_id='$res_id'");
                        $fetch = mysqli_fetch_array($query);

                        $image_json = json_decode($fetch['res_photos']);
                        for ($i = 0; $i < count($image_json); $i++) {
                            $image_filename_db = $res_id . "_" . $image_json[$i];
                            if (!in_array($image_filename_db, $_POST['oldimage'])) {
                                $target_dir = "../../image/resources/";
                                $basename = $image_filename_db;
                                $target_file = $target_dir . $basename;
                                if (file_exists($target_file)) {
                                    unlink($target_file);
                                }
                            } else {
                                $myArray[] = $image_json[$i];
                            }
                        }
                    }

                    // Upload new image //
                    if ($newimage > 0) {
                        foreach ($_FILES['image']['name'] as $i => $name) {
                            //echo basename($_FILES['image']['name'][$i]);
                            $target_dir = "../../image/resources/";
                            $basename = basename($_FILES["image"]["name"][$i]);
                            $target_file = $target_dir . $basename;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_dir . $res_id . "_" . $basename);
                            $myArray[] = $basename;
                        }
                    }

                    $res_name = addslashes($res_name);
                    $description = addslashes($description);
                    
                    $image_json = addslashes(json_encode($myArray));

                    $date = date("Y-m-d H:i:s");

                    mysqli_query($conn, "DELETE FROM `resources_tag` WHERE res_id='$res_id'");
                    for ($i = 0; $i < count($tag_json); $i++) {
                        $tag_id = get_tag($conn, "id", $tag_json[$i]);
                        if ($tag_id != false) {
                            mysqli_query($conn, "INSERT INTO `resources_tag`(`res_id`, `tag_id`) VALUES ('$res_id','$tag_id')");
                        }
                    }

                    $query = "UPDATE `resources_info` SET `res_name`='$res_name',`res_desc`='$description',`res_lat`='$latitude',`res_long`='$longitude',`res_type`='$type',`res_photos`='$image_json' WHERE res_id='$res_id'";
                    //mysqli_set_charset($conn, "utf8");
                    if (mysqli_query($conn, $query)) {
                        $json["response"] = "update_success";
                    } else {
                        $json["response"] = "create_error";
                        $json["error_desc"] = "Sorry, We're experiencing an error in the database. Please try again.";
                    }
                } else {
                    $json["response"] = "found_error";
                    $json["error_desc"] = "Resources not Found";
                }
            } else {
                $json["response"] = "found_error";
                $json["error_count"] = $error;
            }
        } else {
            $json["response"] = "missing_parameters";
        }
    } else if ($_POST['action'] == "update_app") {
        if (
            isset($_POST['version']) && isset($_POST['json_newup'])
        ) {

            $version = $_POST['version'];
            $newup = $_POST['json_newup'];
            $json_newup = json_decode($newup);
            $error = 0;

            if (strlen(trim($version)) <= 0) {
                $json["version"] = "Name should not be empty";
                $error += 1;
            }

            if (!$json_newup) {
                $json["newup"] = "Update item is not JSON";
                $error += 1;
            } else if (count($json_newup) <= 0) {
                $json["tag"] = "Update item should not be empty";
                $error += 1;
            }

            if ($error == 0) {
                $gen_announce_id = gen_announce_id($conn);
                if (isset($_FILES['apk_file']['name'])) {

                    $target_dir = "../../app/apk/";

                    $basename = basename($_FILES["apk_file"]["name"]);
                    $target_file = $target_dir . $basename;
                    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    if ($basename != "CLHear TApp (v." . $version . ").apk") {
                        $json["apk_file"] = "Sorry, apk file version is invalid and/or not match.";
                        $error += 1;
                    }

                    if ($FileType != "apk") {
                        $json["apk_file"] = "Sorry, only apk file is allowed.";
                        $error += 1;
                    }

                    if ($error == 0) {
                        if (move_uploaded_file($_FILES["apk_file"]["tmp_name"], $target_file)) {
                            //File is uploaded.
                            //echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                        } else {
                            $json["apk_file"] = "Sorry, there was an error uploading your file.";
                            $error += 1;
                        }
                    }
                }
            }


            if ($error == 0) {
                $file_dir = "../../app/assets/app_settings.json";

                $date = date("Y-m-d H:i:s");
                $jsonString = file_get_contents($file_dir);
                $data = json_decode($jsonString, true);
                $data['latest_version'] = $version;
                $data['latest_description'] = $json_newup;
                //$data['app_link'] = $base_url."/app/apk/".$basename;
                $data['app_link'] = $base_url . "/app/download.php";
                $data['update_created'] = $date;

                $newJsonString = json_encode($data);
                file_put_contents($file_dir, $newJsonString);
                $json["response"] = "update_success";
            } else {
                $json["response"] = "denied";
            }
        } else {
            $json["response"] = "access_denied";
        }
    } else  if ($_POST['action'] == "set_maintenance") {
        if (
            isset($_POST['maintenance'])
        ) {

            $maintenance = $_POST['maintenance'];
            $error = 0;

            if (strlen(trim($maintenance)) <= 0) {
                $json["maintenance"] = "Maintenance Details should not be empty";
                $error += 1;
            }


            if ($error == 0) {
                $file_dir = "../../app/assets/app_settings.json";
                $jsonString = file_get_contents($file_dir);
                $data = json_decode($jsonString, true);
                $data['maintenance'] = true;
                $data['maintenance_desc'] = $maintenance;

                $newJsonString = json_encode($data);
                file_put_contents($file_dir, $newJsonString);
                $json["response"] = "update_success";
            } else {
                $json["response"] = "denied";
            }
        } else if (isset($_POST['RunServer'])) {
            $file_dir = "../../app/assets/app_settings.json";
            $jsonString = file_get_contents($file_dir);
            $data = json_decode($jsonString, true);
            $data['maintenance'] = false;

            $newJsonString = json_encode($data);
            file_put_contents($file_dir, $newJsonString);
            $json["response"] = "update_success";
        } else {
            $json["response"] = "access_denied";
        }
    } else {
        $json["statusCode"] = 404;
    }

    echo json_encode($json);
} else {
    header("HTTP/1.1 404 Not Found");
}
