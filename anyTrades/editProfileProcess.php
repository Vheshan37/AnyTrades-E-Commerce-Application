<?php

session_start();
require "connection.php";
$email = $_SESSION["at_u"]["email"];

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$mobile = $_POST["mobile"];
$dob = $_POST["dob"];
$line1 = $_POST["line1"];
$line2 = $_POST["line2"];
$line3 = $_POST["line3"];
$province = $_POST["province"];
$district = $_POST["district"];
$city = $_POST["city"];
$bio = $_POST["bio"];
$pCode = $_POST["pCode"];
$str_bio = str_replace("'", "\'", $bio);

if (isset($_SESSION["at_u"])) {

    if (empty($fname)) {
        echo ("First name cannot be empty");
    } else if (strlen($fname) > 50) {
        echo ("First name must be less than 50 characters");
    } else if (empty($lname)) {
        echo ("Last name cannot be empty");
    } else if (strlen($lname) > 50) {
        echo ("Last name must be less than 50 characters");
    } else if (empty($mobile)) {
        echo ("Please enter your Mobile Number");
    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
        echo ("Invalid Mobile Number");
    } else if (strlen($mobile) != 10) {
        echo ("Mobile must have 10 numbers");
    } else if (!is_numeric($mobile)) {
        echo ("Mobile must have be only integers");
    } else if (empty($dob)) {
        echo ("Please enter your birthday");
    } else if (empty($line1)) {
        echo ("Please enter address line 1");
    } else if (empty($line2)) {
        echo ("Please enter address line 2");
    } else if ($province == "0") {
        echo ("Select your province");
    } else if ($district == "0") {
        echo ("Select your district");
    } else if ($city == "0") {
        echo ("Select your city");
    } else if (empty($pCode)) {
        echo ("Please enter your postal code");
    } else {

        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $email . "'");
        $address_num = $address_rs->num_rows;

        if ($address_num == 1) {
            Database::iud("UPDATE `user_has_address` SET `line1`='" . $line1 . "',`line2`='" . $line2 . "',`line3`='" . $line3 . "',`city_id`='" . $city . "',`postal_code`='" . $pCode . "' WHERE `user_email`='" . $email . "'");
        } else {
            Database::iud("INSERT INTO `user_has_address`(`user_email`,`city_id`,`line1`,`line2`,`line3`,`postal_code`) VALUES('" . $email . "','" . $city . "','" . $line1 . "','" . $line2 . "','" . $line3 . "','" . $pCode . "')");
        }

        Database::iud("UPDATE `user` SET `address_status`='1' , `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "',`dob`='" . $dob . "',`bio`='" . $str_bio . "' WHERE `email`='" . $email . "'");
        echo ("Success");
    }
} else {
    echo ("Something went wrong! Please try again later");
}

$img_extentions = array("image/jpeg", "image/jpg", "image/png", "image/svg+xml");

if (isset($_FILES["img"])) {
    $img = $_FILES["img"];
    $img_type = "0";
    if (in_array($img["type"], $img_extentions)) {

        if ($img["type"] == "image/jpeg") {
            $img_type = ".jpeg";
        } else if ($img["type"] == "image/jpg") {
            $img_type = ".jpg";
        } else if ($img["type"] == "image/png") {
            $img_type = ".png";
        } else if ($img["type"] == "image/svg+xml") {
            $img_type = ".svg";
        }

        $img_name = "resources//profile_images//" . $fname . "_profile_img_" . uniqid() . $img_type;
        $img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "'");
        $img_num = $img_rs->num_rows;

        move_uploaded_file($img["tmp_name"], $img_name);

        if ($img_num == 1) {
            Database::iud("UPDATE `profile_image` SET `p_img`='" . $img_name . "' WHERE `user_email`='" . $email . "'");
        } else {
            Database::iud("INSERT INTO `profile_image` (`p_img`,`user_email`) VALUES('" . $img_name . "','" . $email . "')");
        }
    } else {
        echo ("User Image type is not allowed");
    }
}
if (isset($_FILES["background"])) {
    $background = $_FILES["background"];
    $background_type = "0";
    if (in_array($background["type"], $img_extentions)) {

        if ($background["type"] == "image/jpeg") {
            $background_type = ".jpeg";
        } else if ($background["type"] == "image/jpg") {
            $background_type = ".jpg";
        } else if ($background["type"] == "image/png") {
            $background_type = ".png";
        } else if ($background["type"] == "image/svg+xml") {
            $background_type = ".svg";
        }

        $background_name = "resources//profile_images//" . $fname . "_profile_background_" . uniqid() . $img_type;
        $background_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "'");
        $background_num = $background_rs->num_rows;

        move_uploaded_file($background["tmp_name"], $background_name);

        if ($background_num == 1) {
            Database::iud("UPDATE `profile_image` SET `p_back`='" . $background_name . "' WHERE `user_email`='" . $email . "'");
        } else {
            Database::iud("INSERT INTO `profile_image` (`p_back`,`user_email`) VALUES('" . $background_name . "','" . $email . "')");
        }
    } else {
        echo ("User Image type is not allowed");
    }
}
