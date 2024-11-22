<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    if (isset($_GET["p"])) {

        $wid = $_GET["p"];
        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `id`='" . $wid . "'");
        $watchlist_num = $watchlist_rs->num_rows;
        if ($watchlist_num == 1) {
            Database::iud("DELETE FROM `watchlist` WHERE `id`='" . $wid . "'");
            echo ("1");
        } else {
            echo ("Somethign went wrong? Please try again later 1");
        }
    } else {
        echo ("Somethign went wrong? Please try again later 2");
    }
} else {
    echo ("You have to sign in first");
}
