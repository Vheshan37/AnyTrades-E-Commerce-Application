<?php

require 'connection.php';
session_start();
$admin = $_SESSION["at_admin"];

if (isset($_POST["category"]) && isset($_POST["email"]) && isset($_FILES["img"])) {
    $email = $_POST["email"];
    if ($admin["email"] == $email) {

        $category = $_POST["category"];
        $img = $_FILES["img"];

        $exe = ["image/jpeg", "image/jpg", "image/png", "image/svg+xml"];

        if (in_array($img["type"], $exe)) {

            $rs = Database::search("SELECT * FROM `category` WHERE `name`='" . $category . "'");
            if ($rs->num_rows == 0) {

                $type = "0";
                if ($img["type"] == "image/jpeg") {
                    $type = ".jpeg";
                } else if ($img["type"] == "image/jpg") {
                    $type = ".jpg";
                } else if ($img["type"] == "image/png") {
                    $type = ".png";
                } else if ($img["type"] == "image/svg+xml") {
                    $type = ".svg";
                }

                $path = "resources/category/" . $category . $type . "";
                move_uploaded_file($img["tmp_name"], $path);

                Database::iud("INSERT INTO `category` (`name`,`img`) VALUES('" . $category . "','" . $path . "')");

                echo ("1");
            } else {
                echo ("Category already exists");
            }
        } else {
            echo ("Invalid file type");
        }
    } else {
        echo ("Invalid email");
    }
} else {
    echo ("Something went wrong?");
}
