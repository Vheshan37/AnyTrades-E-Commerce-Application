<?php

session_start();
require "connection.php";
if (isset($_SESSION["at_admin"])) {
    $seller = $_SESSION["seller"];
    $json_obj = $_POST["json"];
    $php_obj = json_decode($json_obj);

    $psw = $php_obj->psw;
    $oid = $php_obj->o_id;
    $id = (explode("_", $oid))[1];

    if (empty($psw)) {
        echo ("Please enter your password");
    } else if ($seller["nic"] != $psw) {
        echo ("Invalid password");
    } else {

        $rs = Database::search("SELECT * FROM `invoice` WHERE `id`='" . $id . "'");
        $num = $rs->num_rows;

        if ($num > 0) {
            $data = $rs->fetch_assoc();

            if ($data["order_status_id"] == 5) {
                Database::iud("UPDATE `invoice` SET `status`='2' WHERE `id`='" . $id . "'");
                echo ("1");
            } else {
                echo ("You cannot delete this order untill order is delivered");
            }
        } else {
            echo ("Something went wron? Please try again later.");
        }
    }
} else {
    echo ("You are not a valid admin");
}
