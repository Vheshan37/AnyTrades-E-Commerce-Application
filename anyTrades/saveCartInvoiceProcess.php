<?php

session_start();
require "connection.php";

$checkout_obj = $_SESSION["checkout"];
$products = $checkout_obj->product;
$cart_items = $checkout_obj->cart;
$email = $_SESSION["at_u"]["email"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$ctrlTable = Database::search("SELECT * FROM ctrl");
$ctrlData = $ctrlTable->fetch_assoc();
$inv_no = $ctrlData["inv_no"];
$next_inv_no = intval($inv_no) + 1;
$oid = $next_inv_no;

for ($x = 0; $x < sizeof($products); $x++) {

    $rs = Database::search("SELECT * FROM `product` WHERE `product`.`id`='" . $products[$x] . "'");
    $data = $rs->fetch_assoc();

    $address_rs = Database::search("SELECT *,`city`.`name` AS `city` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `user` ON `user`.`email`=`user_has_address`.`user_email` WHERE `email`='" . $email . "'");
    $address_data = $address_rs->fetch_assoc();

    if ($address_data["district_id"] == 2) {
        $delivery = $data["delivery_in"];
    } else {
        $delivery = $data["delivery_out"];
    }

    $total = $data["price"] + $delivery;

    // $oid = $products[$x] . "_" . $cart_items[$x];
    Database::iud("INSERT INTO `invoice` (`order_id`,`date_time`,`qty`,`total`,`product_id`,`user_email`,`order_status_id`) VALUES('" . $oid . "','" . $date . "','1','" . $total . "','" . $products[$x] . "','" . $email . "',(SELECT id FROM order_status WHERE status='Placed' LIMIT 1))");
}

Database::iud("DELETE FROM `cart` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
Database::iud("UPDATE ctrl SET `inv_no`='" . $next_inv_no . "'");

echo ($next_inv_no);
