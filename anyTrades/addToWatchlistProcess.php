<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    $email = $_SESSION["at_u"]["email"];
    if (isset($_GET["p"])) {
        $pid = $_GET["p"];

        $rs = Database::search("SELECT * FROM watchlist WHERE `product_id`='" . $pid . "' AND `user_email`='" . $email . "'");
        $num = $rs->num_rows;
        if ($num == 0) {
            Database::iud("INSERT INTO `watchlist`(`user_email`,`product_id`) VALUES('" . $email . "','" . $pid . "')");
            echo ("1");
        } else {
            echo ("This item already added to your watchlist");
        }
    } else {
        echo ("Somethign went wrong. Please try again later");
    }
} else {
    echo ("2");
}
