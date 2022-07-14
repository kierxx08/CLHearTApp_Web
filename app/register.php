<?php

require "../assets/db_conn.php";
require "assets/functions.php";
header('Content-Type: application/json');

if (isset($_POST["action"]) && isset($_POST["device_id"])) {
    $action = $_POST["action"];
    $device_id = $_POST["device_id"];
    $error = 0;

    if (check_input("alphanumeric", $device_id) && deviceid_exist($device_id)) {

        // First | Registration
        if ($action == "first" || $action == "last") {
            if (isset($_POST["username"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["password"])) {

                $username = $_POST["username"];
                $fname = ucwords($_POST["fname"]);
                $lname = ucwords($_POST["lname"]);
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                $password = $_POST["password"];
                if (strlen(trim($username)) <= 0) {
                    $json["username"] = "Username should not be empty";
                    $error += 1;
                } else if (!check_input("text02", $username)) {
                    $json["username"] = "Aplhanumeric only";
                    $error += 1;
                } else {
                    $username_query = mysqli_query($conn, "SELECT * FROM `login_info` WHERE user_name='$username'");
                    if (mysqli_num_rows($username_query) > 0) {
                        $json["username"] = "Username Already Registered";
                        $error += 1;
                    }
                }
                if (strlen(trim($fname)) <= 0) {
                    $json["fname"] = "First Name should not be empty";
                    $error += 1;
                } else if (!check_input("alphanumeric02", $fname)) {
                    $json["fname"] = "Aplhanumeric only";
                    $error += 1;
                }
                if (strlen(trim($lname)) <= 0) {
                    $json["lname"] = "Last Name should not be empty";
                    $error += 1;
                } else if (!check_input("alphanumeric02", $lname)) {
                    $json["lname"] = "Aplhanumeric only";
                    $error += 1;
                }
                if (strlen(trim($email)) <= 0) {
                    $json["email"] = "Email should not be empty";
                    $error += 1;
                } else if (!check_input("email", $email)) {
                    $json["email"] = "Not valid email";
                    $error += 1;
                } else {
                    $email_query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email='$email'");
                    if (mysqli_num_rows($email_query) > 0) {
                        $json["email"] = "Email Already Registered";
                        $error += 1;
                    }
                }
                if (strlen(trim($phone)) <= 0) {
                    $json["phone"] = "Phone Number should not be empty";
                    $error += 1;
                } else if (!check_input("integer", $phone)) {
                    $json["phone"] = "Not valid Phone Number";
                    $error += 1;
                } else if (strlen(trim($phone)) != 11) {
                    $json["phone"] = "Phone Number should 11 digit number";
                    $error += 1;
                } else if(strpos( $phone, "09" ) !== 0){
                    $json["phone"] = "Not valid Phone Number";
                    $error += 1;
                } else {
                    $phone_query = mysqli_query($conn, "SELECT * FROM `user_info` WHERE number='$phone'");
                    if (mysqli_num_rows($phone_query) > 0) {
                        $json["phone"] = "Phone Number Already Registered";
                        $error += 1;
                    }
                }
                if (strlen(trim($password)) <= 0) {
                    $json["password"] = "Password should not be empty";
                    $error += 1;
                } else if (strlen($password) < 8) {
                    $json["password"] = "Password is to short";
                    $error += 1;
                } else if (!check_input("password", $password)) {
                    $json["password"] = "Contain Invalid Character";
                    $error += 1;
                }
            } else {
                $json["1form_error"] = "Missing Parameters in the First Form";
                $error += 1;
            }
        }

        // Second Form | Registration
        if ($action == "last") {
            if (isset($_POST["gender"]) && isset($_POST["bday"])) {
                $gender = $_POST["gender"];
                $bday = $_POST["bday"];

                if (strlen(trim($gender)) <= 0) {
                    $json["gender"] = "Gender should not be empty";
                    $error += 1;
                } else if (($gender == "male") || ($gender == "female")) {
                    //$status is okay
                } else {
                    $json["gender"] = "Select one";
                    $error += 1;
                }
                $t = time();
                if (strlen(trim($bday)) <= 0) {
                    $json["bday"] = "Birthday should not be empty";
                    $error += 1;
                } else if (!check_input("integer", $bday) || ($bday > $t) || ($bday < 0)) {
                    $json["bday"] = "Not valid Birthday";
                    $error += 1;
                }
            } else {
                $json["2form_error"] = "Missing Parameters in the Second Form";
                $error += 1;
            }
        }

        // Third Form | Registration
        if ($action == "last") {
            if (isset($_POST["ProvName"]) && isset($_POST["CityName"]) && isset($_POST["BrgyName"])) {
                $ProvName = $_POST["ProvName"];
                $CityName = $_POST["CityName"];
                $BrgyName = $_POST["BrgyName"];

                if (strlen(trim($ProvName)) <= 0) {
                    $json["ProvName"] = "Province should not be empty";
                    $error += 1;
                }
                if (strlen(trim($CityName)) <= 0) {
                    $json["CityName"] = "City/Municipality should not be empty";
                    $error += 1;
                }
                if (strlen(trim($BrgyName)) <= 0) {
                    $json["BrgyName"] = "Barangay should not be empty";
                    $error += 1;
                }
            } else {
                $json["3form_error"] = "Missing Parameters in the Third Form";
                $error += 1;
            }
        }

        if ($action == "last" && $error == 0) {
            $user_id = gen_userid();
            $username = addslashes($username);
            $fname = ucwords(strtolower($fname));
            $lname = ucwords(strtolower($lname));
            $email = addslashes($_POST["email"]);
            $phone = $_POST["phone"];
            $password = password_encrypt($password);
            $gender = $_POST["gender"];
            $bday = addslashes(date('Y-m-d', $bday));
            $ProvName = addslashes(ucwords(strtolower($ProvName)));
            $CityName = addslashes(ucwords(strtolower($CityName)));
            $BrgyName = addslashes(ucwords(strtolower($BrgyName)));
            $date = date("Y-m-d H:i:s");

            $query = "INSERT INTO `user_info`(`user_id`, `fname`, `lname`, `gender`, `bday`, `number`, `email`, `user_prov`, `user_city`, `user_brgy`, `since`) 
                        VALUES ('$user_id','$fname','$lname','$gender','$bday','$phone','$email','$ProvName','$CityName','$BrgyName','$date')";

            $query2 = "INSERT INTO `login_info`(`user_id`, `user_name`, `user_pass`, `login_type`, `login_status`, `last_active`) 
                        VALUES ('$user_id','$username','$password','tourist','verified','$date')";

            if ((mysqli_query($conn, $query)) && (mysqli_query($conn, $query2))) {
                $json["success"] = true;
            } else {
                $json["success"] = true;
                $json["error_desc"] = "Sorry, We're experiencing an error in the database. Please try again.";
            }
        } else if ($action == "first" && $error == 0) {
            $json["success"] = true;
        } else if ($action == "first" || $action == "second" || $action == "last") {
            $json["success"] = false;
            $json["error_desc"] = "error_in_form";
        } else {
            $json["success"] = false;
            $json["error_desc"] = "Invalid Action";
        }
    } else {
        $json["success"] = false;
        $json["error_desc"] = "Invalid Device ID";
    }
} else {
    $json["success"] = false;
    $json["error_desc"] = "Missing Parameters";
}
echo json_encode($json);
