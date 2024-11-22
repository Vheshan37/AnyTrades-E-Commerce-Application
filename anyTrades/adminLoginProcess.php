<?php

require "connection.php";

$json_txt = $_GET["json"];
$phpObj = json_decode($json_txt);

$email = $phpObj->eml;
$password = $phpObj->psw;
$code = $phpObj->code;

$rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
$num = $rs->num_rows;

if ($num == 1) {
    $data = $rs->fetch_assoc();
    if ($data["verification_code"] == $code) {
        Database::iud("UPDATE `admin` SET `verification_code`=(NULL) WHERE `id`='" . $data["id"] . "'");
        // Login Success
        echo ("3");
    } else {
        // Invalid Verification Code
        echo ("2");
    }
} else {
    // Invalid Email or Password
    echo ("1");
}
