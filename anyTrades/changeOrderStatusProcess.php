<?php

$status = $_GET["status"];
$id = $_GET["id"];

session_start();
require "connection.php";

if (isset($_SESSION["at_admin"])) {
    if ($status == 1) {

        $rs = Database::search("SELECT * FROM `invoice` WHERE `id`='" . $id . "'");
        $data = $rs->fetch_assoc();

        $invoice_id = $data["order_status_id"];

        if ($status < 5) {
            Database::iud("UPDATE `invoice` SET `order_status_id`='" . ($invoice_id + 1) . "' WHERE id='" . $id . "'");
        } else {
            echo ("1");
        }

        echo ("1");
    } else if ($status == 2) {
        $rs = Database::search("SELECT * FROM `invoice` WHERE `id`='" . $id . "'");
        $data = $rs->fetch_assoc();

        $invoice_id = $data["order_status_id"];

        if ($status > 1) {
            Database::iud("UPDATE `invoice` SET `order_status_id`='" . ($invoice_id - 1) . "' WHERE id='" . $id . "'");
        } else {
            echo ("1");
        }

        echo ("1");
    }
} else {
    echo ("you are not a valid admin");
}
