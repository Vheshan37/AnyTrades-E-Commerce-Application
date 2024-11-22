<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_u"])) {
    $user = $_SESSION["at_u"];
    $product = $_POST["id"];

    // Amount for the product
    $address_rs = Database::search("SELECT *,`city`.`name` AS `city` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `user` ON `user`.`email`=`user_has_address`.`user_email` WHERE `email`='" . $user["email"] . "'");
    $address_num = $address_rs->num_rows;

    if ($address_num > 0) {
        $address_data = $address_rs->fetch_assoc();

        // Product details
        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $product . "'");
        $product_data = $product_rs->fetch_assoc();

        if ($address_data["district_id"] == 2) {
            $delivery = $product_data["delivery_in"];
        } else {
            $delivery = $product_data["delivery_out"];
        }


        $ctrlTable = Database::search("SELECT * FROM ctrl");
        $ctrlData = $ctrlTable->fetch_assoc();
        $inv_no = $ctrlData["inv_no"];
        $order_id = $inv_no;

        // Requirements for hash code
        $item = $product_data["title"];
        $merchant_id = 11223344;
        $currency = "LKR";
        $merchant_secret = "merchant_secret_code";
        $amount = $product_data["price"] + $delivery;
        $fname = $address_data["fname"];
        $lname = $address_data["lname"];
        $email = $address_data["email"];
        $phone = $address_data["mobile"];
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

        $next_inv_no = intval($inv_no) + 1;
        $order_id = $next_inv_no;
        Database::iud("UPDATE ctrl SET `inv_no`='" . $next_inv_no . "'");
        echo ($json_obj);
    } else {
        // Not filled user profile
        echo ('2');
    }
} else {
    // Not sign in
    echo ('1');
}
