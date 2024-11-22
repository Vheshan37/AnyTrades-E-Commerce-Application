<?php

session_start();
require "connection.php";
if (isset($_SESSION["seller"])) {


    $pid = $_POST["pid"];
    $title = $_POST["title"];
    $quantity = $_POST["quantity"];
    $dip = $_POST["dip"];
    $dop = $_POST["dop"];
    $desc = $_POST["desc"];

    if (empty($title)) {
        echo ("Please enter product title");
    } else if (empty($dip)) {
        echo ("Please enter delivery fee for Colombo");
    } else if (empty($desc)) {
        echo ("Please enter product Description");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date_time = $d->format("Y-m-d H:i:s");

        Database::iud("UPDATE `product` SET `title`='" . $title . "',`qty`='" . $quantity . "',`delivery_in`='" . $dip . "',`delivery_out`='" . $dop . "',`desc`='" . $desc . "' WHERE `id`='" . $pid . "'");

        Database::iud("UPDATE `quantity` SET `qty`='" . $quantity . "',`product_id`='" . $pid . "' WHERE `product_id`='" . $pid . "'");

        Database::iud("DELETE FROM `image` WHERE `product_id`='" . $pid . "'");

        $file_count = sizeof($_FILES);
        $img_extentions = array("image/jpeg", "image/jpg", "image/png", "image/svg+xml");

        for ($x = 0; $x < $file_count; $x++) {


            $img = $_FILES["img" . $x];
            $img_type = "0";
            if (in_array($img["type"], $img_extentions)) {

                if ($img["type"] == "image/jpeg") {
                    $img_type = ".jpeg";
                } else if ($img["type"] == "image/jpg") {
                    $img_type = ".jpg";
                } else if ($img["type"] == "image/png") {
                    $img_type = ".png";
                } else if ($img["type"] == "image/svg+xml") {
                    $img_type = ".svg";
                }

                $img_name = "resources//product_img//" . $title . "_product_img_" . uniqid() . $img_type;
                move_uploaded_file($img["tmp_name"], $img_name);

                Database::iud("INSERT INTO `image`(`path`,`product_id`) VALUES('" . $img_name . "','" . $pid . "')");
            } else {
                echo ("User Image type is not allowed");
            }
        }

        echo ("success");
    }
} else {
    echo ("Something went wrong? Please try again later");
}
