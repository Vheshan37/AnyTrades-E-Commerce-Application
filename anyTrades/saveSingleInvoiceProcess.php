<?php

require "connection.php";

$oid = $_POST["oid"];
$amount = $_POST["amount"];
$email = $_POST["email"];
$pid = $_POST["pid"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `invoice` (`order_id`,`date_time`,`qty`,`total`,`product_id`,`user_email`,`order_status_id`) VALUES('" . $oid . "','" . $date . "','1','" . $amount . "','" . $pid . "','" . $email . "','1')");

$sellerTable = Database::search("SELECT * FROM ");
echo ("1");
