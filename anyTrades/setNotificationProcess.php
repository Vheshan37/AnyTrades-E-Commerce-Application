<?php

require "connection.php";
session_start();
$email = $_SESSION["at_u"]["email"];
$notification_rs = Database::search("SELECT * FROM `notification` WHERE user_email='" . $email . "'");
$notification_data = $notification_rs->fetch_assoc();
if ($notification_data["notification"] == 1) {
    Database::iud("UPDATE `notification` SET `notification`='0' WHERE `user_email`='" . $email . "'");
    setcookie("notification_status", "0", time() + (60 * 60 * 24 * 30 * 2));
    echo ("0");
} else {
    Database::iud("UPDATE `notification` SET `notification`='1' WHERE `user_email`='" . $email . "'");
    setcookie("notification_status", "1", time() + (60 * 60 * 24 * 30 * 2));
    echo ("1");
}
