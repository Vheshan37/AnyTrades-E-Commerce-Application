<?php

require "connection.php";

$category = array();
$product = array();

$category_rs = Database::search("SELECT * FROM `category`");
$category_num = $category_rs->num_rows;

for ($c = 0; $c < $category_num; $c++) {
    $category_data = $category_rs->fetch_assoc();
    $category[$c] = $category_data["name"];

    $product_rs = Database::search("SELECT COUNT(*)AS product FROM product WHERE category_id='" . $category_data["id"] . "'");
    $product_data = $product_rs->fetch_assoc();
    $product[$c] = $product_data["product"];
}

$product_num = (Database::search("SELECT * FROM `product`"))->num_rows;

$obj = new stdClass();
$obj->category = $category;
$obj->product = $product;
$obj->products = $product_num;

echo (json_encode($obj));
