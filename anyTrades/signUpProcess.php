<?php

require "connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];

if (empty($fname)) {
    echo ("Please enter your First Name");
} else if (strlen($fname) > 50) {
    echo ("First name must be less than 50 characters");
} else if (empty($lname)) {
    echo ("Please enter your Last Name");
} else if (strlen($lname) > 50) {
    echo ("Last name must be less than 50 characters");
} else if (empty($email)) {
    echo ("Please enter your Email");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email");
} else if (strlen($email) > 100) {
    echo ("Email address must be less than 100 characters");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo ("Password must be between 8-20 characters");
} else if (strpos($password, ' ') != false) {
    echo ("Password should not contain spaces");
} else if (empty($mobile)) {
    echo ("Please enter your Mobile Number");
} else if (strlen($mobile) != 10) {
    echo ("Mobile must have 10 numbers");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Mobile number");
} else if (!is_numeric($mobile)) {
    echo ("Mobile must have be only integers");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' OR `mobile`='" . $mobile . "'");
    $num = $rs->num_rows;

    if ($num == 0) {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user` (`fname`,`lname`,`email`,`password`,`mobile`,`gender_id`,`join_date`,`status`,`user_type_id`) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','" . $mobile . "','" . $gender . "','" . $date . "','1','1')");

        echo ("Success");
    } else {
        echo ("This Email or mobile number is already taken");
    }
}
