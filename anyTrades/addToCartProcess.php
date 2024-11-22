<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    $email = $_SESSION["at_u"]["email"];
    if (isset($_GET["p"])) {
        $pid = $_GET["p"];
        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "' AND `product_id`='" . $pid . "'");
        $cart_num = $cart_rs->num_rows;

        if ($cart_num == 0) {
            Database::iud("INSERT INTO `cart`(`qty`,`user_email`,`product_id`) VALUES('1','" . $email . "','" . $pid . "')");
            echo ("1");
        } else {
            $cart_data = $cart_rs->fetch_assoc();
            $cart_qty = $cart_data["qty"];
            $qty = $cart_qty + 1;

            Database::iud("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `product_id`='" . $pid . "' AND `user_email`='" . $email . "'");

            echo ("3");
        }
    } else {
        echo ("Somethign went wrong. Please try again later");
    }
} else {
    echo ("2");
}
