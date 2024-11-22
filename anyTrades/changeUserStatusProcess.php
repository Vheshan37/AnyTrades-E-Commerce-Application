<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_admin"])) {

    $mail = $_POST["mail"];
    $status = $_POST["status"];

    Database::iud("UPDATE `user` SET `status`='" . $status . "' WHERE `email`='" . $mail . "'");
    echo ("1");
} else {
    echo ("You are not a valid admin");
}
