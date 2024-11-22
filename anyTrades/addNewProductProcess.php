<?php

session_start();
require "connection.php";
if (isset($_SESSION["category"]) && isset($_SESSION["seller"])) {


    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $title = $_POST["title"];
    $color = $_POST["color"];
    $condition = $_POST["condition"];
    $quantity = $_POST["quantity"];
    $size = $_POST["size"];
    $price = $_POST["price"];
    $dip = $_POST["dip"];
    $dop = $_POST["dop"];
    $desc = $_POST["desc"];

    if ($model == "0") {
        echo ("Please select a Model");
    } else if (empty($title)) {
        echo ("Please enter product title");
    } else if ($color == "0") {
        echo ("Please select a Color");
    } else if ($condition == "") {
        echo ("Please select a Condition");
    } else if (empty($price)) {
        echo ("Please enter product Price");
    } else if (empty($dip)) {
        echo ("Please enter delivery fee for Colombo");
    } else if (empty($desc)) {
        echo ("Please enter product Description");
    } else {

        $bhm_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' AND `model_id`='" . $model . "'");
        $bhm_num = $bhm_rs->num_rows;

        if ($bhm_num == 1) {
            $bhm_data  = $bhm_rs->fetch_assoc();

            $d = new DateTime();
            $tz = new DateTimeZone("Asia/Colombo");
            $d->setTimezone($tz);
            $date_time = $d->format("Y-m-d H:i:s");

            $query = "INSERT INTO `product`(`title`,`price`,`delivery_in`,`delivery_out`,`desc`,`qty`,`condition_id`,`color_id`,`brand_has_model_id`,`category_id`,`seller_nic`,`date_time`) VALUES('" . $title . "','" . $price . "','" . $dip . "','" . $dop . "','" . $desc . "','" . $quantity . "','" . $condition . "','" . $color . "','" . $bhm_data["id"] . "','" . $_SESSION["category"] . "','" . $_SESSION["seller"]["nic"] . "','" . $date_time . "')";

            Database::iud($query);
            $product_id = Database::$connection->insert_id;

            Database::iud("INSERT INTO `quantity` (`qty`,`product_id`) VALUES ('" . $quantity . "','" . $product_id . "')");

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

                    Database::iud("INSERT INTO `image`(`path`,`product_id`) VALUES('" . $img_name . "','" . $product_id . "')");
                } else {
                    echo ("User Image type is not allowed");
                }
            }

            echo ("success");
        } else {
            echo ("Brand doesn't have that kind of Model");
        }
    }
} else {
    echo ("Something went wrong? Please try again later");
}
