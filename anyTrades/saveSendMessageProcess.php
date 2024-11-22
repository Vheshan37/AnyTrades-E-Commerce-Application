<?php

session_start();
require "connection.php";

$text = $_GET["text"];
$from = $_GET["from"];
$email = $_SESSION["at_u"]["email"];
$type = $_GET["direction"];

if (isset($_SESSION["at_u"])) {

    if (isset($_GET["text"]) && isset($_GET["from"])) {

        if (isset($_GET["direction"])) {

            $direction;
            if ($type == 1) {
                $direction = 2;
            } else if ($type == 2) {
                $direction = 1;
            }

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $time  = $d->format("Y-m-d H:i:s");

            Database::iud("INSERT INTO `chat`(`content`,`from`,`to`,`direction`,`time`) VALUES('" . $text . "','" . $email . "','" . $from . "','" . $direction . "','" . $time . "')");

            echo ("1");
        } else {
            echo ("Something went wrond? Please try again later");
        }
    } else {
        echo ("Something went wrong please try again later");
    }
} else {
    echo ("You have to sign in first");
}
