<?php

session_start();
require "connection.php";


if (isset($_SESSION["at_u"]) && isset($_SESSION["seller"])) {

    $seller = $_SESSION["seller"];

    $sname = $_POST["sname"];
    $line1 = $_POST["line1"];
    $line2 = $_POST["line2"];
    $line3 = $_POST["line3"];
    $province = $_POST["province"];
    $district = $_POST["district"];
    $city = $_POST["city"];
    $pCode = $_POST["pCode"];
    $bio = $_POST["bio"];
    $whatsapp = $_POST["whatsapp"];
    $youtube = $_POST["youtube"];
    $facebook = $_POST["facebook"];
    $twitter = $_POST["twitter"];
    $linkedin = $_POST["linkedin"];
    $str_bio = str_replace("'", "\'", $bio);

    if (empty($line1)) {
        echo ("Please enter address line 1");
    } else if (empty($line2)) {
        echo ("Please enter address line 2");
    } else if ($province == "0") {
        echo ("Select your province");
    } else if ($district == "0") {
        echo ("Select your district");
    } else if ($city == "0") {
        echo ("Select your city");
    } else if (empty($pCode)) {
        echo ("Please enter your postal code");
    } else {

        $seller_rs = Database::search("SELECT * FROM `seller` WHERE `nic`='" . $seller["nic"] . "'");
        $seller_num = $seller_rs->num_rows;

        $update_query = "UPDATE `seller` SET";
        if ($seller_num == 1) {

            if ($sname != "") {
                $update_query .= " `name`='" . $sname . "',";
            }

            if ($bio != "") {
                $update_query .= " `bio`='" . $str_bio . "',";
            } else {
                $update_query .= " `bio`='',";
            }

            if ($whatsapp != "") {
                $update_query .= " `whatsapp`='" . $whatsapp . "',";
            } else {
                $update_query .= " `whatsapp`='',";
            }

            if ($youtube != "") {
                $update_query .= " `youtube`='" . $youtube . "',";
            } else {
                $update_query .= " `youtube`='',";
            }

            if ($facebook != "") {
                $update_query .= " `facebook`='" . $facebook . "',";
            } else {
                $update_query .= " `facebook`='',";
            }

            if ($twitter != "") {
                $update_query .= " `twitter`='" . $twitter . "',";
            } else {
                $update_query .= " `twitter`='',";
            }

            if ($linkedin != "") {
                $update_query .= " `linkedin`='" . $linkedin . "'";
            } else {
                $update_query .= " `linkedin`=''";
            }

            $update_query .= " WHERE `nic`='" . $seller["nic"] . "'";

            Database::iud($update_query);
            Database::iud("UPDATE `user` SET `address_status`='2' WHERE `email`='" . $_SESSION["at_u"]["email"] . "'");

            // Address Query
            $address_rs = Database::search("SELECT * FROM `seller_has_address` WHERE `seller_nic`='" . $seller["nic"] . "'");
            $address_num = $address_rs->num_rows;

            if ($address_num == 0) {
                Database::iud("INSERT INTO `seller_has_address`(`seller_nic`,`city_id`,`line1`,`line2`,`postal_code`) VALUES('" . $seller["nic"] . "','" . $city . "','" . $line1 . "','" . $line2 . "','" . $pCode  . "')");

                if (!empty($line3)) {
                    Database::iud("UPDATE `seller_has_address` SET `line3`='" . $line3 . "' WHERE `seller_nic`='" . $seller["nic"] . "'");
                }
            } else if ($address_num == 1) {
                Database::iud("UPDATE `seller_has_address` SET `city_id`='" . $city . "',`line1`='" . $line1 . "',`line2`='" . $line2 . "',`postal_code`='" . $pCode . "' WHERE `seller_nic`='" . $seller["nic"] . "'");

                if (!empty($line3)) {
                    Database::iud("UPDATE `seller_has_address` SET `line3`='" . $line3 . "' WHERE `seller_nic`='" . $seller["nic"] . "'");
                }
            }

            echo ("success");
        } else {
            echo ("Something went wrong!!! Please try again later");
        }


        $file_length = sizeof($_FILES);

        if ($file_length > 0) {

            $img_extentions = array("image/jpeg", "image/jpg", "image/png", "image/svg+xml");

            if (isset($_FILES["img"])) {
                $img = $_FILES["img"];
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

                    $img_name = "resources//profile_images//" . $seller["nic"] . "_seller_img_" . uniqid() . $img_type;
                    $img_rs = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $seller["nic"] . "'");
                    $img_num = $img_rs->num_rows;

                    move_uploaded_file($img["tmp_name"], $img_name);

                    if ($img_num == 1) {
                        Database::iud("UPDATE `seller_profile_image` SET `seller_img`='" . $img_name . "' WHERE `seller_nic`='" . $seller["nic"] . "'");
                    } else {
                        Database::iud("INSERT INTO `seller_profile_image` (`seller_img`,`seller_nic`) VALUES('" . $img_name . "','" . $seller["nic"] . "')");
                    }
                } else {
                    echo ("User Image type is not allowed");
                }
            }
            if (isset($_FILES["background"])) {
                $background = $_FILES["background"];
                $background_type = "0";
                if (in_array($background["type"], $img_extentions)) {

                    if ($background["type"] == "image/jpeg") {
                        $background_type = ".jpeg";
                    } else if ($background["type"] == "image/jpg") {
                        $background_type = ".jpg";
                    } else if ($background["type"] == "image/png") {
                        $background_type = ".png";
                    } else if ($background["type"] == "image/svg+xml") {
                        $background_type = ".svg";
                    }

                    $background_name = "resources//profile_images//" . $seller["nic"] . "_seller_background_" . uniqid() . $background_type;
                    $background_rs = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $seller["nic"] . "'");
                    $background_num = $background_rs->num_rows;

                    move_uploaded_file($background["tmp_name"], $background_name);

                    if ($background_num == 1) {
                        Database::iud("UPDATE `seller_profile_image` SET `seller_back`='" . $background_name . "' WHERE `seller_nic`='" . $seller["nic"] . "'");
                    } else {
                        Database::iud("INSERT INTO `seller_profile_image` (`seller_back`,`seller_nic`) VALUES('" . $background_name . "','" . $seller["nic"] . "')");
                    }
                } else {
                    echo ("User Image type is not allowed");
                }
            }
        }
    }
} else {
    echo ("You are not a seller!. Please register first");
}
