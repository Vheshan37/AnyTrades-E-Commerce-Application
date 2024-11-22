<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    $email = $_POST["email"];
    $nic = $_POST["nic"];

    if (empty($email)) {
        echo ("Please enter your Email");
    } else if (strlen($email) > 100) {
        echo ("Email must be less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email");
    } else if (empty($nic)) {
        echo ("Please enter your NIC");
    } else if (strlen($nic) > 12) {
        echo ("Invalid NIC number");
    } else {

        $seller_rs = Database::search("SELECT * FROM `seller` WHERE user_email='" . $email . "' AND `nic`='" . $nic . "'");
        $seller_num = $seller_rs->num_rows;

        if ($seller_num == 1) {
            if ($_SESSION["at_u"]["email"] == $email) {
                Database::iud("UPDATE `user` SET `user_type_id`='2' WHERE `email`='" . $email . "'");

                $user_type_rs = Database::search("SELECT `user_type`.`name` AS `user_type` FROM `user` 
                INNER JOIN `seller` ON `user`.`email`=`seller`.`user_email` 
                INNER JOIN `user_type` ON `user_type`.`id`=`user`.`user_type_id` WHERE `email`='" . $email . "' AND `nic`='" . $nic . "'");
                $user_type_data = $user_type_rs->fetch_assoc();

                $u_type = $user_type_data["user_type"];

                $_SESSION["u_type"] = $u_type;
                $_SESSION["seller"] = $seller_rs->fetch_assoc();

                echo ("success");
            } else {
                echo ("1");
            }
        } else {
            echo ("Invalid Email or NIC");
        }
    }
} else {
    echo ("login");
}
