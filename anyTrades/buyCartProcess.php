<?php

session_start();
require "connection.php";

$total = $_GET["total"];
$user_email = $_SESSION["at_u"]["email"];
$user = $_SESSION["at_u"];
$checkout = new stdClass();
$products = array();
$cart_array = array();


$address_rs = Database::search("SELECT *,`city`.`name` AS `city` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `user` ON `user`.`email`=`user_has_address`.`user_email` WHERE `email`='" . $user["email"] . "'");
$address_num = $address_rs->num_rows;

if ($address_num > 0) {
    $address_data = $address_rs->fetch_assoc();

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $user_email . "'");
    $cart_num = $cart_rs->num_rows;

    for ($cart = 0; $cart < $cart_num; $cart++) {
        $cart_data = $cart_rs->fetch_assoc();
        $products[$cart] = $cart_data["product_id"];
        $cart_array[$cart] = $cart_data["id"];
    }

    $checkout->product = $products;
    $checkout->cart = $cart_array;
    $checkout->amount = $total;
    $_SESSION["checkout"] = $checkout;


    // Requirements for hash code
    $order_id = uniqid();
    $item = "AnyTrades Products";
    $merchant_id = 1221196;
    $currency = "LKR";
    $merchant_secret = "NzcwNzM0NDkyNDA4NTQwMjkwNzE4MDM0NDA0MTE0MTM2OTA3OTk5";
    $amount = $total;
    $fname = $user["fname"];
    $lname = $user["lname"];
    $email = $user["email"];
    $phone = $user["mobile"];
    if (!empty($address_data["line3"])) {
        $address = $address_data["line1"] . ", " . $address_data["line2"] . ", " . $address_data["line3"];
    } else {
        $address = $address_data["line1"] . ", " . $address_data["line2"];
    }
    $city = $address_data["city"];
    $country = "Sri Lanka";

    $delivery_address = $address;
    $delivery_city = $city;
    $delivery_country = $country;

    // Hash code generator
    $hash = strtoupper(
        md5(
            $merchant_id .
                $order_id .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
        )
    );

    $obj = array();
    $obj["order_id"] = $order_id;
    $obj["item"] = $item;
    $obj["amount"] = $amount;
    $obj["currency"] = $currency;
    $obj["hash"] = $hash;
    $obj["fname"] = $fname;
    $obj["lname"] = $lname;
    $obj["email"] = $email;
    $obj["phone"] = $phone;
    $obj["address"] = $address;
    $obj["city"] = $city;
    $obj["country"] = $country;
    $obj["delivery_address"] = $delivery_address;
    $obj["delivery_city"] = $delivery_city;
    $obj["delivery_country"] = $delivery_country;


    $json_obj = json_encode($obj);
    echo ($json_obj);
} else {
    // Not filled user profile
    echo ("1");
}
