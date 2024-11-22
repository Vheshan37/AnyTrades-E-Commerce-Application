<?php
require "connection.php";
session_start();

if (isset($_SESSION["at_u"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $mobile = $_POST["mobile"];
    $nic = $_POST["nic"];

    if (empty($email)) {
        echo ("Please enter your Email");
    } else if (strlen($email) > 100) {
        echo ("Email must be less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email");
    } else if (empty($password)) {
        echo ("Please enter your Password");
    } else if (strlen($password) > 20 && strlen($password) < 7) {
        echo ("password must be between 8-20 characters");
    } else if (strpos($password, ' ') != false) {
        echo ("Password should not contain spaces");
    } else if (empty($mobile)) {
        echo ("Please enter your Mobile");
    } else if (strlen($mobile) != 10) {
        echo ("Mobile number shoul be 10 characters");
    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
        echo ("Invalid Mobile Number");
    } else if (empty($nic)) {
        echo ("Please enter your NIV");
    } else if (strlen($nic) > 12 && strlen($nic) < 10) {
        echo ("Invalid NIC number");
    } else {
        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
        $user_num = $user_rs->num_rows;

        if ($user_num == 0) {
            echo ("Invalid Email or Password");
        } else if ($user_num == 1) {

            $seller_rs = Database::search("SELECT * FROM `seller` WHERE `user_email`='" . $email . "'");
            $seller_num = $seller_rs->num_rows;
            if ($seller_num == 0) {
                Database::iud("INSERT INTO `seller`(`nic`,`mobile`,`user_email`) VALUES('" . $nic . "','" . $mobile . "','" . $email . "')");
                echo ("success");
            } else {
                echo ("This email is already registered");
            }
        }
    }
} else {
    echo ("login");
}
