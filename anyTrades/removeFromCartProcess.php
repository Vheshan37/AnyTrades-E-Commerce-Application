<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    if (isset($_GET["p"])) {

        $cid = $_GET["p"];
        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `id`='" . $cid . "'");
        $cart_num = $cart_rs->num_rows;
        if ($cart_num == 1) {
            Database::iud("DELETE FROM `cart` WHERE `id`='" . $cid . "'");
            echo ("1");
        } else {
            echo ("Somethign went wrong? Please try again later");
        }
    } else {
        echo ("Somethign went wrong? Please try again later");
    }
} else {
    echo ("You have to sign in first");
}
