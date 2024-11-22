<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_u"])) {

    Database::iud("UPDATE `invoice` SET status='3' WHERE id='" . $_GET["id"] . "' AND `user_email`='" . $_SESSION["at_u"]["email"] . "'");
    echo ("1");
} else {
    echo ("You are not a valid user");
}
