<?php

require "connection.php";
session_start();
$admin = $_SESSION["at_admin"];

if (isset($_POST["json"])) {
    $obj = json_decode($_POST["json"]);
    $category = $obj->category;
    $brand = $obj->brand;
    $modal = $obj->modal;
    $email = $obj->email;

    if (!empty($email) && $category != "0" && !empty($brand)) {
        if ($admin["email"] == $email) {

            $rs = Database::search("SELECT * FROM `model` WHERE `model`='" . $brand . "'");
            $num = $rs->num_rows;
            if ($num == 0) {
                Database::iud("INSERT INTO `model`(`model`) VALUES('" . $modal . "')");
                $modal_id = Database::$connection->insert_id;
                Database::iud("INSERT INTO `brand_has_model`(`model_id`,`brand_id`) VALUES('" . $modal_id . "','" . $brand . "')");
                echo ("1");
            } else {
                echo ("This modal is already exists");
            }
        } else {
            echo ("Invalid email");
        }
    } else {
        echo ("Fill the input field");
    }
} else {
    echo ("Somethign went wrong? Please try again later");
}



// confirm order
// packing
// dispatch
// shipping
// delivered