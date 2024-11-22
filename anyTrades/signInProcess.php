<?php

require "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];
$rememberme = $_POST["rememberme"];

if (empty($email)) {
    echo ("Please enter your Email");
} else if (strlen($email) > 100) {
    echo ("Email must be less than 100 characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email");
} else if (empty($password)) {
    echo ("Please enter your Password");
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo ("Invalid Password");
} else if (strpos($password, ' ') != false) {
    echo ("Password should not contain spaces");
} else {
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();

        if ($data["status"] == 2) {
            echo ("1");
        } else {
            session_start();
            $_SESSION["at_u"] = $data;

            $notification_rs = Database::search("SELECT * FROM `notification` WHERE user_email='" . $email . "'");
            $notification_num = $notification_rs->num_rows;

            if ($notification_num == 0) {
                Database::iud("INSERT INTO `notification` (`user_email`) VALUES('" . $email . "')");
            }


            $user_type_rs = Database::search("SELECT user_type.name AS user_type FROM user INNER JOIN user_type ON user.user_type_id=user_type.id WHERE `email`='" . $email . "' AND password='" . $password . "'");
            $user_type_data = $user_type_rs->fetch_assoc();

            $u_type = $user_type_data["user_type"];

            $_SESSION["u_type"] = $u_type;

            if ($rememberme == "true") {
                setcookie("email", $email, time() + (60 * 60 * 24 * 7));
                setcookie("password", $password, time() + (60 * 60 * 24 * 7));
            } else {
                setcookie("email", "", -1);
                setcookie("password", "", -1);
            }

            echo ("true");
        }
    } else {
        echo ("Invalid Email or Password");
    }
}
