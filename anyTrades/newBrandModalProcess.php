<?php

require "connection.php";
session_start();
$admin = $_SESSION["at_admin"];

if (isset($_POST["json"])) {
    $obj = json_decode($_POST["json"]);
    $category = $obj->category;
    $brand = $obj->brand;
    $email = $obj->email;

    if (!empty($email) && $category != "0" && !empty($brand)) {
        if ($admin["email"] == $email) {

            $rs = Database::search("SELECT * FROM `brand` WHERE `name`='" . $brand . "' AND `category_id`='" . $category . "'");
            $num = $rs->num_rows;
            if ($num == 0) {
                Database::iud("INSERT INTO `brand`(`name`,`category_id`) VALUES('" . $brand . "','" . $category . "')");
                echo ("1");
            } else {
                echo ("This brand is already exists");
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
